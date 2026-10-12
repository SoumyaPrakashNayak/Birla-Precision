<?php
/**
 * Birla Precision Technologies - Product Data API
 * Returns structured Jobber Series data for dynamic filtering, diameter search, and variant pricing
 */

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: public, max-age=3600');

require_once __DIR__ . '/../includes/data.php';

$action = isset($_GET['action']) ? trim($_GET['action']) : 'all';

if ($action === 'overview') {
    echo json_encode([
        'status' => 'success',
        'family' => get_product_family(),
        'variants' => get_product_variants(),
        'popular' => get_popular_jobber_diameters()
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit;
}

if ($action === 'size') {
    $dia = isset($_GET['dia']) ? trim($_GET['dia']) : '';
    $size = get_size_by_diameter($dia);
    if ($size) {
        echo json_encode([
            'status' => 'success',
            'data' => $size,
            'unit' => 'PRICE PER 10 PCS (RS.)',
            'terms' => 'Prices are base prices. GST & taxes extra. Effective: 1st April 2026.'
        ], JSON_UNESCAPED_SLASHES);
    } else {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Diameter not found in April 2026 catalogue']);
    }
    exit;
}

if ($action === 'all') {
    $sizes = get_all_jobber_sizes();
    echo json_encode([
        'status' => 'success',
        'total' => count($sizes),
        'unit' => 'PRICE PER 10 PCS (RS.)',
        'edition' => 'Effective: 1st April 2026',
        'variants' => get_product_variants(),
        'sizes' => $sizes
    ], JSON_UNESCAPED_SLASHES);
    exit;
}

http_response_code(400);
echo json_encode(['status' => 'error', 'message' => 'Invalid action parameter']);
