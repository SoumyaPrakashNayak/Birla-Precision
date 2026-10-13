<?php
/**
 * Birla Precision Technologies Limited / Dagger Brand
 * Homepage (index.php)
 * Faithfully reproducing iBELL layout: Header, Hero, Asymmetrical Tiles, and COLLECTION LIST
 */

require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/db.php';

$current_page = 'home';
$page_title = 'Birla Precision Technologies | Dagger Brand Industrial Tooling';
$page_description = 'Official industrial portal of Birla Precision Technologies Limited (BPTL) and Dagger Brand. High-speed steel (HSS) Parallel Shank Twist Drills (Jobber Series) conforming to IS : 5101.';

$family = get_product_family();
$variants = get_product_variants();

// Fetch dynamic homepage sections from database
$hero_slides = get_site_sections('hero');
$feature_tiles = get_site_sections('feature_tiles');
$collection_items = get_site_sections('collections');

include __DIR__ . '/includes/header.php';
?>

<!-- ==========================================================================
     SECTION 2: FULL-WIDTH HERO CAROUSEL (Dynamic Database Driven)
     ========================================================================== -->
<section class="hero-carousel-section" id="heroCarousel" aria-label="Featured Promotions">
  <div class="hero-carousel-track">
    <?php foreach ($hero_slides as $idx => $slide): ?>
      <div class="hero-slide <?= $idx === 0 ? 'is-active' : '' ?>" aria-label="<?= strip_tags($slide['title']) ?>">
        <img src="<?= htmlspecialchars($slide['image_url']) ?>" alt="<?= strip_tags($slide['title']) ?>" class="hero-slide-bg" onerror="this.src='assets/images/hero/hero_twist_drills_precision.jpg'">
        <div class="hero-slide-dark-overlay"></div>
        <div class="container hero-slide-dark-content">
          <div class="hero-dark-text-box">
            <?php if (!empty($slide['eyebrow'])): ?>
              <span class="hero-eyebrow-red"><?= htmlspecialchars($slide['eyebrow']) ?></span>
            <?php endif; ?>
            <h2 class="hero-dark-heading hero-trusted-heading">
              <?= $slide['title'] ?>
            </h2>
            <?php if (!empty($slide['subtitle'])): ?>
              <p class="hero-dark-subheading"><?= htmlspecialchars($slide['subtitle']) ?></p>
            <?php endif; ?>
            <a href="<?= htmlspecialchars($slide['link_url'] ?? 'products/parallel-shank-twist-drills.php') ?>" class="btn btn-primary hero-explore-btn">
              Explore Jobber Series &rarr;
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Carousel Navigation Controls -->
  <button class="carousel-btn carousel-btn-prev" aria-label="Previous Slide">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="16 3 7 12 16 21"></polyline>
    </svg>
  </button>
  <button class="carousel-btn carousel-btn-next" aria-label="Next Slide">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="8 3 17 12 8 21"></polyline>
    </svg>
  </button>

  <!-- Carousel Indicators matching slide count -->
  <div class="carousel-indicators">
    <?php foreach ($hero_slides as $idx => $slide): ?>
      <button class="carousel-dot <?= $idx === 0 ? 'is-active' : '' ?>" data-slide-to="<?= $idx ?>" aria-label="Slide <?= $idx + 1 ?>" <?= $idx === 0 ? 'aria-current="true"' : '' ?>></button>
    <?php endforeach; ?>
  </div>
</section>

<!-- ==========================================================================
     SECTION 2: LARGE ASYMMETRICAL FEATURE TILES (Dynamic Database Driven)
     ========================================================================== -->
