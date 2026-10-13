<?php
/**
 * Birla Precision Technologies Limited / Dagger Brand
 * Dedicated Products Space & Tooling Catalogue Page
 * Lists all manufactured products and industrial tooling series.
 * Clicking any product card redirects directly to its dedicated product page.
 */

require_once __DIR__ . '/includes/data.php';

$current_page = 'products';
$is_subfolder = false;
$page_title = 'Industrial Cutting Tools & Products Space | Birla Precision Technologies';
$page_description = 'Comprehensive industrial cutting tools catalogue: HSS Parallel Shank Twist Drills, M35 Cobalt, Taper Shank, Carbide Drills, Annular Cutters, and Tooling Systems by Birla Precision & Dagger Brand.';

// Complete catalogue of listed products
$products_catalog = [
    [
        'id' => 'jobber-drills',
        'title' => 'HSS Parallel Shank Twist Drills (Jobber Series)',
        'standard' => 'IS : 5101 / ISO 235 / DIN 338',
        'category' => 'twist_drills',
        'category_name' => 'HSS Twist Drills',
        'badge' => 'FLAGSHIP PRODUCT',
        'badge_class' => 'badge-red',
        'image' => 'assets/images/collections/jobber_drills.png',
        'description' => 'Precision CNC ground twist drills engineered for high-concentricity metal drilling in general engineering, automotive, and fabrication. Available in 262 standardized diameters.',
        'features' => ['262 Standard Sizes', '0.30mm – 22.22mm', 'M2 High-Speed Steel', '118° Point Angle'],
        'url' => 'products/parallel-shank-twist-drills.php'
    ],
    [
        'id' => 'ninja-cobalt',
        'title' => 'NINJA M35 Cobalt Heavy-Duty Jobber Drills',
        'standard' => 'IS : 5101 / 5% Cobalt Alloyed M35',
        'category' => 'high_performance',
        'category_name' => 'Cobalt & High Performance',
        'badge' => 'M35 COBALT',
        'badge_class' => 'badge-red',
        'image' => 'assets/images/collections/ninja_cobalt.png',
        'description' => 'Engineered with 5% Cobalt alloy for superior red hardness and heat resistance. Optimized for drilling stainless steel (SS304/316), heat-treated alloys, and high-tensile steels.',
        'features' => ['5% Cobalt M35 Alloy', 'High Heat Resistance', 'Stainless Steel Drilling', 'Heavy Web Geometry'],
        'url' => 'products/parallel-shank-twist-drills.php?variant=ninja'
    ],
    [
        'id' => 'panther-cnc',
        'title' => 'PANTHER High-Precision Split-Point Drills',
        'standard' => 'IS : 5101 / Aerospace CNC Point',
        'category' => 'high_performance',
        'category_name' => 'Cobalt & High Performance',
        'badge' => 'CNC SPLIT POINT',
        'badge_class' => 'badge-charcoal',
        'image' => 'assets/images/collections/panther_drills.png',
        'description' => 'Manufactured on 5-axis CNC grinders with a specialized 135° split-point geometry. Eliminates walking on curved surfaces and significantly reduces thrust force on CNC machining centers.',
        'features' => ['135° Split Point', 'Self-Centering', 'Low Thrust Force', 'CNC Machining Grade'],
        'url' => 'products/parallel-shank-twist-drills.php?variant=panther'
    ],
    [
        'id' => 'tin-coated',
        'title' => 'ITM STD. TiN Gold Coated Production Drills',
        'standard' => 'IS : 5101 / Titanium Nitride Coated',
        'category' => 'high_performance',
        'category_name' => 'Cobalt & High Performance',
        'badge' => 'TIN GOLD COATED',
        'badge_class' => 'badge-gold',
        'image' => 'assets/images/collections/tin_coated_drills.png',
        'description' => 'Titanium Nitride (TiN) physical vapor deposition ceramic coating provides ultra-low surface friction, thermal barrier protection, and up to 3x longer tool life in mass production.',
        'features' => ['TiN Ceramic Coating', 'Ultra-Low Friction', '3x Tool Life', 'High-Speed Drilling'],
        'url' => 'products/parallel-shank-twist-drills.php?variant=itm_std_tin'
    ],
    [
        'id' => 'taper-shank',
        'title' => 'HSS Taper Shank Twist Drills (Morse Taper)',
        'standard' => 'IS : 5103 / ISO 235 / DIN 345',
        'category' => 'twist_drills',
        'category_name' => 'HSS Twist Drills',
        'badge' => 'MORSE TAPER',
        'badge_class' => 'badge-charcoal',
        'image' => 'assets/images/collections/taper_shank.png',
        'description' => 'Heavy-duty industrial drills featuring precision Morse Taper shanks (MT1 to MT6) for direct spindle mounting on radial drills, pillar presses, and lathe tailstocks.',
        'features' => ['MT1 to MT6 Shanks', 'Diameters 3mm – 100mm', 'Tough M2 Steel', 'Direct Spindle Mount'],
        'url' => 'products/parallel-shank-twist-drills.php?series=taper'
    ],
    [
        'id' => 'forgeline',
        'title' => 'FORGELINE Heavy Web Cast Iron & Forged Drills',
        'standard' => 'IS : 5101 / Reinforced Core Web',
        'category' => 'twist_drills',
        'category_name' => 'HSS Twist Drills',
        'badge' => 'CAST & FORGED',
        'badge_class' => 'badge-charcoal',
        'image' => 'assets/images/collections/forgeline_drills.png',
        'description' => 'Features an extra-heavy web construction and rugged cutting edge geometry designed to resist breakout and premature wear when drilling forged steel billets and ductile cast iron.',
        'features' => ['Reinforced Core Web', 'Breakout Resistant', 'Forged Steel Drilling', 'Ductile Iron Geometry'],
        'url' => 'products/parallel-shank-twist-drills.php?variant=forgeline'
    ],
    [
        'id' => 'annular-cutters',
        'title' => 'Industrial Annular Cutters & Broaching Drills',
        'standard' => 'Weldon Shank / Magnetic Core Standards',
        'category' => 'cutting_tools',
        'category_name' => 'Milling & Core Cutters',
        'badge' => 'CORE CUTTERS',
        'badge_class' => 'badge-charcoal',
        'image' => 'assets/images/collections/annular_cutters.png',
        'description' => 'Hollow core annular cutters for magnetic base drills. Cut only the periphery of the hole, creating accurate, burr-free holes in heavy structural beams with minimal energy consumption.',
        'features' => ['Weldon 19mm Shank', 'Burr-Free Holes', 'Structural Steel', 'Depth 30mm & 50mm'],
        'url' => 'products/parallel-shank-twist-drills.php?series=annular'
    ],
    [
        'id' => 'milling-cutters',
        'title' => 'Industrial HSS Milling Cutters & Reamers',
        'standard' => 'IS : 6251 / ISO 2584 / DIN 844',
        'category' => 'cutting_tools',
        'category_name' => 'Milling & Core Cutters',
        'badge' => 'PRECISION MILLING',
        'badge_class' => 'badge-charcoal',
        'image' => 'assets/images/collections/milling_cutters.png',
        'description' => 'Complete range of side and face cutters, cylindrical cutters, slot drills, and hand/machine reamers for precision metal removal on universal and horizontal milling machines.',
        'features' => ['Side & Face Cutters', 'HSS-E / Cobalt', 'Slot Drills', 'Precision Bore Reamers'],
        'url' => 'products/parallel-shank-twist-drills.php?series=milling'
    ],
    [
        'id' => 'hss-tool-bits',
        'title' => 'HSS Ground Tool Bits & Cutoff Parting Blades',
        'standard' => 'IS : 7291 / M2 & M42 Cobalt Specification',
        'category' => 'cutting_tools',
        'category_name' => 'Milling & Core Cutters',
        'badge' => 'TOOL BITS',
        'badge_class' => 'badge-charcoal',
        'image' => 'assets/images/collections/hss_tool_bits.png',
        'description' => 'Precision hardened and ground square, round, and rectangular lathe tool bits. Heat-treated to 64–67 HRC for high wear resistance during turning, boring, and parting operations.',
        'features' => ['64–67 HRC Hardness', 'Square & Round Profiles', 'M2 & M42 Cobalt', 'Parting Off Blades'],
        'url' => 'products/parallel-shank-twist-drills.php?series=toolbits'
    ],
    [
        'id' => 'hathyar-masonry',
        'title' => 'HATHYAR SDS-Plus Concrete & Masonry Drills',
        'standard' => 'Tungsten Carbide Tipped (TCT)',
        'category' => 'power_tools',
        'category_name' => 'Power & Workshop Tools',
        'badge' => 'CARBIDE TIPPED',
        'badge_class' => 'badge-green',
        'image' => 'assets/images/collections/hathyar_drills.png',
        'description' => 'Tungsten carbide tipped percussion and rotary drill bits designed for fast drilling in reinforced concrete, stone, and brickwork with dust removal flutes.',
        'features' => ['TCT Carbide Tips', 'SDS-Plus Shank', 'Reinforced Concrete', 'Optimized Dust Flute'],
        'url' => 'products/parallel-shank-twist-drills.php?series=hathyar'
    ],
    [
        'id' => 'hammer-drills',
        'title' => 'Heavy Duty Hammer & Rotary Impact Drills',
        'standard' => 'Industrial Workshop Power Tooling',
        'category' => 'power_tools',
        'category_name' => 'Power & Workshop Tools',
        'badge' => 'POWER TOOLING',
        'badge_class' => 'badge-charcoal',
        'image' => 'assets/images/collections/hammer_impact_drills.png',
        'description' => 'High-torque impact drills and heavy rotary hammer machines engineered for continuous operation in construction sites and metal fabrication workshops.',
        'features' => ['High-Torque Motor', 'Variable Speed Drive', 'Reverse Rotation', 'Ergonomic Grip'],
        'url' => 'products/parallel-shank-twist-drills.php?series=hammer'
    ],
    [
        'id' => 'cutting-machines',
        'title' => 'High-Speed Metal Abrasive Cut-off Machines',
        'standard' => 'Heavy Fabrication Workshop Equipment',
        'category' => 'power_tools',
        'category_name' => 'Power & Workshop Tools',
        'badge' => 'FABRICATION',
        'badge_class' => 'badge-charcoal',
        'image' => 'assets/images/collections/cutting_machines.png',
        'description' => 'Heavy-duty 14-inch chop saws and abrasive cutoff machinery designed for rapid, clean section cutting of pipes, angles, channels, and solid bars.',
        'features' => ['355mm Wheel Capacity', 'Heavy Metal Clamping', 'Spark Deflector Guard', 'Quick Lock Vise'],
        'url' => 'products/parallel-shank-twist-drills.php?series=cutting_machines'
    ]
];

