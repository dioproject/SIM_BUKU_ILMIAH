# Alur Role — SIM BUKU ILMIAH

## Entity Relationship

```
Jenis
  └── Buku
        ├── Bab (author_id → User, reviewer_id → User, status_id → Status)
        └── Finalisasi
              ├── Produksi → Royalti (user_id → User, bab_id → Bab)
              └── Katalog
User
  ├── Notifikasi (bab_id → Bab)
  └── Histori (user_id → User, bab_id → Bab, status_id → Status)
```

## Status Editorial

| ID | Status | Keterangan |
|----|--------|------------|
| 1 | Draft | Bab baru dibuat admin, belum siap ditugaskan |
| 2 | Tersedia | Bab tersedia untuk ditugaskan oleh admin/editor |
| 3 | Disetujui | Bab sudah layak masuk finalisasi |
| 4 | Ditugaskan | Author/reviewer sudah ditentukan |
| 5 | Revisi | Reviewer meminta perbaikan |
| 6 | Dalam Review | Naskah sedang ditangani reviewer |
| 7 | Dikirim Author | Author sudah mengunggah naskah |
| 8 | Direvisi | Author sudah mengunggah revisi |
| 9 | Finalisasi | Buku sedang diproses final |
| 10 | Terbit | Buku sudah masuk katalog terbit |

---

## Alur ADMIN

### 1. Buku (BookController)
- **Create** → isi `judul`, `total_bab`, `jenis_id`, upload `template` → simpan ke DB + log ke Histori
- **Store Chapter** → input array nama bab → `Bab::create()` dgn `status_id = 1` (Draft)
- **Assign Author** → pilih bab + pilih author → update `author_id` + set `status_id = 4` (Ditugaskan)
- **Assign Reviewer** → pilih bab + pilih reviewer → update `reviewer_id` + set `status_id = 4` (Ditugaskan)
- **Merge Bab** → gabung file `.docx` dari bab yg `status_id = 3` (Disetujui) → simpan file merge → `Finalisasi::updateOrCreate(['buku_id' => $book->id], ['merge' => $filename])`
  - **Validasi**: Semua bab buku harus sudah `status_id = 3` (Disetujui)
- **Delete** → hapus template, file bab, file reviu, semua Bab, lalu Buku

### 2. Finalisasi (FinalisasiController)
- **List** → `Finalisasi::paginate(10)`
- **Edit** → form ISBN, cover, final_file
- **Update** → simpan ISBN + upload cover & pdf

### 3. Produksi (ProduksiController)
- **Create** → pilih Finalisasi (dropdown, hanya yg status Finalisasi/Terbit) → isi `jml_print`, `biaya_produksi`, `harga_jual`, `tahun_terbit` → simpan
- **Validasi**: Buku harus sudah Finalisasi/Terbit
- Relasi: `Produksi.final_id → Finalisasi.id`

### 4. Royalti (RoyaltyController)
- **Create** → pilih Produksi → pilih Author → pilih Bab → isi `persentase` (%) → hitung otomatis:
  - `total_royalti = (harga_jual - biaya_produksi) × jml_print × (persentase / 100)`
  - `royalti_bab = total_royalti / buku.total_bab`
- **Validasi**:
  - Produksi harus ada
  - Bab harus terkait dengan buku yg sama
  - Author harus sesuai dengan bab yg dipilih
- **List** → eager load `penerbitan.final.buku`, `user`, `bab`

### 5. Katalog (CatalogController)
- **List** → menampilkan data dari tabel `katalogs`
- **Create** → pilih Finalisasi → isi `judul`, `pengarang`, `isbn`, `tahun_terbit`, `kategori`, `deskripsi`, upload `cover`
- **Store** → validasi finalisasi, ISBN, cover, file final harus ada → `Katalog::create()`
- **Validasi**: Buku harus sudah Finalisasi, data final harus lengkap (ISBN, cover, file final)

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
- **Upload** → upload file bab (validasi: bab harus `status_id = 4` Ditugaskan + author_id = Auth::id())
- **Upload Revisi** → upload file revisi (validasi: bab harus `status_id = 5` Revisi)

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
- **Approve** → set `status_id = 3` (Disetujui) + `approved_at` (validasi: file author harus ada, catatan reviewer harus diisi)
- **Revisi** → set `status_id = 5` (Revisi) + catatan revisi (validasi: catatan harus diisi)

---

## Alur User (AuthController)

- **Register** → buat user dgn role (ADMIN/AUTHOR/REVIEWER)
- **Login** → redirect ke dashboard sesuai role (HomeController)
- **Logout** → session dihapus

---

## Transisi Status

```
Draft (1) → Ditugaskan (4)        [Admin assign author/reviewer]
Tersedia (2) → Ditugaskan (4)     [Admin assign author/reviewer]
Ditugaskan (4) → Dikirim Author (7) [Author upload naskah]
Dikirim Author (7) → Dalam Review (6) [Reviewer mulai review]
Dalam Review (6) → Disetujui (3)   [Reviewer approve]
Dalam Review (6) → Revisi (5)      [Reviewer minta revisi]
Revisi (5) → Direvisi (8)          [Author upload revisi]
Direvisi (8) → Dalam Review (6)    [Reviewer review ulang]
Disetujui (3) → Finalisasi (9)     [Admin merge/finalisasi]
Finalisasi (9) → Terbit (10)       [Admin publish ke katalog]
```

---

## Catatan Penting

| Kolom | Model | Catatan |
|-------|-------|---------|
| `judul` | Buku | Judul buku, **bukan** `title` |
| `nama` | Bab | Nama/judul chapter, **bukan** `title` |
| `username` | User | Dipakai di dashboard, **bukan** `name` |
| `created_at` | Bab | Label chart: "Created per Day" (bukan "Approved") |
| `produksi_id` | Royalti | FK ke `produksis.id`, akses buku via `penerbitan.final.buku` |
| `user_id` | Royalti | FK ke `users.id`, author yg mendapat royalti |
| `bab_id` | Royalti | FK ke `babs.id`, bab terkait royalti |
| `jml_print` | Produksi | Jumlah cetak/eksemplar, **bukan** `eksemplar` |

## Urutan Create untuk Royalti

1. Admin buat **Buku** + generate **Bab** (status: Draft)
2. Admin **assign** author + reviewer ke bab (status: Ditugaskan)
3. Author **upload** naskah bab (status: Dikirim Author → Dalam Review)
4. Reviewer **review** + **approve** atau **revisi** (status: Disetujui atau Revisi)
5. Admin **merge** bab (validasi: semua bab harus Disetujui) → buat **Finalisasi**
6. Admin **edit Finalisasi** (isi ISBN, cover, file final)
7. Admin buat **Produksi** (pilih Finalisasi yg sudah jadi, isi data produksi)
8. Admin buat **Katalog** (pilih Finalisasi, isi data katalog) → status: Terbit
9. Admin buat **Royalti** (pilih Produksi, pilih Author, pilih Bab, isi persen → hitung otomatis)

> **Royalti tidak perlu input judul buku lagi.** Judul buku otomatis tampil dari chain `Royalti → penerbitan → Produksi → final → Finalisasi → buku → judul`.

> **Royalti dibuat per author per bab**, bukan per buku. Setiap bab yg ditulis author mendapat royalti terpisah berdasarkan persentase kontribusi.
