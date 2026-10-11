import json
import pymysql
import os

# Connect to MySQL
conn = pymysql.connect(
    host='127.0.0.1',
    user='root',
    password='',
    database='birla_precision',
    autocommit=False,
    charset='utf8mb4'
)

cursor = conn.cursor()

# 1. Create tables
cursor.execute("DROP TABLE IF EXISTS size_variant_pricing")
cursor.execute("DROP TABLE IF EXISTS product_sizes")
cursor.execute("DROP TABLE IF EXISTS product_variants")
cursor.execute("DROP TABLE IF EXISTS product_families")
cursor.execute("DROP TABLE IF EXISTS enquiries")

cursor.execute("""
CREATE TABLE product_families (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    brand VARCHAR(100) NOT NULL DEFAULT 'Birla Precision / Dagger Brand',
    standard VARCHAR(100) NOT NULL DEFAULT 'IS : 5101',
    hsn_code VARCHAR(50) NOT NULL DEFAULT '8207',
    material VARCHAR(100) NOT NULL DEFAULT 'HSS M2',
    shank_type VARCHAR(100) NOT NULL DEFAULT 'Parallel Shank',
    series VARCHAR(100) NOT NULL DEFAULT 'Jobber Series',
    description TEXT,
    pricing_unit VARCHAR(50) DEFAULT 'PRICE PER 10 PCS (RS.)',
    effective_date VARCHAR(50) DEFAULT 'Effective: 1st April 2026'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
""")

cursor.execute("""
CREATE TABLE product_variants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    grade VARCHAR(100) NOT NULL,
    coating VARCHAR(100) DEFAULT NULL,
    description TEXT,
    logo_path VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
""")

cursor.execute("""
CREATE TABLE product_sizes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_family_id INT NOT NULL,
    metric_dia DECIMAL(6,2) NOT NULL,
    inch_equiv VARCHAR(20) DEFAULT NULL,
    gauge_number VARCHAR(20) DEFAULT NULL,
    moq INT NOT NULL DEFAULT 100,
    page_source INT NOT NULL,
    INDEX idx_metric_dia (metric_dia),
    FOREIGN KEY (product_family_id) REFERENCES product_families (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
""")

cursor.execute("""
CREATE TABLE size_variant_pricing (
    id INT AUTO_INCREMENT PRIMARY KEY,
    size_id INT NOT NULL,
    variant_id INT NOT NULL,
    price_per_10_pcs DECIMAL(10,2) DEFAULT NULL,
    is_available TINYINT(1) NOT NULL DEFAULT 0,
    catalogue_edition VARCHAR(50) DEFAULT 'April 2026',
    UNIQUE KEY uq_size_variant (size_id, variant_id),
    FOREIGN KEY (size_id) REFERENCES product_sizes (id) ON DELETE CASCADE,
    FOREIGN KEY (variant_id) REFERENCES product_variants (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
""")

cursor.execute("""
CREATE TABLE enquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    enquiry_ref VARCHAR(50) NOT NULL UNIQUE,
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
    message TEXT,
    ip_address VARCHAR(50) DEFAULT NULL,
    status VARCHAR(50) DEFAULT 'New',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
""")

conn.commit()
print("Tables created successfully.")

# 2. Insert product family
desc = (
    "Birla Precision Technologies Limited / Dagger Brand HSS Parallel Shank Twist Drills (Jobber Series) "
    "are engineered in accordance with Indian Standard IS : 5101 and international ISO standards. "
    "Manufactured from premium High-Speed Steel (M2 standard grade) with state-of-the-art CNC grinding technology "
    "at ITM's pioneering facilities in Nashik, Aurangabad, and Chalisgaon. Delivering superior flute precision, "
    "consistent chip clearance, and exceptional hole accuracy across general engineering, automotive, "
    "forged steel, and industrial machining applications."
)