<section class="feature-tiles-section" aria-label="Feature Equipment Tiles">
  <div class="container">
    
    <div class="tiles-wrapper">
      
      <!-- Row 1: Wide Left + Narrow Right -->
      <div class="tiles-row tiles-row-1">
        <?php if (isset($feature_tiles[0])): $t1 = $feature_tiles[0]; ?>
          <a href="<?= htmlspecialchars($t1['link_url'] ?? 'products/parallel-shank-twist-drills.php') ?>" class="feature-tile" data-aos="fade-right" data-aos-duration="600" aria-label="<?= htmlspecialchars($t1['title']) ?>">
            <img src="<?= htmlspecialchars($t1['image_url']) ?>" alt="<?= htmlspecialchars($t1['title']) ?>" class="tile-bg-image" loading="lazy">
            <div class="tile-overlay"></div>
            <div class="tile-caption">
              <h3 class="tile-label"><?= htmlspecialchars($t1['title']) ?></h3>
              <span class="tile-subtext">
                <?= htmlspecialchars($t1['subtitle']) ?>
                <svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
              </span>
            </div>
          </a>
        <?php endif; ?>

        <?php if (isset($feature_tiles[1])): $t2 = $feature_tiles[1]; ?>
          <a href="<?= htmlspecialchars($t2['link_url'] ?? 'products/parallel-shank-twist-drills.php') ?>" class="feature-tile" data-aos="fade-left" data-aos-duration="600" aria-label="<?= htmlspecialchars($t2['title']) ?>">
            <img src="<?= htmlspecialchars($t2['image_url']) ?>" alt="<?= htmlspecialchars($t2['title']) ?>" class="tile-bg-image" loading="lazy">
            <div class="tile-overlay"></div>
            <div class="tile-caption">
              <h3 class="tile-label"><?= htmlspecialchars($t2['title']) ?></h3>
              <span class="tile-subtext">
                <?= htmlspecialchars($t2['subtitle']) ?>
                <svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
              </span>
            </div>
          </a>
        <?php endif; ?>
      </div>

      <!-- Row 2: Narrow Left + Wide Right -->
      <div class="tiles-row tiles-row-2">
        <?php if (isset($feature_tiles[2])): $t3 = $feature_tiles[2]; ?>
          <a href="<?= htmlspecialchars($t3['link_url'] ?? 'products/parallel-shank-twist-drills.php') ?>" class="feature-tile" data-aos="fade-right" data-aos-duration="600" aria-label="<?= htmlspecialchars($t3['title']) ?>">
            <img src="<?= htmlspecialchars($t3['image_url']) ?>" alt="<?= htmlspecialchars($t3['title']) ?>" class="tile-bg-image" loading="lazy">
            <div class="tile-overlay"></div>
            <div class="tile-caption">
              <h3 class="tile-label"><?= htmlspecialchars($t3['title']) ?></h3>
              <span class="tile-subtext">
                <?= htmlspecialchars($t3['subtitle']) ?>
                <svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
              </span>
            </div>
          </a>
        <?php endif; ?>

        <?php if (isset($feature_tiles[3])): $t4 = $feature_tiles[3]; ?>
          <a href="<?= htmlspecialchars($t4['link_url'] ?? 'products/parallel-shank-twist-drills.php') ?>" class="feature-tile" data-aos="fade-left" data-aos-duration="600" aria-label="<?= htmlspecialchars($t4['title']) ?>">
            <img src="<?= htmlspecialchars($t4['image_url']) ?>" alt="<?= htmlspecialchars($t4['title']) ?>" class="tile-bg-image" loading="lazy">
            <div class="tile-overlay"></div>
            <div class="tile-caption">
              <h3 class="tile-label"><?= htmlspecialchars($t4['title']) ?></h3>
              <span class="tile-subtext">
                <?= htmlspecialchars($t4['subtitle']) ?>
                <svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
              </span>
            </div>
          </a>
        <?php endif; ?>
      </div>

    </div>

  </div>
</section>

<!-- ==========================================================================
     SECTION 3: COLLECTION LIST (Dynamic Database Driven)
     ========================================================================== -->
<section class="collection-list-section" id="collection" aria-label="Collection List">
  <div class="container">
    
    <div class="collection-header" data-aos="fade-up" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
      <h2 class="collection-title" style="margin:0;">COLLECTION LIST</h2>
      <a href="products.php" class="btn btn-secondary" style="font-size:0.85rem;padding:8px 18px;border-radius:6px;text-decoration:none;font-weight:600;">
        Explore All Products &rarr;
      </a>
    </div>

    <!-- Dynamic Collection Grid -->
    <div class="collection-grid">
      <?php foreach ($collection_items as $cidx => $col): ?>
        <a href="<?= htmlspecialchars($col['link_url'] ?? 'products/parallel-shank-twist-drills.php') ?>" class="collection-card" data-aos="fade-up" data-aos-delay="<?= min(500, ($cidx + 1) * 50) ?>">
          <div class="collection-img-box">
            <img src="<?= htmlspecialchars($col['image_url']) ?>" alt="<?= htmlspecialchars($col['title']) ?>" class="collection-img" loading="lazy" onerror="this.src='assets/images/brand/dagger_brand_logo.png'">
          </div>
          <h3 class="collection-item-title"><?= htmlspecialchars($col['title']) ?></h3>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Red "view more" Button -->
    <div class="collection-actions" data-aos="fade-up">
      <a href="products.php" class="btn-view-more">
        view more
      </a>
    </div>

  </div>