include __DIR__ . '/includes/header.php';
?>

<!-- Breadcrumb Navigation -->
<nav class="breadcrumb-nav" aria-label="Breadcrumbs" style="background:#F8FAFC;border-bottom:1px solid #E2E8F0;padding:14px 0;">
  <div class="container">
    <ol class="breadcrumb-list" style="margin:0;padding:0;list-style:none;display:flex;align-items:center;font-size:0.875rem;">
      <li><a href="index.php" style="color:#64748B;text-decoration:none;">Home</a></li>
      <li class="breadcrumb-separator" style="margin:0 8px;color:#94A3B8;">&rsaquo;</li>
      <li class="breadcrumb-current" aria-current="page" style="color:#DC2626;font-weight:600;">Products Catalogue</li>
    </ol>
  </div>
</nav>

<!-- ==========================================================================
     TOOLBAR CONTROLS: CATEGORY TABS & LIVE SEARCH
     ========================================================================== -->
<section class="products-toolbar-section">
  <div class="container products-toolbar-layout">
    
    <!-- Category Filter Tabs -->
    <div class="category-filter-tabs" id="categoryTabs" role="tablist">
      <button type="button" class="cat-tab-btn is-active" data-cat="all">All Products (<?php echo count($products_catalog); ?>)</button>
      <button type="button" class="cat-tab-btn" data-cat="twist_drills">HSS Twist Drills</button>
      <button type="button" class="cat-tab-btn" data-cat="high_performance">Cobalt &amp; TiN</button>
      <button type="button" class="cat-tab-btn" data-cat="cutting_tools">Milling &amp; Tool Bits</button>
      <button type="button" class="cat-tab-btn" data-cat="power_tools">Power &amp; Workshop</button>
    </div>

    <!-- Live Search Box -->
    <div class="products-search-box">
      <svg class="products-search-icon" viewBox="0 0 24 24">
        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
      </svg>
      <input 
        type="text" 
        id="productsSearchInput" 
        class="products-search-input" 
        placeholder="Filter by product name, standard, or material..." 
        autocomplete="off"
      >
    </div>

  </div>
