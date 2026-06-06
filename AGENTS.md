# AGENTS.md

## Aturan Wajib

Setiap perubahan kode WAJIB langsung di-commit dan di-push ke GitHub. Jangan ada perubahan yang tertinggal di lokal.

## Prinsip Kerja Project

Project ini adalah SIM Buku Ilmiah, bukan sekadar aplikasi upload dokumen atau CRUD buku. Setiap perubahan harus menjaga alur editorial penerbitan buku ilmiah agar rapi, terkontrol, dan masuk akal secara proses akademik.

Project sudah berjalan di VPS EC2 AWS. Jangan menjalankan Apache, MySQL, server Laravel, migration, atau test yang menyentuh database di laptop lokal. Workspace lokal dipakai untuk membaca dan mengedit file saja. Jika perlu menjalankan migration/test/runtime, lakukan di VPS atau minta konfirmasi user.

## Tujuan Alur Aplikasi

Aplikasi harus memfasilitasi proses:

1. Admin/editor membuat data buku dan struktur bab.
2. Admin/editor menugaskan author ke bab.
3. Admin/editor menugaskan reviewer ke bab.
4. Author mengunggah naskah bab yang ditugaskan.
5. Reviewer menilai naskah bab yang ditugaskan.
6. Author merevisi jika reviewer meminta revisi.
7. Reviewer/admin menyetujui bab yang sudah layak.
8. Admin menggabungkan bab yang disetujui.
9. Admin melakukan finalisasi buku.
10. Buku masuk katalog setelah data final lengkap.
11. Produksi dan royalti dibuat setelah buku final.

Alur lama berupa author bebas claim bab sendiri harus dihindari. Untuk SIM Buku Ilmiah, assignment harus datang dari admin/editor agar proses editorial terkontrol.

## Role Dan Tanggung Jawab

### Admin

Admin adalah pengelola sistem dan alur editorial.

Admin boleh:

- Mengelola user.
- Membuat buku.
- Membuat daftar bab.
- Menugaskan author ke bab.
- Menugaskan reviewer ke bab.
- Melihat seluruh buku, bab, file, catatan, histori, dan status.
- Melakukan finalisasi buku.
- Membuat katalog.
- Membuat data produksi.
- Membuat perhitungan royalti.
- Menggabungkan bab hanya jika semua bab yang diperlukan sudah disetujui.

Admin tidak idealnya menulis atau mereview isi bab sebagai proses normal. Jika admin melakukan tindakan editorial, itu harus terlihat sebagai tindakan admin/editor, bukan sebagai author/reviewer tersembunyi.

### Author

Author adalah penulis naskah.

Author hanya boleh:

- Melihat buku dan bab yang ditugaskan kepadanya.
- Mengunggah file naskah bab untuk tugasnya sendiri.
- Mengunggah revisi jika status bab meminta revisi.
- Melihat catatan reviewer untuk babnya.
- Melihat status progres babnya.

Author tidak boleh:

- Claim bab sendiri.
- Melihat semua bab yang belum ditugaskan.
- Upload file untuk bab milik author lain.
- Mengubah reviewer.
- Menyetujui bab.
- Melakukan finalisasi atau produksi.

### Reviewer

Reviewer adalah penilai naskah.

Reviewer hanya boleh:

- Melihat buku dan bab yang ditugaskan kepadanya.
- Mengunduh/membaca file naskah bab yang sudah dikirim author.
- Mengunggah file review.
- Mengisi catatan review.
- Memberikan keputusan review, minimal `Revisi` atau `Direkomendasikan Disetujui`.

Reviewer tidak boleh:

- Melihat semua bab di sistem.
- Mereview bab yang tidak ditugaskan kepadanya.
- Mengubah author.
- Mengubah struktur buku.
- Melakukan finalisasi, produksi, katalog, atau royalti.

## Status Editorial Yang Disarankan

Gunakan status yang mencerminkan proses editorial, bukan istilah task kasar.

Status ideal:

- `Draft`: bab baru dibuat admin, belum siap ditugaskan.
- `Tersedia`: bab tersedia untuk ditugaskan oleh admin/editor.
- `Ditugaskan`: author/reviewer sudah ditentukan.
- `Dikirim Author`: author sudah mengunggah naskah.
- `Dalam Review`: naskah sedang ditangani reviewer.
- `Revisi`: reviewer meminta perbaikan.
- `Direvisi`: author sudah mengunggah revisi.
- `Disetujui`: bab sudah layak masuk finalisasi.
- `Finalisasi`: buku sedang diproses final.
- `Terbit`: buku sudah masuk katalog terbit.

