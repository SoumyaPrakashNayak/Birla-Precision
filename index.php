<?php
/**
 * Birla Precision Technologies Limited / Dagger Brand
 * Homepage (index.php)
 * Faithfully reproducing iBELL layout: Header, Hero, Asymmetrical Tiles, and COLLECTION LIST
 */

require_once __DIR__ . '/includes/data.php';

$current_page = 'home';
$page_title = 'Birla Precision Technologies | Dagger Brand Industrial Tooling';
$page_description = 'Official industrial portal of Birla Precision Technologies Limited (BPTL) and Dagger Brand. High-speed steel (HSS) Parallel Shank Twist Drills (Jobber Series) conforming to IS : 5101.';

$family = get_product_family();
$variants = get_product_variants();

include __DIR__ . '/includes/header.php';
?>

<!-- ==========================================================================
     SECTION 2: FULL-WIDTH HERO CAROUSEL (iBELL Screenshot 1 & 2 Layout)
     ========================================================================== -->
<section class="hero-carousel-section" id="heroCarousel" aria-label="Featured Promotions">
  <div class="hero-carousel-track">
    
    <!-- Slide 1: Exact Match for Design Reference (HSS Twist Drills - Trusted for Precision) -->
    <div class="hero-slide is-active" aria-label="HSS Twist Drills - Trusted for Precision">
      <img src="assets/images/hero/hero_twist_drills_precision.jpg" alt="High Speed Steel Twist Drills by Birla Precision" class="hero-slide-bg">
      <div class="hero-slide-dark-overlay"></div>
      <div class="container hero-slide-dark-content">
        <div class="hero-dark-text-box">
          <span class="hero-eyebrow-red">HSS TWIST DRILLS</span>
          <h2 class="hero-dark-heading hero-trusted-heading">
            <span class="trusted-word">Trusted</span> for Precision
          </h2>
          <p class="hero-dark-subheading">High-performance cutting tools for aerospace, automotive and heavy fabrication.</p>
          <a href="products/parallel-shank-twist-drills.php" class="btn btn-primary hero-explore-btn">
            Explore Jobber Series &rarr;
          </a>
        </div>
      </div>
    </div>

    <!-- Slide 2: High Precision CNC Machining -->
    <div class="hero-slide" aria-label="Industrial High Precision CNC Machining">
      <img src="assets/images/hero/hero_industrial_precision.jpg" alt="Industrial CNC Precision Machining Center" class="hero-slide-bg">
      <div class="hero-slide-dark-overlay"></div>
      <div class="container hero-slide-dark-content">
        <div class="hero-dark-text-box">
          <span class="hero-eyebrow-red">DAGGER BRAND &bull; SINCE 1937</span>
          <h2 class="hero-dark-heading hero-trusted-heading">
            <span class="trusted-word">Precision</span> That Drives Performance
          </h2>
          <p class="hero-dark-subheading">Engineered tooling solutions for demanding industrial applications across 50+ countries.</p>
          <a href="products/parallel-shank-twist-drills.php" class="btn btn-primary hero-explore-btn">
            Explore All Variants &rarr;
          </a>
        </div>
      </div>
    </div>

    <!-- Slide 3: Automated Drill Manufacturing Line -->
    <div class="hero-slide" aria-label="Automated Precision Grinding & Drill Manufacturing">
      <img src="assets/images/hero/hero_drill_manufacturing.jpg" alt="Robotic Automated Drill Manufacturing Line" class="hero-slide-bg">
      <div class="hero-slide-dark-overlay"></div>
      <div class="container hero-slide-dark-content">
        <div class="hero-dark-text-box">
          <span class="hero-eyebrow-red">INDIAN TOOL MANUFACTURERS</span>
          <h2 class="hero-dark-heading hero-trusted-heading">
            <span class="trusted-word">Pioneering</span> Industrial Drills
          </h2>
          <p class="hero-dark-subheading">Precision HSS Parallel Shank Twist Drills conforming strictly to IS : 5101 standards.</p>
          <a href="products/parallel-shank-twist-drills.php" class="btn btn-primary hero-explore-btn">
            View Jobber Series &rarr;
          </a>
        </div>
      </div>
    </div>

  </div>

  <!-- Carousel Navigation Controls -->
  <button class="carousel-btn carousel-btn-prev" aria-label="Previous Slide">
    <svg viewBox="0 0 24 24">
      <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
    </svg>
  </button>
  <button class="carousel-btn carousel-btn-next" aria-label="Next Slide">
    <svg viewBox="0 0 24 24">
      <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
    </svg>
  </button>

  <!-- 3 Carousel Indicators at Bottom Center (matching iBELL screenshots) -->
  <div class="carousel-indicators">
    <button class="carousel-dot is-active" data-slide-to="0" aria-label="Slide 1" aria-current="true"></button>
    <button class="carousel-dot" data-slide-to="1" aria-label="Slide 2"></button>
    <button class="carousel-dot" data-slide-to="2" aria-label="Slide 3"></button>
  </div>
