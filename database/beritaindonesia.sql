-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Jul 2025 pada 18.32
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beritaindonesia`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `balaskomentar`
--

CREATE TABLE `balaskomentar` (
  `id_bk` int(10) NOT NULL,
  `nama_bk` varchar(255) NOT NULL,
  `isi_bk` text NOT NULL,
  `tanggal_bk` varchar(255) NOT NULL,
  `kode_k` varchar(255) NOT NULL,
  `kode_berita` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `balaskomentar`
--

INSERT INTO `balaskomentar` (`id_bk`, `nama_bk`, `isi_bk`, `tanggal_bk`, `kode_k`, `kode_berita`) VALUES
(1, 'Pembaca Demo 01', 'Terima kasih atas komentarnya', '03 July 2025', '6', '3'),
(2, 'Pembaca Demo 02', 'Terima kasih atas sarannya', '03 July 2025', '6', '3'),
(3, 'Pembaca Demo 03', 'Terima kasih', '03 July 2025', '6', '3'),
(4, 'Pembaca Demo 04', 'Terima kasih', '03 July 2025', '6', '3'),
(5, 'Pembaca Demo 05', 'Terima kasih atas sarannya', '03 July 2025', '6', '3'),
(6, 'Pembaca Demo 06', 'Terima kasih atas masukannya', '03 July 2025', '6', '3'),
(7, 'Pembaca Demo 07', 'Terima kasih atas sarannya', '03 July 2025', '6', '3'),
(8, 'Pembaca Demo 08', 'Terima kasih', '03 July 2025', '3', '6'),
(9, 'Pembaca Demo 09', 'Terima kasih atas balasannya', '03 July 2025', '4', '6');

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `id_berita` int(10) NOT NULL,
  `kode_kategori` varchar(255) NOT NULL,
  `judul_berita` varchar(255) NOT NULL,
  `isi_berita` text NOT NULL,
  `tanggal_berita` varchar(255) NOT NULL,
  `gambar_berita` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`id_berita`, `kode_kategori`, `judul_berita`, `isi_berita`, `tanggal_berita`, `gambar_berita`) VALUES
(6, '6', 'Harga Minyak Goreng Curah Masih Betah di Rp 19 Ribu per Liter', 'Pada akhir pekan ini, rata-rata harga minyak goreng curah di Jakarta terpantau masih di angka Rp 19 ribu per kg. Nilai jualnya memang telah menurun dibanding beberapa hari selepas Lebaran 2022, yang sempat tembus lebih dari Rp 21 ribu per liter di pasar tradisional di jakarta timur.\r\n\r\nMengutip data infopangan.jakarta.go.id, Minggu (15/5/2022), minyak goreng curah di DKI Jakarta dibanderol pada kisaran harga rata-rata Rp 19.178 per kg. Itu turun 115 per kg dibanding sehari sebelumnya, Sabtu (14/5/2022).\r\n\r\nMinyak goreng curah termahal dijual di Pasar Kebayoran Lama seharga Rp 23 Ribu per kg. Sedangkan harga jual termurah berada di Pasar Jembatan Lima, Rp 17.000 per kg.\r\n\r\nKondisi sedikit berbeda dialami minyak goreng kemasan yang dijual di pasar ritel seperti Alfamart dan Indomaret. Meski masih bertengger di kisaran Rp 22-26 ribu per liter, namun harganya cenderung alami penurunan.', '03 July 2025', 'minyak.jpg'),
(9, '6', 'Gokil Sih! Konsumsi BBM Naik Tinggi Banget saat Mudik 2022', 'Bahan bakar yang mengalami kenaikan sangat tinggi ialah jenis Pertalite. \"Khusus BBM Pertalite itu kenaikannya sangat tinggi sebesar 46% pada H-1, itu adalah penyaluran tertinggi untuk Pertalite,\" sambungnya.\r\n\r\nSementara, saat arus balik gasoline mengalami kenaikan secara nasional sebesar 12%. Kenaikan tertinggi terjadi pada 5 Mei atau H+3 yakni sebesar 29% terhadap penjualan normal.\r\n\r\nDia menambahkan, kenaikan konsumsi ini jauh di atas prediksi sebelumnya. Khususnya untuk arus mudik yang sebelumnya diramal naik hanya 11%.\r\n\r\n\"Jadi memang kenaikannya sangat luar biasa dan ini jauh di atas prediksi, kemarin kalau nggak salah di awal kita memprediksikan akan terjadi kenaikan sekitar 11% namun ternyata kenaikannya sampai 26% pada saat arus mudik, dan 29% saat arus balik,\" ujarnya.\r\n\r\nRekor! Konsumsi BBM Saat Puncak Mudik 2022 Naik 41%\r\nMeski demikian, Pertamina dan badan usaha lain melakukan persiapan dengan baik. Alhasil tidak ada kekurangan atau kelangkaan BBM.\r\n\r\n\"Sehingga meskipun terjadi lonjakan kenaikan yang jauh melampaui dari perkiraan semula semuanya bisa dikendalikan, bisa diatasi, sehingga tidak terjadi kekurangan atau kelangkaan BBM sehingga masyarakat bisa terpenuhi kebutuhannya,\" terangnya.\r\n\r\n', '23 May 2022', 'pombensin.jpg'),
(10, '7', ' NU Tak Boleh Jadi Senjata Kompetisi Politik oleh Parpol  Baca artikel CNN Indonesia ', '\"Kita mohon jangan pakai politik identitas, terutama identitas agama, termasuk identitas NU. Tidak boleh mengeksploitasi identitas NU untuk politik, tidak. NU ini untuk selalu bangsa,\" kata mantan Juru Bicara Kepresidenan era Presiden keempat RI Abdurahman Wahid (Gus Dur) tersebut.\r\n\r\nANALISIS\r\nIsu Kudeta, Panik Cak Imin dan Panas Dingin PKB-NU Jelang Pemilu\r\nSebagai informasi, saat berkunjung ke Kantor PCNU Kabupaten Kediri, Jawa Timur, pada awal Maret 2022 lalu, Gus Yahya sempat mengingatkan agar kader NU terlebih lagi pengurus PBNU tidak terlibat atau menjauhi politik praktis menjelang Pilpres 2024.\r\n\r\nBahkan, pihaknya tidak segan memberikan sanksi tegas dengan peringatan tertulis pertama dan selanjutnya jika ada pengurus yang melanggar aturan.\r\n\r\n\"Langsung kami terbitkan surat peringatan tertulis tahap satu, diulangi lagi surat tertulis tahap dua, diulangi lagi dibekukan. Pokoknya tidak boleh,\" kata mantan Wantimpres tersebut kala itu.\r\n\r\n', '23 May 2022', 'nu.jpeg'),
(11, '7', 'LMU Sesalkan Ada Kegiatan Partai Politik di Kampus Unsera', 'Rianto meminta agar pihak Rektorat dari Universitas Serang Raya mengambil langkah tegas dengan meninjau kembali kegiatan BEM di kampus yang terindikasi ditunggangi oleh kegiatan politik praktis Partai Mahasiswa Indonesia (PMI).\r\n\r\n\"Seharusnya kalau PMI mau mengadakan kegiatan, jangan menggunakan fasilitas kampus. Itu sangat tidak berintegritas,\" ujar dia.\r\n\r\n\"Kami menduga kegiatan pertemuan mahasiswa dengan mengatasnamakan BEM ini ditunggangi oleh sejumlah kader partai,\" ujar dia.\r\n\r\nSeperti diketahui Unsera menjadi lokasi pertemuan sejumlah organisasi dari BEM Nusantara pada 20 sampai 25 Mei 2022.\r\n\r\nDari pertemuan tersebut mengundang Eko Pratama yang merupakan ketua umum Partai Mahasiswa Indonesia.', '23 May 2022', '32456-ilustrasi-politik-pixabay.jpg'),
(12, '8', 'Filosofi Onde onde, Kue Wajib Ritual Syukuran Bugis Makassar Sejak Abad 13', 'Onde-onde merupakan salah satu makanan tradisional masyarakat Bugis-Makassar yang wajib ada pada ritual syukuran. Kue tradisional ini juga disebut Umba-umba oleh masyarakat Bugis-Makassar dan sudah ada sejak abad 13-14.\r\n\r\nKue tradisional ini memiliki cita rasa yang nikmat. Isian serutan gula merah yang lumer memberikan rasa manis legit yang khas. Sementara adonan tepung beras dan parutan kelapa memberikan cita rasa gurih yang tipis. Perpaduan rasa ini cukup memanjakan lidah.\r\n\r\nMeski begitu, kehadiran kue tradisional ini pada acara ritual syukuran masyarakat Bugis-Makassar bukan hanya karena rasanya yang nikmat. Tetapi tersimpan berbagai harapan dan doa melalui kue Onde-onde ini. Sehingga kerap dihadirkan dalam ritual-ritual adat.\r\n\r\nOnde-onde juga menjadi kue wajib hadir dalam ritual syukuran di masyarakat Bugis Makassar. Seperti saat pindah ke rumah baru, atau telah membeli kendaraan baru, dan sebagainya.\r\n\r\n\"Jadi kue itu bukan dihadirkan saja di dalam sebuah ritual atau acara adat, tapi ada harapan dan doa,\" ungkap Firman kepada detikSulsel pada Selasa (10/5/2022)\r\n\r\nFirman menjelaskan, Onde-onde terbuat dari tiga bahan dasar yakni gula merah, tepung beras dan kelapa. Masing-masing bahan tersebut menjadi simbol-simbol tertentu bagi masyarakat Bugis Makassar.\r\n\r\nGula merah disimbolkan sebagai kesukaan, tepung beras simbol dari kekuatan, dan kelapa sebagai simbol kenikmatan. Tiga bahan ini dianggap oleh masyarakat Bugis-Makassar sebagai bahan pokok dalam pembuatan makanan Bugis-Makassar.\r\n', '23 May 2022', 'ondeonde.jpeg'),
(13, '8', 'Beli Baju Saat Lebaran Bisa Meningkatkan Limbah Pakaian? Ini Kata Pakar UNS  Baca artikel detikedu', 'Harus Disikapi dengan Bijak\r\nPakar lingkungan Universitas Sebelas Maret (UNS) Surakarta, Prof. Dr. Prabang Setyono, M.Si. mengatakan bahwa budaya simbolik baju Lebaran memiliki makna positif. Namun, dalam praktiknya harus diimbangi dengan sikap bijak berpakaian.\r\n\r\n\"Budaya tersebut sebenarnya pemaknaan simboliknya bagus, hanya pemaknaan secara fisiknya tidak harus dengan baju baru tapi baju yang bagus yang sudah tersimpan lama tapi belum dipakai atau jarang dipakai saja,\" ujar Prof. Prabang, dikutip dari laman resmi UNS, Rabu (4/5/2022).\r\n\r\nBagaimana Jika Sudah Telanjur Membeli Baju Baru?\r\n\r\nProf. Prabang memberikan beberapa solusi yang dapat dilakukan masyarakat yang sudah telanjur membeli baju baru.\r\n\r\nGuru besar bidang ilmu pencemaran lingkungan ini menyarankan masyarakat untuk menggunakan sistem sirkuler baju layak pakai.\r\n\r\nSistem ini dapat dipahami sebagai penyaluran baju-baju yang dianggap sudah kekecilan atau tidak tren tapi masih bisa dipakai kepada masyarakat yang membutuhkan. Alih-alih membuang, sistem sirkuler penyaluran ini tidak akan menimbulkan limbah bahan tekstil dari baju tersebut.\r\n\r\n\"Bagi yang sudah membeli pakaian maka baju yang dianggap sudah tidak tren atau sudah tidak dipakai harus disalurkan ke suatu unit usaha atau tempat penampungan baju layak pakai untuk didistribusikan ke masyarakat pengguna lain agar penggunaannya berkelanjutan atau sustainable ,\" imbuh Prof. Prabang.', '23 May 2022', 'berburu-baju-lebaran-dengan-thrifting-di-pasar-senen-7.jpeg'),
(14, '6', 'Harga BBM', 'Ini berita yang sangat luar biasa', '03 July 2025', 'WhatsApp Image 2025-07-02 at 21.30.36_2d7ca7cb.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(10) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `tanggal_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `tanggal_kategori`) VALUES
(6, 'Sosial', '21 April 2022'),
(7, 'Politik', '03 July 2025'),
(8, 'Budaya', '21 April 2022');

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar`
--

CREATE TABLE `komentar` (
  `id_k` int(10) NOT NULL,
  `isi_k` text NOT NULL,
  `tanggal_k` varchar(255) NOT NULL,
  `kode_berita` varchar(255) NOT NULL,
  `nama_k` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `komentar`
--

INSERT INTO `komentar` (`id_k`, `isi_k`, `tanggal_k`, `kode_berita`, `nama_k`) VALUES
(3, 'Informasi yang menarik', '03 July 2025', '6', 'Pembaca Demo 10'),
(4, 'Berita yang informatif', '03 July 2025', '6', 'Pembaca Demo 11'),
(5, 'Terima kasih untuk informasinya', '03 July 2025', '9', 'Pembaca Demo 12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level_user` enum('admin','member') NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `foto_user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `level_user`, `nama_user`, `foto_user`) VALUES
(1, 'demo_admin', '$2y$12$pITsMrBhqtdAZtqTfUlybOmd1LrcGidfeepZOz0CEPeJXmpJtNl9W', 'admin', 'Admin Demo', 'default');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `balaskomentar`
--
ALTER TABLE `balaskomentar`
  ADD PRIMARY KEY (`id_bk`);

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id_k`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `balaskomentar`
--
ALTER TABLE `balaskomentar`
  MODIFY `id_bk` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id_k` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
