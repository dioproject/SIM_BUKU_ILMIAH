<h1 align="center">SIM Buku Ilmiah</h1>

<p align="center">
  Sistem Informasi Manajemen Penerbitan Buku Ilmiah dengan alur editorial terstruktur.
</p>

## Tentang

SIM Buku Ilmiah adalah aplikasi berbasis web untuk mengelola proses penerbitan buku ilmiah dari hulu ke hilir:

- Manajemen user (admin, author, reviewer)
- Pembuatan buku dan struktur bab
- Assignment author & reviewer ke bab
- Upload naskah, review, dan revisi
- Finalisasi buku dan katalog
- Produksi dan royalti

## Alur Editorial

```
Admin buat bab → Assign author/reviewer → Author upload naskah
→ Reviewer nilai → Revisi jika perlu → Disetujui → Finalisasi → Terbit
```

## Tech Stack

- **Laravel** — PHP Framework
- **Stisla** — Bootstrap Admin Template
- **MySQL** — Database
- **Docker** — Deployment (VPS)

## Prasyarat

- PHP ^8.1
- Composer
- MySQL
- Node.js & NPM

## Instalasi

```bash
git clone https://github.com/dioproject/SIM_BUKU_ILMIAH.git
cd SIM_BUKU_ILMIAH
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Testing

```bash
php artisan test
```

## Lisensi

[MIT](LICENSE)
