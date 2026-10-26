# Mulai dari sini — Web-Berita MVC

Ikuti urutan ini. Jangan langsung mencampur database demo dan database hasil migrasi.

## 1. Pasang proyek di Laragon

1. Backup folder proyek lama dan database lama terlebih dahulu.
2. Ekstrak folder `Web-Berita-MVC` ke `C:\laragon\www\Web-Berita-MVC`.
3. Buka folder tersebut di VS Code.
4. Salin `.env.example` menjadi `.env`.
5. Jalankan Apache dan MySQL dari Laragon.

## 2. Pilih satu cara menyiapkan database

### Pilihan A — demo cepat (database baru kosong)

1. Buat database `beritaindonesia_mvc` di phpMyAdmin.
2. Import `database/schema.sql`.
3. Import `database/seed_demo.sql`.
4. Buka `http://localhost/Web-Berita-MVC/` (aturan Apache akan mengarahkan ke `public/`). Jika redirect tidak bekerja pada konfigurasi Apache kamu, gunakan `http://localhost/Web-Berita-MVC/public/`.

Login demo: `demo_admin` / `DemoOnly-Change-2026!`.

### Pilihan B — pindahkan data dari proyek lama (disarankan jika ingin mempertahankan data)

1. Backup database lama. Jangan ubah atau hapus database lama.
2. Buat database tujuan `beritaindonesia_mvc` yang kosong.
3. Import hanya `database/schema.sql`. Jangan import `seed_demo.sql`.
4. Pastikan `.env` memakai `DB_NAME=beritaindonesia_mvc` dan `LEGACY_DB_NAME=beritaindonesia` (atau nama database lama kamu).
5. Atur `LEGACY_IMAGE_DIR` jika gambar lama berada di folder lain. Contoh:

   ```dotenv
   LEGACY_IMAGE_DIR="C:/laragon/www/Web-Berita-fixed/Web-Berita-fixed/images"
   ```

6. Buka PowerShell dari root proyek, lalu jalankan:

   ```powershell
   php tools/migrate_legacy_database.php
   ```

7. Jika tool melaporkan relasi atau tanggal bermasalah, proses berhenti sebelum menulis. Tinjau laporan tersebut; jangan menghapus data hanya untuk memaksa migrasi lewat.
8. Jika migrasi sukses, buka `http://localhost/Web-Berita-MVC/public/`.

## 3. Alur pertama untuk dipelajari

Mulai dari satu fitur, bukan semua file sekaligus:

- **Klik kategori:** `Views/partials/public-header.php` → `routes/web.php` → `Controllers/ArticleController.php` → `Models/Article.php` → `Views/public/articles/index.php`.
- **Buka detail berita:** `Views/public/articles/index.php` → route `articles.show` → `ArticleController::show()` → `Article::find()` → `Views/public/articles/show.php`.
- **Tambah berita:** `Views/admin/articles/form.php` → route `admin.articles.store` → `Controllers/Admin/ArticleController.php` → `Services/ImageUploadService.php` → `Models/Article.php`.

Buka `docs/ARCHITECTURE.md` untuk diagram request dan `docs/DATABASE.md` untuk relasi tabel.

## 4. Jika tidak tampil

- Periksa `.env`, terutama `DB_HOST`, `DB_NAME`, `DB_USER`, dan `DB_PASSWORD`.
- Pastikan database tujuan berisi tabel `users`, `categories`, `articles`, `comments`, dan `comment_replies`.
- Pastikan PHP CLI Laragon memiliki ekstensi `pdo_mysql` dan `fileinfo`.
- Baca log PHP/Laragon. Aplikasi tidak menampilkan kredensial database kepada pengunjung.
- URL aplikasi dalam konfigurasi folder biasa adalah `http://localhost/Web-Berita-MVC/public/`. Jika folder proyek bernama lain, sesuaikan alamatnya.