</section>

<!-- ==========================================================================
     OUR FOUNDATION IN NUMBERS / PIONEERING SECTION (Matching Image 1 Reference)
     ========================================================================== -->
<section class="foundation-numbers-section" id="about" aria-label="Our Foundation in Numbers">
  
  <!-- Left Side Drill Flute Backdrop Image with Smooth Fade -->
  <div class="foundation-bg-flute" aria-hidden="true">
    <img src="assets/images/hero/hero_twist_drills_precision.jpg" alt="" class="foundation-flute-img">
    <div class="foundation-flute-overlay"></div>
  </div>

  <!-- Right Side World Globe Graphic with Dotted Trade Connections -->
  <div class="foundation-bg-globe" aria-hidden="true">
    <svg viewBox="0 0 460 460" fill="none" class="foundation-globe-svg" xmlns="http://www.w3.org/2000/svg">
      <!-- Latitude / Longitude Grids -->
      <circle cx="230" cy="230" r="190" stroke="#E5E7EB" stroke-width="1.5" stroke-dasharray="4 4"/>
      <ellipse cx="230" cy="230" rx="190" ry="120" stroke="#E5E7EB" stroke-width="1.2" stroke-dasharray="3 3"/>
      <ellipse cx="230" cy="230" rx="190" ry="60" stroke="#E5E7EB" stroke-width="1.2" stroke-dasharray="3 3"/>
      <line x1="40" y1="230" x2="420" y2="230" stroke="#E5E7EB" stroke-width="1.2"/>
      <ellipse cx="230" cy="230" rx="120" ry="190" stroke="#E5E7EB" stroke-width="1.2" stroke-dasharray="3 3"/>
      <ellipse cx="230" cy="230" rx="60" ry="190" stroke="#E5E7EB" stroke-width="1.2" stroke-dasharray="3 3"/>
      <line x1="230" y1="40" x2="230" y2="420" stroke="#E5E7EB" stroke-width="1.2"/>
      
      <!-- Stylized Continent Dot Patterns / Shapes -->
      <path d="M160 120c15-5 35 10 50 5s25-25 45-20 30 20 25 35-15 25-5 40 30 15 25 30-20 25-35 15-25 10-35-5-15-30-30-25-35-10-40-35 5-30 0-40z" fill="#D1D5DB" fill-opacity="0.35"/>
      <path d="M220 230c10-5 25 5 35 15s15 30 10 45-20 25-15 40-15 20-30 15-20-15-25-30 5-35 10-50 5-30 15-35z" fill="#D1D5DB" fill-opacity="0.3"/>
      <path d="M100 130c12-8 28 5 35 18s5 25 0 35-18 15-25 28-20 5-25-10 2-28 5-40 0-25 10-31z" fill="#D1D5DB" fill-opacity="0.25"/>
      
      <!-- Arcs Connecting Global Manufacturing Hubs -->
      <path d="M220 185 Q 280 120 360 160" stroke="#D92D30" stroke-width="1.8" stroke-dasharray="4 3" stroke-linecap="round"/>
      <path d="M220 185 Q 260 90 180 100" stroke="#D92D30" stroke-width="1.8" stroke-dasharray="4 3" stroke-linecap="round"/>
      <path d="M220 185 Q 250 270 340 290" stroke="#D92D30" stroke-width="1.5" stroke-dasharray="4 3" stroke-linecap="round"/>
      <path d="M220 185 Q 150 140 100 160" stroke="#D92D30" stroke-width="1.5" stroke-dasharray="4 3" stroke-linecap="round"/>
      
      <!-- Hub Nodes / Red Anchor Dots -->
      <circle cx="220" cy="185" r="4.5" fill="#D92D30"/>
      <circle cx="220" cy="185" r="8" stroke="#D92D30" stroke-width="1.2" stroke-opacity="0.4"/>
      <circle cx="360" cy="160" r="3.5" fill="#D92D30"/>
      <circle cx="180" cy="100" r="3.5" fill="#D92D30"/>
      <circle cx="340" cy="290" r="3.5" fill="#D92D30"/>
      <circle cx="100" cy="160" r="3.5" fill="#D92D30"/>
    </svg>
  </div>

  <div class="container foundation-container">
    
    <!-- Header: Eyebrow + Heading + Subtitle -->
    <div class="foundation-header-box" data-aos="fade-up">
      <div class="foundation-eyebrow">
        <span class="foundation-eyebrow-line"></span>
        <span class="foundation-eyebrow-text">OUR FOUNDATION IN NUMBERS</span>
        <span class="foundation-eyebrow-line"></span>
      </div>
      <h2 class="foundation-main-title">
        Trusted by <span class="highlight-red">Industries Worldwide</span>
      </h2>
      <p class="foundation-lead-desc">
        Decades of expertise, advanced manufacturing, and a global presence driving precision in every cut.
      </p>
    </div>

    <!-- 4 Stats Columns Grid with Vertical Dividers & Rolling Numbers -->
    <div class="foundation-stats-grid" id="foundationStatsGrid">
      
      <!-- 1. 1937 - Pioneering Legacy -->
      <div class="foundation-stat-col" data-aos="fade-up" data-aos-delay="100">
        <div class="stat-icon-badge">
          <!-- Industrial Factory icon -->
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2 20h20M4 20V8l4 3V8l4 3V4l8 4v12H4z"></path>
          </svg>
        </div>
        <div class="foundation-stat-num-box">
          <span class="stat-roll-number" data-target="1937">0</span>
        </div>
        <h4 class="foundation-stat-heading">Pioneering Legacy</h4>
        <p class="foundation-stat-summary">
          First company in India to manufacture High-Speed Steel cutting tools and precision toolholders.
        </p>
      </div>

      <!-- 2. 3 - Advanced Plants -->
      <div class="foundation-stat-col" data-aos="fade-up" data-aos-delay="200">
        <div class="stat-icon-badge">
          <!-- Plant / Manufacturing facility icon -->
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 21h18M5 21V10l4 2.5V10l4 2.5V7l6 3v11H5z"></path>
          </svg>
        </div>
        <div class="foundation-stat-num-box">
          <span class="stat-roll-number" data-target="3">0</span>
        </div>
        <h4 class="foundation-stat-heading">Advanced Plants</h4>
        <p class="foundation-stat-summary">
          State-of-the-art production facilities at Nashik, Aurangabad, and Chalisgaon with CNC grinding lines.
        </p>
      </div>

      <!-- 3. 50+ - Countries Served -->
      <div class="foundation-stat-col" data-aos="fade-up" data-aos-delay="300">
        <div class="stat-icon-badge">
          <!-- Globe icon -->
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="2" y1="12" x2="22" y2="12"></line>
            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
          </svg>
        </div>
        <div class="foundation-stat-num-box">
          <span class="stat-roll-number" data-target="50" data-suffix="+">0</span><span class="stat-plus-sign">+</span>
        </div>
        <h4 class="foundation-stat-heading">Countries Served</h4>
        <p class="foundation-stat-summary">
          Global footprint delivering dependable industrial tooling solutions to international manufacturing hubs.
        </p>
      </div>

      <!-- 4. 262 - Jobber Diameters -->
      <div class="foundation-stat-col" data-aos="fade-up" data-aos-delay="400">
        <div class="stat-icon-badge">
          <!-- Twist drill flutes / tool icon -->
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="8" y="2" width="8" height="20" rx="3"></rect>
            <line x1="8" y1="7" x2="16" y2="10"></line>
            <line x1="8" y1="12" x2="16" y2="15"></line>
            <line x1="8" y1="17" x2="16" y2="20"></line>
          </svg>
        </div>
        <div class="foundation-stat-num-box">
          <span class="stat-roll-number" data-target="262">0</span>
        </div>
        <h4 class="foundation-stat-heading">Jobber Diameters</h4>
        <p class="foundation-stat-summary">
          Comprehensive size availability from 0.30 mm micro-drills to 22.22 mm (7/8") heavy duty jobbers.
        </p>
      </div>

    </div>

  </div>
</section>



<?php
include __DIR__ . '/includes/footer.php';
?>
