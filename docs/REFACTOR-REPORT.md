# Laporan refactoring Web-Berita

## Hasil yang dibuat

- Memisahkan request routing, controller, model, view, service, dan konfigurasi.
- Menggunakan PDO dan prepared statements untuk query database.
- Menyeragamkan penamaan model/tabel/kolom pada skema baru menjadi bahasa Inggris dan `snake_case`.
- Menambahkan foreign key dan indeks pada database MVC.
- Menambahkan CSRF protection pada form yang mengubah data.
- Menambahkan pengecekan session/role untuk semua route admin.
- Menggunakan `password_verify()` untuk autentikasi.
- Membatasi upload ke JPG/PNG/WEBP, maksimum 5 MB, nama acak, dan direktori upload dengan larangan eksekusi script.
- Menambahkan migrator legacy yang memeriksa relasi dan menolak database tujuan yang sudah berisi data.
- Menambahkan panduan setup, arsitektur, DBML, dan cara tracing request.
- CSS di-copy tanpa mengubah isi file: `news-modern.css`, `styles.css`, dan `news-admin-modern.css`.

## Pemetaan file lama

| Legacy | MVC |
|---|---|
| `index.php` | `HomeController` + `Views/public/home.php` |
| `berita.php` | `ArticleController::index()` + `Views/public/articles/index.php` |
| `detail_berita.php` | `ArticleController::show()` + `Views/public/articles/show.php` |
| `header.php` / `footer.php` | `Views/partials/public-header.php` / `public-footer.php` |
| `controllers/connect.php` | `Core/Database.php` + `config/database.php` |
| `controllers/login_admin.php` | `Admin/AuthController.php` + `Models/User.php` |
| `admin/index.php` | `Admin/DashboardController.php` + `Views/admin/dashboard.php` |
| `admin/berita.php` | `Admin/ArticleController.php` + `Views/admin/articles/index.php` |
| `admin/t_berita.php` / `e_berita.php` | `Views/admin/articles/form.php` + `Admin/ArticleController.php` |
| `controllers/proses_tbh_berita.php` / `proses_edit_berita.php` | `Admin/ArticleController.php` + `Models/Article.php` + `ImageUploadService.php` |
| `admin/kategori.php`, `t_kategori.php`, `e_kategori.php` | `Admin/CategoryController.php` + `Views/admin/categories/*` |
| `admin/komentar.php` | `Admin/CommentController.php` + `Views/admin/comments/index.php` |

## Catatan verifikasi

Pemeriksaan lokal yang telah dilakukan saat paket dibuat:

- Seluruh 41 file PHP berhasil melewati `php -l` tanpa kesalahan sintaks.
- Referensi nama route dari View cocok dengan route yang didefinisikan.
- Class/action yang terdaftar pada Router diperiksa secara statis.
- Referensi asset lokal diperiksa dan file CSS utama cocok byte-for-byte dengan CSS sumber sebelumnya.
- Helper URL, slug, dan ringkasan teks diperiksa secara dasar.
- Hash password demo diverifikasi dengan `password_verify()`.

**Batasan penting:** lingkungan pembuatan paket ini tidak memiliki ekstensi PDO MySQL (`pdo_mysql`) maupun server MySQL/MariaDB yang dapat dipakai. Karena itu, integrasi database, migrasi data, dan pengujian browser langsung belum dapat dinyatakan berhasil. Jalankan pengujian tersebut di Laragon setelah mengaktifkan PDO MySQL dan menyiapkan database. Jangan menganggap migrasi database atau semua interaksi browser sudah berhasil sebelum menjalankannya di lingkunganmu.

## Hal yang belum disediakan

- Tidak ada relasi author untuk artikel karena tidak ada data author yang konsisten pada database lama.
- Tidak ada rich-text HTML untuk isi artikel. Isi artikel ditampilkan sebagai teks yang di-escape, untuk mengurangi risiko stored XSS.
- Tidak ada user management admin; autentikasi admin lama dipertahankan sesuai tabel `users`.
- Belum ada automated browser suite; pengujian manual dan pemeriksaan syntax tetap diperlukan.
