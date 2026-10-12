<?php
/**
 * Birla Precision Technologies Limited / Dagger Brand
 * Dedicated Product Page: HSS Parallel Shank Twist Drills — Jobber Series
 * Exact replica of provided UI design specification:
 * - Gallery with authentic photography, badges, and 5 thumbnails
 * - Step 1: "Find your drill size" with unit dropdown box (MM, INCH, DG), unit toggle pills, and searchable diameter dropdown
 * - Step 2: "Choose drill variant" with 6 cards (2x3 grid) with radio buttons and stock indicators
 * - Selected diameter summary bar with "Change ⟳"
 * - Commercial charcoal card with Catalogue Price, MOQ, Delivery Terms, and action buttons
 * - Complete 262-size data table and technical enquiry form
 */

require_once __DIR__ . '/../includes/data.php';

$current_page = 'product';
$is_subfolder = true;
$page_title = 'HSS Parallel Shank Twist Drills (Jobber Series) — IS : 5101 | Dagger Brand';
$page_description = 'Comprehensive diameter specification, variant availability, catalogue pricing per 10 pieces, and technical enquiry for Dagger Brand HSS Parallel Shank Jobber Drills.';

$family = get_product_family();
$variants = get_product_variants();
$popular_diameters = get_popular_jobber_diameters();
$all_sizes = get_all_jobber_sizes();

// Initial selected diameter (default to 3.17 mm / 1/8" as shown in reference or GET param)
$initial_dia = isset($_GET['dia']) ? trim($_GET['dia']) : '3.17';
$initial_row = get_size_by_diameter($initial_dia);
if (!$initial_row) {
    $initial_row = get_size_by_diameter('3.17') ?? get_size_by_diameter('6.80') ?? $all_sizes[0];
}

$initial_dia_val = $initial_row['mm'];
$initial_variant = isset($_GET['variant']) && isset($variants[$_GET['variant']]) ? $_GET['variant'] : 'itm_std';

include __DIR__ . '/../includes/header.php';
?>

<!-- Breadcrumb Navigation -->
<nav class="breadcrumb-nav" aria-label="Breadcrumbs">
  <div class="container">
    <ol class="breadcrumb-list">
      <li><a href="../index.php">Home</a></li>
      <li class="breadcrumb-separator">&rsaquo;</li>
      <li><a href="../index.php#products">Products</a></li>
      <li class="breadcrumb-separator">&rsaquo;</li>
      <li><a href="parallel-shank-twist-drills.php">Parallel Shank Twist Drills</a></li>
      <li class="breadcrumb-separator">&rsaquo;</li>
      <li class="breadcrumb-current" aria-current="page">HSS Parallel Shank Twist Drills — Jobber Series</li>
    </ol>
  </div>
</nav>

<!-- ==========================================================================
     PRODUCT HERO & REAL-TIME CONFIGURATOR
     ========================================================================== -->
