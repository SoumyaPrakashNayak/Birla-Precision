<?php
/**
 * Birla Precision Technologies Limited - Database Manager & Multi-Environment Connector
 * Configured for Hostinger MySQL (u641661223_DRILLMAC) with graceful SQLite local fallback.
 */

define('HOSTINGER_DB_HOST', 'localhost');
define('HOSTINGER_DB_NAME', 'u641661223_DRILLMAC');
define('HOSTINGER_DB_USER', 'u641661223_DRILLMAC');
define('HOSTINGER_DB_PASS', 'fi7Qo2uF');

define('LOCAL_DB_HOST', '127.0.0.1');
define('LOCAL_DB_NAME', 'birla_precision');
define('LOCAL_DB_USER', 'root');
define('LOCAL_DB_PASS', '');

$GLOBALS['_bptl_db_connection'] = null;
$GLOBALS['_bptl_db_driver'] = null; // 'mysql' or 'sqlite'

/**
 * Returns active PDO connection (Hostinger MySQL -> Local MySQL -> SQLite)
 *
 * @return PDO
 */
function get_db() {
    if ($GLOBALS['_bptl_db_connection'] !== null) {
        return $GLOBALS['_bptl_db_connection'];
    }

    $pdo = null;

    // 1. Try Hostinger MySQL credentials (standard on Hostinger web servers)
    try {
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', HOSTINGER_DB_HOST, HOSTINGER_DB_NAME);
        $pdo = new PDO($dsn, HOSTINGER_DB_USER, HOSTINGER_DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_TIMEOUT => 2
        ]);
        $GLOBALS['_bptl_db_driver'] = 'mysql';
    } catch (Throwable $e) {
        $pdo = null;
    }

    // 2. Try Local MySQL (if running XAMPP/WAMP on dev machine)
    if (!$pdo) {
        try {
            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', LOCAL_DB_HOST, LOCAL_DB_NAME);
            $pdo = new PDO($dsn, LOCAL_DB_USER, LOCAL_DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT => 1
            ]);
            $GLOBALS['_bptl_db_driver'] = 'mysql';
        } catch (Throwable $e) {
            $pdo = null;
        }
    }

    // 3. Resilient fallback to SQLite (guarantees local dev & test works without external services)
    if (!$pdo) {
        $db_dir = __DIR__ . '/../database';
        if (!is_dir($db_dir)) {
            @mkdir($db_dir, 0755, true);
        }
        $sqlite_file = $db_dir . '/birla_precision.sqlite';
        $pdo = new PDO('sqlite:' . $sqlite_file, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        $GLOBALS['_bptl_db_driver'] = 'sqlite';
    }

    $GLOBALS['_bptl_db_connection'] = $pdo;

    // Ensure core schema and seed data exist
    init_db_schema($pdo, $GLOBALS['_bptl_db_driver']);

    return $pdo;
}

/**
 * Get active database driver name ('mysql' or 'sqlite')
 */
function get_db_driver() {
    if ($GLOBALS['_bptl_db_driver'] === null) {
        get_db();
    }
    return $GLOBALS['_bptl_db_driver'];
}

/**
 * Initializes database tables and default seeds if not present
 */
