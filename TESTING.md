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

Semua file test:

 | Folder | File Test | Jumlah Test | Fokus Pengujian |
|--------|-----------|-------------|-----------------|
| `tests/Unit/` | `StatusTransitionTest.php` | 14 | Validasi transisi status editorial via StatusHelper (tanpa DB) |
| `tests/Unit/` | `ExampleTest.php` | 1 | Test dasar lingkungan PHPUnit |
| `tests/Feature/` | `AuthTest.php` | 7 | Login, register, role redirect, logout |
| | `AdminBukuTest.php` | 6 | CRUD buku, search, middleware, store chapter |
| | `FinalisasiTest.php` | 2 | Finalisasi update ISBN |
| | `RoyaltiTest.php` | 3 | Chain relasi Royalti → Produksi → Finalisasi → Buku |
| | `DashboardTest.php` | 10 | Render dashboard setiap role + tampil data statistik per role |
| | `UserManagementTest.php` | 11 | CRUD user, validasi phone_region, search, akses role |
| | `ChapterAssignmentTest.php` | 7 | Assign author/reviewer, store chapter, approve admin |
| | `AuthorWorkflowTest.php` | 8 | Author: buku ditugaskan, upload, revisi, pagar akses |
| | `ReviewerWorkflowTest.php` | 15 | Reviewer: review, approve, revisi, notifikasi catatan, pagar akses |
| | `AdminWorkflowFullTest.php` | 19 | Merge, finalisasi, produksi, katalog, royalti |
| | `HistoriNotifikasiTest.php` | 16 | Histori aktivitas, notifikasi, baca notifikasi, catatan reviewer |
| | `ProduksiTest.php` | 8 | CRUD produksi: index, create, store, show, edit, update, destroy, akses |
| | `RoleWorkflowTest.php` | 4 | Test integrasi akses silang role |
| | `ExampleTest.php` | 1 | Test dasar fitur HTTP |
| | **Total** | **132** | |

---

## Detail Pengujian per Fitur

### 1. AuthTest — Autentikasi dan Otorisasi (7 test)

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

### 3. FinalisasiTest — Finalisasi (2 test)

Menguji proses finalisasi buku dan pembuatan katalog.

| Test | Deskripsi | Hasil |
|------|-----------|-------|
| `test_finalisasi_index_renders` | Halaman daftar finalisasi bisa diakses admin | ✅ |
| `test_finalisasi_update_creates_katalog` | Update finalisasi dengan isbn + file PDF | ✅ |

**Tujuan**: Memastikan admin bisa mengupdate finalisasi (ISBN, file final) tanpa error.

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

### 5. DashboardTest — Tampilan Dashboard (10 test)

Memastikan halaman dashboard setiap role bisa di-render tanpa error dan menampilkan statistik yang relevan per role.

| Test | Deskripsi | Hasil |
|------|-----------|-------|
| `test_admin_dashboard_renders` | Dashboard admin tampil tanpa error | ✅ |
| `test_author_dashboard_renders` | Dashboard author tampil tanpa error | ✅ |
| `test_reviewer_dashboard_renders` | Dashboard reviewer tampil tanpa error | ✅ |
| `test_dashboard_shows_recent_chapters_with_author_nama` | Dashboard admin menampilkan nama bab yang baru dibuat | ✅ |
| `test_admin_dashboard_shows_total_books` | Dashboard admin menampilkan total buku | ✅ |
| `test_admin_dashboard_shows_total_authors` | Dashboard admin menampilkan total penulis | ✅ |
| `test_admin_dashboard_shows_total_reviewers` | Dashboard admin menampilkan total reviewer | ✅ |
| `test_admin_dashboard_shows_chapters_by_status` | Dashboard admin menampilkan distribusi status bab | ✅ |
| `test_author_dashboard_shows_assigned_chapters` | Dashboard author menampilkan bab ditugaskan & perlu revisi | ✅ |
| `test_reviewer_dashboard_shows_assigned_chapters` | Dashboard reviewer menampilkan perlu direview & sedang direview | ✅ |

**Tujuan**: Selain memastikan dashboard tidak error, test ini memvalidasi bahwa setiap role melihat statistik yang relevan dengan tugasnya — admin melihat data global, author melihat bab tugasnya, reviewer melihat bab yang perlu direview.