<section class="product-detail-section" id="productOverview">
  <div class="container">
    
    <div class="product-detail-layout">
      
      <!-- Left Column: Visual Gallery (Sticky) -->
      <div class="product-gallery-sticky">
        <div class="gallery-card">
          
          <div class="gallery-stage">
            <div class="gallery-badges-strip">
              <span class="gallery-badge gallery-badge-red">DAGGER BRAND</span>
              <span class="gallery-badge gallery-badge-charcoal">IS : 5101</span>
              <span class="gallery-badge gallery-badge-charcoal">HSN 8207</span>
            </div>

            <img 
              src="../assets/images/products/gallery_view_1.jpg" 
              alt="HSS Parallel Shank Jobber Drills Showcase on Pedestal" 
              id="galleryMainImage" 
              class="gallery-main-image"
            >

            <button type="button" class="gallery-zoom-btn" id="galleryZoomBtn" aria-label="Zoom Product Image" title="Zoom Product Photograph">
              <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
            </button>
          </div>

          <!-- Gallery Thumbnails (5 items with ultra-sharp high-definition views) -->
          <div class="gallery-thumbnails-row">
            <button 
              type="button" 
              class="gallery-thumb-btn is-active" 
              data-full-img="../assets/images/products/gallery_view_1.jpg"
              data-caption="Jobber Drills Series Lineup on Architectural Pedestals"
              aria-label="View Jobber Drills Series Lineup"
            >
              <img src="../assets/images/products/gallery_thumb_1.jpg" alt="Jobber Series Lineup">
            </button>

            <button 
              type="button" 
              class="gallery-thumb-btn" 
              data-full-img="../assets/images/products/gallery_view_2.jpg"
              data-caption="118° Split Point Precision Ground Cutting Angle Geometry"
              aria-label="View Point Angle Geometry"
            >
              <img src="../assets/images/products/gallery_thumb_2.jpg" alt="Point Angle Geometry">
            </button>

            <button 
              type="button" 
              class="gallery-thumb-btn" 
              data-full-img="../assets/images/products/gallery_view_3.jpg"
              data-caption="HSS Parallel Shank Drill Group Showcase"
              aria-label="View Straight Shank Drill Lineup"
            >
              <img src="../assets/images/products/gallery_thumb_3.jpg" alt="Drill Lineup">
            </button>

            <button 
              type="button" 
              class="gallery-thumb-btn" 
              data-full-img="../assets/images/products/gallery_view_4.jpg"
              data-caption="Spiral Flute Helix, Polished Land & Cutting Margin Relief Macro"
              aria-label="View Flute Helix Macro"
            >
              <img src="../assets/images/products/gallery_thumb_4.jpg" alt="Flute Helix Macro">
            </button>

            <button 
              type="button" 
              class="gallery-thumb-btn" 
              data-full-img="../assets/images/products/gallery_view_5.jpg"
              data-caption="Precision Cylindrical Parallel Shank Tolerance & Chamfered End"
              aria-label="View Parallel Shank Finish"
            >
              <img src="../assets/images/products/gallery_thumb_5.jpg" alt="Parallel Shank Finish">
            </button>
          </div>

          <p class="gallery-caption-note">
            Authentic product photographs from Birla Precision Technologies April 2026 Catalogue.
          </p>

        </div>
      </div>

      <!-- Right Column: Interactive Configurator Panel -->
      <div class="product-config-panel">
        
        <!-- Meta Header -->
        <div class="product-meta-header">
          <div class="product-brand-row">
            <span class="brand-pill-red">DAGGER BRAND &bull; BIRLA PRECISION</span>
            <span class="std-pill">Standard: IS : 5101 / ISO 235</span>
            <span class="std-pill">HSN Code: 8207</span>
          </div>
          <h1 class="product-page-title">HSS Parallel Shank Twist Drills — Jobber Series</h1>
          <p class="product-lead-desc">
            Pioneered by Indian Tool Manufacturers (ITM) since 1937. Manufactured from high-purity High-Speed Steel and precision ground for accurate, vibration-free drilling. Designed for a wide range of applications in general engineering, automotive, aerospace and heavy fabrication.
          </p>
        </div>

        <!-- 1. Step 1: Find your drill size -->
        <div class="config-step-card">
          <div class="step-header-row">
            <div class="step-title-group">
              <span class="step-num-circle">1</span>
              <h2 class="step-heading">Find your drill size (in mm)</h2>
              <span class="unit-only-pill-tag">Metric (mm)</span>
            </div>
            <a href="#technical-specs" class="step-link-red">
              <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
              <span>View technical specs &rarr;</span>
            </a>
          </div>

          <!-- Diameter Dropdown Row (Metric mm only) -->
          <div class="size-controls-row size-controls-mm-only">
            
            <!-- Left: Search & Diameter Dropdown Box -->
            <div class="diameter-dropdown-wrapper" id="diaDropdownWrapper">
              <div class="diameter-input-container" id="diaInputContainer">
                <svg class="dia-search-glass" viewBox="0 0 24 24">
                  <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                </svg>
                <input 
                  type="text" 
                  id="diaSearchInput" 
                  class="dia-search-input" 
                  placeholder="Search or choose size in mm (e.g. 3.00, 4.50, 6.00)..." 
                  value="<?php echo htmlspecialchars($initial_row['mm']); ?> mm" 
                  autocomplete="off"
                >
                <svg class="dia-chevron-icon" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
              </div>

              <!-- Dropped Down Size Menu List (MM Only) -->
              <div class="diameter-dropdown-menu" id="diaDropdownMenu">
                <div class="dia-menu-scroll" id="diaMenuScroll">
                  <!-- Populated dynamically via JS matching mm -->
                </div>
                <div class="dia-menu-footer-note">
                  <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                  <span>All 262 metric sizes available (0.30 mm – 22.22 mm)</span>
                </div>
              </div>
            </div>

            <!-- Right: Add Size Button -->
            <div class="size-action-container">
              <button type="button" class="btn-add-size-direct" id="addDiaToListBtn" title="Add this size to your collective order list">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="12" y1="5" x2="12" y2="19"></line>
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>+ Add Size</span>
              </button>
            </div>

          </div>

          <!-- Popular Quick-Add Metric Sizes in mm -->
          <div class="quick-add-sizes-wrapper">
            <span class="quick-add-label">Quick-Add Popular Sizes (mm):</span>
            <div class="quick-add-pills" id="quickAddPills">
              <button type="button" class="quick-size-btn" data-mm="2.50">+ 2.50 mm</button>
              <button type="button" class="quick-size-btn" data-mm="3.00">+ 3.00 mm</button>
              <button type="button" class="quick-size-btn" data-mm="4.00">+ 4.00 mm</button>
              <button type="button" class="quick-size-btn" data-mm="5.00">+ 5.00 mm</button>
              <button type="button" class="quick-size-btn" data-mm="6.00">+ 6.00 mm</button>
              <button type="button" class="quick-size-btn" data-mm="8.00">+ 8.00 mm</button>
              <button type="button" class="quick-size-btn" data-mm="10.00">+ 10.00 mm</button>
              <button type="button" class="quick-size-btn" data-mm="12.00">+ 12.00 mm</button>
            </div>
          </div>
        </div>

        <!-- 2. Step 2: Choose drill variant -->
        <div class="config-step-card">
          <div class="step-header-row">
            <div class="step-title-group">
              <span class="step-num-circle">2</span>
              <h2 class="step-heading">Choose drill variant</h2>
              <span class="info-help-icon" title="Authentic variant specifications from April 2026 catalogue">ⓘ</span>
            </div>
          </div>

          <!-- 6 Variant Cards Grid (2-column layout matching reference design) -->
          <div class="variant-cards-grid">
            
            <!-- 1. ITM STD. -->
            <div class="variant-item-card is-active" data-variant="itm_std">
              <div class="variant-card-header">
                <div class="variant-name">ITM STD.</div>
                <div class="variant-radio-circle"></div>
              </div>
              <div class="variant-card-sub">HSS</div>
              <div class="variant-stock-pill stock-in">
                <span class="stock-dot"></span> In Stock
              </div>
            </div>

            <!-- 2. ITM STD. TIN -->
            <div class="variant-item-card" data-variant="itm_std_tin">
              <div class="variant-card-header">
                <div class="variant-name">ITM STD. TIN</div>
                <div class="variant-radio-circle"></div>
              </div>
              <div class="variant-card-sub">HSS + TiN Coated</div>
              <div class="variant-stock-pill stock-in">
                <span class="stock-dot"></span> In Stock
              </div>
            </div>

            <!-- 3. PANTHER -->
            <div class="variant-item-card" data-variant="panther">
              <div class="variant-card-header">
                <div class="variant-name">PANTHER</div>
                <div class="variant-radio-circle"></div>
              </div>
              <div class="variant-card-sub">HSS Premium</div>
              <div class="variant-stock-pill stock-in">
                <span class="stock-dot"></span> In Stock
              </div>
            </div>

            <!-- 4. NINJA -->
            <div class="variant-item-card" data-variant="ninja">
              <div class="variant-card-header">
                <div class="variant-name">NINJA</div>
                <div class="variant-radio-circle"></div>
              </div>
              <div class="variant-card-sub">HSS Cobalt</div>
              <div class="variant-stock-pill stock-limited">
                <span class="stock-dot"></span> Limited Stock
              </div>
            </div>

            <!-- 5. FORGELINE -->
            <div class="variant-item-card" data-variant="forgeline">
              <div class="variant-card-header">
                <div class="variant-name">FORGELINE</div>
                <div class="variant-radio-circle"></div>
              </div>
              <div class="variant-card-sub">HSS Robust Geometry</div>
              <div class="variant-stock-pill stock-in">
                <span class="stock-dot"></span> In Stock
              </div>
            </div>

            <!-- 6. HATHYAR -->
            <div class="variant-item-card" data-variant="hathyar">
              <div class="variant-card-header">
                <div class="variant-name">HATHYAR</div>
                <div class="variant-radio-circle"></div>
              </div>
              <div class="variant-card-sub">HSS Heavy Duty</div>
              <div class="variant-stock-pill stock-in">
                <span class="stock-dot"></span> In Stock
              </div>
            </div>

          </div>
        </div>

        <!-- Selected Diameter Bar (Metric mm only) -->
        <div class="selected-dia-summary-bar">
          <div class="dia-summary-left">
            <span class="dia-summary-label">Selected Diameter</span>
            <div class="dia-summary-val" id="selectedDiaText"><?php echo htmlspecialchars($initial_row['mm']); ?> mm</div>
          </div>
          <button type="button" class="dia-change-btn" id="diaChangeBtn" title="Choose or change diameter in mm">
            <span>Change</span>
            <span class="refresh-symbol">&#x21bb;</span>
          </button>
        </div>

        <!-- Selected Diameter & Collective Multi-Size Order Card -->
        <div class="commercial-charcoal-card">
          
          <div class="commercial-info-row">
            
            <!-- Col 1: Conformance & Standard -->
            <div class="commercial-col commercial-col-spec">
              <div class="comm-icon-box">
                <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 11 14 15 10"></polyline></svg>
              </div>
              <div class="comm-text-box">
                <span class="comm-label">Conformance & Standard</span>
                <div class="comm-val-highlight">IS : 5101 / ISO 235</div>
                <p class="comm-note">
                  Precision ground High-Speed Steel (M2 / M35 Cobalt).
                </p>
              </div>
            </div>

            <!-- Col 2: MOQ -->
            <div class="commercial-col commercial-col-moq">
              <div class="comm-icon-box">
                <svg viewBox="0 0 24 24"><path d="M21 16.5l-9 5.2-9-5.2V7.5l9-5.2 9 5.2v9zM12 4.1L5.2 8 12 11.9 18.8 8 12 4.1zm-7 5.7v6.6l7 4v-6.6l-7-4zm16 0l-7 4v6.6l7-4V9.8z"/></svg>
              </div>
              <div class="comm-text-box">
                <span class="comm-label">Packaging & MOQ</span>
                <div class="comm-val-highlight" id="commMoqDisplay">Multiples of 10 pcs</div>
                <p class="comm-note">
                  Standard MOQ applies per size.
                </p>
              </div>
            </div>

            <!-- Col 3: Delivery Terms -->
            <div class="commercial-col commercial-col-delivery">
              <div class="comm-icon-box">
                <svg viewBox="0 0 24 24"><path d="M20 8h-3V4H1v13h2a3 3 0 0 0 6 0h6a3 3 0 0 0 6 0h2v-5l-3-4zM6 18.5A1.5 1.5 0 1 1 7.5 17 1.5 1.5 0 0 1 6 18.5zm12 0a1.5 1.5 0 1 1 1.5-1.5 1.5 1.5 0 0 1-1.5 1.5zM17 12V9.5h2.5l2 2.5H17z"/></svg>
              </div>
              <div class="comm-text-box">
                <span class="comm-label">Delivery Terms</span>
                <div class="comm-val-highlight">F.O.R. Destination</div>
                <p class="comm-note">
                  Direct dispatch from Nashik / Aurangabad plants.
                </p>
              </div>
            </div>

          </div>

          <!-- Collective Multi-Size Product List Container -->
          <div class="collective-order-card" id="collectiveOrderCard">
            <div class="collective-box-header">
              <div class="collective-box-title-group">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                  <line x1="3" y1="6" x2="21" y2="6"></line>
                  <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
                <span class="collective-box-title">Selected Sizes to Order / Enquire:</span>
                <span class="collective-count-badge" id="collectiveCountBadge">1 Size</span>
              </div>
              <button type="button" class="collective-add-btn" id="collectiveAddMoreBtn" title="Choose and add another diameter in mm">
                <span>+ Add Another Size (mm)</span>
              </button>
            </div>

            <!-- Dynamic list of collective items -->
            <div class="collective-items-container" id="collectiveItemsContainer">
              <!-- Rendered dynamically by product.js -->
            </div>
            
            <div class="collective-note-row">
              <span class="collective-note-icon">ℹ</span>
              <span>Packaged in multiples of 10 pieces as per IS:5101. You can add multiple sizes and enquire / add to cart collectively.</span>
            </div>
          </div>

          <!-- Bottom Button Action Bar -->
          <div class="commercial-actions-bar">
            <a href="#enquiry" class="btn-quote-red" id="requestQuotationBtn">
              <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
              <span>Request Official Quotation &rarr;</span>
            </a>

            <button type="button" class="btn-add-to-cart" id="addToCartBtn">
              <svg class="cart-btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
              </svg>
              <span class="cart-btn-text" id="cartBtnText">Add Selected Sizes to Cart</span>
            </button>
          </div>

        </div>

      </div>

    </div>

  </div>
