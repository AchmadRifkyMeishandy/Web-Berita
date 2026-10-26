-- Data contoh untuk pemasangan baru saja.
-- Jangan import file ini jika database sudah memiliki data hasil migrasi lama.

INSERT INTO users (id, username, password_hash, role, full_name, profile_photo) VALUES
(1, 'demo_admin', '$2y$12$pITsMrBhqtdAZtqTfUlybOmd1LrcGidfeepZOz0CEPeJXmpJtNl9W', 'admin', 'Admin Demo', NULL);

INSERT INTO categories (id, name, slug, created_at) VALUES
(1, 'Sosial', 'sosial', '2022-04-21 00:00:00'),
(2, 'Politik', 'politik', '2025-07-03 00:00:00'),
(3, 'Budaya', 'budaya', '2022-04-21 00:00:00');

INSERT INTO articles (id, category_id, title, slug, body, image_path, published_at) VALUES
(1, 1, 'Harga Minyak Goreng Curah Masih Betah di Rp 19 Ribu per Liter', 'harga-minyak-goreng-curah-rp-19-ribu', 'Rata-rata harga minyak goreng curah di Jakarta masih menjadi perhatian pembeli di pasar tradisional. Informasi harga pangan membantu pembaca memahami pergerakan harga kebutuhan pokok dan dampaknya terhadap rumah tangga.', 'minyak.jpg', '2022-05-15 10:00:00'),
(2, 1, 'Konsumsi BBM Meningkat Saat Periode Mudik', 'konsumsi-bbm-meningkat-saat-mudik', 'Konsumsi bahan bakar meningkat pada periode mudik dan arus balik. Perencanaan distribusi menjadi penting agar kebutuhan masyarakat dapat tetap terpenuhi selama perjalanan.', 'pombensin.jpg', '2022-05-23 09:00:00'),
(3, 2, 'NU Tak Boleh Jadi Senjata Kompetisi Politik oleh Parpol', 'nu-tak-boleh-jadi-senjata-kompetisi-politik', 'Tokoh masyarakat mengingatkan bahwa identitas organisasi dan agama sebaiknya tidak dieksploitasi untuk kepentingan kompetisi politik. Ruang publik perlu memberi tempat bagi diskusi yang sehat dan saling menghormati.', 'nu.jpeg', '2022-05-23 08:30:00'),
(4, 3, 'Filosofi Onde-onde dalam Tradisi Syukuran Bugis Makassar', 'filosofi-onde-onde-tradisi-syukuran', 'Onde-onde atau umba-umba menjadi bagian dari tradisi syukuran masyarakat Bugis-Makassar. Bahan dan penyajiannya menyimpan makna yang diwariskan lintas generasi.', 'ondeonde.jpeg', '2022-05-23 08:00:00'),
(5, 3, 'Beli Baju Saat Lebaran Bisa Meningkatkan Limbah Pakaian?', 'beli-baju-lebaran-limbah-pakaian', 'Kebiasaan membeli pakaian baru dapat dibarengi sikap bijak, seperti menggunakan pakaian yang masih layak dan menyalurkan pakaian yang tidak lagi dipakai agar masa gunanya lebih panjang.', 'berburu-baju-lebaran-dengan-thrifting-di-pasar-senen-7.jpeg', '2022-05-23 07:30:00');

INSERT INTO comments (id, article_id, name, body, created_at) VALUES
(1, 1, 'Pembaca Demo 10', 'Informasi yang menarik', '2025-07-03 10:00:00'),
(2, 1, 'Pembaca Demo 11', 'Berita yang informatif', '2025-07-03 10:10:00'),
(3, 2, 'Pembaca Demo 12', 'Terima kasih untuk informasinya', '2025-07-03 11:00:00');

INSERT INTO comment_replies (id, comment_id, name, body, created_at) VALUES
(1, 1, 'Pembaca Demo 08', 'Terima kasih', '2025-07-03 12:00:00'),
(2, 2, 'Pembaca Demo 09', 'Terima kasih atas balasannya', '2025-07-03 12:10:00');