---

### 6. StatusTransitionTest — Transisi Status Editorial (14 test)

Memvalidasi aturan transisi status menggunakan `StatusHelper` agar alur editorial tidak bisa dilompati.

| Test | Deskripsi | Hasil |
|------|-----------|-------|
| `test_draft_can_transition_to_tersedia` | Draft → Tersedia valid | ✅ |
| `test_draft_cannot_transition_directly_to_disetujui` | Draft → Disetujui langsung tidak valid | ✅ |
| `test_ditugaskan_can_transition_to_dikirim_author` | Ditugaskan → Dikirim Author valid | ✅ |
| `test_dikirim_author_can_transition_to_dalam_review` | Dikirim Author → Dalam Review valid | ✅ |
| `test_dalam_review_can_approve_or_revisi` | Dalam Review → Disetujui/Revisi valid | ✅ |
| `test_revisi_can_transition_to_direvisi` | Revisi → Direvisi valid | ✅ |
| `test_direvisi_can_transition_back_to_dalam_review` | Direvisi → Dalam Review valid | ✅ |
| `test_disetujui_can_transition_to_finalisasi` | Disetujui → Finalisasi valid | ✅ |
| `test_disetujui_cannot_go_back_to_revisi` | Disetujui → Revisi tidak valid | ✅ |
| `test_terbit_is_final_no_transitions` | Terbit tidak punya transisi keluar | ✅ |
| `test_can_be_uploaded_by_author_allows_ditugaskan_and_revisi` | Hanya Ditugaskan & Revisi bisa upload author | ✅ |
| `test_can_be_approved_allows_dalam_review_and_direvisi` | Hanya Dalam Review & Direvisi bisa disetujui | ✅ |
| `test_can_be_assigned_allows_draft_and_tersedia` | Hanya Draft & Tersedia bisa di-assign | ✅ |
| `test_can_be_merged_returns_true_only_when_all_disetujui` | Merge hanya jika semua bab Disetujui | ✅ |

**Tujuan**: Status helper adalah fondasi alur editorial. Test ini memastikan tidak ada transisi ilegal yang lolos (misal: Draft langsung Disetujui, atau Disetujui balik ke Revisi).

---

### 7. UserManagementTest — Manajemen User Admin (11 test)

Memastikan admin bisa mengelola user dan validasi data berfungsi.

| Test | Deskripsi | Hasil |
|------|-----------|-------|
| `test_admin_can_view_users_list` | Admin lihat daftar user | ✅ |
| `test_admin_can_search_users` | Pencarian user berdasarkan username | ✅ |
| `test_admin_can_view_create_user_page` | Halaman tambah user bisa diakses | ✅ |
| `test_admin_can_create_user` | Admin membuat user AUTHOR | ✅ |
| `test_admin_can_create_reviewer` | Admin membuat user REVIEWER | ✅ |
| `test_create_user_validation_fails_with_non_numeric_contact` | Kontak non-angka ditolak | ✅ |
| `test_create_user_validation_fails_with_duplicate_email` | Email duplikat ditolak | ✅ |
| `test_admin_can_edit_user` | Halaman edit user bisa diakses | ✅ |
| `test_admin_can_update_user` | Update user dengan data baru | ✅ |
| `test_admin_can_delete_user` | Hapus user berhasil | ✅ |
| `test_non_admin_cannot_access_user_management` | User AUTHOR kena 403 | ✅ |

**Tujuan**: Memvalidasi CRUD user admin dengan aturan baru (`phone_region`, regex kontak `[0-9]{6,15}`), serta memastikan user non-admin tidak bisa mengakses halaman ini.

---

### 8. ChapterAssignmentTest — Assignment Chapter (7 test)

Menguji proses admin menambahkan bab dan menugaskan author/reviewer.