function init_db_schema(PDO $pdo, $driver) {
    static $initialized = false;
    if ($initialized) return;
    $initialized = true;

    $is_sqlite = ($driver === 'sqlite');
    $auto_id = $is_sqlite ? 'INTEGER PRIMARY KEY AUTOINCREMENT' : 'INT AUTO_INCREMENT PRIMARY KEY';
    $dt_now = $is_sqlite ? 'DATETIME DEFAULT CURRENT_TIMESTAMP' : 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP';

    // 1. Admins Table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS admins (
            id {$auto_id},
            username VARCHAR(50) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            email VARCHAR(150) DEFAULT NULL,
            created_at {$dt_now}
        )
    ");

    // 2. Site Sections Table (Hero, Feature Tiles, Collection List)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS site_sections (
            id {$auto_id},
            section_key VARCHAR(50) NOT NULL,
            item_key VARCHAR(50) NOT NULL,
            title VARCHAR(255) NOT NULL,
            subtitle TEXT DEFAULT NULL,
            eyebrow VARCHAR(150) DEFAULT NULL,
            image_url VARCHAR(255) NOT NULL,
            link_url VARCHAR(255) DEFAULT NULL,
            sort_order INT DEFAULT 0,
            is_active INT DEFAULT 1,
            created_at {$dt_now}
        )
    ");

    // 3. Categories Table (Supports Hierarchy: Top-level Categories & Subcategories)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS categories (
            id {$auto_id},
            parent_id INT DEFAULT NULL,
            name VARCHAR(150) NOT NULL,
            slug VARCHAR(150) NOT NULL UNIQUE,
            description TEXT DEFAULT NULL,
            image VARCHAR(255) DEFAULT NULL,
            sort_order INT DEFAULT 0,
            is_active INT DEFAULT 1,
            created_at {$dt_now}
        )
    ");

    // 4. Products Table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS products (
            id {$auto_id},
            slug VARCHAR(120) NOT NULL UNIQUE,
            title VARCHAR(255) NOT NULL,
            standard VARCHAR(150) DEFAULT NULL,
            hsn_code VARCHAR(50) DEFAULT '8207',
            brand VARCHAR(100) DEFAULT 'Dagger Brand / Birla Precision',
            category VARCHAR(100) DEFAULT 'twist_drills',
            category_name VARCHAR(100) DEFAULT 'HSS Twist Drills',
            category_id INT DEFAULT NULL,
            subcategory_id INT DEFAULT NULL,
            badge VARCHAR(100) DEFAULT NULL,
            badge_class VARCHAR(50) DEFAULT 'badge-red',
            description TEXT DEFAULT NULL,
            full_details TEXT DEFAULT NULL,
            image VARCHAR(255) NOT NULL,
            gallery_json TEXT DEFAULT NULL,
            features_json TEXT DEFAULT NULL,
            size_types_json TEXT DEFAULT NULL,
            is_active INT DEFAULT 1,
            sort_order INT DEFAULT 0,
            created_at {$dt_now}
        )
    ");

    // Ensure category_id, subcategory_id, and size_types_json exist on products table if created previously
    if ($is_sqlite) {
        $p_cols = $pdo->query("PRAGMA table_info(products)")->fetchAll(PDO::FETCH_COLUMN, 1);
        if (!in_array('category_id', $p_cols)) {
            $pdo->exec("ALTER TABLE products ADD COLUMN category_id INT DEFAULT NULL");
        }
        if (!in_array('subcategory_id', $p_cols)) {
            $pdo->exec("ALTER TABLE products ADD COLUMN subcategory_id INT DEFAULT NULL");
        }
        if (!in_array('size_types_json', $p_cols)) {
            $pdo->exec("ALTER TABLE products ADD COLUMN size_types_json TEXT DEFAULT NULL");
        }
    } else {
        try {
            $pdo->exec("ALTER TABLE products ADD COLUMN category_id INT DEFAULT NULL");
        } catch (Throwable $e) {}
        try {
            $pdo->exec("ALTER TABLE products ADD COLUMN subcategory_id INT DEFAULT NULL");
        } catch (Throwable $e) {}
        try {
            $pdo->exec("ALTER TABLE products ADD COLUMN size_types_json TEXT DEFAULT NULL");
        } catch (Throwable $e) {}
    }

    // 4b. Size Types Library Table (Populated from ITM Price List PDF + Custom Admin Types)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS size_types (
            id {$auto_id},
            code VARCHAR(60) NOT NULL UNIQUE,
            label VARCHAR(120) NOT NULL,
            unit_suffix VARCHAR(40) DEFAULT '',
            placeholder VARCHAR(160) DEFAULT '',
            presets_text TEXT DEFAULT NULL,
            is_default INT DEFAULT 0,
            sort_order INT DEFAULT 0,
            created_at {$dt_now}
        )
    ");

    // 5. Product Sizes Table
    if ($is_sqlite) {
        $cols = $pdo->query("PRAGMA table_info(product_sizes)")->fetchAll(PDO::FETCH_COLUMN, 1);
        if (!empty($cols) && !in_array('product_id', $cols)) {
            // Drop old empty table from legacy dump
            $pdo->exec("DROP TABLE product_sizes");
        }
    }
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS product_sizes (
            id {$auto_id},
            product_id INT NOT NULL,
            size_type VARCHAR(60) DEFAULT 'mm',
            size_value VARCHAR(150) DEFAULT NULL,
            size_mm VARCHAR(50) NOT NULL,
            size_inch VARCHAR(50) DEFAULT NULL,
            dg VARCHAR(50) DEFAULT NULL,
            is_popular INT DEFAULT 0,
            price DECIMAL(10,2) DEFAULT NULL,
            sort_order INT DEFAULT 0
        )
    ");

    // Ensure size_type and size_value columns exist on legacy product_sizes tables
    if ($is_sqlite) {
        $ps_cols = $pdo->query("PRAGMA table_info(product_sizes)")->fetchAll(PDO::FETCH_COLUMN, 1);
        if (!in_array('size_type', $ps_cols)) {
            $pdo->exec("ALTER TABLE product_sizes ADD COLUMN size_type VARCHAR(60) DEFAULT 'mm'");
        }
        if (!in_array('size_value', $ps_cols)) {
            $pdo->exec("ALTER TABLE product_sizes ADD COLUMN size_value VARCHAR(150) DEFAULT NULL");
            $pdo->exec("UPDATE product_sizes SET size_value = size_mm WHERE size_value IS NULL");
        }
    } else {
        try {
            $pdo->exec("ALTER TABLE product_sizes ADD COLUMN size_type VARCHAR(60) DEFAULT 'mm'");
        } catch (Throwable $e) {}
        try {
            $pdo->exec("ALTER TABLE product_sizes ADD COLUMN size_value VARCHAR(150) DEFAULT NULL");
            $pdo->exec("UPDATE product_sizes SET size_value = size_mm WHERE size_value IS NULL");
        } catch (Throwable $e) {}
    }

    // 5. Enquiries Table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS enquiries (
            id {$auto_id},
            enquiry_ref VARCHAR(50) NOT NULL,
            product_family VARCHAR(255) NOT NULL,
            metric_dia VARCHAR(50) NOT NULL,
            inch_equiv VARCHAR(50) DEFAULT NULL,
            gauge_number VARCHAR(50) DEFAULT NULL,
            variant_name VARCHAR(100) NOT NULL,
            quantity INT NOT NULL,
            price_basis VARCHAR(100) NOT NULL,
            customer_name VARCHAR(255) NOT NULL,
            company_name VARCHAR(255) DEFAULT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(50) NOT NULL,
            address TEXT DEFAULT NULL,
            message TEXT DEFAULT NULL,
            ip_address VARCHAR(50) DEFAULT NULL,
            status VARCHAR(50) DEFAULT 'New',
            created_at {$dt_now}
        )
    ");

    // Seed Default Admin (admin / admin123) if none exists
    $admin_count = (int)$pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn();
    if ($admin_count === 0) {
        $stmt = $pdo->prepare("INSERT INTO admins (username, password_hash, email) VALUES (?, ?, ?)");
        $stmt->execute([
            'admin',
            password_hash('admin123', PASSWORD_BCRYPT),
            'admin@birlaprecision.com'
        ]);
    }

    // Seed Default Site Sections if none exist
    $sections_count = (int)$pdo->query("SELECT COUNT(*) FROM site_sections")->fetchColumn();
    if ($sections_count === 0) {
        seed_default_sections($pdo);
    }

    // Seed Default Products if none exist
    $products_count = (int)$pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    if ($products_count === 0) {
        seed_default_products($pdo);
    }

    // Seed Default Categories & Subcategories if none exist
    $categories_count = (int)$pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
    if ($categories_count === 0) {
        seed_default_categories($pdo);
    }

    // Seed Default Size Types (from ITM Price List 2026 PDF) if none exist
    $size_types_count = (int)$pdo->query("SELECT COUNT(*) FROM size_types")->fetchColumn();
    if ($size_types_count === 0) {
        seed_default_size_types($pdo);
    }
}

/**
 * Seed initial Homepage Sections (Hero, Feature Tiles, Collection List)
 */