</section>

<!-- ==========================================================================
     PRODUCTS GRID SPACE
     ========================================================================== -->
<section class="products-space-section">
  <div class="container">
    
    <div class="products-grid-header">
      <span class="products-results-count" id="productsCountText">
        Showing all <?php echo count($products_catalog); ?> tooling products
      </span>
      <span style="font-size:0.85rem;color:#64748B;">
        Click any product to open its configurator &amp; specifications page
      </span>
    </div>

    <!-- Grid of All Listed Products -->
    <div class="products-cards-grid" id="productsCardsGrid">
      <?php foreach ($products_catalog as $prod): ?>
        <a 
          href="<?php echo htmlspecialchars($prod['url']); ?>" 
          class="product-showcase-card" 
          data-category="<?php echo htmlspecialchars($prod['category']); ?>"
          data-title="<?php echo htmlspecialchars(strtolower($prod['title'])); ?>"
          data-standard="<?php echo htmlspecialchars(strtolower($prod['standard'])); ?>"
          data-desc="<?php echo htmlspecialchars(strtolower($prod['description'])); ?>"
        >
          <!-- Thumbnail Media -->
          <div class="card-top-media">
            <img 
              src="<?php echo htmlspecialchars($prod['image']); ?>" 
              alt="<?php echo htmlspecialchars($prod['title']); ?>" 
              class="card-product-img"
              loading="lazy"
            >
          </div>

          <!-- Card Details -->
          <div class="card-body-content">
            <span class="card-std-tag"><?php echo htmlspecialchars($prod['standard']); ?></span>
            <h2 class="card-product-title"><?php echo htmlspecialchars($prod['title']); ?></h2>
            <p class="card-product-desc"><?php echo htmlspecialchars($prod['description']); ?></p>

            <!-- Feature Pills -->
            <div class="card-features-row">
              <?php foreach ($prod['features'] as $feat): ?>
                <span class="feature-pill"><?php echo htmlspecialchars($feat); ?></span>
              <?php endforeach; ?>
            </div>

            <!-- Card Bottom Action -->
            <div class="card-action-bar">
              <span class="card-btn-redirect">
                <span>Configure &amp; View Product</span>
                <span class="arrow">&rarr;</span>
              </span>
              <span class="card-view-count">Dagger Brand</span>
            </div>
          </div>
        </a>
      <?php endforeach; ?>

      <!-- Empty Filter State -->
      <div class="products-empty-filter" id="productsEmptyFilter" style="display:none;">
        <svg class="empty-filter-icon" viewBox="0 0 24 24">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
          <line x1="11" y1="8" x2="11" y2="14"></line>
          <line x1="8" y1="11" x2="14" y2="11"></line>
        </svg>
        <h3 class="empty-filter-title">No Matching Products Found</h3>
        <p class="empty-filter-desc">We couldn't find any products matching your search filter. Try clearing your search term or selecting another category.</p>
        <button type="button" class="btn btn-primary" id="resetFiltersBtn">Reset Search &amp; Show All Products</button>
      </div>

    </div>

  </div>