| Test | Deskripsi | Hasil |
|------|-----------|-------|
| `test_admin_can_assign_author_and_reviewer` | Assign author + reviewer → status Ditugaskan | ✅ |
| `test_admin_can_assign_author_only_without_reviewer` | Assign author saja, reviewer null | ✅ |
| `test_assign_fails_when_chapter_status_not_draft_or_tersedia` | Assign gagal jika status bukan Draft/Tersedia | ✅ |
| `test_assign_fails_with_invalid_author_id` | Assign dengan author_id tidak valid | ✅ |
| `test_admin_can_store_chapters` | Admin membuat beberapa bab sekaligus | ✅ |
| `test_admin_can_approve_chapter` | Admin menyetujui bab yang sudah siap | ✅ |
| `test_admin_cannot_approve_chapter_without_file` | Admin tidak bisa approve bab tanpa file naskah | ✅ |

**Tujuan**: Assignment harus melalui admin — tidak boleh ada author claim sendiri. Test ini memvalidasi bahwa alur assignment editorial bekerja dengan benar dan kondisi invalid ditolak.

---

### 9. AuthorWorkflowTest — Workflow Author (8 test)

Memastikan author hanya bisa mengerjakan bab yang ditugaskan kepadanya.

| Test | Deskripsi | Hasil |
|------|-----------|-------|
| `test_author_chapter_index_only_shows_assigned_chapters` | Hanya bab miliknya yang muncul di daftar | ✅ |
| `test_author_books_index_only_shows_books_with_assigned_chapters` | Hanya buku yang punya bab tugasnya yang muncul | ✅ |
| `test_author_can_upload_chapter` | Author upload naskah → status Dikirim Author | ✅ |
| `test_author_can_upload_revision_when_status_is_revisi` | Author upload revisi → status Direvisi | ✅ |
| `test_author_cannot_upload_chapter_owned_by_another_author` | Upload bab milik author lain ditolak | ✅ |
| `test_author_cannot_upload_chapter_with_wrong_status` | Upload saat status bukan Ditugaskan/Revisi ditolak | ✅ |
| `test_author_show_book_only_shows_their_chapters` | Detail buku hanya menampilkan chapter tugasnya | ✅ |
| `test_author_cannot_access_admin_routes` | Author akses admin → 403 | ✅ |

**Tujuan**: Author tidak bisa sembarangan upload ke bab mana pun. Hanya bab dengan status Ditugaskan atau Revisi yang bisa diupload, dan hanya oleh author yang ditugaskan.

---

### 10. ReviewerWorkflowTest — Workflow Reviewer (15 test)

Memastikan reviewer hanya bisa menilai bab yang ditugaskan dan harus memberi file review/catatan sebelum approve.

| Test | Deskripsi | Hasil |
|------|-----------|-------|
| `test_reviewer_chapter_index_only_shows_assigned_chapters` | Hanya bab tugasnya yang muncul | ✅ |
| `test_reviewer_books_index_only_shows_books_with_assigned_chapters` | Hanya buku tugasnya yang muncul | ✅ |
| `test_reviewer_can_upload_review_file` | Upload review → status Dalam Review | ✅ |
| `test_reviewer_cannot_upload_review_for_unassigned_chapter` | Upload review bab orang lain ditolak | ✅ |
| `test_reviewer_cannot_upload_review_for_chapter_without_author_file` | Upload review tanpa naskah author ditolak | ✅ |
| `test_reviewer_can_approve_chapter_with_review_file` | Approve dengan file review berhasil | ✅ |
| `test_reviewer_can_approve_chapter_with_notes_only` | Approve dengan catatan saja berhasil | ✅ |
| `test_reviewer_cannot_approve_without_review_file_or_notes` | Approve tanpa file/catatan ditolak | ✅ |
| `test_reviewer_can_request_revision` | Request revisi berhasil → status Revisi | ✅ |
| `test_reviewer_cannot_request_revision_without_review_file_or_notes` | Revisi tanpa file/catatan ditolak | ✅ |
| `test_reviewer_cannot_approve_chapter_not_assigned_to_them` | Approve bab orang lain ditolak | ✅ |
| `test_reviewer_cannot_upload_note_for_unassigned_chapter` | Catatan untuk bab orang lain ditolak | ✅ |
| `test_reviewer_cannot_access_admin_routes` | Reviewer akses admin → 403 | ✅ |
| `test_reviewer_notes_sends_notification_to_author` | Catatan reviewer mengirim notifikasi ke author | ✅ |
| `test_reviewer_notes_sends_notification_to_correct_chapter` | Notifikasi dikirim ke bab yang benar | ✅ |

