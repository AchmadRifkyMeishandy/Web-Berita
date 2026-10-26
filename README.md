# Web-Berita MVC

Portal berita berbasis **PHP native + MySQL/MariaDB** yang direfaktor menggunakan pola MVC. Proyek ini dibuat sebagai portofolio pembelajaran: nama variabel dan file konsisten, query terpusat di Model, tampilan dipisahkan ke View, dan request dipetakan melalui Router.

> **CSS dipertahankan.** File `news-modern.css`, `styles.css`, dan `news-admin-modern.css` disalin dari versi sebelumnya tanpa mengubah isi CSS. Struktur markup dan lokasi asset dipindahkan agar sesuai dengan MVC; desain visual tidak dimaksudkan untuk dirombak.

## Stack

- PHP 8.1+ (disarankan PHP 8.3 di Laragon)
- MySQL / MariaDB dan ekstensi PDO MySQL
- HTML, CSS yang sudah ada, Bootstrap dan Bootstrap Icons dari CDN
- Tanpa framework PHP dan tanpa dependency Composer wajib

## Quick start — instalasi baru

1. Ekstrak proyek ke `C:\laragon\www\Web-Berita-MVC`.
2. Di phpMyAdmin, buat database bernama `beritaindonesia_mvc`.
3. Pilih database tersebut dan impor `database/schema.sql`.
4. Impor `database/seed_demo.sql` untuk mengisi data demo. Jangan impor seed jika kamu akan memigrasikan data dari database lama.
5. Salin `.env.example` menjadi `.env`. Periksa nama database, username, dan password MySQL.
6. Jalankan Apache dan MySQL di Laragon.
7. Buka `http://localhost/Web-Berita-MVC/` (aturan Apache akan mengarahkan ke `public/`). Jika redirect tidak bekerja pada konfigurasi Apache kamu, gunakan `http://localhost/Web-Berita-MVC/public/`.

Jika folder proyekmu berbeda, sesuaikan bagian alamat setelah `localhost`. Cara terbaik untuk deployment adalah membuat virtual host Laragon yang DocumentRoot-nya menunjuk langsung ke folder `public`. File `.htaccess` di root proyek juga memblokir akses langsung ke folder internal, tetapi aturan ini membutuhkan dukungan `mod_rewrite` Apache untuk perlindungan folder.

### Akun demo

- Username: `demo_admin`
- Password: `DemoOnly-Change-2026!`

Akun ini hanya untuk lingkungan lokal/portofolio. Ganti password sebelum demo publik atau deployment. Jangan mengunggah `.env` ke Git.

## Migrasikan data proyek lama dengan aman

Jangan menjalankan migrasi pada database sumber. Migrator menyalin data ke database tujuan baru dan tidak mengubah database lama.

1. Backup database lama melalui phpMyAdmin (Export/Quick/SQL).
2. Buat database tujuan `beritaindonesia_mvc` yang kosong.
3. Impor **hanya** `database/schema.sql` ke database tujuan. Jangan impor `seed_demo.sql` dalam jalur ini.
4. Salin `.env.example` menjadi `.env`. Atur `DB_NAME=beritaindonesia_mvc` untuk tujuan dan `LEGACY_DB_NAME=beritaindonesia` untuk sumber. Sesuaikan host, user, password bila berbeda.
5. Jika database lama berada di instalasi/folder proyek lain, atur `LEGACY_IMAGE_DIR` ke folder `images` proyek lama. Jika kosong, migrator mencoba mencari gambar di `public/assets/images` proyek MVC.
6. Buka PowerShell di root proyek lalu jalankan:

   ```powershell
   php tools/migrate_legacy_database.php
   ```

7. Migrator memeriksa relasi sebelum menulis. Jika ada kategori/artikel/komentar/balasan yang tidak memiliki induk valid, proses berhenti dan menjelaskan ID yang perlu ditinjau. Jangan abaikan laporan tersebut; perbaiki datanya lalu jalankan kembali.
8. Jika sukses, periksa jumlah data pada database tujuan dan buka website.