</section>

<!-- ==========================================================================
     SECTION 2: LARGE ASYMMETRICAL FEATURE TILES (iBELL Style)
     ========================================================================== -->
<section class="feature-tiles-section" aria-label="Feature Equipment Tiles">
  <div class="container">
    
    <div class="tiles-wrapper">
      
      <!-- Row 1: Wide Left (CHAIN SAWS) + Narrow Right (DRIVERS & DRILLS) -->
      <div class="tiles-row tiles-row-1">
        
        <!-- Tile 1: Wide Left - CHAIN SAWS -->
        <a href="products/parallel-shank-twist-drills.php" class="feature-tile" data-aos="fade-right" data-aos-duration="600" aria-label="Chain Saws">
          <img src="assets/images/tiles/tile_chainsaws.jpg" alt="Professional Chain Saws" class="tile-bg-image" loading="lazy">
          <div class="tile-overlay"></div>
          <div class="tile-caption">
            <h3 class="tile-label">CHAIN SAWS</h3>
            <span class="tile-subtext">
              Heavy Duty Industrial Reference
              <svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
            </span>
          </div>
        </a>

        <!-- Tile 2: Narrow Right - DRIVERS & DRILLS -->
        <a href="products/parallel-shank-twist-drills.php" class="feature-tile" data-aos="fade-left" data-aos-duration="600" aria-label="Drivers and Drills">
          <img src="assets/images/tiles/tile_drivers_drills.jpg" alt="Industrial Drivers and Drills" class="tile-bg-image" loading="lazy">
          <div class="tile-overlay"></div>
          <div class="tile-caption">
            <h3 class="tile-label">DRIVERS &amp; DRILLS</h3>
            <span class="tile-subtext">
              High-Torque Performance
              <svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
            </span>
          </div>
        </a>

      </div>

      <!-- Row 2: Narrow Left (CUTTING TOOLS) + Wide Right (POWER TOOLS) -->
      <div class="tiles-row tiles-row-2">
        
        <!-- Tile 3: Narrow Left - CUTTING TOOLS -->
        <a href="products/parallel-shank-twist-drills.php" class="feature-tile" data-aos="fade-right" data-aos-duration="600" aria-label="Cutting Tools">
          <img src="assets/images/tiles/tile_cutting_tools.jpg" alt="Industrial Cutting Tools" class="tile-bg-image" loading="lazy">
          <div class="tile-overlay"></div>
          <div class="tile-caption">
            <h3 class="tile-label">CUTTING TOOLS</h3>
            <span class="tile-subtext">
              Precision High-Speed Steel
              <svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
            </span>
          </div>
        </a>

        <!-- Tile 4: Wide Right - POWER TOOLS -->
        <a href="products/parallel-shank-twist-drills.php" class="feature-tile" data-aos="fade-left" data-aos-duration="600" aria-label="Power Tools">
          <img src="assets/images/tiles/tile_power_tools.jpg" alt="Industrial Power Tools" class="tile-bg-image" loading="lazy">
          <div class="tile-overlay"></div>
          <div class="tile-caption">
            <h3 class="tile-label">POWER TOOLS</h3>
            <span class="tile-subtext">
              Metal Fabrication &amp; Grinding
              <svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
            </span>
          </div>
        </a>

      </div>

    </div>

  </div>
</section>

<!-- ==========================================================================
     SECTION 3: COLLECTION LIST (iBELL Screenshots 3 & 4 Exact Reproduction)
     ========================================================================== -->
