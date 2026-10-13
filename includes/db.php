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

    // 3. Products Table
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
            badge VARCHAR(100) DEFAULT NULL,
            badge_class VARCHAR(50) DEFAULT 'badge-red',
            description TEXT DEFAULT NULL,
            full_details TEXT DEFAULT NULL,
            image VARCHAR(255) NOT NULL,
            gallery_json TEXT DEFAULT NULL,
            features_json TEXT DEFAULT NULL,
            is_active INT DEFAULT 1,
            sort_order INT DEFAULT 0,
            created_at {$dt_now}
        )
    ");

    // 4. Product Sizes Table
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
            size_mm VARCHAR(50) NOT NULL,
            size_inch VARCHAR(50) DEFAULT NULL,
            dg VARCHAR(50) DEFAULT NULL,
            is_popular INT DEFAULT 0,
            price DECIMAL(10,2) DEFAULT NULL,
            sort_order INT DEFAULT 0
        )
    ");

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