cursor.execute("""
INSERT INTO product_families (name, slug, brand, standard, hsn_code, material, shank_type, series, description, pricing_unit, effective_date)
VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
""", (
    'HSS Parallel Shank Twist Drills — Jobber Series',
    'parallel-shank-twist-drills',
    'Dagger Brand / Birla Precision',
    'IS : 5101',
    '8207',
    'HSS - M2 (Standard) / M35 Cobalt',
    'Parallel Shank',
    'Jobber Series',
    desc,
    'PRICE PER 10 PCS (RS.)',
    'Effective: 1st April 2026'
))
family_id = cursor.lastrowid
print(f"Inserted product family ID: {family_id}")

# 3. Insert the 6 Variants
variants_data = [
    (
        'itm_std',
        'ITM STD.',
        'HSS M2',
        'Bright / Steam Tempered',
        'Standard industrial grade HSS drill for general purpose steel, iron, and structural engineering materials.',
        'assets/images/brand/dagger_brand_logo.png'
    ),
    (
        'itm_std_tin',
        'ITM STD. TIN',
        'HSS M2',
        'Titanium Nitride (TiN Gold)',
        'Titanium Nitride coated for reduced friction, enhanced heat dissipation, and extended production tool life.',
        'assets/images/brand/dagger_brand_logo.png'
    ),
    (
        'panther',
        'PANTHER',
        'HSS Premium CNC Ground',
        'Special Surface Treatment',
        'Engineered with special point geometry to reduce thrust force, for machining tough alloys, stainless steels, and nickel chromium steels.',
        'assets/images/brand/panther_logo.png'
    ),
    (
        'ninja',
        'NINJA',
        'HSS M35 Cobalt',
        'Special Ground Finish',
        'High heat-resistant cobalt steel series engineered for razor-sharp cutting accuracy and high tensile strength alloys.',
        'assets/images/brand/ninja_logo.png'
    ),
    (
        'forgeline',
        'FORGELINE',
        'HSS Robust Geometry',
        'Wear-Resistant Finish',
        'Special heavy-duty geometry specifically engineered for high-productivity drilling in forged steel and cast iron.',
        'assets/images/brand/forgeline_logo.png'
    ),
    (
        'hathyar',
        'HATHYAR',
        'HSS Heavy Duty',
        'Industrial Ground',
        'High-torque heavy duty jobber series designed for demanding fabrication, workshop, and structural operations.',
        'assets/images/brand/hathyar_logo.png'
    )
]

variant_map = {}
for code, name, grade, coating, v_desc, logo in variants_data:
    cursor.execute("""
    INSERT INTO product_variants (code, name, grade, coating, description, logo_path)
    VALUES (%s, %s, %s, %s, %s, %s)
    """, (code, name, grade, coating, v_desc, logo))
    variant_map[code] = cursor.lastrowid

conn.commit()
print("Inserted variants:", variant_map)

# 4. Load JSON rows and insert sizes and pricing
with open('jobber_series_data.json', 'r', encoding='utf-8') as f:
    rows = json.load(f)

sizes_count = 0
pricing_count = 0

for row in rows:
    cursor.execute("""
    INSERT INTO product_sizes (product_family_id, metric_dia, inch_equiv, gauge_number, moq, page_source)
    VALUES (%s, %s, %s, %s, %s, %s)
    """, (
        family_id,
        row['diameter_float'],
        row['inch'],
        row['dg'],
        row['moq'] if row['moq'] is not None else 100,
        row['page']
    ))
    size_id = cursor.lastrowid
    sizes_count += 1
    
    # 6 variants
    var_cols = [
        ('itm_std', row['itm_std']),
        ('itm_std_tin', row['itm_std_tin']),
        ('panther', row['panther']),
        ('ninja', row['ninja']),
        ('forgeline', row['forgeline']),
        ('hathyar', row['hathyar'])
    ]
    
    for v_code, price in var_cols:
        v_id = variant_map[v_code]
        is_avail = 1 if (price is not None and price > 0) else 0
        cursor.execute("""
        INSERT INTO size_variant_pricing (size_id, variant_id, price_per_10_pcs, is_available, catalogue_edition)
        VALUES (%s, %s, %s, %s, %s)
        """, (size_id, v_id, price, is_avail, 'April 2026'))
        pricing_count += 1

conn.commit()
cursor.close()
conn.close()

print(f"Successfully seeded database! Total sizes: {sizes_count}, Total pricing entries: {pricing_count}")