**Tujuan**: Reviewer HARUS memberikan file review atau catatan sebelum approve/minta revisi. Setelah menulis catatan, author otomatis mendapat notifikasi. Tidak ada approve instan tanpa bukti review.

---

### 11. AdminWorkflowFullTest — Alur Lengkap Admin (19 test)

Menguji merge, finalisasi, produksi, katalog, dan royalti dari ujung ke ujung.

| Test | Deskripsi | Hasil |
|------|-----------|-------|
| `test_admin_can_view_books_list` | Halaman daftar buku | ✅ |
| `test_admin_can_search_books` | Pencarian judul buku | ✅ |
| `test_admin_can_view_create_book_page` | Halaman tambah buku | ✅ |
| `test_admin_can_store_book` | Simpan buku baru dengan template | ✅ |
| `test_admin_can_view_book_detail` | Detail buku menampilkan bab | ✅ |
| `test_admin_can_delete_book` | Hapus buku beserta bab-babnya | ✅ |
| `test_merge_succeeds_when_all_chapters_approved` | Merge berhasil jika semua bab Disetujui | ✅ |
| `test_merge_fails_when_chapters_not_all_approved` | Merge gagal jika ada bab belum Disetujui | ✅ |
| `test_merge_fails_when_chapter_count_is_less_than_total_bab` | Merge gagal jika jumlah bab kurang | ✅ |
| `test_finalisasi_index_renders` | Halaman daftar finalisasi | ✅ |
| `test_finalisasi_update_creates_katalog` | Update finalisasi dengan ISBN + file final | ✅ |
| `test_produksi_index_renders` | Halaman daftar produksi | ✅ |
| `test_produksi_store_validates_data` | Simpan produksi dengan data valid | ✅ |
| `test_produksi_store_fails_without_complete_final_data` | Produksi gagal jika data final belum lengkap | ✅ |
| `test_katalog_index_renders` | Halaman daftar katalog | ✅ |
| `test_katalog_store_creates_entry` | Katalog terbuat dengan status_publish = true | ✅ |
| `test_royalti_store_calculates_correctly` | Royalti tersimpan dengan perhitungan benar | ✅ |
| `test_royalti_store_fails_when_bab_not_belonging_to_user` | Royalti gagal jika bab bukan milik user | ✅ |
| `test_royalti_index_displays_buku_judul` | Halaman royalti menampilkan judul buku | ✅ |

**Tujuan**: End-to-end workflow dari admin bikin buku → merge → finalisasi → produksi → katalog → royalti. Setiap tahap hanya bisa dilanjutkan jika prasyarat tahap sebelumnya terpenuhi.

---

### 12. HistoriNotifikasiTest — Activity Log & Notifikasi (16 test)

Memastikan setiap aksi penting tercatat di histori dan notifikasi dikirim ke pihak terkait, termasuk fitur baca notifikasi.

| Test | Deskripsi | Hasil |
|------|-----------|-------|
| `test_create_user_creates_history` | Membuat user mencatat histori | ✅ |
| `test_delete_user_creates_history` | Hapus user mencatat histori | ✅ |
| `test_assign_chapter_creates_history` | Assign chapter mencatat histori | ✅ |
| `test_assign_chapter_creates_notification_for_author` | Assign mengirim notifikasi ke author | ✅ |
| `test_assign_chapter_creates_notification_for_reviewer` | Assign mengirim notifikasi ke reviewer | ✅ |
| `test_author_upload_creates_history` | Upload naskah mencatat histori | ✅ |
| `test_author_upload_creates_notification_for_admin` | Upload naskah memberi notifikasi admin | ✅ |
| `test_reviewer_approve_creates_history` | Approve reviewer mencatat histori | ✅ |
| `test_reviewer_approve_creates_notification_for_author` | Approve memberi notifikasi author | ✅ |
| `test_reviewer_revisi_creates_history` | Request revisi mencatat histori | ✅ |
| `test_admin_approve_creates_history` | Approve admin mencatat histori | ✅ |
| `test_notification_mark_as_read` | Notifikasi bisa ditandai sudah dibaca | ✅ |
| `test_notification_mark_all_as_read` | Semua notifikasi bisa ditandai sudah dibaca sekaligus | ✅ |
| `test_notification_mark_as_read_only_own_notifications` | User hanya bisa menandai notifikasinya sendiri | ✅ |
| `test_reviewer_notes_creates_notification_for_author` | Catatan reviewer mengirim notifikasi ke author | ✅ |
| `test_reviewer_notes_creates_history` | Catatan reviewer tercatat di histori | ✅ |

