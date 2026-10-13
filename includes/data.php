<?php
/**
 * Birla Precision Technologies Limited / Dagger Brand
 * Catalogue Data Access & Procedural Helper Functions
 * 
 * Source: ITM - Price List - Effective 1st April 2026
 * Standard: IS : 5101 | HSN Code: 8207
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Generate CSRF token if not set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
session_write_close();

/**
 * Get product family metadata
 */
function get_product_family() {
    return [
        'id' => 1,
        'name' => 'HSS Parallel Shank Twist Drills — Jobber Series',
        'short_name' => 'Parallel Shank Twist Drills (Jobber Series)',
        'slug' => 'parallel-shank-twist-drills',
        'brand' => 'Dagger Brand / Birla Precision',
        'standard' => 'IS : 5101 (Also conforming to ISO 235 / DIN 338)',
        'hsn_code' => '8207',
        'material' => 'HSS M2 (Standard) / HSS M35 Cobalt / CNC Ground Specs',
        'shank_type' => 'Parallel (Straight Cylindrical)',
        'series' => 'Jobber Series',
        'pricing_unit' => 'PRICE PER 10 PCS (RS.)',
        'effective_date' => 'Effective: 1st April 2026',
        'description' => 'Birla Precision Technologies Limited / Dagger Brand HSS Parallel Shank Twist Drills (Jobber Series) are engineered in accordance with Indian Standard IS : 5101. Manufactured from premium High-Speed Steel with precision CNC grinding technology across ITM plants in Nashik, Aurangabad, and Chalisgaon. Engineered for accurate concentricity, clean chip evacuation, and reliable industrial performance across diverse metals.',
        'page_range' => 'Pages 17 – 22 of April 2026 Price List',
        'total_diameters' => 262,
        'diameter_range' => '0.30 mm to 22.22 mm (7/8")',
        'hero_image' => 'assets/images/products/hss_jobber_drills_clean.png',
        'family_image' => 'assets/images/products/hss_drills_family.png'
    ];
}

/**
 * Get all 6 verified variants
 */
function get_product_variants() {
    return [
        'itm_std' => [
            'code' => 'itm_std',
            'name' => 'ITM STD.',
            'badge' => 'Standard Industrial',
            'grade' => 'HSS M2',
            'coating' => 'Bright / Steam Tempered',
            'summary' => 'Standard industrial workhorse for carbon steels, structural alloys, cast iron, and general engineering.',
            'logo' => 'assets/images/brand/dagger_brand_logo.png',
            'accent' => '#D32F2F',
            'popular' => true
        ],
        'itm_std_tin' => [
            'code' => 'itm_std_tin',
            'name' => 'ITM STD. TIN',
            'badge' => 'TiN Gold Coated',
            'grade' => 'HSS M2 + TiN',
            'coating' => 'Titanium Nitride (TiN)',
            'summary' => 'Golden TiN ceramic coating reduces friction, resists heat buildup, and substantially extends tool life during repetitive production runs.',
            'logo' => 'assets/images/brand/dagger_brand_logo.png',
            'accent' => '#D4AF37',
            'popular' => true
        ],
        'panther' => [
            'code' => 'panther',
            'name' => 'PANTHER',
            'badge' => 'CNC Point Geometry',
            'grade' => 'HSS Premium',
            'coating' => 'Special Surface Treatment',
            'summary' => 'Manufactured on high-precision CNC grinders with unique point geometry to minimize thrust force and machine tough materials like stainless steel and alloy steels.',
            'logo' => 'assets/images/brand/panther_logo.png',
            'accent' => '#212121',
            'popular' => false
        ],
        'ninja' => [
            'code' => 'ninja',
            'name' => 'NINJA',
            'badge' => 'M35 Cobalt / Razor Sharp',
            'grade' => 'HSS M35 Cobalt',
            'coating' => 'Ground Razor Accuracy',
            'summary' => 'Cobalt-alloyed high-speed steel with superior red hardness for high-temperature resistance and razor-sharp cutting in abrasive high-tensile steels.',
            'logo' => 'assets/images/brand/ninja_logo.png',
            'accent' => '#B71C1C',
            'popular' => false
        ],
        'forgeline' => [
            'code' => 'forgeline',
            'name' => 'FORGELINE',
            'badge' => 'Forged Steel & Cast Iron',
            'grade' => 'HSS Robust Geometry',
            'coating' => 'High Wear Resistance',
            'summary' => 'Engineered with heavy-duty web and robust flutes specifically tested for forged steels, heavy castings, and demanding production environments.',
            'logo' => 'assets/images/brand/forgeline_logo.png',
            'accent' => '#E65100',
            'popular' => false
        ],
        'hathyar' => [
            'code' => 'hathyar',
            'name' => 'HATHYAR',
            'badge' => 'Heavy-Duty Workhorse',
            'grade' => 'HSS Heavy Duty',
            'coating' => 'Industrial Ground',
            'summary' => 'Rugged, high-torque industrial jobber drill series engineered for severe fabrication shop conditions and maintenance tasks.',
            'logo' => 'assets/images/brand/hathyar_logo.png',
            'accent' => '#3E2723',
            'popular' => false
        ]
    ];
}

