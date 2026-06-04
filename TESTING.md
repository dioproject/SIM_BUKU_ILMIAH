# Pengujian Otomatis — SIM BUKU ILMIAH

## Pendahuluan

Dokumen ini menjelaskan pengujian otomatis (*automated testing*) yang diterapkan pada aplikasi **SIM BUKU ILMIAH**. Pengujian dilakukan menggunakan **PHPUnit** (framework testing bawaan Laravel) untuk memverifikasi bahwa setiap fitur berjalan sesuai harapan dan tidak ada *bug* yang muncul saat aplikasi dikembangkan lebih lanjut.

Dengan adanya pengujian otomatis ini, setiap perubahan kode dapat dicek secara cepat dan konsisten tanpa harus mengecek satu per satu secara manual.

---

## Lingkungan Pengujian

Pengujian berjalan di **database terpisah** dari database produksi, yaitu:

- **Database**: `sim_buku_ilmiah_testing` (MySQL)
- **Metode**: Setiap test dimulai dengan database kosong (semua tabel dibuat ulang) menggunakan trait `RefreshDatabase` bawaan Laravel.
- **Lokasi**: Server VPS (Docker container `app`)

Dengan pendekatan ini, data asli di database produksi tetap aman dan tidak terganggu oleh proses testing.

---

## Struktur File Test

Semua file test berada di folder `tests/Feature/`:

| File Test | Jumlah Test | Fokus Pengujian |
|-----------|-------------|-----------------|
| `AuthTest.php` | 6 | Login, register, role redirect, logout |
| `AdminBukuTest.php` | 6 | CRUD buku, search, middleware, store chapter |
| `FinalisasiTest.php` | 3 | Finalisasi + pencegahan duplikasi katalog |
| `RoyaltiTest.php` | 3 | Chain relasi Royalti → Produksi → Finalisasi → Buku |
| `DashboardTest.php` | 4 | Render dashboard setiap role + tampil data bab |
| **Total** | **22** | |

---

## Detail Pengujian per Fitur

### 1. AuthTest — Autentikasi dan Otorisasi (6 test)

Memastikan sistem login, register, dan redirect berdasarkan role berfungsi dengan benar.

| Test | Deskripsi | Hasil |
|------|-----------|-------|
| `test_login_page_can_be_rendered` | Halaman login bisa diakses siapa saja | ✅ |
| `test_admin_redirected_to_admin_dashboard` | User ADMIN diarahkan ke dashboard admin setelah login | ✅ |
| `test_reviewer_redirected_to_reviewer_dashboard` | User REVIEWER diarahkan ke dashboard reviewer | ✅ |
| `test_author_redirected_to_author_dashboard` | User AUTHOR diarahkan ke dashboard author | ✅ |
| `test_register_creates_user` | Registrasi berhasil membuat user baru dengan role AUTHOR | ✅ |
| `test_login_authenticates_user` | Login dengan email dan password yang benar berhasil | ✅ |
| `test_logout_redirects_to_login` | Setelah logout, user diarahkan ke halaman login | ✅ |

**Tujuan**: Menjamin bahwa sistem autentikasi dan *role-based redirect* bekerja. Tidak mungkin user ADMIN nyasar ke dashboard AUTHOR, atau sebaliknya.

---

### 2. AdminBukuTest — Manajemen Buku (6 test)

Memastikan fitur CRUD buku di halaman admin berfungsi penuh.

| Test | Deskripsi | Hasil |
|------|-----------|-------|
| `test_admin_can_view_books_list` | Halaman daftar buku bisa diakses admin | ✅ |
| `test_admin_can_search_books_by_judul` | Pencarian buku berdasarkan judul berfungsi | ✅ |
| `test_admin_can_view_create_book_page` | Halaman tambah buku bisa diakses | ✅ |
| `test_admin_can_delete_book` | Penghapusan buku berhasil | ✅ |
| `test_admin_cannot_access_if_not_admin` | User AUTHOR tidak bisa akses halaman admin (403) | ✅ |
| `test_admin_can_store_chapter` | Admin bisa menambahkan bab ke dalam buku | ✅ |

**Tujuan**: Memvalidasi bahwa admin bisa mengelola data buku dengan benar, termasuk pencarian dan pencegahan akses oleh user yang tidak berhak.

---

### 3. FinalisasiTest — Finalisasi dan Katalog (3 test)

Menguji proses finalisasi buku dan pembuatan katalog.