<section class="collection-list-section" id="collection" aria-label="Collection List">
  <div class="container">
    
    <div class="collection-header" data-aos="fade-up">
      <h2 class="collection-title">COLLECTION LIST</h2>
    </div>

    <!-- 10-Item Grid (5 columns on desktop matching screenshots) -->
    <div class="collection-grid">
      
      <!-- 1. Brush Cutters -->
      <a href="products/parallel-shank-twist-drills.php" class="collection-card" data-aos="fade-up" data-aos-delay="50">
        <div class="collection-img-box">
          <img src="assets/images/collections/brush_cutters.png" alt="Brush Cutters" class="collection-img" loading="lazy">
        </div>
        <h3 class="collection-item-title">Brush Cutters</h3>
      </a>

      <!-- 2. One Power Series -->
      <a href="products/parallel-shank-twist-drills.php" class="collection-card" data-aos="fade-up" data-aos-delay="100">
        <div class="collection-img-box">
          <img src="assets/images/collections/one_power_series.png" alt="One Power Series" class="collection-img" loading="lazy">
        </div>
        <h3 class="collection-item-title">One Power Series</h3>
      </a>

      <!-- 3. Concrete Vibrators -->
      <a href="products/parallel-shank-twist-drills.php" class="collection-card" data-aos="fade-up" data-aos-delay="150">
        <div class="collection-img-box">
          <img src="assets/images/collections/concrete_vibrators.png" alt="Concrete Vibrators" class="collection-img" loading="lazy">
        </div>
        <h3 class="collection-item-title">Concrete Vibrators</h3>
      </a>

      <!-- 4. Hammer & Impact Drills -->
      <a href="products/parallel-shank-twist-drills.php" class="collection-card" data-aos="fade-up" data-aos-delay="200">
        <div class="collection-img-box">
          <img src="assets/images/collections/hammer_impact_drills.png" alt="Hammer & Impact Drills" class="collection-img" loading="lazy">
        </div>
        <h3 class="collection-item-title">Hammer &amp; Impact Drills</h3>
      </a>

      <!-- 5. Tool Kits -->
      <a href="products/parallel-shank-twist-drills.php" class="collection-card" data-aos="fade-up" data-aos-delay="250">
        <div class="collection-img-box">
          <img src="assets/images/collections/tool_kits.png" alt="Tool Kits" class="collection-img" loading="lazy">
        </div>
        <h3 class="collection-item-title">Tool Kits</h3>
      </a>

      <!-- 6. Laser Measures -->
      <a href="products/parallel-shank-twist-drills.php" class="collection-card" data-aos="fade-up" data-aos-delay="300">
        <div class="collection-img-box">
          <img src="assets/images/collections/laser_measures.png" alt="Laser Measures" class="collection-img" loading="lazy">
        </div>
        <h3 class="collection-item-title">Laser Measures</h3>
      </a>

      <!-- 7. Cutting Machines -->
      <a href="products/parallel-shank-twist-drills.php" class="collection-card" data-aos="fade-up" data-aos-delay="350">
        <div class="collection-img-box">
          <img src="assets/images/collections/cutting_machines.png" alt="Cutting Machines" class="collection-img" loading="lazy">
        </div>
        <h3 class="collection-item-title">Cutting Machines</h3>
      </a>

      <!-- 8. Screw Drivers -->
      <a href="products/parallel-shank-twist-drills.php" class="collection-card" data-aos="fade-up" data-aos-delay="400">
        <div class="collection-img-box">
          <img src="assets/images/collections/screw_drivers.png" alt="Screw Drivers" class="collection-img" loading="lazy">
        </div>
        <h3 class="collection-item-title">Screw Drivers</h3>
      </a>

      <!-- 9. Wood Working Tools -->
      <a href="products/parallel-shank-twist-drills.php" class="collection-card" data-aos="fade-up" data-aos-delay="450">
        <div class="collection-img-box">
          <img src="assets/images/collections/wood_working_tools.png" alt="Wood Working Tools" class="collection-img" loading="lazy">
        </div>
        <h3 class="collection-item-title">Wood Working Tools</h3>
      </a>

      <!-- 10. Angle Grinders -->
      <a href="products/parallel-shank-twist-drills.php" class="collection-card" data-aos="fade-up" data-aos-delay="500">
        <div class="collection-img-box">
          <img src="assets/images/collections/angle_grinders.png" alt="Angle Grinders" class="collection-img" loading="lazy">
        </div>
        <h3 class="collection-item-title">Angle Grinders</h3>
      </a>

    </div>

    <!-- Red "view more" Button matching screenshots 3 & 4 -->
    <div class="collection-actions" data-aos="fade-up">
      <a href="products/parallel-shank-twist-drills.php" class="btn-view-more">
        view more
      </a>
    </div>

  </div>
