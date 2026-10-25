<?php
$rawId = $_GET['id_berita'] ?? null;
$articleId = filter_var($rawId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

if ($articleId === false || $articleId === null) {
    header('Location: index.php');
    exit;
}

// Keep older shared URLs working while routing readers through the secured article page.
header('Location: detail_berita.php?id_berita=' . $articleId . '#comments');
exit;