**Tujuan**: Setiap langkah dalam alur editorial harus tercatat (histori) dan memberi tahu pihak terkait (notifikasi). Test ini menjamin tidak ada aksi "silent" yang tidak terlacak, serta memastikan fitur baca notifikasi berfungsi dengan benar.

---

### 13. ProduksiTest — CRUD Produksi (8 test)

Menguji seluruh operasi CRUD pada halaman produksi oleh admin.

| Test | Deskripsi | Hasil |
|------|-----------|-------|
| `test_produksi_index_page_renders` | Halaman daftar produksi bisa diakses admin | ✅ |
| `test_produksi_create_page_renders` | Halaman tambah produksi bisa diakses | ✅ |
| `test_produksi_store_creates_new_produksi` | Menyimpan produksi baru dengan data valid | ✅ |
| `test_produksi_show_page_renders` | Halaman detail produksi bisa diakses | ✅ |
| `test_produksi_edit_page_renders` | Halaman edit produksi bisa diakses | ✅ |
| `test_produksi_update_modifies_produksi` | Mengubah data produksi berhasil | ✅ |
| `test_produksi_destroy_deletes_produksi` | Menghapus produksi berhasil | ✅ |
| `test_non_admin_cannot_access_produksi_routes` | AUTHOR/REVIEWER tidak bisa akses (403) | ✅ |

**Tujuan**: Memvalidasi bahwa seluruh operasi CRUD produksi berjalan dengan benar dan hanya bisa diakses oleh admin.

---

### 14. RoleWorkflowTest — Integrasi Akses Role (4 test)

Menguji skenario integrasi akses silang antar role dalam satu alur.

| Test | Deskripsi | Hasil |
|------|-----------|-------|
| `test_author_chapter_index_only_shows_assigned_chapters` | Author hanya melihat chapter tugasnya | ✅ |
| `test_admin_can_assign_author_and_reviewer_to_chapter` | Admin bisa assign author dan reviewer | ✅ |
| `test_author_cannot_upload_chapter_owned_by_another_author` | Author tidak bisa upload chapter milik author lain | ✅ |
| `test_reviewer_cannot_approve_chapter_without_review_file` | Reviewer tidak bisa approve tanpa file review | ✅ |

**Tujuan**: Memvalidasi bahwa pembatasan akses berdasarkan role tetap terjaga dalam skenario integrasi, bukan hanya dalam isolasi per-file test.

---

### 15. ExampleTest (Unit) — Test Dasar (1 test)

Test dasar untuk memastikan lingkungan PHPUnit dan autoloading berfungsi.

| Test | Deskripsi | Hasil |
|------|-----------|-------|
| `test_that_true_is_true` | Assert dasar bahwa true adalah true | ✅ |

**Tujuan**: Verifikasi bahwa PHPUnit dapat berjalan dan autoloading composer tidak bermasalah.

---

### 16. ExampleTest (Feature) — Test Dasar HTTP (1 test)

Test dasar untuk memastikan routing dan middleware berfungsi.

| Test | Deskripsi | Hasil |
|------|-----------|-------|
| `test_guest_is_redirected_to_login` | Guest diarahkan ke halaman login | ✅ |

**Tujuan**: Verifikasi bahwa middleware auth bekerja dan guest diarahkan ke halaman login.

---

## Hasil Pengujian

Berikut adalah hasil eksekusi seluruh test menggunakan format `--testdox`:

