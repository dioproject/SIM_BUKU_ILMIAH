# Alur Role — SIM BUKU ILMIAH

## Entity Relationship

```
Jenis
  └── Buku
        ├── Bab (author_id → User, reviewer_id → User, status_id → Status)
        └── Finalisasi
              ├── Produksi → Royalti
              └── Katalog
User
  └── Notifikasi
```

## Full Chain Royalti

```
Royalti → penerbitan() → Produksi → final() → Finalisasi → buku() → Buku → judul
```

---

## Alur ADMIN

### 1. Buku (BookController)
- **Create** → isi `judul`, `total_bab`, `jenis_id`, upload `template` → simpan ke DB + log ke Histori
- **Store Chapter** → input array nama bab → `Bab::create()` dgn `status_id = 2` (default)
- **Merge Bab** → gabung file `.docx` dari bab yg `status_id = 3` (approved) → simpan file merge → `Finalisasi::updateOrCreate(['buku_id' => $book->id], ['merge' => $filename])`
- **Delete** → hapus template, file bab, file reviu, semua Bab, lalu Buku

### 2. Finalisasi (FinalisasiController)
- **List** → `Finalisasi::paginate(10)`
- **Edit** → form ISBN, cover, final_file
- **Update** → simpan ISBN + upload cover & pdf → **otomatis buat Katalog** via `Katalog::firstOrCreate(['final_id' => $finalisasi->id])`

### 3. Produksi (ProduksiController)
- **Create** → pilih Finalisasi (dropdown) → isi `eksemplar`, `biaya_produksi`, `harga_jual` → simpan
- Relasi: `Produksi.final_id → Finalisasi.id`

### 4. Royalti (RoyaltyController)
- **Create** → pilih Produksi → isi `persentase` (%) → hitung otomatis:
  - `total_royalti = (harga_jual - biaya_produksi) × eksemplar × (persentase / 100)`
  - `royalti_bab = total_royalti / buku.total_bab`
- **List** → eager load `penerbitan.final.buku`

### 5. Katalog (CatalogController)
- **List** → menampilkan data dari tabel `katalogs`

---

## Alur AUTHOR

### 1. Dashboard (HomeController@authorPage)
- Statistik harian: `Bab::groupBy('created_at')`
- 5 aktivitas terakhir: `Bab::with('author')->latest()->take(5)`
- Akses: `$activity->nama` (judul bab), lihat chart "Total Chapters Created per Day"

### 2. Buku (AuthorBookController)
- **List** → semua buku + hitung bab yg sudah diisi (`filledChaptersCount`)
- **Show** → detail buku daftar bab-nya

### 3. Chapter (AuthorChapterController)
- **List** → semua bab milik author yg login (`author_id = Auth::id()`)
- **Show** → detail bab
- **Claim** → set `author_id` pada bab
- **Upload** → upload file bab

---

## Alur REVIEWER

### 1. Dashboard (HomeController@reviewerPage)
- Sama seperti author: statistik harian + 5 aktivitas terakhir

### 2. Buku (ReviewerBookController)
- **List** → semua buku + hitung bab yg sudah diisi
- **Show** → detail buku daftar bab-nya
- **Upload Review** → upload file review `file_revieu`
- **Notes** → simpan catatan reviewer

### 3. Chapter (ReviewerChapterController)
- **List** → semua bab (bisa difilter per reviewer)
- **Show** → detail bab
- **Approve** → set `status_id = 3` + `approved_at`

---

## Alur User (AuthController)

- **Register** → buat user dgn role (ADMIN/AUTHOR/REVIEWER)
- **Login** → redirect ke dashboard sesuai role (HomeController)
- **Logout** → session dihapus

---

## Catatan Penting

| Kolom | Model | Catatan |
|-------|-------|---------|
| `judul` | Buku | Judul buku, **bukan** `title` |
| `nama` | Bab | Nama/judul chapter, **bukan** `title` |
| `username` | User | Dipakai di dashboard, **bukan** `name` |
| `created_at` | Bab | Label chart: "Created per Day" (bukan "Approved") |
| `produksi_id` | Royalti | FK ke `produksis.id`, akses buku via `penerbitan.final.buku` |

## Urutan Create untuk Royalti

1. Admin buat **Buku** + generate **Bab**
2. Author **claim** + **upload** bab per bab
3. Reviewer **review** + **approve**
4. Admin **merge** bab → otomatis buat **Finalisasi**
5. Admin **edit Finalisasi** (isi ISBN, cover) → otomatis buat **Katalog**
6. Admin buat **Produksi** (pilih Finalisasi yg sudah jadi)
7. Admin buat **Royalti** (pilih Produksi, isi persen → hitung otomatis)

> **Royalti tidak perlu input judul buku lagi.** Judul buku otomatis tampil dari chain `Royalti → penerbitan → Produksi → final → Finalisasi → buku → judul`.
