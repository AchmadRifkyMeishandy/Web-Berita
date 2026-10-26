<?php

declare(strict_types=1);

namespace App\Services;

use RuntimeException;

final class ImageUploadService
{
    private const MAX_SIZE = 5242880; // 5 MB
    private const MIME_EXTENSIONS = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    public function store(array $file): string
    {
        if (!isset($file['error']) || is_array($file['error'])) {
            throw new RuntimeException('Data upload gambar tidak valid.');
        }
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Gambar gagal diunggah. Periksa ukuran file lalu coba lagi.');
        }
        if (!isset($file['tmp_name'], $file['size']) || (int) $file['size'] > self::MAX_SIZE) {
            throw new RuntimeException('Ukuran gambar maksimal 5 MB.');
        }

        $mimeType = (new \finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        $imageInformation = getimagesize($file['tmp_name']);
        if (!isset(self::MIME_EXTENSIONS[$mimeType]) || $imageInformation === false) {
            throw new RuntimeException('Format gambar yang diperbolehkan hanya JPG, PNG, dan WEBP.');
        }

        $directory = dirname(__DIR__, 2) . '/public/assets/images/uploads';
        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new RuntimeException('Folder penyimpanan gambar tidak dapat dibuat.');
        }

        $filename = bin2hex(random_bytes(16)) . '.' . self::MIME_EXTENSIONS[$mimeType];
        if (!move_uploaded_file($file['tmp_name'], $directory . '/' . $filename)) {
            throw new RuntimeException('Gambar tidak dapat disimpan. Periksa izin folder uploads.');
        }

        return 'uploads/' . $filename;
    }

    public function deleteIfUploaded(?string $relativePath): void
    {
        $relativePath = (string) $relativePath;
        if (!str_starts_with($relativePath, 'uploads/')) {
            return;
        }
        $filename = basename($relativePath);
        $path = dirname(__DIR__, 2) . '/public/assets/images/uploads/' . $filename;
        if (is_file($path) && !unlink($path)) {
            error_log('Could not remove an uploaded article image: ' . $path);
        }
    }
}