</section>

<!-- ==========================================================================
     SECTION: PRIMARY PRODUCT CARD (Parallel Shank Twist Drills — Jobber Series)
     ========================================================================== -->
<section class="collection-section" id="products" aria-label="Featured Drilling Solutions">
  <div class="container">
    
    <div class="section-header-center" data-aos="fade-up">
      <span class="section-eyebrow">Verified Industrial Catalogue</span>
      <h2 class="section-title">Explore Our Precision Drilling Solutions</h2>
      <p class="section-subtitle">
        Discover the Parallel Shank Twist Drill Jobber Series and choose the specification suited to your requirements.
      </p>
    </div>

    <!-- Redesigned Precision Drilling Solutions Card matching reference design -->
    <div class="precision-solutions-card" id="precisionSolutionsCard">
      
      <!-- Left Column: Visual Showcase, Feature Badges & Thumbnails Carousel -->
      <div class="sol-visual-col">
        
        <!-- Upper Visual Box (Main Showcase + 4 Vertical Feature Icons) -->
        <div class="sol-showcase-box">
          
          <!-- Main Product Image Display Area with Badges -->
          <div class="sol-main-image-wrap">
            <div class="sol-floating-badges">
              <span class="sol-badge-pill-tag sol-badge-red">DAGGER BRAND</span>
              <span class="sol-badge-pill-tag sol-badge-charcoal">IS : 5101</span>
              <span class="sol-badge-pill-tag sol-badge-charcoal">HSN 8207</span>
            </div>

            <img 
              src="assets/images/products/gallery_view_1.jpg" 
              alt="HSS Parallel Shank Jobber Drills Series Lineup on Pedestal" 
              id="solMainImage" 
              class="sol-main-image"
            >
          </div>

          <!-- 4 Vertical Feature Badges Stacked on Right -->
          <div class="sol-features-column">
            
            <div class="sol-feature-item">
              <div class="sol-feature-icon-circle">
                <!-- Target / Crosshair icon -->
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="12" r="10"></circle>
                  <line x1="22" y1="12" x2="18" y2="12"></line>
                  <line x1="6" y1="12" x2="2" y2="12"></line>
                  <line x1="12" y1="6" x2="12" y2="2"></line>
                  <line x1="12" y1="22" x2="12" y2="18"></line>
                </svg>
              </div>
              <span class="sol-feature-label">Precision Ground Flutes</span>
            </div>

            <div class="sol-feature-item">
              <div class="sol-feature-icon-circle">
                <!-- Shield with Checkmark icon -->
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                  <polyline points="9 12 11 14 15 10"></polyline>
                </svg>
              </div>
              <span class="sol-feature-label">High-Speed Steel (HSS)</span>
            </div>

            <div class="sol-feature-item">
              <div class="sol-feature-icon-circle">
                <!-- Cog / Gear icon -->
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="12" r="3"></circle>
                  <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                </svg>
              </div>
              <span class="sol-feature-label">Wide Applications</span>
            </div>

            <div class="sol-feature-item">
              <div class="sol-feature-icon-circle">
                <!-- Diamond icon -->
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M6 3h12l4 6-10 12L2 9l4-6z"></path>
                  <path d="M12 21L7 9"></path>
                  <path d="M12 21l5-12"></path>
                  <path d="M2 9h20"></path>
                </svg>
              </div>
              <span class="sol-feature-label">Consistent Performance</span>
            </div>

          </div>

        </div>

        <!-- Lower Carousel Thumbnails Row with < and > Arrow Controls -->
        <div class="sol-carousel-nav">
          <button type="button" class="sol-arrow-btn sol-arrow-prev" id="solThumbPrev" aria-label="Previous image">
            <svg viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
          </button>

          <div class="sol-thumbs-strip" id="solThumbsStrip">
            <button type="button" class="sol-thumb-item is-active" data-full-src="assets/images/products/gallery_view_1.jpg" data-index="0" aria-label="View 1: Series Showcase">
              <img src="assets/images/products/gallery_thumb_1.jpg" alt="Series Lineup">
            </button>
            <button type="button" class="sol-thumb-item" data-full-src="assets/images/products/gallery_view_2.jpg" data-index="1" aria-label="View 2: Point Angle Macro">
              <img src="assets/images/products/gallery_thumb_2.jpg" alt="Point Angle">
            </button>
            <button type="button" class="sol-thumb-item" data-full-src="assets/images/products/gallery_view_3.jpg" data-index="2" aria-label="View 3: Drill Group">
              <img src="assets/images/products/gallery_thumb_3.jpg" alt="Drill Group">
            </button>
            <button type="button" class="sol-thumb-item" data-full-src="assets/images/products/gallery_view_4.jpg" data-index="3" aria-label="View 4: Flute Helix Macro">
              <img src="assets/images/products/gallery_thumb_4.jpg" alt="Flute Macro">
            </button>
            <button type="button" class="sol-thumb-item" data-full-src="assets/images/products/gallery_view_5.jpg" data-index="4" aria-label="View 5: Cylindrical Shank">
              <img src="assets/images/products/gallery_thumb_5.jpg" alt="Parallel Shank">
            </button>
          </div>

          <button type="button" class="sol-arrow-btn sol-arrow-next" id="solThumbNext" aria-label="Next image">
            <svg viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
          </button>
        </div>

      </div>

      <!-- Right Column: Technical Details, Specifications & CTAs -->
      <div class="sol-content-col">
        
        <!-- Top Pill Badges -->
        <div class="sol-pill-tags-row">
          <span class="sol-pill-badge sol-pill-brand">DAGGER BRAND – BIRLA PRECISION</span>
          <span class="sol-pill-badge sol-pill-gray">Standard: IS : 5101 / ISO 235</span>
          <span class="sol-pill-badge sol-pill-gray">HSN Code: 8207</span>
        </div>

        <!-- Main Product Title -->
        <h3 class="sol-main-title">HSS Parallel Shank Twist Drills &mdash; Jobber Series</h3>

        <!-- Description Paragraph -->
        <p class="sol-main-description">
          Manufactured from high-grade High-Speed Steel (M2 / M35 Cobalt) by Indian Tool Manufacturers (ITM), pioneers of cutting tools in India since 1937. Featuring precision-ground flutes, uniform hardness, and consistent concentricity for clean, vibration-free hole making in automotive, aerospace, structural engineering, and heavy metal fabrication.
        </p>

        <!-- 6-Card Specifications Grid (2 cols x 3 rows) -->
        <div class="sol-specs-grid">
          
          <!-- 1. Indian Standard -->
          <div class="sol-spec-box">
            <div class="sol-spec-icon-box">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
              </svg>
            </div>
            <div class="sol-spec-text-box">
              <span class="sol-spec-subtitle">INDIAN STANDARD</span>
              <strong class="sol-spec-value">IS : 5101 / ISO 235</strong>
            </div>
          </div>

          <!-- 2. Diameter Range -->
          <div class="sol-spec-box">
            <div class="sol-spec-icon-box">
              <!-- Diameter circle with diagonal line -->
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="9"></circle>
                <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
              </svg>
            </div>
            <div class="sol-spec-text-box">
              <span class="sol-spec-subtitle">DIAMETER RANGE</span>
              <strong class="sol-spec-value">0.30 mm to 22.22 mm (7/8")</strong>
            </div>
          </div>

          <!-- 3. Catalogue Scope -->
          <div class="sol-spec-box">
            <div class="sol-spec-icon-box">
              <!-- Stacked layers icon -->
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                <polyline points="2 17 12 22 22 17"></polyline>
                <polyline points="2 12 12 17 22 12"></polyline>
              </svg>
            </div>
            <div class="sol-spec-text-box">
              <span class="sol-spec-subtitle">CATALOGUE SCOPE</span>
              <strong class="sol-spec-value">262 Verified Diameters</strong>
            </div>
          </div>

          <!-- 4. Material & Grades -->
          <div class="sol-spec-box">
            <div class="sol-spec-icon-box">
              <!-- 3D Cube icon -->
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                <line x1="12" y1="22.08" x2="12" y2="12"></line>
              </svg>
            </div>
            <div class="sol-spec-text-box">
              <span class="sol-spec-subtitle">MATERIAL &amp; GRADES</span>
              <strong class="sol-spec-value">HSS M2 / TiN / M35 Cobalt</strong>
            </div>
          </div>

          <!-- 5. Available Variants -->
          <div class="sol-spec-box">
            <div class="sol-spec-icon-box">
              <!-- Price tag icon -->
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                <line x1="7" y1="7" x2="7.01" y2="7"></line>
              </svg>
            </div>
            <div class="sol-spec-text-box">
              <span class="sol-spec-subtitle">AVAILABLE VARIANTS</span>
              <strong class="sol-spec-value">6 Tailored Series</strong>
            </div>
          </div>

          <!-- 6. Commercial Basis -->
          <div class="sol-spec-box">
            <div class="sol-spec-icon-box">
              <!-- Coins / Cylinder stack icon -->
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
              </svg>
            </div>
            <div class="sol-spec-text-box">
              <span class="sol-spec-subtitle">COMMERCIAL BASIS</span>
              <strong class="sol-spec-value">Price Per 10 Pieces (Rs.)</strong>
            </div>
          </div>

        </div>

        <!-- Action Buttons -->
        <div class="sol-cta-row">
          
          <a href="products/parallel-shank-twist-drills.php" class="sol-btn-primary">
            <!-- Document icon -->
            <svg class="sol-btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
              <polyline points="14 2 14 8 20 8"></polyline>
              <line x1="16" y1="13" x2="8" y2="13"></line>
              <line x1="16" y1="17" x2="8" y2="17"></line>
              <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Explore Sizes &amp; Pricing</span>
            <span class="sol-btn-arrow">&rarr;</span>
          </a>

          <a href="products/parallel-shank-twist-drills.php#enquiry" class="sol-btn-secondary">
            <!-- Chat bubble / Enquiry icon -->
            <svg class="sol-btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
            <span>Request Quotation</span>
          </a>

        </div>

      </div>

    </div>

  </div>
</section>

<!-- ==========================================================================
     HERITAGE & MANUFACTURING STRENGTHS
     ========================================================================== -->
<section class="heritage-section" id="about" aria-label="Company Heritage">
  <div class="container">
    
    <div class="heritage-grid">
      
      <div class="heritage-stat-card" data-aos="fade-up" data-aos-delay="100">
        <div class="stat-number">1937</div>
        <div class="stat-title">Pioneering Legacy</div>
        <p class="stat-desc">First company in India to manufacture High-Speed Steel cutting tools and precision toolholders.</p>
      </div>

      <div class="heritage-stat-card" data-aos="fade-up" data-aos-delay="200">
        <div class="stat-number">3</div>
        <div class="stat-title">Advanced Plants</div>
        <p class="stat-desc">State-of-the-art production facilities at Nashik, Aurangabad, and Chalisgaon with CNC grinding lines.</p>
      </div>

      <div class="heritage-stat-card" data-aos="fade-up" data-aos-delay="300">
        <div class="stat-number">50+</div>
        <div class="stat-title">Countries Served</div>
        <p class="stat-desc">Global footprint delivering dependable industrial tooling solutions to international manufacturing hubs.</p>
      </div>

      <div class="heritage-stat-card" data-aos="fade-up" data-aos-delay="400">
        <div class="stat-number">262</div>
        <div class="stat-title">Jobber Diameters</div>
        <p class="stat-desc">Comprehensive size availability from 0.30 mm micro-drills to 22.22 mm (7/8") heavy duty jobbers.</p>
      </div>

    </div>

  </div>
</section>

<!-- ==========================================================================
     BRAND PORTFOLIO STRIP WITH INFINITE SCROLLING ANIMATION
     ========================================================================== -->
<section class="brands-strip-section" id="brands" aria-label="Our Trusted Tooling Brands">
  <div class="container">
    <div class="brands-strip-header" data-aos="fade-up">
      <h3 class="brands-strip-title">OUR TRUSTED TOOLING BRANDS &bull; BIRLA PRECISION TECHNOLOGIES</h3>
      <p class="brands-strip-sub">Industry-leading brands trusted across aerospace, automotive, die-mould, and heavy fabrication.</p>
    </div>
  </div>

  <!-- Infinite Scrolling Marquee Container -->
  <div class="brands-marquee-container" data-aos="fade-up" data-aos-delay="100">
    <div class="brands-marquee-track">
      
      <!-- Set 1 of Brand Logos -->
      <a href="products/parallel-shank-twist-drills.php" class="brand-marquee-item" title="Birla Precision Technologies Limited">
        <img src="assets/images/brand/brand_birla_corp.png" alt="Birla Precision Technologies" class="brand-marquee-img">
      </a>
      <a href="products/parallel-shank-twist-drills.php?variant=itm_std" class="brand-marquee-item" title="Dagger Brand — Since 1937">
        <img src="assets/images/brand/brand_dagger.png" alt="Dagger Brand Since 1937" class="brand-marquee-img">
      </a>
      <a href="products/parallel-shank-twist-drills.php?variant=panther" class="brand-marquee-item" title="Panther Products — Quicker, Sharper, More Powerful">
        <img src="assets/images/brand/brand_panther.png" alt="Panther Drills" class="brand-marquee-img">
      </a>
      <a href="products/parallel-shank-twist-drills.php?variant=ninja" class="brand-marquee-item" title="Ninja — Sharp Work Razor Accuracy">
        <img src="assets/images/brand/brand_ninja.png" alt="Ninja Cobalt Drills" class="brand-marquee-img">
      </a>
      <a href="products/parallel-shank-twist-drills.php?variant=forgeline" class="brand-marquee-item" title="Forgeline Drill — Forged Steel & Cast Iron">
        <img src="assets/images/brand/brand_forgeline.png" alt="Forgeline Drills" class="brand-marquee-img">
      </a>
      <a href="products/parallel-shank-twist-drills.php?variant=hathyar" class="brand-marquee-item" title="Hathyar Drills — Heavy Duty Workshop">
        <img src="assets/images/brand/brand_hathyar.png" alt="Hathyar Drills" class="brand-marquee-img">
      </a>

      <!-- Set 2 (Duplicate for Seamless Infinite Marquee Loop) -->
      <a href="products/parallel-shank-twist-drills.php" class="brand-marquee-item" aria-hidden="true" tabindex="-1">
        <img src="assets/images/brand/brand_birla_corp.png" alt="Birla Precision Technologies" class="brand-marquee-img">
      </a>
      <a href="products/parallel-shank-twist-drills.php?variant=itm_std" class="brand-marquee-item" aria-hidden="true" tabindex="-1">
        <img src="assets/images/brand/brand_dagger.png" alt="Dagger Brand Since 1937" class="brand-marquee-img">
      </a>
      <a href="products/parallel-shank-twist-drills.php?variant=panther" class="brand-marquee-item" aria-hidden="true" tabindex="-1">
        <img src="assets/images/brand/brand_panther.png" alt="Panther Drills" class="brand-marquee-img">
      </a>
      <a href="products/parallel-shank-twist-drills.php?variant=ninja" class="brand-marquee-item" aria-hidden="true" tabindex="-1">
        <img src="assets/images/brand/brand_ninja.png" alt="Ninja Cobalt Drills" class="brand-marquee-img">
      </a>
      <a href="products/parallel-shank-twist-drills.php?variant=forgeline" class="brand-marquee-item" aria-hidden="true" tabindex="-1">
        <img src="assets/images/brand/brand_forgeline.png" alt="Forgeline Drills" class="brand-marquee-img">
      </a>
      <a href="products/parallel-shank-twist-drills.php?variant=hathyar" class="brand-marquee-item" aria-hidden="true" tabindex="-1">
        <img src="assets/images/brand/brand_hathyar.png" alt="Hathyar Drills" class="brand-marquee-img">
      </a>

    </div>
  </div>
</section>

<?php
include __DIR__ . '/includes/footer.php';
?>
