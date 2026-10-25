<?php
mysqli_report(MYSQLI_REPORT_OFF);

$db = mysqli_connect('localhost', 'root', '', 'beritaindonesia');

if (!$db) {
    error_log('Database connection failed: ' . mysqli_connect_error());
    http_response_code(500);
    exit('Website sedang mengalami gangguan koneksi database. Silakan coba lagi nanti.');
}

mysqli_set_charset($db, 'utf8mb4');