</section>

<!-- ==========================================================================
     TECHNICAL SPECIFICATIONS & APPLICATION TABS
     ========================================================================== -->
<section class="product-tabs-section">
  <div class="container">
    
    <div class="tab-nav-list" role="tablist">
      <button type="button" class="tab-btn is-active" data-tab="specs" role="tab">Standards &amp; Metallurgy</button>
      <button type="button" class="tab-btn" data-tab="variants" role="tab">Variant Breakdown</button>
      <button type="button" class="tab-btn" data-tab="commercial" role="tab">Commercial &amp; Ordering Rules</button>
      <button type="button" class="tab-btn" data-tab="sets" role="tab">Pre-Packaged Drill Sets</button>
    </div>

    <!-- Tab 1: Standards & Metallurgy -->
    <div class="tab-content-panel is-active" id="tab-specs">
      <div class="specs-data-grid">
        <div class="specs-data-row">
          <strong>Standard Specification</strong>
          <span>IS : 5101 (Conforms to ISO 235 / DIN 338)</span>
        </div>
        <div class="specs-data-row">
          <strong>Harmonized System (HSN)</strong>
          <span>8207 (Tools, Interchangeable Tools for Hand Tools)</span>
        </div>
        <div class="specs-data-row">
          <strong>Base Material</strong>
          <span>High-Speed Steel (M2 Grade Standard / M35 Cobalt)</span>
        </div>
        <div class="specs-data-row">
          <strong>Flute Geometry</strong>
          <span>Precision Ground Type 'N' RH Helical Flutes</span>
        </div>
        <div class="specs-data-row">
          <strong>Point Angle</strong>
          <span>118&deg; Standard (135&deg; Split Point on Panther/Forgeline)</span>
        </div>
        <div class="specs-data-row">
          <strong>Shank Design</strong>
          <span>Parallel (Straight Cylindrical, equal to drill diameter)</span>
        </div>
        <div class="specs-data-row">
          <strong>Diameter Range</strong>
          <span>0.30 mm to 22.22 mm (7/8")</span>
        </div>
        <div class="specs-data-row">
          <strong>Manufacturing Plants</strong>
          <span>Nashik, Aurangabad, and Chalisgaon (Maharashtra)</span>
        </div>
      </div>
    </div>

    <!-- Tab 2: Variant Breakdown -->
    <div class="tab-content-panel" id="tab-variants">
      <div class="specs-data-grid">
        <div class="specs-data-row">
          <strong>ITM STD.</strong>
          <span>Standard M2 High-Speed Steel. Ideal for mild steel, structural steel, and cast iron.</span>
        </div>
        <div class="specs-data-row">
          <strong>ITM STD. TIN</strong>
          <span>Titanium Nitride coated. Reduces thermal buildup and wear during high-volume production.</span>
        </div>
        <div class="specs-data-row">
          <strong>PANTHER</strong>
          <span>CNC ground point geometry. Reduces thrust force; ideal for stainless steel &amp; tough alloys.</span>
        </div>
        <div class="specs-data-row">
          <strong>NINJA</strong>
          <span>HSS M35 Cobalt grade. Maximum heat hardness and razor-sharp accuracy for high-tensile alloys.</span>
        </div>
        <div class="specs-data-row">
          <strong>FORGELINE</strong>
          <span>Robust flute web design. Engineered specifically for forged steel and abrasive cast irons.</span>
        </div>
        <div class="specs-data-row">
          <strong>HATHYAR</strong>
          <span>Heavy-duty fabrication shop drill. High torsional strength for rigorous workshop conditions.</span>
        </div>
      </div>
    </div>

    <!-- Tab 3: Commercial & Ordering Rules (From PDF Page 3 & 22) -->
    <div class="tab-content-panel" id="tab-commercial">
      <div style="background-color:#F8F9FA;padding:24px;border-radius:6px;border:1px solid #ECEFF1;font-size:0.88rem;line-height:1.7;">
        <h4 style="font-family:var(--font-heading);color:#111;margin-bottom:12px;">Official Commercial Terms (Effective 1st April 2026):</h4>
        <ol style="margin-left:20px;display:flex;flex-direction:column;gap:8px;">
          <li><strong>Quotation Terms:</strong> Official B2B quotations are issued on request. GST and applicable government levies will be itemized on the official quote.</li>
          <li><strong>Packaging &amp; Order Quantities:</strong> All sizes must be ordered in multiples of 10 only as per IS : 5101.</li>
          <li><strong>Minimum Order Quantity (MOQ):</strong> Standard packaging MOQ applies for each diameter (e.g. 200 pcs, 100 pcs, 20 pcs as noted).</li>
          <li><strong>Non-Listed Intermediate Sizes:</strong> For non-listed intermediate sizes, quotation will be provided upon engineering assessment.</li>
          <li><strong>Special Flutes:</strong> Quick spiral, slow spiral, or tenon shanks can be manufactured and quoted upon request.</li>
          <li><strong>Dispatch Terms:</strong> Quotations are issued on an F.O.R. destination basis direct from plant dispatch.</li>
        </ol>
      </div>
    </div>

    <!-- Tab 4: Pre-Packaged Drill Sets (From PDF Page 22) -->
    <div class="tab-content-panel" id="tab-sets">
      <div class="specs-data-grid">
        <div class="specs-data-row">
          <strong>Jobber Drill 13 Pcs. Set (1/64" Rise)</strong>
          <span>Range: 1/16" to 1/4" &bull; <strong>Quotation on Official Request</strong></span>
        </div>
        <div class="specs-data-row">
          <strong>Hathyar Drill 13 Pcs. Set (1/64" Rise)</strong>
          <span>Range: 1/16" to 1/4" &bull; <strong>Quotation on Official Request</strong></span>
        </div>
        <div class="specs-data-row">
          <strong>Hathyar Drill 25 Pcs. Set (0.5mm Rise)</strong>
          <span>Range: 1.00 mm to 13.00 mm &bull; <strong>Quotation on Official Request</strong></span>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ==========================================================================
     PRODUCT ENQUIRY & OFFICIAL QUOTATION WORKFLOW
     ========================================================================== -->
<section class="enquiry-section" id="enquiry">
  <div class="container">
    
    <div class="enquiry-card">
      <div style="text-align:center;margin-bottom:24px;">
        <span class="section-eyebrow">Official Quotation Workflow</span>
        <h2 style="font-family:var(--font-heading);font-size:1.8rem;color:#111;margin-bottom:8px;">
          Request Official Quotation / Bulk Tooling Enquiry
        </h2>
        <p style="font-size:0.9rem;color:#6C757D;">
          All selected tooling specifications from your cart and configurator are shared below. Multiples of 10 pieces required.
        </p>
      </div>

      <!-- Feedback Banner -->
      <div id="enquiryFeedback" class="form-feedback-message"></div>

      <!-- Selected Items from Cart / Configurator Breakdown (Live Shared Info) -->
      <div class="enquiry-cart-summary-box" id="enquiryCartSummaryBox" style="display:none;">
        <div class="enquiry-summary-header">
          <div class="enquiry-summary-title-wrap">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
              <polyline points="14 2 14 8 20 8"></polyline>
              <line x1="16" y1="13" x2="8" y2="13"></line>
              <line x1="16" y1="17" x2="8" y2="17"></line>
            </svg>
            <span class="enquiry-summary-title">Selected Tooling Specifications to be Quoted:</span>
          </div>
          <span class="enquiry-summary-count-badge" id="enquirySummaryCount">0 Items</span>
        </div>
        <div class="enquiry-summary-items" id="enquirySummaryItems">
          <!-- Populated dynamically via JS from Cart -->
        </div>
      </div>

      <!-- Form -->
      <form id="productEnquiryForm" method="POST" action="../enquiry_submit.php">
        
        <!-- CSRF Token -->
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">

        <div class="enquiry-form-grid">
          
          <!-- Selected Diameter (Pre-filled) -->
          <div class="form-group">
            <label class="form-label" for="enquiryDiaInput">Selected Drill Diameter</label>
            <input 
              type="text" 
              name="metric_dia" 
              id="enquiryDiaInput" 
              class="form-control form-readonly" 
              value="<?php echo htmlspecialchars($initial_row['mm']); ?> mm"
              readonly
            >
          </div>

          <!-- Selected Variant (Pre-filled) -->
          <div class="form-group">
            <label class="form-label" for="enquiryVariantInput">Selected Variant</label>
            <input 
              type="text" 
              name="variant_name" 
              id="enquiryVariantInput" 
              class="form-control form-readonly" 
              value="<?php echo htmlspecialchars($variants[$initial_variant]['name']); ?>"
              readonly
            >
          </div>

          <!-- Quantity (Validated against MOQ & multiple of 10) -->
          <div class="form-group">
            <label class="form-label" for="enquiryQuantityInput">Required Quantity (Pieces)</label>
            <input 
              type="number" 
              name="quantity" 
              id="enquiryQuantityInput" 
              class="form-control" 
              value="<?php echo (int)($initial_row['moq'] ?? 100); ?>" 
              min="10" 
              step="10" 
              required
            >
            <small id="enquiryMoqNotice" style="display:block;font-size:0.75rem;color:#78909C;margin-top:4px;">
              Standard MOQ is <?php echo (int)($initial_row['moq'] ?? 100); ?> pcs (Multiples of 10).
            </small>
          </div>

          <!-- Procurement Basis Reference -->
          <div class="form-group">
            <label class="form-label" for="enquiryPriceBasisInput">Procurement Basis</label>
            <input 
              type="text" 
              name="price_basis" 
              id="enquiryPriceBasisInput" 
              class="form-control form-readonly" 
              value="Official B2B Quotation on Request (IS : 5101)"
              readonly
            >
          </div>

          <!-- Customer Name -->
          <div class="form-group">
            <label class="form-label" for="enquiryNameInput">Full Name *</label>
            <input 
              type="text" 
              name="customer_name" 
              id="enquiryNameInput" 
              class="form-control" 
              placeholder="e.g. Rajesh Kumar" 
              required
            >
          </div>

          <!-- Company Name -->
          <div class="form-group">
            <label class="form-label" for="enquiryCompanyInput">Company / Organization</label>
            <input 
              type="text" 
              name="company_name" 
              id="enquiryCompanyInput" 
              class="form-control" 
              placeholder="e.g. Apex Precision Engineering Ltd." 
              required
            >
          </div>

          <!-- Email -->
          <div class="form-group">
            <label class="form-label" for="enquiryEmailInput">Corporate Email *</label>
            <input 
              type="email" 
              name="email" 
              id="enquiryEmailInput" 
              class="form-control" 
              placeholder="e.g. procurement@apex-eng.com" 
              required
            >
          </div>

          <!-- Phone -->
          <div class="form-group">
            <label class="form-label" for="enquiryPhoneInput">Phone / Mobile Number *</label>
            <input 
              type="tel" 
              name="phone" 
              id="enquiryPhoneInput" 
              class="form-control" 
              placeholder="e.g. +91 98200 12345" 
              required
            >
          </div>

          <!-- Message -->
          <div class="form-group form-group-full">
            <label class="form-label" for="enquiryMessageInput">Application Requirements / Material Being Machined</label>
            <textarea 
              name="message" 
              id="enquiryMessageInput" 
              class="form-control" 
              placeholder="Specify workpiece material, hole depth, CNC machine details, or custom coating preferences..."
            ></textarea>
          </div>

          <!-- Submit Button -->
          <div class="form-group form-group-full" style="text-align:center;margin-top:10px;">
            <button type="submit" class="btn btn-primary" id="enquirySubmitBtn" style="min-width:280px;">
              Submit Official Enquiry
            </button>
            <p style="font-size:0.75rem;color:#888;margin-top:8px;">
              By submitting, your request is routed directly to the Birla Precision cutting tools technical sales desk.
            </p>
          </div>

        </div>

      </form>

    </div>

  </div>
</section>

<!-- Gallery Lightbox Modal -->
<div class="gallery-lightbox-modal" id="galleryLightboxModal" aria-hidden="true" role="dialog">
  <div class="lightbox-backdrop" id="lightboxBackdrop"></div>
  <div class="lightbox-dialog">
    <button type="button" class="lightbox-close-btn" id="lightboxCloseBtn" aria-label="Close Lightbox">&times;</button>
    <div class="lightbox-body">
      <img src="../assets/images/products/gallery_view_1.jpg" alt="Enlarged High Resolution Product Photograph" id="lightboxImage" class="lightbox-image">
    </div>
    <div class="lightbox-footer">
      <span class="lightbox-caption" id="lightboxCaption">Jobber Drills Series Lineup on Architectural Pedestals</span>
    </div>
  </div>
</div>

<!-- Product Page JavaScript -->
<script src="../assets/js/product.js"></script>

<?php
include __DIR__ . '/../includes/footer.php';
?>