Migrator sengaja menolak berjalan jika database tujuan tidak kosong untuk mencegah duplikasi. Database lama tidak diubah. Buat backup terlebih dahulu dan jangan menjalankan tool pada database produksi tanpa menguji salinan.

## Struktur folder

```text
Web-Berita-MVC/
├── app/
│   ├── Controllers/        # Menerima request dan mengatur alur
│   ├── Core/               # Router, database, view, CSRF, base controller
│   ├── Models/             # Query dan akses data
│   ├── Services/           # Proses khusus, seperti upload gambar
│   ├── Views/              # HTML untuk publik dan admin
│   └── helpers.php         # Helper escaping, URL, tanggal, flash
├── config/database.php     # Konfigurasi koneksi dari environment
├── database/               # Skema SQL, data demo, DBML
├── docs/                   # Panduan arsitektur dan database
├── public/                 # Entry point browser dan aset statis
├── routes/web.php           # Peta route + HTTP method
├── storage/logs/           # Lokasi laporan lokal
└── tools/                  # Tool migrasi CLI
```

## Cara mengikuti alur kode di VS Code

### Contoh klik kategori

1. `app/Views/partials/public-header.php` membuat tautan kategori menggunakan `url('articles.index', ['category_id' => ...])`.
2. `routes/web.php` memetakan nama route `articles.index` ke `ArticleController::index()`.
3. `app/Controllers/ArticleController.php` membaca dan memvalidasi `category_id`.
4. `app/Models/Article.php` mengambil artikel dengan query terparameterisasi dan JOIN kategori.
5. `app/Views/public/articles/index.php` mengulang data artikel dan membuat kartu.
6. Pengunjung mengeklik kartu, kemudian link menuju route `articles.show` dan `ArticleController::show()`.

### Contoh login admin dan tambah berita

1. Form login ada di `app/Views/admin/auth/login.php`.
2. Request POST masuk ke route `admin.login` di `routes/web.php`.
3. `app/Controllers/Admin/AuthController.php` memeriksa CSRF, username, role dan password hash.
4. `app/Models/User.php` mengambil akun dari database.
5. Setelah masuk, `app/Controllers/Admin/DashboardController.php` menampilkan dashboard.
6. Form tambah ada di `app/Views/admin/articles/form.php`.
7. `Admin/ArticleController.php` memvalidasi data dan meminta `ImageUploadService` memvalidasi/menyimpan gambar.
8. `app/Models/Article.php` menjalankan INSERT dengan prepared statement.

Di VS Code, gunakan `Ctrl+Shift+F` untuk mencari nama route, `url('admin.articles.store')` untuk melihat form action, atau `Article::create` untuk mengikuti query. Lihat `docs/ARCHITECTURE.md` untuk diagram alur.

## Keputusan keamanan

- Query memakai PDO prepared statements.
- Output HTML di-escape menggunakan helper `e()`.
- Perubahan data menggunakan POST dan token CSRF.
- Route admin memeriksa session dan role di server.
- Password diverifikasi dengan `password_verify()`.
- Upload membatasi MIME type dan ukuran serta menggunakan nama acak.
- Kategori yang masih dipakai artikel tidak bisa dihapus (foreign key RESTRICT).
- Hapus artikel menghapus komentar dan balasan terkait melalui foreign key CASCADE.

## Catatan batasan saat ini

- URL dikirim melalui query `?route=...` agar langsung bekerja di Laragon tanpa mengharuskan konfigurasi rewrite. Virtual host opsional dapat mengarahkan DocumentRoot ke `public`.
- Tidak ada fitur author artikel karena skema lama tidak menyimpan relasi penulis; migrasi tidak akan mengarang kepemilikan artikel.
- Migrasi menolak data relasi orphan sebelum penulisan. Untuk data bermasalah, perlu peninjauan manual.
- Pengujian sintaks bisa dilakukan secara lokal; pengujian integrasi tetap memerlukan koneksi database dan browser Laragon.

## License dan data

Gunakan data demo untuk demonstrasi. Periksa lisensi gambar dan sumber artikel sebelum menerbitkan portofolio secara publik.