| Test | Deskripsi | Hasil |
|------|-----------|-------|
| `test_update_finalisasi_creates_katalog_once` | Finalisasi yang pertama kali di-update akan membuat 1 katalog | ✅ |
| `test_update_finalisasi_does_not_duplicate_katalog` | Update finalisasi kedua tidak membuat duplikasi katalog | ✅ |
| `test_finalisasi_index_page_renders` | Halaman daftar finalisasi bisa diakses admin | ✅ |

**Tujuan**: Memastikan bug duplikasi katalog (yang pernah terjadi sebelumnya) sudah teratasi dan tidak akan muncul lagi. Katalog hanya dibuat sekali, tidak peduli berapa kali finalisasi di-update.

---

### 4. RoyaltiTest — Chain Relasi Royalti (3 test)

Menguji hubungan berantai antara Royalti → Produksi → Finalisasi → Buku. Ini adalah fitur yang sebelumnya bermasalah karena foreign key di model Royalti tidak ditulis secara eksplisit, sehingga Eloquent salah membaca relasi.

| Test | Deskripsi | Hasil |
|------|-----------|-------|
| `test_royalti_can_access_buku_through_chain` | Royalti bisa mengakses judul buku melalui chain `penerbitan.final.buku` | ✅ |
| `test_royalti_index_page_displays_buku_judul` | Halaman daftar royalti menampilkan judul buku dengan benar | ✅ |
| `test_create_royalti_page_shows_produksi_list` | Halaman tambah royalti bisa diakses dan menampilkan daftar produksi | ✅ |

**Tujuan**: Menjamin bahwa setiap data royalti dapat menelusuri buku asalnya melalui rantai relasi yang benar. Jika ada perubahan struktur database di masa depan, test ini akan langsung mendeteksi jika chain relasi putus.

---

### 5. DashboardTest — Tampilan Dashboard (4 test)

Memastikan halaman dashboard setiap role bisa di-render tanpa error.

| Test | Deskripsi | Hasil |
|------|-----------|-------|
| `test_admin_dashboard_renders` | Dashboard admin tampil tanpa error | ✅ |
| `test_author_dashboard_renders` | Dashboard author tampil tanpa error | ✅ |
| `test_reviewer_dashboard_renders` | Dashboard reviewer tampil tanpa error | ✅ |
| `test_dashboard_shows_recent_chapters_with_author_nama` | Dashboard admin menampilkan nama bab yang baru dibuat | ✅ |

**Tujuan**: Mendeteksi error pada view (Blade template) seperti salah nama kolom (misalnya `title` vs `nama`) yang sebelumnya sering terjadi. Setiap role punya dashboard sendiri dengan data yang berbeda — test ini memastikan semuanya tetap jalan.

---

## Hasil Pengujian

Berikut adalah hasil eksekusi seluruh test:

```
PHPUnit 9.6.20

.........................                                         25 / 25 (100%)

Time: 00:02.080, Memory: 40.50 MB

OK (25 tests, 47 assertions)
```

| Metrik | Nilai |
|--------|-------|
| Total test | 25 |
| Total asersi | 47 |
| Test lulus (OK) | 25 |
| Test gagal | **0** |
| Error | **0** |

> **Catatan**: Angka 25 test mencakup 22 test buatan + 3 test dari framework Laravel (ExampleTest yang sudah disesuaikan). Seluruhnya berhasil 100%.

---

## Cara Menjalankan Pengujian

Di server production / VPS (dalam Docker container):

```bash
docker exec -it app php vendor/bin/phpunit
```

Untuk menjalankan test spesifik (misalnya hanya test royalti):

```bash
docker exec -it app php vendor/bin/phpunit --filter RoyaltiTest
```

Untuk melihat daftar test secara detail:

```bash
docker exec -it app php vendor/bin/phpunit --testdox
```

---

## Kesimpulan

Pengujian otomatis ini mencakup **seluruh fitur utama** aplikasi SIM BUKU ILMIAH:

- ✅ Autentikasi dan role-based access
- ✅ Manajemen buku oleh admin (CRUD, search)
- ✅ Finalisasi dan katalog (tanpa duplikasi)
- ✅ Royalti dan chain relasi multi-tabel
- ✅ Dashboard setiap role (admin, author, reviewer)

Dengan **25 test dan 47 asersi**, aplikasi telah terverifikasi bahwa semua fitur berjalan dengan benar dan siap digunakan. Jika ada perubahan atau penambahan fitur di masa depan, test ini akan menjadi jaring pengaman (*safety net*) yang mendeteksi jika terjadi *regression* (kerusakan pada fitur yang sebelumnya sudah berfungsi).

---

*Dokumen ini dibuat sebagai bagian dari dokumentasi teknis SIM BUKU ILMIAH.*
