<?php include "controllers/connect.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Detail Berita</title>
    <?php include "link.php"; ?>
</head>
<body>

<?php include "header.php"; ?>

<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">

            <!-- Tampilkan isi berita -->
            <?php
            $konten = mysqli_query($db, "SELECT * FROM berita WHERE id_berita='$_GET[id_berita]'");
            while($k = mysqli_fetch_array($konten)) {
                $kategori = mysqli_query($db, "SELECT * FROM kategori WHERE id_kategori='$k[kode_kategori]'");
                $kat = mysqli_fetch_array($kategori);
            ?>
                <div class="post-preview">
                    <h2>Kategori: <?= $kat['nama_kategori']; ?></h2>
                    <h3><?= $k['judul_berita']; ?></h3>
                    <img src="images/<?= $k['gambar_berita']; ?>" width="400" />
                    <p style="color:gray; font-size:14px;">Posted on <?= $k['tanggal_berita']; ?></p>
                    <p><?= $k['isi_berita']; ?></p>
                </div>
            <?php } ?>

            <hr />
            <h4>Komentar</h4>

            <!-- Form komentar utama -->
            <form action="detail_berita.php?id_berita=<?= $_GET['id_berita']; ?>" method="POST">
                <input type="text" name="nama_k" placeholder="Nama Anda" required style="width:100%; margin-bottom:5px;" />
                <input type="hidden" name="kode_berita" value="<?= $_GET['id_berita']; ?>" />
                <textarea name="isi_k" placeholder="Tulis komentar..." required style="width:100%; margin-bottom:5px;"></textarea>
                <input type="submit" name="tbh" value="Kirim Komentar" style="width:100%;" />
            </form>

            <hr />

            <!-- Tampilkan komentar & balasannya -->
            <?php
            $komentar = mysqli_query($db, "SELECT * FROM komentar WHERE kode_berita='$_GET[id_berita]' ORDER BY id_k DESC");
            while($kom = mysqli_fetch_array($komentar)) {
            ?>
                <p><b><?= $kom['nama_k']; ?></b> <span style="font-size:12px; color:gray;"><?= $kom['tanggal_k']; ?></span></p>
                <p><?= $kom['isi_k']; ?></p>

                <!-- Tampilkan balasan -->
                <div style="margin-left:20px; background:#f9f9f9; padding:10px; border-radius:5px;">
                    <?php
                    $balas = mysqli_query($db, "SELECT * FROM balaskomentar WHERE kode_k='$kom[id_k]' ORDER BY id_bk ASC");
                    while($b = mysqli_fetch_array($balas)) {
                    ?>
                        <p style="font-size:13px;"><b><?= $b['nama_bk']; ?></b> <span style="font-size:11px; color:gray;"><?= $b['tanggal_bk']; ?></span></p>
                        <p style="font-size:13px;"><?= $b['isi_bk']; ?></p>
                        <hr />
                    <?php } ?>
                </div>

                <!-- Form balasan komentar -->
                <form action="detail_berita.php?id_berita=<?= $_GET['id_berita']; ?>" method="POST" style="margin-left:20px; margin-top:10px;">
                    <input type="text" name="nama_k" placeholder="Nama Anda" required style="width:100%; margin-bottom:5px; font-size:12px;" />
                    <textarea name="isi_k" placeholder="Tulis balasan..." required style="width:100%; font-size:12px; margin-bottom:5px;"></textarea>
                    <input type="hidden" name="kode_k" value="<?= $kom['id_k']; ?>" />
                    <input type="hidden" name="kode_b" value="<?= $_GET['id_berita']; ?>" />
                    <input type="submit" name="bls" value="Balas Komentar" style="width:100%; font-size:12px;" />
                </form>

                <hr />
            <?php } ?>

        </div>
    </div>
</div>

<!-- Proses Simpan Komentar -->
<?php
if (@$_POST['tbh']) {
    $nama_k = $_POST['nama_k'];
    $isi_k = $_POST['isi_k'];
    $kode_berita = $_POST['kode_berita'];
    $tanggal = date('d F Y');

    $query = "INSERT INTO komentar (nama_k, isi_k, tanggal_k, kode_berita)
              VALUES ('$nama_k', '$isi_k', '$tanggal', '$kode_berita')";
    mysqli_query($db, $query);
    echo "<script>window.location.href='detail_berita.php?id_berita=$kode_berita';</script>";
}
?>

<!-- Proses Simpan Balasan -->
<?php
if (@$_POST['bls']) {
    $nama_bk = $_POST['nama_k'];
    $isi_bk = $_POST['isi_k'];
    $kode_k = $_POST['kode_k'];         // id_k komentar
    $kode_berita = $_POST['kode_b'];    // id_berita
    $tanggal_bk = date('d F Y');

    $query = "INSERT INTO balaskomentar (nama_bk, isi_bk, tanggal_bk, kode_k, kode_berita)
              VALUES ('$nama_bk', '$isi_bk', '$tanggal_bk', '$kode_k', '$kode_berita')";
    mysqli_query($db, $query);
    echo "<script>window.location.href='detail_berita.php?id_berita=$kode_berita';</script>";
}
?>

<?php include "footer.php"; ?>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
