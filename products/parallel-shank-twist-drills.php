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
              <h2 class="step-heading">Find your drill size</h2>
            </div>
            <a href="#all-sizes-table" class="step-link-red">
              <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
              <span>View size chart &rarr;</span>
            </a>
          </div>

          <!-- Unit Selector & Diameter Dropdown Row -->
          <div class="size-controls-row">
            
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
                  placeholder="Search or choose a diameter..." 
                  value="3.17 mm (1/8 inch)" 
                  autocomplete="off"
                >
                <svg class="dia-chevron-icon" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
              </div>

              <!-- Dropped Down Size Menu List -->
              <div class="diameter-dropdown-menu" id="diaDropdownMenu">
                <div class="dia-menu-scroll" id="diaMenuScroll">
                  <!-- Populated dynamically via JS matching unit (MM, INCH, DG) -->
                </div>
                <a href="#all-sizes-table" class="dia-menu-footer-link">
                  <svg viewBox="0 0 24 24"><path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"/></svg>
                  <span>View all sizes (0.30 mm – 22.22 mm) &rarr;</span>
                </a>
              </div>
            </div>

            <!-- Right: Unit Selector (Dropdown Box + Interactive Toggle Pills) -->
            <div class="unit-selector-container">
              
              <!-- Required Dropdown box for SIZE units (MM, INCH, DG) -->
              <div class="unit-dropdown-box-wrap">
                <label for="unitSelectBox" class="unit-dropdown-label">SIZE:</label>
                <select id="unitSelectBox" class="unit-dropdown-select" aria-label="Select Size Unit">
                  <option value="mm" selected>MM</option>
                  <option value="inch">INCH</option>
                  <option value="dg">DG</option>
                </select>
              </div>

              <!-- Interactive Unit Toggle Pills matching screenshot -->
              <div class="unit-toggle-pills" role="radiogroup" aria-label="Size Units">
                <button type="button" class="unit-pill-btn is-active" data-unit="mm" aria-checked="true">
                  <span class="unit-radio-dot"></span>
                  <span>Metric (mm)</span>
                </button>
                <button type="button" class="unit-pill-btn" data-unit="inch" aria-checked="false">
                  <span>Inch</span>
                </button>
                <button type="button" class="unit-pill-btn" data-unit="dg" aria-checked="false">
                  <svg viewBox="0 0 24 24"><path d="M5 9.2h3V19H5zM10.6 5h2.8v14h-2.8zm5.6 8H19v6h-2.8z"/></svg>
                  <span>Gauge Lookup</span>
                </button>
              </div>

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

        <!-- Selected Diameter Summary Bar -->
        <div class="selected-dia-summary-bar">
          <div class="dia-summary-left">
            <span class="dia-summary-label">Selected Diameter</span>
            <div class="dia-summary-val" id="selectedDiaText"><?php 
              $disp = $initial_row['mm'] . ' mm';
              if (!empty($initial_row['inch'])) $disp .= ' (' . $initial_row['inch'] . ' inch)';
              elseif (!empty($initial_row['dg'])) $disp .= ' (DG ' . $initial_row['dg'] . ')';
              echo htmlspecialchars($disp);
            ?></div>
          </div>
          <button type="button" class="dia-change-btn" id="diaChangeBtn" aria-label="Change Selected Diameter">
            <span>Change</span>
            <span class="refresh-symbol">&#x21bb;</span>
          </button>
        </div>

        <!-- Commercial Pricing & Logistics Charcoal Card -->
        <div class="commercial-charcoal-card">
          
          <div class="commercial-info-row">
            
            <!-- Col 1: Catalogue Price -->
            <div class="commercial-col commercial-col-price">
              <div class="comm-icon-box">
                <svg viewBox="0 0 24 24"><path d="M4 6h16v3H4zm0 6h16v3H4zm0 6h16v3H4zM2 4a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4z"/></svg>
              </div>
              <div class="comm-text-box">
                <span class="comm-label">Catalogue Price (per 10 pieces)</span>
                <div class="comm-price-big" id="commPriceDisplay"><?php 
                  echo !empty($initial_row[$initial_variant]) ? '₹ ' . number_format($initial_row[$initial_variant], 2) : 'Available on Request';
                ?></div>
                <p class="comm-note">
                  April 2026 catalogue. Taxes extra. Please request an official quotation for the latest pricing and availability.
                </p>
              </div>
            </div>

            <!-- Col 2: MOQ -->
            <div class="commercial-col commercial-col-moq">
              <div class="comm-icon-box">
                <svg viewBox="0 0 24 24"><path d="M21 16.5l-9 5.2-9-5.2V7.5l9-5.2 9 5.2v9zM12 4.1L5.2 8 12 11.9 18.8 8 12 4.1zm-7 5.7v6.6l7 4v-6.6l-7-4zm16 0l-7 4v6.6l7-4V9.8z"/></svg>
              </div>
              <div class="comm-text-box">
                <span class="comm-label">Minimum Order Quantity (MOQ)</span>
                <div class="comm-val-highlight" id="commMoqDisplay"><?php echo (int)($initial_row['moq'] ?? 100); ?> Pieces</div>
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
              </div>
            </div>

          </div>

          <!-- Bottom Button Action Bar -->
          <div class="commercial-actions-bar">
            <a href="#enquiry" class="btn-quote-red" id="requestQuotationBtn">
              <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
              <span>Request Official Quotation &rarr;</span>
            </a>

            <a href="#all-sizes-table" class="btn-compare-table" id="compareTableBtn">
              <svg viewBox="0 0 24 24"><path d="M5 9.2h3V19H5zM10.6 5h2.8v14h-2.8zm5.6 8H19v6h-2.8z"/></svg>
              <span>Compare in Full Size Table</span>
            </a>
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
          <li><strong>Pricing Basis:</strong> All listed prices are stated <em>PRICE PER 10 PCS (RS.)</em>. These are base prices; GST and applicable government levies will be charged extra.</li>
          <li><strong>Packaging &amp; Order Quantities:</strong> All sizes must be ordered in multiples of 10 only.</li>
          <li><strong>Minimum Order Quantity (MOQ):</strong> MOQ applies for each size / length of the product (e.g. 200 pcs, 100 pcs, 20 pcs as noted). A smaller-than-MOQ order may attract a surcharge upon request.</li>
          <li><strong>Non-Listed Intermediate Sizes:</strong> For non-listed intermediate sizes, the higher price of the nearest listed size (Inch or MM) will be applicable.</li>
          <li><strong>Special Flutes:</strong> Quick spiral or slow spiral drills: sizes up to 3.17mm (1/8") attract 50% extra; sizes over 3.17mm attract 25% extra. Jobbers with tenon: 10% extra.</li>
          <li><strong>Price Revision:</strong> Prices are quoted on an F.O.R. destination basis and are subject to change without prior notice.</li>
        </ol>
      </div>
    </div>

    <!-- Tab 4: Pre-Packaged Drill Sets (From PDF Page 22) -->
    <div class="tab-content-panel" id="tab-sets">
      <div class="specs-data-grid">
        <div class="specs-data-row">
          <strong>Jobber Drill 13 Pcs. Set (1/64" Rise)</strong>
          <span>Range: 1/16" to 1/4" &bull; <strong>Catalogue Price: ₹3,030</strong></span>
        </div>
        <div class="specs-data-row">
          <strong>Hathyar Drill 13 Pcs. Set (1/64" Rise)</strong>
          <span>Range: 1/16" to 1/4" &bull; <strong>Catalogue Price: ₹2,727</strong></span>
        </div>
        <div class="specs-data-row">
          <strong>Hathyar Drill 25 Pcs. Set (0.5mm Rise)</strong>
          <span>Range: 1.00 mm to 13.00 mm &bull; <strong>Catalogue Price: ₹13,685</strong></span>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ==========================================================================
     COMPLETE 262-ROW CATALOGUE DATA TABLE (Pages 17 to 22)
     ========================================================================== -->
<section class="catalogue-table-section" id="all-sizes-table">
  <div class="container">
    
    <div class="section-header-center" style="margin-bottom:30px;">
      <span class="section-eyebrow">Authoritative PDF Price Table</span>
      <h2 class="section-title">Complete Jobber Series Size &amp; Pricing Directory</h2>
      <p class="section-subtitle">
        Extracted directly from pages 17 to 22 of the April 2026 Price List. Click any row to load into the live configurator.
      </p>
    </div>

    <!-- Controls Bar -->
    <div class="table-controls-bar">
      <div class="table-filter-group">
        <input 
          type="text" 
          id="tableSearchInput" 
          class="table-search-input" 
          placeholder="Filter table (e.g. 3.17, 1/4, 6.80)..."
        >
        <span class="table-count-label" id="tableRowsCount">Showing 262 diameter specifications (IS : 5101)</span>
      </div>
      <div>
        <span class="badge badge-dark">Unit: Price Per 10 Pieces (Rs.)</span>
      </div>
    </div>

    <!-- Responsive Table Container -->
    <div class="table-responsive-wrapper">
      <table class="catalogue-table" id="jobberCatalogueTable">
        <thead>
          <tr>
            <th scope="col">MM</th>
            <th scope="col">INCH</th>
            <th scope="col">DG</th>
            <th scope="col">ITM STD.</th>
            <th scope="col">ITM STD. TIN</th>
            <th scope="col">PANTHER</th>
            <th scope="col">NINJA</th>
            <th scope="col">FORGELINE</th>
            <th scope="col">HATHYAR</th>
            <th scope="col">MOQ</th>
          </tr>
        </thead>
        <tbody id="catalogueTableBody">
          <?php foreach ($all_sizes as $row): ?>
            <tr data-dia="<?php echo htmlspecialchars($row['mm']); ?>" class="<?php echo ($row['mm'] === $initial_dia_val) ? 'is-selected-row' : ''; ?>">
              <td class="dia-cell"><strong><?php echo htmlspecialchars($row['mm']); ?></strong></td>
              <td><?php echo !empty($row['inch']) ? htmlspecialchars($row['inch']) : '<span class="price-dash">-</span>'; ?></td>
              <td><?php echo !empty($row['dg']) ? htmlspecialchars($row['dg']) : '<span class="price-dash">-</span>'; ?></td>
              <td><?php echo !empty($row['itm_std']) ? '<span class="price-tag-table">₹' . number_format($row['itm_std'], 0) . '</span>' : '<span class="price-dash">—</span>'; ?></td>
              <td><?php echo !empty($row['itm_std_tin']) ? '<span class="price-tag-table">₹' . number_format($row['itm_std_tin'], 0) . '</span>' : '<span class="price-dash">—</span>'; ?></td>
              <td><?php echo !empty($row['panther']) ? '<span class="price-tag-table">₹' . number_format($row['panther'], 0) . '</span>' : '<span class="price-dash">—</span>'; ?></td>
              <td><?php echo !empty($row['ninja']) ? '<span class="price-tag-table">₹' . number_format($row['ninja'], 0) . '</span>' : '<span class="price-dash">—</span>'; ?></td>
              <td><?php echo !empty($row['forgeline']) ? '<span class="price-tag-table">₹' . number_format($row['forgeline'], 0) . '</span>' : '<span class="price-dash">—</span>'; ?></td>
              <td><?php echo !empty($row['hathyar']) ? '<span class="price-tag-table">₹' . number_format($row['hathyar'], 0) . '</span>' : '<span class="price-dash">—</span>'; ?></td>
              <td><span class="badge badge-light"><?php echo (int)($row['moq'] ?? 100); ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div>
</section>

<!-- ==========================================================================
     PRODUCT ENQUIRY WORKFLOW (Preserves Selected Configuration)
     ========================================================================== -->
<section class="enquiry-section" id="enquiry">
  <div class="container">
    
    <div class="enquiry-card">
      <div style="text-align:center;margin-bottom:24px;">
        <span class="section-eyebrow">Official Quotation Workflow</span>
        <h2 style="font-family:var(--font-heading);font-size:1.8rem;color:#111;margin-bottom:8px;">
          Request Updated Quotation / Bulk Enquiry
        </h2>
        <p style="font-size:0.9rem;color:#6C757D;">
          Specifications from the live configurator above are automatically pre-filled. Multiples of 10 pieces required.
        </p>
      </div>

      <!-- Feedback Banner -->
      <div id="enquiryFeedback" class="form-feedback-message"></div>

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

          <!-- Price Basis Reference -->
          <div class="form-group">
            <label class="form-label" for="enquiryPriceBasisInput">Catalogue Price Basis</label>
            <input 
              type="text" 
              name="price_basis" 
              id="enquiryPriceBasisInput" 
              class="form-control form-readonly" 
              value="Catalogue <?php echo format_inr($initial_row[$initial_variant]); ?> per 10 pcs (April 2026 Price List)"
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