</section>

<!-- ==========================================================================
     CLIENT FILTERING INTERACTIONS SCRIPT
     ========================================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  var searchInput = document.getElementById('productsSearchInput');
  var catTabs = document.querySelectorAll('.cat-tab-btn');
  var cards = document.querySelectorAll('.product-showcase-card');
  var emptyState = document.getElementById('productsEmptyFilter');
  var countText = document.getElementById('productsCountText');
  var resetBtn = document.getElementById('resetFiltersBtn');

  var currentCat = 'all';
  var searchQuery = '';

  function filterCards() {
    var visibleCount = 0;
    var totalCards = cards.length;

    cards.forEach(function (card) {
      var cardCat = card.getAttribute('data-category') || '';
      var cardTitle = card.getAttribute('data-title') || '';
      var cardStd = card.getAttribute('data-standard') || '';
      var cardDesc = card.getAttribute('data-desc') || '';

      var matchesCat = (currentCat === 'all' || cardCat === currentCat);
      var matchesSearch = true;

      if (searchQuery) {
        var query = searchQuery.toLowerCase();
        matchesSearch = (
          cardTitle.indexOf(query) !== -1 ||
          cardStd.indexOf(query) !== -1 ||
          cardDesc.indexOf(query) !== -1
        );
      }

      if (matchesCat && matchesSearch) {
        card.style.display = 'flex';
        visibleCount++;
      } else {
        card.style.display = 'none';
      }
    });

    if (emptyState) {
      emptyState.style.display = (visibleCount === 0) ? 'block' : 'none';
    }

    if (countText) {
      if (searchQuery) {
        countText.textContent = 'Found ' + visibleCount + ' product' + (visibleCount === 1 ? '' : 's') + ' matching "' + searchQuery + '"';
      } else if (currentCat !== 'all') {
        countText.textContent = 'Showing ' + visibleCount + ' product' + (visibleCount === 1 ? '' : 's') + ' in this category';
      } else {
        countText.textContent = 'Showing all ' + visibleCount + ' tooling products';
      }
    }
  }

  // Check URL query param for category (e.g. ?cat=twist_drills)
  try {
    var urlParams = new URLSearchParams(window.location.search);
    var paramCat = urlParams.get('cat');
    if (paramCat) {
      currentCat = paramCat;
      catTabs.forEach(function (t) {
        if (t.getAttribute('data-cat') === paramCat) {
          t.classList.add('is-active');
        } else {
          t.classList.remove('is-active');
        }
      });
      filterCards();
    }
  } catch (e) {}

  // Category Tab Clicks
  catTabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      catTabs.forEach(function (t) { t.classList.remove('is-active'); });
      this.classList.add('is-active');
      currentCat = this.getAttribute('data-cat') || 'all';
      filterCards();
    });
  });

  // Search Input
  if (searchInput) {
    searchInput.addEventListener('input', function () {
      searchQuery = this.value.trim();
      filterCards();
    });
  }

  // Reset Filters Button
  if (resetBtn) {
    resetBtn.addEventListener('click', function () {
      if (searchInput) searchInput.value = '';
      searchQuery = '';
      currentCat = 'all';
      catTabs.forEach(function (t) {
        if (t.getAttribute('data-cat') === 'all') {
          t.classList.add('is-active');
        } else {
          t.classList.remove('is-active');
        }
      });
      filterCards();
    });
  }

});
</script>

<?php
include __DIR__ . '/includes/footer.php';
?>
