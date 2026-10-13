-- ============================================================================
-- BIRLA PRECISION TECHNOLOGIES - HOSTINGER MYSQL SETUP SCRIPT
-- Database: u641661223_DRILLMAC
-- ============================================================================

SET FOREIGN_KEY_CHECKS = 0;
SET NAMES utf8mb4;

-- 1. Admins Table
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `email` VARCHAR(150) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Site Sections Table (Hero, Feature Tiles, Collection List)
CREATE TABLE IF NOT EXISTS `site_sections` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `section_key` VARCHAR(50) NOT NULL,
  `item_key` VARCHAR(50) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `subtitle` TEXT DEFAULT NULL,
  `eyebrow` VARCHAR(150) DEFAULT NULL,
  `image_url` VARCHAR(255) NOT NULL,
  `link_url` VARCHAR(255) DEFAULT NULL,
  `sort_order` INT DEFAULT 0,
  `is_active` INT DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Products Table
CREATE TABLE IF NOT EXISTS `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `slug` VARCHAR(120) NOT NULL UNIQUE,
  `title` VARCHAR(255) NOT NULL,
  `standard` VARCHAR(150) DEFAULT NULL,
  `hsn_code` VARCHAR(50) DEFAULT '8207',
  `brand` VARCHAR(100) DEFAULT 'Dagger Brand / Birla Precision',
  `category` VARCHAR(100) DEFAULT 'twist_drills',
  `category_name` VARCHAR(100) DEFAULT 'HSS Twist Drills',
  `badge` VARCHAR(100) DEFAULT NULL,
  `badge_class` VARCHAR(50) DEFAULT 'badge-red',
  `description` TEXT DEFAULT NULL,
  `full_details` TEXT DEFAULT NULL,
  `image` VARCHAR(255) NOT NULL,
  `gallery_json` TEXT DEFAULT NULL,
  `features_json` TEXT DEFAULT NULL,
  `is_active` INT DEFAULT 1,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Product Sizes Table
CREATE TABLE IF NOT EXISTS `product_sizes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `product_id` INT NOT NULL,
  `size_mm` VARCHAR(50) NOT NULL,
  `size_inch` VARCHAR(50) DEFAULT NULL,
  `dg` VARCHAR(50) DEFAULT NULL,
  `is_popular` INT DEFAULT 0,
  `price` DECIMAL(10,2) DEFAULT NULL,
  `sort_order` INT DEFAULT 0,
  INDEX `idx_product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Enquiries Table
CREATE TABLE IF NOT EXISTS `enquiries` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `enquiry_ref` VARCHAR(50) NOT NULL,
  `product_family` VARCHAR(255) NOT NULL,
  `metric_dia` VARCHAR(50) NOT NULL,
  `inch_equiv` VARCHAR(50) DEFAULT NULL,
  `gauge_number` VARCHAR(50) DEFAULT NULL,
  `variant_name` VARCHAR(100) NOT NULL,
  `quantity` INT NOT NULL,
  `price_basis` VARCHAR(100) NOT NULL,
  `customer_name` VARCHAR(255) NOT NULL,
  `company_name` VARCHAR(255) DEFAULT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(50) NOT NULL,
  `address` TEXT DEFAULT NULL,
  `message` TEXT DEFAULT NULL,
  `ip_address` VARCHAR(50) DEFAULT NULL,
  `status` VARCHAR(50) DEFAULT 'New',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Default Admin User (admin / admin123)
INSERT IGNORE INTO `admins` (`id`, `username`, `password_hash`, `email`) 
VALUES (1, 'admin', '$2y$10$w0f5u4NeqiBw454xTjJ47u2RskG8jT9E82l7lB11q3bB5lF8K.Cxe', 'admin@birlaprecision.com');



-- ============================================================================
-- SEED DATA: Site Sections (Hero, Feature Tiles, Collection List)
-- ============================================================================
INSERT IGNORE INTO `site_sections` (`id`, `section_key`, `item_key`, `title`, `subtitle`, `eyebrow`, `image_url`, `link_url`, `sort_order`, `is_active`) VALUES (1, 'hero', 'slide_1', '<span class=\"trusted-word\">Trusted</span> for Precision', 'High-performance cutting tools for aerospace, automotive and heavy fabrication.', 'HSS TWIST DRILLS', 'assets/images/hero/hero_twist_drills_precision.jpg', 'products/parallel-shank-twist-drills.php', 1, 1);
INSERT IGNORE INTO `site_sections` (`id`, `section_key`, `item_key`, `title`, `subtitle`, `eyebrow`, `image_url`, `link_url`, `sort_order`, `is_active`) VALUES (2, 'hero', 'slide_2', '<span class=\"trusted-word\">Precision</span> That Drives Performance', 'Engineered tooling solutions for demanding industrial applications across 50+ countries.', 'DAGGER BRAND • SINCE 1937', 'assets/images/hero/hero_industrial_precision.jpg', 'products/parallel-shank-twist-drills.php', 2, 1);
INSERT IGNORE INTO `site_sections` (`id`, `section_key`, `item_key`, `title`, `subtitle`, `eyebrow`, `image_url`, `link_url`, `sort_order`, `is_active`) VALUES (3, 'hero', 'slide_3', '<span class=\"trusted-word\">Pioneering</span> Industrial Drills', 'Precision HSS Parallel Shank Twist Drills conforming strictly to IS : 5101 standards.', 'INDIAN TOOL MANUFACTURERS', 'assets/images/hero/hero_drill_manufacturing.jpg', 'products/parallel-shank-twist-drills.php', 3, 1);
INSERT IGNORE INTO `site_sections` (`id`, `section_key`, `item_key`, `title`, `subtitle`, `eyebrow`, `image_url`, `link_url`, `sort_order`, `is_active`) VALUES (4, 'feature_tiles', 'tile_chainsaws', 'CHAIN SAWS', 'Heavy Duty Industrial Reference', '', 'assets/images/tiles/tile_chainsaws.jpg', 'products/parallel-shank-twist-drills.php', 1, 1);
INSERT IGNORE INTO `site_sections` (`id`, `section_key`, `item_key`, `title`, `subtitle`, `eyebrow`, `image_url`, `link_url`, `sort_order`, `is_active`) VALUES (5, 'feature_tiles', 'tile_drivers_drills', 'DRIVERS & DRILLS', 'High-Torque Performance', '', 'assets/images/tiles/tile_drivers_drills.jpg', 'products/parallel-shank-twist-drills.php', 2, 1);
INSERT IGNORE INTO `site_sections` (`id`, `section_key`, `item_key`, `title`, `subtitle`, `eyebrow`, `image_url`, `link_url`, `sort_order`, `is_active`) VALUES (6, 'feature_tiles', 'tile_cutting_tools', 'CUTTING TOOLS', 'Precision High-Speed Steel', '', 'assets/images/tiles/tile_cutting_tools.jpg', 'products/parallel-shank-twist-drills.php', 3, 1);
INSERT IGNORE INTO `site_sections` (`id`, `section_key`, `item_key`, `title`, `subtitle`, `eyebrow`, `image_url`, `link_url`, `sort_order`, `is_active`) VALUES (7, 'feature_tiles', 'tile_power_tools', 'POWER TOOLS', 'Metal Fabrication & Grinding', '', 'assets/images/tiles/tile_power_tools.jpg', 'products/parallel-shank-twist-drills.php', 4, 1);
INSERT IGNORE INTO `site_sections` (`id`, `section_key`, `item_key`, `title`, `subtitle`, `eyebrow`, `image_url`, `link_url`, `sort_order`, `is_active`) VALUES (8, 'collections', 'brush_cutters', 'Brush Cutters', '', '', 'assets/images/collections/brush_cutters.png', 'products/parallel-shank-twist-drills.php', 1, 1);
INSERT IGNORE INTO `site_sections` (`id`, `section_key`, `item_key`, `title`, `subtitle`, `eyebrow`, `image_url`, `link_url`, `sort_order`, `is_active`) VALUES (9, 'collections', 'one_power_series', 'One Power Series', '', '', 'assets/images/collections/one_power_series.png', 'products/parallel-shank-twist-drills.php', 2, 1);
INSERT IGNORE INTO `site_sections` (`id`, `section_key`, `item_key`, `title`, `subtitle`, `eyebrow`, `image_url`, `link_url`, `sort_order`, `is_active`) VALUES (10, 'collections', 'concrete_vibrators', 'Concrete Vibrators', '', '', 'assets/images/collections/concrete_vibrators.png', 'products/parallel-shank-twist-drills.php', 3, 1);
INSERT IGNORE INTO `site_sections` (`id`, `section_key`, `item_key`, `title`, `subtitle`, `eyebrow`, `image_url`, `link_url`, `sort_order`, `is_active`) VALUES (11, 'collections', 'hammer_impact_drills', 'Hammer & Impact Drills', '', '', 'assets/images/collections/hammer_impact_drills.png', 'products/parallel-shank-twist-drills.php', 4, 1);
INSERT IGNORE INTO `site_sections` (`id`, `section_key`, `item_key`, `title`, `subtitle`, `eyebrow`, `image_url`, `link_url`, `sort_order`, `is_active`) VALUES (12, 'collections', 'tool_kits', 'Tool Kits', '', '', 'assets/images/collections/tool_kits.png', 'products/parallel-shank-twist-drills.php', 5, 1);
INSERT IGNORE INTO `site_sections` (`id`, `section_key`, `item_key`, `title`, `subtitle`, `eyebrow`, `image_url`, `link_url`, `sort_order`, `is_active`) VALUES (13, 'collections', 'laser_measures', 'Laser Measures', '', '', 'assets/images/collections/laser_measures.png', 'products/parallel-shank-twist-drills.php', 6, 1);
INSERT IGNORE INTO `site_sections` (`id`, `section_key`, `item_key`, `title`, `subtitle`, `eyebrow`, `image_url`, `link_url`, `sort_order`, `is_active`) VALUES (14, 'collections', 'cutting_machines', 'Cutting Machines', '', '', 'assets/images/collections/cutting_machines.png', 'products/parallel-shank-twist-drills.php', 7, 1);
INSERT IGNORE INTO `site_sections` (`id`, `section_key`, `item_key`, `title`, `subtitle`, `eyebrow`, `image_url`, `link_url`, `sort_order`, `is_active`) VALUES (15, 'collections', 'screw_drivers', 'Screw Drivers', '', '', 'assets/images/collections/screw_drivers.png', 'products/parallel-shank-twist-drills.php', 8, 1);
INSERT IGNORE INTO `site_sections` (`id`, `section_key`, `item_key`, `title`, `subtitle`, `eyebrow`, `image_url`, `link_url`, `sort_order`, `is_active`) VALUES (16, 'collections', 'wood_working_tools', 'Wood Working Tools', '', '', 'assets/images/collections/wood_working_tools.png', 'products/parallel-shank-twist-drills.php', 9, 1);
INSERT IGNORE INTO `site_sections` (`id`, `section_key`, `item_key`, `title`, `subtitle`, `eyebrow`, `image_url`, `link_url`, `sort_order`, `is_active`) VALUES (17, 'collections', 'angle_grinders', 'Angle Grinders', '', '', 'assets/images/collections/angle_grinders.png', 'products/parallel-shank-twist-drills.php', 10, 1);

-- ============================================================================
-- SEED DATA: Products Catalogue
-- ============================================================================
INSERT IGNORE INTO `products` (`id`, `slug`, `title`, `standard`, `hsn_code`, `brand`, `category`, `category_name`, `badge`, `badge_class`, `description`, `full_details`, `image`, `gallery_json`, `features_json`, `is_active`, `sort_order`) VALUES (1, 'parallel-shank-twist-drills', 'HSS Parallel Shank Twist Drills (Jobber Series)', 'IS : 5101 / ISO 235 / DIN 338', '8207', 'Dagger Brand / Birla Precision', 'twist_drills', 'HSS Twist Drills', 'FLAGSHIP PRODUCT', 'badge-red', 'Precision CNC ground twist drills engineered for high-concentricity metal drilling in general engineering, automotive, and fabrication. Available in 262 standardized diameters.', 'Birla Precision Technologies Limited / Dagger Brand HSS Parallel Shank Twist Drills (Jobber Series) are engineered in accordance with Indian Standard IS : 5101. Manufactured from premium High-Speed Steel with precision CNC grinding technology across ITM plants in Nashik, Aurangabad, and Chalisgaon.', 'assets/images/collections/jobber_drills.png', '[\"assets\\/images\\/products\\/gallery_view_1.jpg\",\"assets\\/images\\/products\\/gallery_view_2.jpg\",\"assets\\/images\\/products\\/gallery_view_3.jpg\",\"assets\\/images\\/products\\/gallery_view_4.jpg\",\"assets\\/images\\/products\\/gallery_view_5.jpg\"]', '[\"262 Standard Sizes\",\"0.30mm \\u2013 22.22mm\",\"M2 High-Speed Steel\",\"118\\u00b0 Point Angle\"]', 1, 1);
INSERT IGNORE INTO `products` (`id`, `slug`, `title`, `standard`, `hsn_code`, `brand`, `category`, `category_name`, `badge`, `badge_class`, `description`, `full_details`, `image`, `gallery_json`, `features_json`, `is_active`, `sort_order`) VALUES (2, 'ninja-cobalt', 'NINJA M35 Cobalt Heavy-Duty Jobber Drills', 'IS : 5101 / 5% Cobalt Alloyed M35', '8207', 'Dagger Brand / Birla Precision', 'high_performance', 'Cobalt & High Performance', 'M35 COBALT', 'badge-red', 'Engineered with 5% Cobalt alloy for superior red hardness and heat resistance. Optimized for drilling stainless steel (SS304/316), heat-treated alloys, and high-tensile steels.', 'Cobalt-alloyed high-speed steel with superior red hardness for high-temperature resistance and razor-sharp cutting in abrasive high-tensile steels and stainless steels.', 'uploads/products/Image_1_10PCS_HSS_M2_Long_Seri_20261013_122148_5df2da5d.webp', '[\"assets/images/collections/ninja_cobalt.png\",\"uploads/products/42356094__98666_1541059628_20261013_122144_e99b7ad7.webp\",\"uploads/products/42356094__98666_1541059628_20261013_122148_aeb343cb.webp\"]', '[\"5% Cobalt M35 Alloy\",\"High Heat Resistance\",\"Stainless Steel Drilling\",\"Heavy Web Geometry\"]', 1, 2);
INSERT IGNORE INTO `products` (`id`, `slug`, `title`, `standard`, `hsn_code`, `brand`, `category`, `category_name`, `badge`, `badge_class`, `description`, `full_details`, `image`, `gallery_json`, `features_json`, `is_active`, `sort_order`) VALUES (3, 'panther-cnc', 'PANTHER High-Precision Split-Point Drills', 'IS : 5101 / Aerospace CNC Point', '8207', 'Dagger Brand / Birla Precision', 'high_performance', 'Cobalt & High Performance', 'CNC SPLIT POINT', 'badge-charcoal', 'Manufactured on 5-axis CNC grinders with a specialized 135° split-point geometry. Eliminates walking on curved surfaces and significantly reduces thrust force on CNC machining centers.', 'Manufactured on high-precision CNC grinders with unique point geometry to minimize thrust force and machine tough materials like stainless steel and alloy steels.', 'assets/images/collections/panther_drills.png', '[\"assets\\/images\\/collections\\/panther_drills.png\"]', '[\"135\\u00b0 Split Point\",\"Self-Centering\",\"Low Thrust Force\",\"CNC Machining Grade\"]', 1, 3);
INSERT IGNORE INTO `products` (`id`, `slug`, `title`, `standard`, `hsn_code`, `brand`, `category`, `category_name`, `badge`, `badge_class`, `description`, `full_details`, `image`, `gallery_json`, `features_json`, `is_active`, `sort_order`) VALUES (4, 'tin-coated', 'ITM STD. TiN Gold Coated Production Drills', 'IS : 5101 / Titanium Nitride Coated', '8207', 'Dagger Brand / Birla Precision', 'high_performance', 'Cobalt & High Performance', 'TIN GOLD COATED', 'badge-gold', 'Titanium Nitride (TiN) physical vapor deposition ceramic coating provides ultra-low surface friction, thermal barrier protection, and up to 3x longer tool life in mass production.', 'Golden TiN ceramic coating reduces friction, resists heat buildup, and substantially extends tool life during repetitive production runs.', 'assets/images/collections/tin_coated_drills.png', '[\"assets\\/images\\/collections\\/tin_coated_drills.png\"]', '[\"TiN Ceramic Coating\",\"Ultra-Low Friction\",\"3x Tool Life\",\"High-Speed Drilling\"]', 1, 4);
INSERT IGNORE INTO `products` (`id`, `slug`, `title`, `standard`, `hsn_code`, `brand`, `category`, `category_name`, `badge`, `badge_class`, `description`, `full_details`, `image`, `gallery_json`, `features_json`, `is_active`, `sort_order`) VALUES (5, 'taper-shank', 'HSS Taper Shank Twist Drills (Morse Taper)', 'IS : 5103 / ISO 235 / DIN 345', '8207', 'Dagger Brand / Birla Precision', 'twist_drills', 'HSS Twist Drills', 'MORSE TAPER', 'badge-charcoal', 'Heavy-duty industrial drills featuring precision Morse Taper shanks (MT1 to MT6) for direct spindle mounting on radial drills, pillar presses, and lathe tailstocks.', 'Standard morse taper shank drills engineered for deep hole drilling and high torque machining applications across heavy industrial equipment.', 'assets/images/collections/taper_shank.png', '[\"assets\\/images\\/collections\\/taper_shank.png\"]', '[\"MT1 to MT6 Shanks\",\"Diameters 3mm \\u2013 100mm\",\"Tough M2 Steel\",\"Direct Spindle Mount\"]', 1, 5);
INSERT IGNORE INTO `products` (`id`, `slug`, `title`, `standard`, `hsn_code`, `brand`, `category`, `category_name`, `badge`, `badge_class`, `description`, `full_details`, `image`, `gallery_json`, `features_json`, `is_active`, `sort_order`) VALUES (6, 'forgeline', 'FORGELINE Heavy Web Cast Iron GOLD & Forged Drills', 'IS : 5101 / Reinforced Core Web', '8207', 'Dagger Brand / Birla Precision', 'twist_drills', 'HSS Twist Drills', 'CAST & FORGED', 'badge-red', 'Features an extra-heavy web construction and rugged cutting edge geometry designed to resist breakout and premature wear when drilling forged steel billets and ductile cast iron.', 'Engineered with heavy-duty web and robust flutes specifically tested for forged steels, heavy castings, and demanding production environments.', 'assets/images/collections/forgeline_drills.png', '[\"assets/images/collections/forgeline_drills.png\"]', '[\"Reinforced Core Web\",\"Breakout Resistant\",\"Forged Steel Drilling\",\"Ductile Iron Geometry\"]', 1, 6);

-- ============================================================================
-- SEED DATA: Product Sizes
-- ============================================================================
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (1, 1, '1.00', '', '', 1, 1);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (2, 1, '1.50', '', '', 0, 2);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (3, 1, '2.00', '', '', 1, 3);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (4, 1, '2.50', '', '', 0, 4);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (5, 1, '3.00', '', '', 1, 5);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (6, 1, '3.17', '1/8\"', '', 1, 6);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (7, 1, '3.50', '', '', 0, 7);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (8, 1, '4.00', '', '', 1, 8);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (9, 1, '4.50', '', '', 0, 9);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (10, 1, '5.00', '', '', 1, 10);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (11, 1, '5.50', '', '', 0, 11);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (12, 1, '6.00', '', '', 1, 12);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (13, 1, '6.35', '1/4\"', '', 1, 13);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (14, 1, '6.80', '', '', 1, 14);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (15, 1, '7.00', '', '', 0, 15);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (16, 1, '7.50', '', '', 0, 16);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (17, 1, '8.00', '', '', 1, 17);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (18, 1, '8.50', '', '', 1, 18);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (19, 1, '9.00', '', '', 0, 19);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (20, 1, '9.52', '3/8\"', '', 1, 20);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (21, 1, '10.00', '', '', 1, 21);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (22, 1, '10.50', '', '', 0, 22);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (23, 1, '11.00', '', '', 0, 23);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (24, 1, '12.00', '', '', 1, 24);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (25, 1, '12.70', '1/2\"', '', 1, 25);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (26, 1, '13.00', '', '', 0, 26);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (27, 1, '14.00', '', '', 0, 27);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (28, 1, '15.00', '', '', 0, 28);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (29, 1, '16.00', '', '', 0, 29);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (59, 3, '1.00', '', '', 1, 1);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (60, 3, '1.50', '', '', 0, 2);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (61, 3, '2.00', '', '', 1, 3);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (62, 3, '2.50', '', '', 0, 4);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (63, 3, '3.00', '', '', 1, 5);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (64, 3, '3.17', '1/8\"', '', 1, 6);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (65, 3, '3.50', '', '', 0, 7);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (66, 3, '4.00', '', '', 1, 8);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (67, 3, '4.50', '', '', 0, 9);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (68, 3, '5.00', '', '', 1, 10);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (69, 3, '5.50', '', '', 0, 11);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (70, 3, '6.00', '', '', 1, 12);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (71, 3, '6.35', '1/4\"', '', 1, 13);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (72, 3, '6.80', '', '', 1, 14);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (73, 3, '7.00', '', '', 0, 15);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (74, 3, '7.50', '', '', 0, 16);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (75, 3, '8.00', '', '', 1, 17);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (76, 3, '8.50', '', '', 1, 18);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (77, 3, '9.00', '', '', 0, 19);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (78, 3, '9.52', '3/8\"', '', 1, 20);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (79, 3, '10.00', '', '', 1, 21);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (80, 3, '10.50', '', '', 0, 22);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (81, 3, '11.00', '', '', 0, 23);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (82, 3, '12.00', '', '', 1, 24);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (83, 3, '12.70', '1/2\"', '', 1, 25);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (84, 3, '13.00', '', '', 0, 26);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (85, 3, '14.00', '', '', 0, 27);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (86, 3, '15.00', '', '', 0, 28);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (87, 3, '16.00', '', '', 0, 29);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (88, 4, '1.00', '', '', 1, 1);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (89, 4, '1.50', '', '', 0, 2);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (90, 4, '2.00', '', '', 1, 3);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (91, 4, '2.50', '', '', 0, 4);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (92, 4, '3.00', '', '', 1, 5);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (93, 4, '3.17', '1/8\"', '', 1, 6);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (94, 4, '3.50', '', '', 0, 7);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (95, 4, '4.00', '', '', 1, 8);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (96, 4, '4.50', '', '', 0, 9);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (97, 4, '5.00', '', '', 1, 10);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (98, 4, '5.50', '', '', 0, 11);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (99, 4, '6.00', '', '', 1, 12);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (100, 4, '6.35', '1/4\"', '', 1, 13);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (101, 4, '6.80', '', '', 1, 14);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (102, 4, '7.00', '', '', 0, 15);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (103, 4, '7.50', '', '', 0, 16);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (104, 4, '8.00', '', '', 1, 17);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (105, 4, '8.50', '', '', 1, 18);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (106, 4, '9.00', '', '', 0, 19);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (107, 4, '9.52', '3/8\"', '', 1, 20);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (108, 4, '10.00', '', '', 1, 21);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (109, 4, '10.50', '', '', 0, 22);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (110, 4, '11.00', '', '', 0, 23);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (111, 4, '12.00', '', '', 1, 24);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (112, 4, '12.70', '1/2\"', '', 1, 25);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (113, 4, '13.00', '', '', 0, 26);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (114, 4, '14.00', '', '', 0, 27);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (115, 4, '15.00', '', '', 0, 28);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (116, 4, '16.00', '', '', 0, 29);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (117, 5, '1.00', '', '', 1, 1);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (118, 5, '1.50', '', '', 0, 2);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (119, 5, '2.00', '', '', 1, 3);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (120, 5, '2.50', '', '', 0, 4);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (121, 5, '3.00', '', '', 1, 5);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (122, 5, '3.17', '1/8\"', '', 1, 6);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (123, 5, '3.50', '', '', 0, 7);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (124, 5, '4.00', '', '', 1, 8);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (125, 5, '4.50', '', '', 0, 9);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (126, 5, '5.00', '', '', 1, 10);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (127, 5, '5.50', '', '', 0, 11);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (128, 5, '6.00', '', '', 1, 12);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (129, 5, '6.35', '1/4\"', '', 1, 13);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (130, 5, '6.80', '', '', 1, 14);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (131, 5, '7.00', '', '', 0, 15);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (132, 5, '7.50', '', '', 0, 16);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (133, 5, '8.00', '', '', 1, 17);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (134, 5, '8.50', '', '', 1, 18);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (135, 5, '9.00', '', '', 0, 19);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (136, 5, '9.52', '3/8\"', '', 1, 20);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (137, 5, '10.00', '', '', 1, 21);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (138, 5, '10.50', '', '', 0, 22);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (139, 5, '11.00', '', '', 0, 23);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (140, 5, '12.00', '', '', 1, 24);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (141, 5, '12.70', '1/2\"', '', 1, 25);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (142, 5, '13.00', '', '', 0, 26);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (143, 5, '14.00', '', '', 0, 27);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (144, 5, '15.00', '', '', 0, 28);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (145, 5, '16.00', '', '', 0, 29);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (175, 6, '1.00', '', '', 1, 1);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (176, 6, '1.50', '', '', 0, 2);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (177, 6, '2.00', '', '', 1, 3);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (178, 6, '2.50', '', '', 0, 4);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (179, 6, '3.00', '', '', 1, 5);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (180, 6, '3.17', '1/8\"', '', 1, 6);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (181, 6, '3.50', '', '', 0, 7);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (182, 6, '4.00', '', '', 1, 8);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (183, 6, '4.50', '', '', 0, 9);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (184, 6, '5.00', '', '', 1, 10);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (185, 6, '5.50', '', '', 0, 11);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (186, 6, '6.00', '', '', 1, 12);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (187, 6, '6.35', '1/4\"', '', 1, 13);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (188, 6, '6.80', '', '', 1, 14);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (189, 6, '7.00', '', '', 0, 15);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (190, 6, '7.50', '', '', 0, 16);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (191, 6, '8.00', '', '', 1, 17);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (192, 6, '8.50', '', '', 1, 18);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (193, 6, '9.00', '', '', 0, 19);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (194, 6, '9.52', '3/8\"', '', 1, 20);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (195, 6, '10.00', '', '', 1, 21);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (196, 6, '10.50', '', '', 0, 22);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (197, 6, '11.00', '', '', 0, 23);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (198, 6, '12.00', '', '', 1, 24);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (199, 6, '12.70', '1/2\"', '', 1, 25);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (200, 6, '13.00', '', '', 0, 26);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (201, 6, '14.00', '', '', 0, 27);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (202, 6, '15.00', '', '', 0, 28);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (203, 6, '16.00', '', '', 0, 29);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (233, 2, '1.00', '', '', 1, 1);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (234, 2, '1.50', '', '', 0, 2);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (235, 2, '2.00', '', '', 1, 3);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (236, 2, '2.50', '', '', 0, 4);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (237, 2, '3.00', '', '', 1, 5);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (238, 2, '3.17', '1/8\"', '', 1, 6);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (239, 2, '3.50', '', '', 0, 7);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (240, 2, '4.00', '', '', 1, 8);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (241, 2, '4.50', '', '', 0, 9);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (242, 2, '5.00', '', '', 1, 10);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (243, 2, '5.50', '', '', 0, 11);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (244, 2, '6.00', '', '', 1, 12);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (245, 2, '6.35', '1/4\"', '', 1, 13);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (246, 2, '6.80', '', '', 1, 14);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (247, 2, '7.00', '', '', 0, 15);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (248, 2, '7.50', '', '', 0, 16);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (249, 2, '8.00', '', '', 1, 17);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (250, 2, '8.50', '', '', 1, 18);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (251, 2, '9.00', '', '', 0, 19);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (252, 2, '9.52', '3/8\"', '', 1, 20);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (253, 2, '10.00', '', '', 1, 21);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (254, 2, '10.50', '', '', 0, 22);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (255, 2, '11.00', '', '', 0, 23);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (256, 2, '12.00', '', '', 1, 24);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (257, 2, '12.70', '1/2\"', '', 1, 25);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (258, 2, '13.00', '', '', 0, 26);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (259, 2, '14.00', '', '', 0, 27);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (260, 2, '15.00', '', '', 0, 28);
INSERT IGNORE INTO `product_sizes` (`id`, `product_id`, `size_mm`, `size_inch`, `dg`, `is_popular`, `sort_order`) VALUES (261, 2, '16.00', '', '', 0, 29);

SET FOREIGN_KEY_CHECKS = 1;
