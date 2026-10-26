# Database Web-Berita MVC

## Tabel dan relasi

- `users`: identitas login, password hash, dan role admin/member.
- `categories`: kategori artikel dengan `name` dan `slug` unik.
- `articles`: artikel yang menunjuk satu kategori melalui `category_id`.
- `comments`: komentar yang menunjuk satu artikel melalui `article_id`.
- `comment_replies`: balasan yang menunjuk satu komentar melalui `comment_id`.

Relasi:

```text
categories 1 ───── n articles
articles   1 ───── n comments
comments   1 ───── n comment_replies
```

`users` belum berelasi dengan `articles` karena database lama tidak menyimpan author artikel. Tidak ada relasi author yang dibuat-buat saat migrasi.

## Mengapa foreign key penting?

Foreign key mencegah artikel menunjuk kategori yang tidak ada, komentar menunjuk artikel yang hilang, atau balasan menunjuk komentar yang tidak ada. Kolom kunci menggunakan tipe `INT UNSIGNED` yang sama. Indeks dibuat untuk foreign key dan kolom pengurutan utama.

Kebijakan penghapusan:

- Kategori: `RESTRICT` karena kategori yang masih digunakan artikel harus dipindah lebih dahulu.
- Artikel: komentar dihapus dengan `CASCADE` karena komentar tidak dapat berdiri tanpa artikel.
- Komentar: balasan dihapus dengan `CASCADE` karena balasan tidak dapat berdiri tanpa komentar.

## Skema lama ke skema baru

| Legacy | MVC | Mapping |
|---|---|---|
| `kategori.id_kategori` | `categories.id` | ID dipertahankan |
| `kategori.nama_kategori` | `categories.name` | Nama kategori |
| `kategori.tanggal_kategori` | `categories.created_at` | Dikonversi menjadi DATETIME |
| `berita.id_berita` | `articles.id` | ID dipertahankan |
| `berita.kode_kategori` | `articles.category_id` | String numerik dikonversi ke integer |
| `berita.judul_berita` | `articles.title` | Judul |
| `berita.isi_berita` | `articles.body` | Isi lengkap dipertahankan |
| `berita.gambar_berita` | `articles.image_path` | Nama/path relatif gambar |
| `berita.tanggal_berita` | `articles.published_at` | Dikonversi ke DATETIME jika dapat diparsing |
| `komentar.id_k` | `comments.id` | ID dipertahankan |
| `komentar.kode_berita` | `comments.article_id` | ID artikel integer |
| `balaskomentar.id_bk` | `comment_replies.id` | ID dipertahankan |
| `balaskomentar.kode_k` | `comment_replies.comment_id` | ID komentar integer |
| `users.password` | `users.password_hash` | Hash dipertahankan; nilai plaintext lama di-hash selama migrasi |
| `users.level_user` | `users.role` | Admin/member yang valid dipertahankan |

## Pilihan instalasi

### Fresh install

Import `schema.sql`, kemudian `seed_demo.sql`. Seed hanya untuk database kosong.

### Migrasi data lama

Import `schema.sql` ke database tujuan kosong, atur `.env`, lalu jalankan `php tools/migrate_legacy_database.php`. Tool memeriksa orphan sebelum mulai menulis, memastikan database tujuan kosong, dan memakai transaksi pada database tujuan.

Backup database lama terlebih dahulu. Database sumber tidak dimodifikasi. Jika migrator berhenti karena relasi orphan, tidak ada data tujuan yang ditulis; perbaiki atau tinjau data lama sebelum mencoba lagi.

## DBML

File `database/schema.dbml` menggambarkan skema MVC yang sebenarnya dan dapat disalin ke dbdiagram.io.