Jika database saat ini masih memakai status lama seperti `Available`, `Claimed`, `Approve`, atau `Selected`, label UI dan logic baru harus diarahkan ke istilah editorial di atas. Hindari menampilkan istilah `Claimed` ke user.

## Transisi Status Yang Benar

Alur status minimal:

1. Admin membuat bab: `Draft` atau `Tersedia`.
2. Admin assign author/reviewer: `Ditugaskan`.
3. Author upload naskah: `Dikirim Author` atau `Dalam Review`.
4. Reviewer upload review/catatan:
   - Jika perlu perbaikan: `Revisi`.
   - Jika layak: `Direkomendasikan Disetujui` atau langsung `Disetujui`, tergantung kebijakan.
5. Author upload revisi: `Direvisi` atau `Dalam Review`.
6. Reviewer/admin menyetujui: `Disetujui`.
7. Semua bab disetujui: admin boleh merge/finalisasi.

Jangan izinkan transisi yang melompati proses penting, misalnya:

- Bab tanpa file author langsung `Disetujui`.
- Reviewer approve bab tanpa file review/catatan.
- Author upload ke bab yang belum ditugaskan kepadanya.
- Admin merge buku dengan bab yang belum disetujui.

## Aturan Data Dan Akses

Semua pembatasan harus dilakukan di backend/controller/query, bukan hanya menyembunyikan tombol di Blade.

Wajib:

- Query author selalu dibatasi `author_id = Auth::id()`.
- Query reviewer selalu dibatasi `reviewer_id = Auth::id()`.
- Upload author memvalidasi pemilik bab.
- Upload reviewer memvalidasi reviewer yang ditugaskan.
- Approve/revisi memvalidasi status dan file yang diperlukan.
- Merge memvalidasi semua bab buku sudah `Disetujui`.

UI boleh menyembunyikan tombol, tetapi backend tetap harus menolak request manual berdasarkan ID.

## Katalog, Finalisasi, Produksi, Royalti

Katalog tidak seharusnya dibuat hanya karena ada row finalisasi. Katalog sebaiknya muncul setelah data final lengkap:

- ISBN.
- Cover.
- File final PDF.
- Judul.
- Author/editor.
- Jenis/kategori.
- Tahun terbit.
- Deskripsi atau abstrak.
- Status publish.

Produksi dibuat setelah buku final, bukan saat naskah masih review.

Royalti sebaiknya tidak selalu dibagi rata per bab. Untuk versi awal boleh tetap otomatis, tetapi desain jangka panjang perlu mendukung pembagian royalti per kontributor berdasarkan persentase kontribusi atau kontrak.

## Hal Yang Perlu Dihindari

- Author bebas claim bab.
- Reviewer melihat semua pekerjaan.
- Status berbasis istilah kasar seperti `Claimed` di UI.
- Aksi perubahan data memakai route `GET`.
- Logic penting hanya ada di Blade.
- Hardcode angka status tanpa konstanta atau helper.
- Controller lama yang masih memakai domain asing seperti `Book`, `Review`, `Category`, `editor`, `first_name`, atau `last_name`.
- Menjalankan server/database lokal di laptop user.

## Prioritas Pengembangan Berikutnya

1. Rapikan status editorial dan migrasi label status lama.
2. Tambahkan helper/constant status agar controller tidak memakai angka langsung.
3. Buat assignment author/reviewer oleh admin sebagai alur utama.
4. Hapus endpoint dan UI claim author.
5. Tambahkan keputusan reviewer: `Revisi` atau `Rekomendasikan Disetujui`.
6. Batasi merge hanya jika semua bab sudah disetujui.
7. Tambahkan test akses silang role dan transisi status.
8. Bersihkan controller/view lama yang tidak sesuai domain SIM Buku Ilmiah.

## Commit Message Style

Gunakan commit message singkat dan jelas, misalnya:

- `Refactor chapter workflow to admin assignments`
- `Add editorial status workflow`
- `Restrict reviewer access to assigned chapters`
- `Validate chapter finalization readiness`
- `Document SIM Buku editorial flow`