/**
 * Load all diameter rows from JSON
 */
function get_all_jobber_sizes() {
    static $sizes = null;
    if ($sizes !== null) {
        return $sizes;
    }
    
    // Look in current directory or parent directory
    $paths = [
        __DIR__ . '/../jobber_series_data.json',
        __DIR__ . '/jobber_series_data.json',
        dirname(__DIR__) . '/jobber_series_data.json'
    ];
    
    $json_content = null;
    foreach ($paths as $p) {
        if (file_exists($p)) {
            $json_content = file_get_contents($p);
            break;
        }
    }
    
    if ($json_content) {
        $sizes = json_decode($json_content, true);
    } else {
        $sizes = [];
    }
    
    return $sizes;
}

/**
 * Get a specific size row by metric diameter (string or float)
 */
function get_size_by_diameter($mm_query) {
    $sizes = get_all_jobber_sizes();
    $target_str = number_format((float)$mm_query, 2, '.', '');
    
    foreach ($sizes as $row) {
        if (number_format((float)$row['mm'], 2, '.', '') === $target_str) {
            return $row;
        }
    }
    return null;
}

/**
 * Get popular standard diameters for quick-selection buttons
 */
function get_popular_jobber_diameters() {
    return [
        ['mm' => '1.00', 'inch' => '', 'dg' => '', 'label' => '1.0 mm'],
        ['mm' => '2.00', 'inch' => '', 'dg' => '', 'label' => '2.0 mm'],
        ['mm' => '3.00', 'inch' => '', 'dg' => '', 'label' => '3.0 mm'],
        ['mm' => '3.17', 'inch' => '1/8', 'dg' => '', 'label' => '3.17 mm (1/8")'],
        ['mm' => '4.00', 'inch' => '', 'dg' => '', 'label' => '4.0 mm'],
        ['mm' => '5.00', 'inch' => '', 'dg' => '', 'label' => '5.0 mm'],
        ['mm' => '6.00', 'inch' => '', 'dg' => '', 'label' => '6.0 mm'],
        ['mm' => '6.35', 'inch' => '1/4', 'dg' => '', 'label' => '6.35 mm (1/4")'],
        ['mm' => '6.80', 'inch' => '', 'dg' => '', 'label' => '6.8 mm (M8 tap)'],
        ['mm' => '8.00', 'inch' => '', 'dg' => '', 'label' => '8.0 mm'],
        ['mm' => '8.50', 'inch' => '', 'dg' => '', 'label' => '8.5 mm (M10 tap)'],
        ['mm' => '9.52', 'inch' => '3/8', 'dg' => '', 'label' => '9.52 mm (3/8")'],
        ['mm' => '10.00', 'inch' => '', 'dg' => '', 'label' => '10.0 mm'],
        ['mm' => '12.00', 'inch' => '', 'dg' => '', 'label' => '12.0 mm'],
        ['mm' => '12.70', 'inch' => '1/2', 'dg' => '', 'label' => '12.7 mm (1/2")']
    ];
}

/**
 * Format Indian Rupee currency with commas
 */
function format_inr($amount) {
    if ($amount === null || $amount === '') {
        return 'Not Listed';
    }
    $num = (float)$amount;
    return '₹' . number_format($num, 0, '.', ',');
}

/**
 * Procedural database connection using mysqli with prepared statements
 */
function get_db_connection() {
    static $mysqli = null;
    if ($mysqli !== null) {
        return $mysqli;
    }
    
    // Prevent unhandled exception from halting script if MySQL service is inactive
    mysqli_report(MYSQLI_REPORT_OFF);
    
    // 1. Attempt Hostinger Production MySQL
    $mysqli = @new mysqli('127.0.0.1', 'u641661223_DRILLMAC', 'fi7Qo2uF', 'u641661223_DRILLMAC');
    if (!$mysqli->connect_errno) {
        $mysqli->set_charset('utf8mb4');
        return $mysqli;
    }
    
    // 2. Attempt Local Development MySQL (XAMPP default)
    $mysqli = @new mysqli('127.0.0.1', 'root', '', 'birla_precision');
    if (!$mysqli->connect_errno) {
        $mysqli->set_charset('utf8mb4');
        return $mysqli;
    }
    
    // Return null gracefully if neither MySQL server is reachable
    $mysqli = null;
    return null;
}
