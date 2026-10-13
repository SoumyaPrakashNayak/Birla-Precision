<?php
/**
 * Birla Precision Technologies - File Upload Helper
 * Handles secure image uploads for Hero, Tiles, Collections, and Products.
 */

function handle_image_upload($file_array, $destination_folder = 'products') {
    if (!isset($file_array) || !is_array($file_array) || $file_array['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'No file uploaded or upload error code: ' . ($file_array['error'] ?? 'NONE')];
    }

    $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
    $allowed_mimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml'];

    $file_name = $file_array['name'];
    $file_tmp  = $file_array['tmp_name'];
    $file_size = $file_array['size'];

    // 15MB max
    if ($file_size > 15 * 1024 * 1024) {
        return ['success' => false, 'error' => 'File size exceeds 15MB limit.'];
    }

    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed_extensions, true)) {
        return ['success' => false, 'error' => 'Invalid file format. Allowed formats: ' . implode(', ', $allowed_extensions)];
    }

    // Verify MIME
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $file_tmp);
    finfo_close($finfo);

    if (!in_array($mime, $allowed_mimes, true) && $ext !== 'svg') {
        return ['success' => false, 'error' => 'Uploaded file failed MIME verification: ' . $mime];
    }

    // Prepare directory
    $base_dir = dirname(__DIR__) . '/uploads/' . trim($destination_folder, '/');
    if (!is_dir($base_dir)) {
        @mkdir($base_dir, 0755, true);
    }

    $clean_stem = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($file_name, PATHINFO_FILENAME));
    $clean_stem = substr($clean_stem, 0, 30);
    $unique_name = $clean_stem . '_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $target_filepath = $base_dir . '/' . $unique_name;

    if (move_uploaded_file($file_tmp, $target_filepath)) {
        // Return relative path for web usage
        return [
            'success' => true,
            'file_path' => 'uploads/' . trim($destination_folder, '/') . '/' . $unique_name,
            'file_name' => $unique_name
        ];
    }

    return ['success' => false, 'error' => 'Failed to move uploaded file to destination directory.'];
}