function seed_default_sections(PDO $pdo) {
    $stmt = $pdo->prepare("
        INSERT INTO site_sections 
        (section_key, item_key, title, subtitle, eyebrow, image_url, link_url, sort_order) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    // 1. Hero Slides
    $hero_slides = [
        [
            'hero', 'slide_1', 
            '<span class="trusted-word">Trusted</span> for Precision', 
            'High-performance cutting tools for aerospace, automotive and heavy fabrication.', 
            'HSS TWIST DRILLS', 
            'assets/images/hero/hero_twist_drills_precision.jpg', 
            'products/parallel-shank-twist-drills.php', 
            1
        ],
        [
            'hero', 'slide_2', 
            '<span class="trusted-word">Precision</span> That Drives Performance', 
            'Engineered tooling solutions for demanding industrial applications across 50+ countries.', 
            'DAGGER BRAND • SINCE 1937', 
            'assets/images/hero/hero_industrial_precision.jpg', 
            'products/parallel-shank-twist-drills.php', 
            2
        ],
        [
            'hero', 'slide_3', 
            '<span class="trusted-word">Pioneering</span> Industrial Drills', 
            'Precision HSS Parallel Shank Twist Drills conforming strictly to IS : 5101 standards.', 
            'INDIAN TOOL MANUFACTURERS', 
            'assets/images/hero/hero_drill_manufacturing.jpg', 
            'products/parallel-shank-twist-drills.php', 
            3
        ]
    ];

    foreach ($hero_slides as $s) {
        $stmt->execute($s);
    }

    // 2. Feature Tiles (The 4 Asymmetrical equipment tiles)
    $tiles = [
        [
            'feature_tiles', 'tile_chainsaws', 
            'CHAIN SAWS', 
            'Heavy Duty Industrial Reference', 
            '', 
            'assets/images/tiles/tile_chainsaws.jpg', 
            'products/parallel-shank-twist-drills.php', 
            1
        ],
        [
            'feature_tiles', 'tile_drivers_drills', 
            'DRIVERS & DRILLS', 
            'High-Torque Performance', 
            '', 
            'assets/images/tiles/tile_drivers_drills.jpg', 
            'products/parallel-shank-twist-drills.php', 
            2
        ],
        [
            'feature_tiles', 'tile_cutting_tools', 
            'CUTTING TOOLS', 
            'Precision High-Speed Steel', 
            '', 
            'assets/images/tiles/tile_cutting_tools.jpg', 
            'products/parallel-shank-twist-drills.php', 
            3
        ],
        [
            'feature_tiles', 'tile_power_tools', 
            'POWER TOOLS', 
            'Metal Fabrication & Grinding', 
            '', 
            'assets/images/tiles/tile_power_tools.jpg', 
            'products/parallel-shank-twist-drills.php', 
            4
        ]
    ];

    foreach ($tiles as $t) {
        $stmt->execute($t);
    }

    // 3. Collection List
    $collections = [
        ['collections', 'brush_cutters', 'Brush Cutters', '', '', 'assets/images/collections/brush_cutters.png', 'products/parallel-shank-twist-drills.php', 1],
        ['collections', 'one_power_series', 'One Power Series', '', '', 'assets/images/collections/one_power_series.png', 'products/parallel-shank-twist-drills.php', 2],
        ['collections', 'concrete_vibrators', 'Concrete Vibrators', '', '', 'assets/images/collections/concrete_vibrators.png', 'products/parallel-shank-twist-drills.php', 3],
        ['collections', 'hammer_impact_drills', 'Hammer & Impact Drills', '', '', 'assets/images/collections/hammer_impact_drills.png', 'products/parallel-shank-twist-drills.php', 4],
        ['collections', 'tool_kits', 'Tool Kits', '', '', 'assets/images/collections/tool_kits.png', 'products/parallel-shank-twist-drills.php', 5],
        ['collections', 'laser_measures', 'Laser Measures', '', '', 'assets/images/collections/laser_measures.png', 'products/parallel-shank-twist-drills.php', 6],
        ['collections', 'cutting_machines', 'Cutting Machines', '', '', 'assets/images/collections/cutting_machines.png', 'products/parallel-shank-twist-drills.php', 7],
        ['collections', 'screw_drivers', 'Screw Drivers', '', '', 'assets/images/collections/screw_drivers.png', 'products/parallel-shank-twist-drills.php', 8],
        ['collections', 'wood_working_tools', 'Wood Working Tools', '', '', 'assets/images/collections/wood_working_tools.png', 'products/parallel-shank-twist-drills.php', 9],
        ['collections', 'angle_grinders', 'Angle Grinders', '', '', 'assets/images/collections/angle_grinders.png', 'products/parallel-shank-twist-drills.php', 10],
    ];

    foreach ($collections as $c) {
        $stmt->execute($c);
    }
}

/**
 * Seed initial Products catalogue
 */
function seed_default_products(PDO $pdo) {
    $products = [
        [
            'slug' => 'parallel-shank-twist-drills',
            'title' => 'HSS Parallel Shank Twist Drills (Jobber Series)',
            'standard' => 'IS : 5101 / ISO 235 / DIN 338',
            'hsn_code' => '8207',
            'brand' => 'Dagger Brand / Birla Precision',
            'category' => 'twist_drills',
            'category_name' => 'HSS Twist Drills',
            'badge' => 'FLAGSHIP PRODUCT',
            'badge_class' => 'badge-red',
            'description' => 'Precision CNC ground twist drills engineered for high-concentricity metal drilling in general engineering, automotive, and fabrication. Available in 262 standardized diameters.',
            'full_details' => 'Birla Precision Technologies Limited / Dagger Brand HSS Parallel Shank Twist Drills (Jobber Series) are engineered in accordance with Indian Standard IS : 5101. Manufactured from premium High-Speed Steel with precision CNC grinding technology across ITM plants in Nashik, Aurangabad, and Chalisgaon.',
            'image' => 'assets/images/collections/jobber_drills.png',
            'gallery' => json_encode([
                'assets/images/products/gallery_view_1.jpg',
                'assets/images/products/gallery_view_2.jpg',
                'assets/images/products/gallery_view_3.jpg',
                'assets/images/products/gallery_view_4.jpg',
                'assets/images/products/gallery_view_5.jpg'
            ]),
            'features' => json_encode(['262 Standard Sizes', '0.30mm – 22.22mm', 'M2 High-Speed Steel', '118° Point Angle']),
            'sort_order' => 1
        ],
        [
            'slug' => 'ninja-cobalt',
            'title' => 'NINJA M35 Cobalt Heavy-Duty Jobber Drills',
            'standard' => 'IS : 5101 / 5% Cobalt Alloyed M35',
            'hsn_code' => '8207',
            'brand' => 'Dagger Brand / Birla Precision',
            'category' => 'high_performance',
            'category_name' => 'Cobalt & High Performance',
            'badge' => 'M35 COBALT',
            'badge_class' => 'badge-red',
            'description' => 'Engineered with 5% Cobalt alloy for superior red hardness and heat resistance. Optimized for drilling stainless steel (SS304/316), heat-treated alloys, and high-tensile steels.',
            'full_details' => 'Cobalt-alloyed high-speed steel with superior red hardness for high-temperature resistance and razor-sharp cutting in abrasive high-tensile steels and stainless steels.',
            'image' => 'assets/images/collections/ninja_cobalt.png',
            'gallery' => json_encode(['assets/images/collections/ninja_cobalt.png']),
            'features' => json_encode(['5% Cobalt M35 Alloy', 'High Heat Resistance', 'Stainless Steel Drilling', 'Heavy Web Geometry']),
            'sort_order' => 2
        ],
        [
            'slug' => 'panther-cnc',
            'title' => 'PANTHER High-Precision Split-Point Drills',
            'standard' => 'IS : 5101 / Aerospace CNC Point',
            'hsn_code' => '8207',
            'brand' => 'Dagger Brand / Birla Precision',
            'category' => 'high_performance',
            'category_name' => 'Cobalt & High Performance',
            'badge' => 'CNC SPLIT POINT',
            'badge_class' => 'badge-charcoal',
            'description' => 'Manufactured on 5-axis CNC grinders with a specialized 135° split-point geometry. Eliminates walking on curved surfaces and significantly reduces thrust force on CNC machining centers.',
            'full_details' => 'Manufactured on high-precision CNC grinders with unique point geometry to minimize thrust force and machine tough materials like stainless steel and alloy steels.',
            'image' => 'assets/images/collections/panther_drills.png',
            'gallery' => json_encode(['assets/images/collections/panther_drills.png']),
            'features' => json_encode(['135° Split Point', 'Self-Centering', 'Low Thrust Force', 'CNC Machining Grade']),
            'sort_order' => 3
        ],
        [
            'slug' => 'tin-coated',
            'title' => 'ITM STD. TiN Gold Coated Production Drills',
            'standard' => 'IS : 5101 / Titanium Nitride Coated',
            'hsn_code' => '8207',
            'brand' => 'Dagger Brand / Birla Precision',
            'category' => 'high_performance',
            'category_name' => 'Cobalt & High Performance',
            'badge' => 'TIN GOLD COATED',
            'badge_class' => 'badge-gold',
            'description' => 'Titanium Nitride (TiN) physical vapor deposition ceramic coating provides ultra-low surface friction, thermal barrier protection, and up to 3x longer tool life in mass production.',
            'full_details' => 'Golden TiN ceramic coating reduces friction, resists heat buildup, and substantially extends tool life during repetitive production runs.',
            'image' => 'assets/images/collections/tin_coated_drills.png',
            'gallery' => json_encode(['assets/images/collections/tin_coated_drills.png']),
            'features' => json_encode(['TiN Ceramic Coating', 'Ultra-Low Friction', '3x Tool Life', 'High-Speed Drilling']),
            'sort_order' => 4
        ],
        [
            'slug' => 'taper-shank',
            'title' => 'HSS Taper Shank Twist Drills (Morse Taper)',
            'standard' => 'IS : 5103 / ISO 235 / DIN 345',
            'hsn_code' => '8207',
            'brand' => 'Dagger Brand / Birla Precision',
            'category' => 'twist_drills',
            'category_name' => 'HSS Twist Drills',
            'badge' => 'MORSE TAPER',
            'badge_class' => 'badge-charcoal',
            'description' => 'Heavy-duty industrial drills featuring precision Morse Taper shanks (MT1 to MT6) for direct spindle mounting on radial drills, pillar presses, and lathe tailstocks.',
            'full_details' => 'Standard morse taper shank drills engineered for deep hole drilling and high torque machining applications across heavy industrial equipment.',
            'image' => 'assets/images/collections/taper_shank.png',
            'gallery' => json_encode(['assets/images/collections/taper_shank.png']),
            'features' => json_encode(['MT1 to MT6 Shanks', 'Diameters 3mm – 100mm', 'Tough M2 Steel', 'Direct Spindle Mount']),
            'sort_order' => 5
        ],
        [
            'slug' => 'forgeline',
            'title' => 'FORGELINE Heavy Web Cast Iron & Forged Drills',
            'standard' => 'IS : 5101 / Reinforced Core Web',
            'hsn_code' => '8207',
            'brand' => 'Dagger Brand / Birla Precision',
            'category' => 'twist_drills',
            'category_name' => 'HSS Twist Drills',
            'badge' => 'CAST & FORGED',
            'badge_class' => 'badge-charcoal',
            'description' => 'Features an extra-heavy web construction and rugged cutting edge geometry designed to resist breakout and premature wear when drilling forged steel billets and ductile cast iron.',
            'full_details' => 'Engineered with heavy-duty web and robust flutes specifically tested for forged steels, heavy castings, and demanding production environments.',
            'image' => 'assets/images/collections/forgeline_drills.png',
            'gallery' => json_encode(['assets/images/collections/forgeline_drills.png']),
            'features' => json_encode(['Reinforced Core Web', 'Breakout Resistant', 'Forged Steel Drilling', 'Ductile Iron Geometry']),
            'sort_order' => 6
        ]
    ];

    $stmt = $pdo->prepare("
        INSERT INTO products 
        (slug, title, standard, hsn_code, brand, category, category_name, badge, badge_class, description, full_details, image, gallery_json, features_json, sort_order) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $size_stmt = $pdo->prepare("
        INSERT INTO product_sizes (product_id, size_mm, size_inch, dg, is_popular, sort_order) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    // Standard popular sizes list for drills
    $default_sizes = [
        ['1.00', '', '', 1],
        ['1.50', '', '', 0],
        ['2.00', '', '', 1],
        ['2.50', '', '', 0],
        ['3.00', '', '', 1],
        ['3.17', '1/8"', '', 1],
        ['3.50', '', '', 0],
        ['4.00', '', '', 1],
        ['4.50', '', '', 0],
        ['5.00', '', '', 1],
        ['5.50', '', '', 0],
        ['6.00', '', '', 1],
        ['6.35', '1/4"', '', 1],
        ['6.80', '', '', 1],
        ['7.00', '', '', 0],
        ['7.50', '', '', 0],
        ['8.00', '', '', 1],
        ['8.50', '', '', 1],
        ['9.00', '', '', 0],
        ['9.52', '3/8"', '', 1],
        ['10.00', '', '', 1],
        ['10.50', '', '', 0],
        ['11.00', '', '', 0],
        ['12.00', '', '', 1],
        ['12.70', '1/2"', '', 1],
        ['13.00', '', '', 0],
        ['14.00', '', '', 0],
        ['15.00', '', '', 0],
        ['16.00', '', '', 0]
    ];

    foreach ($products as $p) {
        $stmt->execute([
            $p['slug'],
            $p['title'],
            $p['standard'],
            $p['hsn_code'],
            $p['brand'],
            $p['category'],
            $p['category_name'],
            $p['badge'],
            $p['badge_class'],
            $p['description'],
            $p['full_details'],
            $p['image'],
            $p['gallery'],
            $p['features'],
            $p['sort_order']
        ]);
        $prod_id = (int)$pdo->lastInsertId();

        $order = 1;
        foreach ($default_sizes as $s) {
            $size_stmt->execute([
                $prod_id,
                $s[0],
                $s[1],
                $s[2],
                $s[3],
                $order++
            ]);
        }
    }
}

/**
 * Procedural helper to fetch site section items
 */
function get_site_sections($section_key) {
    try {
        $pdo = get_db();
        $stmt = $pdo->prepare("SELECT * FROM site_sections WHERE section_key = ? AND is_active = 1 ORDER BY sort_order ASC, id ASC");
        $stmt->execute([$section_key]);
        return $stmt->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}

/**
 * Procedural helper to fetch all active products
 */
function get_all_products($limit = null) {
    try {
        $pdo = get_db();
        $sql = "SELECT * FROM products WHERE is_active = 1 ORDER BY sort_order ASC, id ASC";
        if ($limit !== null) {
            $sql .= " LIMIT " . (int)$limit;
        }
        return $pdo->query($sql)->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}

/**
 * Procedural helper to fetch product by id or slug
 */
function get_product_by_id_or_slug($id_or_slug) {
    try {
        $pdo = get_db();
        if (is_numeric($id_or_slug)) {
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([(int)$id_or_slug]);
        } else {
            $stmt = $pdo->prepare("SELECT * FROM products WHERE slug = ?");
            $stmt->execute([$id_or_slug]);
        }
        $prod = $stmt->fetch();
        if (!$prod) return null;

        // Fetch sizes
        $size_stmt = $pdo->prepare("SELECT * FROM product_sizes WHERE product_id = ? ORDER BY sort_order ASC, id ASC");
        $size_stmt->execute([$prod['id']]);
        $prod['sizes'] = $size_stmt->fetchAll();

        return $prod;
    } catch (Throwable $e) {
        return null;
    }
}

/**
 * Seed initial Categories & Subcategories hierarchy and link default products
 */
function seed_default_categories(PDO $pdo) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO categories (parent_id, name, slug, description, image, sort_order, is_active)
            VALUES (?, ?, ?, ?, ?, ?, 1)
        ");

        // 1. Top-Level: HSS Twist Drills
        $stmt->execute([
            null,
            'HSS Twist Drills',
            'twist_drills',
            'Precision High-Speed Steel cutting tools manufactured conforming to IS:5101, ISO 235 and DIN 338.',
            'assets/images/products/mega_menu_featured_card.png',
            1
        ]);
        $cat_twist_drills_id = (int)$pdo->lastInsertId();

        // 2. Top-Level: Cobalt & High Performance
        $stmt->execute([
            null,
            'Cobalt & High Performance',
            'high_performance',
            'Premium M35 5% Cobalt alloy and TiN gold coated production drills for stainless steel and high-tensile alloys.',
            'assets/images/collections/ninja_cobalt.png',
            2
        ]);
        $cat_high_perf_id = (int)$pdo->lastInsertId();

        // Subcategories under HSS Twist Drills
        $stmt->execute([
            $cat_twist_drills_id,
            'HSS Parallel Shank Twist Drills (Jobber Series)',
            'jobber-series',
            'Standard parallel shank twist drills in 262 standard sizes from 0.30mm to 22.22mm.',
            'assets/images/collections/jobber_drills.png',
            1
        ]);
        $sub_jobber_id = (int)$pdo->lastInsertId();

        $stmt->execute([
            $cat_twist_drills_id,
            'HSS Taper Shank Twist Drills (Morse Taper)',
            'morse-taper',
            'Direct spindle mount drills featuring precision Morse Tapers MT1 through MT6.',
            'assets/images/collections/taper_shank.png',
            2
        ]);
        $sub_taper_id = (int)$pdo->lastInsertId();

        $stmt->execute([
            $cat_twist_drills_id,
            'FORGELINE Heavy Web Cast Iron GOLD & Forged Drills',
            'forgeline-series',
            'Extra-heavy web drills engineered for forged billets and ductile cast iron breakout resistance.',
            'assets/images/collections/forgeline_drills.png',
            3
        ]);
        $sub_forge_id = (int)$pdo->lastInsertId();

        // Subcategories under Cobalt & High Performance
        $stmt->execute([
            $cat_high_perf_id,
            'NINJA M35 Cobalt Heavy-Duty Jobber Drills',
            'ninja-cobalt-series',
            '5% Cobalt alloyed high-speed steel drills for tough stainless steel applications.',
            'assets/images/collections/ninja_cobalt.png',
            1
        ]);
        $sub_ninja_id = (int)$pdo->lastInsertId();

        $stmt->execute([
            $cat_high_perf_id,
            'PANTHER High-Precision Split-Point Drills',
            'panther-series',
            '135-degree split-point self-centering drills for CNC machining centers.',
            'assets/images/collections/panther_drills.png',
            2
        ]);
        $sub_panther_id = (int)$pdo->lastInsertId();

        $stmt->execute([
            $cat_high_perf_id,
            'ITM STD. TiN Gold Coated Production Drills',
            'tin-gold-series',
            'Titanium Nitride coated drills providing 3x tool life in repetitive high-speed production.',
            'assets/images/collections/tin_coated_drills.png',
            3
        ]);
        $sub_tin_id = (int)$pdo->lastInsertId();

        // Link existing products to categories and subcategories
        $link_map = [
            'parallel-shank-twist-drills' => [$cat_twist_drills_id, $sub_jobber_id, 'HSS Twist Drills', 'twist_drills'],
            'taper-shank'                 => [$cat_twist_drills_id, $sub_taper_id, 'HSS Twist Drills', 'twist_drills'],
            'forgeline'                   => [$cat_twist_drills_id, $sub_forge_id, 'HSS Twist Drills', 'twist_drills'],
            'ninja-cobalt'                => [$cat_high_perf_id, $sub_ninja_id, 'Cobalt & High Performance', 'high_performance'],
            'panther-cnc'                 => [$cat_high_perf_id, $sub_panther_id, 'Cobalt & High Performance', 'high_performance'],
            'tin-coated'                  => [$cat_high_perf_id, $sub_tin_id, 'Cobalt & High Performance', 'high_performance'],
        ];

        $upd_stmt = $pdo->prepare("UPDATE products SET category_id = ?, subcategory_id = ?, category_name = ?, category = ? WHERE slug = ?");
        foreach ($link_map as $p_slug => $d) {
            $upd_stmt->execute([$d[0], $d[1], $d[2], $d[3], $p_slug]);
        }
    } catch (Throwable $e) {
        // Seeding error logged or ignored safely
    }
}

/**
 * Procedural helper to fetch categories
 * @param int|string|null $parent_id null = all, 0 or 'top' = top-level only, int = children of parent_id
 * @param bool $only_active
 * @return array
 */
function get_categories($parent_id = null, $only_active = true) {
    try {
        $pdo = get_db();
        $sql = "SELECT c.*, 
                    p.name AS parent_name,
                    (SELECT COUNT(*) FROM products WHERE category_id = c.id OR subcategory_id = c.id) AS product_count,
                    (SELECT COUNT(*) FROM categories WHERE parent_id = c.id) AS subcategory_count
                FROM categories c
                LEFT JOIN categories p ON c.parent_id = p.id
                WHERE 1=1";
        $params = [];

        if ($only_active) {
            $sql .= " AND c.is_active = 1";
        }

        if ($parent_id === 0 || $parent_id === 'top') {
            $sql .= " AND (c.parent_id IS NULL OR c.parent_id = 0)";
        } elseif ($parent_id !== null) {
            $sql .= " AND c.parent_id = ?";
            $params[] = (int)$parent_id;
        }

        $sql .= " ORDER BY c.sort_order ASC, c.id ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}

/**
 * Procedural helper to fetch category by ID or Slug
 */
function get_category_by_id_or_slug($id_or_slug) {
    try {
        $pdo = get_db();
        if (is_numeric($id_or_slug)) {
            $stmt = $pdo->prepare("SELECT c.*, p.name AS parent_name FROM categories c LEFT JOIN categories p ON c.parent_id = p.id WHERE c.id = ?");
            $stmt->execute([(int)$id_or_slug]);
        } else {
            $stmt = $pdo->prepare("SELECT c.*, p.name AS parent_name FROM categories c LEFT JOIN categories p ON c.parent_id = p.id WHERE c.slug = ?");
            $stmt->execute([$id_or_slug]);
        }
        return $stmt->fetch() ?: null;
    } catch (Throwable $e) {
        return null;
    }
}

/**
 * Fetch full hierarchical tree of categories, subcategories, and linked products
 */
function get_categories_tree($only_active = true) {
    try {
        $top_cats = get_categories(0, $only_active);
        $all_products = get_all_products();

        // Index products by category_id, subcategory_id, and category slug
        $products_by_cat = [];
        $products_by_sub = [];
        foreach ($all_products as $p) {
            if (!empty($p['category_id'])) {
                $products_by_cat[(string)$p['category_id']][] = $p;
            }
            if (!empty($p['category'])) {
                $products_by_cat[(string)$p['category']][] = $p;
            }
            if (!empty($p['subcategory_id'])) {
                $products_by_sub[(string)$p['subcategory_id']][] = $p;
            }
        }

        foreach ($top_cats as &$top) {
            $subs = get_categories($top['id'], $only_active);
            foreach ($subs as &$sub) {
                $sub['products'] = $products_by_sub[(string)$sub['id']] ?? [];
            }
            unset($sub);
            $top['subcategories'] = $subs;

            // Direct products for this category
            $top['direct_products'] = $products_by_cat[(string)$top['id']] ?? ($products_by_cat[(string)$top['slug']] ?? []);

            // All products (including under subcategories)
            $all_for_top = $top['direct_products'];
            foreach ($subs as $sub) {
                if (!empty($sub['products'])) {
                    foreach ($sub['products'] as $sp) {
                        $all_for_top[] = $sp;
                    }
                }
            }
            // De-duplicate by ID
            $unique_prods = [];
            foreach ($all_for_top as $p) {
                $unique_prods[$p['id']] = $p;
            }
            $top['all_products'] = array_values($unique_prods);
        }
        unset($top);

        return $top_cats;
    } catch (Throwable $e) {
        return [];
    }
}

/**
 * Seed default Size Types derived from ITM Price List (04-2026) PDF
 */
function seed_default_size_types(PDO $pdo) {
    $types = [
        [
            'code' => 'mm',
            'label' => 'Metric (mm)',
            'unit_suffix' => 'mm',
            'placeholder' => 'Select or type size (e.g. 3.5)',
            'presets_text' => implode("\n", ['1.00', '1.50', '2.00', '2.50', '3.00', '3.17', '3.50', '4.00', '4.50', '5.00', '5.50', '6.00', '6.35', '6.80', '7.00', '7.50', '8.00', '8.50', '9.00', '9.52', '10.00', '10.50', '11.00', '11.50', '12.00', '12.70', '13.00', '14.00', '15.00', '16.00']),
            'is_default' => 1,
            'sort_order' => 1
        ],
        [
            'code' => 'inch',
            'label' => 'Inch',
            'unit_suffix' => '"',
            'placeholder' => 'Select or type size (e.g. 1/8")',
            'presets_text' => implode("\n", ['3/64"', '1/16"', '5/64"', '3/32"', '7/64"', '1/8"', '9/64"', '5/32"', '3/16"', '7/32"', '1/4"', '9/32"', '5/16"', '11/32"', '3/8"', '7/16"', '1/2"', '5/8"', '3/4"', '7/8"', '1"', '1.1/4"', '1.1/2"', '2"']),
            'is_default' => 1,
            'sort_order' => 2
        ],
        [
            'code' => 'dg',
            'label' => 'Drill Gauge (DG / No.)',
            'unit_suffix' => 'DG',
            'placeholder' => 'Select or type gauge (e.g. 60, A, BS-1)',
            'presets_text' => implode("\n", [
                '60','59','58','57','56','55','54','53','52','51',
                '50','49','48','47','46','45','44','43','42','41',
                '40','39','38','37','36','35','34','33','32','31',
                '30','29','28','27','26','25','24','23','22','21',
                '20','19','18','17','16','15','14','13','12','11',
                '10','9','8','7','6','5','4','3','2','1',
                'A','B','C','D','E','F','G','H','I','J','K','L','M',
                'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
                'BS-1','BS-2','BS-3','BS-4','BS-5','BS-6','BS-7'
            ]),
            'is_default' => 0,
            'sort_order' => 3
        ],
        [
            'code' => 'mt',
            'label' => 'Morse Taper (MT)',
            'unit_suffix' => '',
            'placeholder' => 'Select or type taper (e.g. MT1, MT2)',
            'presets_text' => implode("\n", ['MT0', 'MT1', 'MT2', 'MT3', 'MT4', 'MT5', 'MT6']),
            'is_default' => 0,
            'sort_order' => 4
        ],
        [
            'code' => 'thread',
            'label' => 'Thread / Pitch (M / BSP / TPI)',
            'unit_suffix' => '',
            'placeholder' => 'Select or type thread (e.g. M10 x 1.5)',
            'presets_text' => implode("\n", [
                'M2.0 x 0.40', 'M2.5 x 0.45', 'M3 x 0.5', 'M3.5 x 0.6', 'M4 x 0.7',
                'M5 x 0.8', 'M6 x 1.0', 'M8 x 1.25', 'M10 x 1.5', 'M12 x 1.75',
                'M14 x 2.00', 'M16 x 2.00', 'M18 x 2.5', 'M20 x 2.5', 'M22 x 2.5', 'M24 x 3.0',
                '1/8 BSP', '1/4 BSP', '3/8 BSP', '1/2 BSP', '3/4 BSP', '1" BSP', '1/4 NPT', '1/2 NPT'
            ]),
            'is_default' => 0,
            'sort_order' => 5
        ],
        [
            'code' => 'dimensions',
            'label' => 'Dimensions (Dia x Depth / OAL)',
            'unit_suffix' => '',
            'placeholder' => 'Select or type dimension (e.g. 12 x 35MM)',
            'presets_text' => implode("\n", [
                '12 x 35MM', '14 x 35MM', '16 x 35MM', '18 x 35MM', '20 x 35MM', '22 x 35MM', '25 x 35MM',
                '12 x 50MM', '14 x 50MM', '16 x 50MM', '18 x 50MM', '20 x 50MM', '25 x 50MM',
                '5.00 x 110 MM OAL', '6.00 x 160 MM OAL', '8.00 x 160 MM OAL', '10.00 x 160 MM OAL', '12.00 x 210 MM OAL',
                '100 x 4 x 16 MM', '100 x 6 x 16 MM', '125 x 6 x 22.23 MM'
            ]),
            'is_default' => 0,
            'sort_order' => 6
        ],
        [
            'code' => 'cut_grade',
            'label' => 'Length & Cut Grade (Files / Saws)',
            'unit_suffix' => '',
            'placeholder' => 'Select or type size & grade (e.g. 150 MM BASTARD)',
            'presets_text' => implode("\n", [
                '100 MM BASTARD', '100 MM 2ND CUT', '100 MM SMOOTH',
                '150 MM BASTARD', '150 MM 2ND CUT', '150 MM SMOOTH',
                '200 MM BASTARD', '200 MM 2ND CUT', '200 MM SMOOTH',
                '250 MM BASTARD', '250 MM 2ND CUT', '300 MM BASTARD',
                '4" x 30T', '7" x 40T', '10" x 60T', '14" x 100T'
            ]),
            'is_default' => 0,
            'sort_order' => 7
        ]
    ];

    $stmt = $pdo->prepare("
        INSERT INTO size_types (code, label, unit_suffix, placeholder, presets_text, is_default, sort_order)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    foreach ($types as $t) {
        try {
            $stmt->execute([
                $t['code'],
                $t['label'],
                $t['unit_suffix'],
                $t['placeholder'],
                $t['presets_text'],
                $t['is_default'],
                $t['sort_order']
            ]);
        } catch (Throwable $e) {}
    }
}

/**
 * Fetch all configured size types from library
 */
function get_all_size_types() {
    try {
        $pdo = get_db();
        return $pdo->query("SELECT * FROM size_types ORDER BY sort_order ASC, id ASC")->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}

/**
 * Create a new custom size type or return existing match
 */
function create_or_get_size_type($label, $unit_suffix = '', $placeholder = '', $code = '') {
    $pdo = get_db();
    $label = trim($label);
    if (empty($label)) return null;

    $code = trim($code);
    if (empty($code)) {
        $code = preg_replace('/[^a-z0-9]+/', '_', strtolower($label));
        $code = trim($code, '_');
        if (empty($code)) $code = 'size_' . time();
    }

    // Check by code first
    $stmt = $pdo->prepare("SELECT * FROM size_types WHERE code = ?");
    $stmt->execute([$code]);
    $existing = $stmt->fetch();
    if ($existing) {
        return $existing;
    }

    // Check by case-insensitive label
    $stmt2 = $pdo->prepare("SELECT * FROM size_types WHERE LOWER(label) = LOWER(?)");
    $stmt2->execute([$label]);
    $existingByLabel = $stmt2->fetch();
    if ($existingByLabel) {
        return $existingByLabel;
    }

    if (empty($placeholder)) {
        $placeholder = 'Select or type ' . $label;
    }

    $maxOrder = (int)$pdo->query("SELECT COALESCE(MAX(sort_order), 0) FROM size_types")->fetchColumn();
    $ins = $pdo->prepare("
        INSERT INTO size_types (code, label, unit_suffix, placeholder, presets_text, is_default, sort_order)
        VALUES (?, ?, ?, ?, '', 0, ?)
    ");
    $ins->execute([$code, $label, trim($unit_suffix), trim($placeholder), $maxOrder + 1]);

    return [
        'id' => (int)$pdo->lastInsertId(),
        'code' => $code,
        'label' => $label,
        'unit_suffix' => trim($unit_suffix),
        'placeholder' => trim($placeholder),
        'presets_text' => '',
        'is_default' => 0,
        'sort_order' => $maxOrder + 1
    ];
}

/**
 * Build unified size configuration for a product (handles custom size types + legacy rows)
 */
function get_product_size_config($product) {
    $all_lib = get_all_size_types();
    $lib_map = [];
    foreach ($all_lib as $st) {
        $lib_map[$st['code']] = $st;
    }

    $configured_types = [];
    if (!empty($product['size_types_json'])) {
        $decoded = json_decode($product['size_types_json'], true);
        if (is_array($decoded)) {
            $configured_types = $decoded;
        }
    }

    $raw_sizes = $product['sizes'] ?? [];
    $sizes_by_type = [];
    $popular_by_type = [];

    foreach ($raw_sizes as $sz) {
        $stype = !empty($sz['size_type']) ? $sz['size_type'] : 'mm';
        $sval = isset($sz['size_value']) && $sz['size_value'] !== '' ? $sz['size_value'] : ($sz['size_mm'] ?? '');
        $sval = trim((string)$sval);

        if ($sval !== '') {
            if (!isset($sizes_by_type[$stype])) $sizes_by_type[$stype] = [];
            $exists = false;
            foreach ($sizes_by_type[$stype] as $existing) {
                if (strcasecmp($existing['val'], $sval) === 0) {
                    $exists = true;
                    break;
                }
            }
            if (!$exists) {
                $sizes_by_type[$stype][] = [
                    'val' => $sval,
                    'inch' => !empty($sz['size_inch']) ? $sz['size_inch'] : null,
                    'dg' => !empty($sz['dg']) ? $sz['dg'] : null,
                    'is_popular' => !empty($sz['is_popular']) ? 1 : 0
                ];
            }
            if (!empty($sz['is_popular'])) {
                if (!isset($popular_by_type[$stype])) $popular_by_type[$stype] = [];
                if (!in_array($sval, $popular_by_type[$stype], true)) {
                    $popular_by_type[$stype][] = $sval;
                }
            }
        }

        // Backward-compat: legacy rows stored inch inside size_inch on mm rows
        if ($stype === 'mm' && !empty($sz['size_inch'])) {
            $ival = trim((string)$sz['size_inch']);
            if ($ival !== '') {
                if (!isset($sizes_by_type['inch'])) $sizes_by_type['inch'] = [];
                $i_exists = false;
                foreach ($sizes_by_type['inch'] as $ex) {
                    if (strcasecmp($ex['val'], $ival) === 0) { $i_exists = true; break; }
                }
                if (!$i_exists) {
                    $sizes_by_type['inch'][] = [
                        'val' => $ival,
                        'mm_equiv' => $sval,
                        'is_popular' => !empty($sz['is_popular']) ? 1 : 0
                    ];
                }
            }
        }

        // Backward-compat: legacy rows stored dg inside dg column
        if ($stype === 'mm' && !empty($sz['dg'])) {
            $dval = trim((string)$sz['dg']);
            if ($dval !== '') {
                if (!isset($sizes_by_type['dg'])) $sizes_by_type['dg'] = [];
                $d_exists = false;
                foreach ($sizes_by_type['dg'] as $ex) {
                    if (strcasecmp($ex['val'], $dval) === 0) { $d_exists = true; break; }
                }
                if (!$d_exists) {
                    $sizes_by_type['dg'][] = [
                        'val' => $dval,
                        'mm_equiv' => $sval,
                        'is_popular' => 0
                    ];
                }
            }
        }
    }

    // If product has no explicit size_types_json yet, infer cleanly (Metric mm + Inch + any other present types)
    if (empty($configured_types)) {
        $default_codes = ['mm', 'inch'];
        foreach (array_keys($sizes_by_type) as $k) {
            if (!in_array($k, $default_codes, true)) {
                $default_codes[] = $k;
            }
        }
        foreach ($default_codes as $code) {
            $meta = $lib_map[$code] ?? [
                'code' => $code,
                'label' => ucwords(str_replace('_', ' ', $code)),
                'unit_suffix' => '',
                'placeholder' => 'Select or type size'
            ];
            $pop = $popular_by_type[$code] ?? [];
            if (empty($pop) && $code === 'mm') {
                $pop = ['2.00', '3.00', '4.00', '5.00', '6.00', '8.00', '10.00', '12.00'];
            } elseif (empty($pop) && $code === 'inch') {
                $pop = ['1/16"', '1/8"', '3/16"', '1/4"', '5/16"', '3/8"', '7/16"', '1/2"'];
            }
            $configured_types[] = [
                'code' => $meta['code'],
                'label' => $meta['label'],
                'unit_suffix' => $meta['unit_suffix'] ?? '',
                'placeholder' => $meta['placeholder'] ?? ('Select or type ' . $meta['label']),
                'popular' => $pop
            ];
        }
    } else {
        // Hydrate missing metadata and popular fallback
        foreach ($configured_types as &$ct) {
            $code = $ct['code'];
            if (isset($lib_map[$code])) {
                if (empty($ct['label'])) $ct['label'] = $lib_map[$code]['label'];
                if (!isset($ct['unit_suffix'])) $ct['unit_suffix'] = $lib_map[$code]['unit_suffix'];
                if (empty($ct['placeholder'])) $ct['placeholder'] = $lib_map[$code]['placeholder'];
            }
            if (empty($ct['popular'])) {
                if (!empty($popular_by_type[$code])) {
                    $ct['popular'] = $popular_by_type[$code];
                } elseif (!empty($sizes_by_type[$code])) {
                    $ct['popular'] = array_slice(array_column($sizes_by_type[$code], 'val'), 0, 8);
                } elseif ($code === 'inch') {
                    $ct['popular'] = ['1/16"', '1/8"', '3/16"', '1/4"', '5/16"', '3/8"', '7/16"', '1/2"'];
                } else {
                    $ct['popular'] = [];
                }
            }
        }
        unset($ct);
    }

    return [
        'size_types' => $configured_types,
        'sizes_by_type' => $sizes_by_type
    ];
}