```
PHPUnit 9.6.20 by Sebastian Bergmann and contributors.

Example (Tests\Unit\Example)
 ✔ That true is true

Status Transition (Tests\Unit\StatusTransition)
 ✔ Draft can transition to tersedia
 ✔ Draft cannot transition directly to disetujui
 ✔ Ditugaskan can transition to dikirim author
 ✔ Dikirim author can transition to dalam review
 ✔ Dalam review can approve or revisi
 ✔ Revisi can transition to direvisi
 ✔ Direvisi can transition back to dalam review
 ✔ Disetujui can transition to finalisasi
 ✔ Disetujui cannot go back to revisi
 ✔ Terbit is final no transitions
 ✔ Can be uploaded by author allows ditugaskan and revisi
 ✔ Can be approved allows dalam review and direvisi
 ✔ Can be assigned allows draft and tersedia
 ✔ Can be merged returns true only when all disetujui

Admin Buku (Tests\Feature\AdminBuku)
 ✔ Admin can view books list
 ✔ Admin can search books by judul
 ✔ Admin can view create book page
 ✔ Admin can delete book
 ✔ Admin cannot access if not admin
 ✔ Admin can store chapter

Admin Workflow Full (Tests\Feature\AdminWorkflowFull)
 ✔ Admin can view books list
 ✔ Admin can search books
 ✔ Admin can view create book page
 ✔ Admin can store book
 ✔ Admin can view book detail
 ✔ Admin can delete book
 ✔ Merge succeeds when all chapters approved
 ✔ Merge fails when chapters not all approved
 ✔ Merge fails when chapter count is less than total bab
 ✔ Finalisasi index renders
 ✔ Finalisasi update creates katalog
 ✔ Produksi index renders
 ✔ Produksi store validates data
 ✔ Produksi store fails without complete final data
 ✔ Katalog index renders
 ✔ Katalog store creates entry
 ✔ Royalti store calculates correctly
 ✔ Royalti store fails when bab not belonging to user
 ✔ Royalti index displays buku judul

Auth (Tests\Feature\Auth)
 ✔ Login page can be rendered
 ✔ Admin redirected to admin dashboard
 ✔ Reviewer redirected to reviewer dashboard
 ✔ Author redirected to author dashboard
 ✔ Register creates user
 ✔ Login authenticates user
 ✔ Logout redirects to login

Author Workflow (Tests\Feature\AuthorWorkflow)
 ✔ Author chapter index only shows assigned chapters
 ✔ Author books index only shows books with assigned chapters
 ✔ Author can upload chapter
 ✔ Author can upload revision when status is revisi
 ✔ Author cannot upload chapter owned by another author
 ✔ Author cannot upload chapter with wrong status
 ✔ Author show book only shows their chapters
 ✔ Author cannot access admin routes

Chapter Assignment (Tests\Feature\ChapterAssignment)
 ✔ Admin can assign author and reviewer
 ✔ Admin can assign author only without reviewer
 ✔ Assign fails when chapter status not draft or tersedia
 ✔ Assign fails with invalid author id
 ✔ Admin can store chapters
 ✔ Admin can approve chapter
 ✔ Admin cannot approve chapter without file

Dashboard (Tests\Feature\Dashboard)
 ✔ Admin dashboard renders
 ✔ Author dashboard renders
 ✔ Reviewer dashboard renders
 ✔ Dashboard shows recent chapters with author nama
 ✔ Admin dashboard shows total books
 ✔ Admin dashboard shows total authors
 ✔ Admin dashboard shows total reviewers
 ✔ Admin dashboard shows chapters by status
 ✔ Author dashboard shows assigned chapters
 ✔ Reviewer dashboard shows assigned chapters

Example (Tests\Feature\Example)
 ✔ Guest is redirected to login

Finalisasi (Tests\Feature\Finalisasi)
 ✔ Update finalisasi updates isbn
 ✔ Finalisasi index page renders

Histori Notifikasi (Tests\Feature\HistoriNotifikasi)
 ✔ Create user creates history
 ✔ Delete user creates history
 ✔ Assign chapter creates history
 ✔ Assign chapter creates notification for author
 ✔ Assign chapter creates notification for reviewer
 ✔ Author upload creates history
 ✔ Author upload creates notification for admin
 ✔ Reviewer approve creates history
 ✔ Reviewer approve creates notification for author
 ✔ Reviewer revisi creates history
 ✔ Admin approve creates history
 ✔ Notification mark as read
 ✔ Notification mark all as read
 ✔ Notification mark as read only own notifications
 ✔ Reviewer notes creates notification for author
 ✔ Reviewer notes creates history

Produksi (Tests\Feature\Produksi)
 ✔ Produksi index page renders
 ✔ Produksi create page renders
 ✔ Produksi store creates new produksi
 ✔ Produksi show page renders
 ✔ Produksi edit page renders
 ✔ Produksi update modifies produksi
 ✔ Produksi destroy deletes produksi
 ✔ Non admin cannot access produksi routes

Reviewer Workflow (Tests\Feature\ReviewerWorkflow)
 ✔ Reviewer chapter index only shows assigned chapters
 ✔ Reviewer books index only shows books with assigned chapters
 ✔ Reviewer can upload review file
 ✔ Reviewer cannot upload review for unassigned chapter
 ✔ Reviewer cannot upload review for chapter without author file
 ✔ Reviewer can approve chapter with review file
 ✔ Reviewer can approve chapter with notes only
 ✔ Reviewer cannot approve without review file or notes
 ✔ Reviewer can request revision
 ✔ Reviewer cannot request revision without review file or notes
 ✔ Reviewer cannot approve chapter not assigned to them
 ✔ Reviewer cannot upload note for unassigned chapter
 ✔ Reviewer cannot access admin routes
 ✔ Reviewer notes sends notification to author
 ✔ Reviewer notes sends notification to correct chapter

Role Workflow (Tests\Feature\RoleWorkflow)
 ✔ Author chapter index only shows assigned chapters
 ✔ Admin can assign author and reviewer to chapter
 ✔ Author cannot upload chapter owned by another author
 ✔ Reviewer cannot approve chapter without review file

Royalti (Tests\Feature\Royalti)
 ✔ Royalti can access buku through chain
 ✔ Royalti index page displays buku judul
 ✔ Create royalti page shows produksi list

User Management (Tests\Feature\UserManagement)
 ✔ Admin can view users list
 ✔ Admin can search users
 ✔ Admin can view create user page
 ✔ Admin can create user
 ✔ Admin can create reviewer
 ✔ Create user validation fails with non numeric contact
 ✔ Create user validation fails with duplicate email
 ✔ Admin can edit user
 ✔ Admin can update user
 ✔ Admin can delete user
 ✔ Non admin cannot access user management

Time: 00:05.564, Memory: 46.50 MB

OK (132 tests, 247 assertions)
```

| Metrik | Nilai |
|--------|-------|
| Total test | 132 |
| Total asersi | 247 |
| Test lulus (OK) | 132 |
| Test gagal | **0** |
| Error | **0** |
| Waktu eksekusi | ~5-6 detik |

> **Catatan**: Seluruh test menggunakan `RefreshDatabase` sehingga setiap test dimulai dengan database kosong. Dijalankan di VPS via `docker exec -it app php vendor/bin/phpunit --testdox`.

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

Pengujian otomatis ini mencakup **seluruh fitur dan alur editorial** aplikasi SIM BUKU ILMIAH:

- ✅ Autentikasi dan role-based access / redirect
- ✅ Manajemen user oleh admin (CRUD, search, validasi)
- ✅ Manajemen buku dan chapter oleh admin
- ✅ Assignment author & reviewer oleh admin
- ✅ Upload naskah oleh author (naskah awal & revisi)
- ✅ Review dan keputusan reviewer (approve / revisi)
- ✅ Notifikasi catatan reviewer ke author
- ✅ Notifikasi read/unread (mark as read, mark all as read, security)
- ✅ Finalisasi, merge, produksi, katalog, royalti
- ✅ CRUD produksi (index, create, store, show, edit, update, destroy)
- ✅ Status transisi editorial (validasi larangan lompat status)
- ✅ Histori aktivitas dan notifikasi
- ✅ Pencegahan akses antar role (author/reviewer tidak bisa akses admin)

Dengan **132 test dan 247 asersi**, aplikasi telah terverifikasi bahwa semua fitur berjalan dengan benar dan siap digunakan. Jika ada perubahan atau penambahan fitur di masa depan, test ini akan menjadi jaring pengaman (*safety net*) yang mendeteksi jika terjadi *regression* (kerusakan pada fitur yang sebelumnya sudah berfungsi).

---

*Dokumen ini dibuat sebagai bagian dari dokumentasi teknis SIM BUKU ILMIAH.*
