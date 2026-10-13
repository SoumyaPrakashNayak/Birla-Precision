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

      <!-- Right Column: Interactive Configurator Panel (Reference Design) -->
      <div class="product-config-panel">
        
        <!-- Meta Header -->
        <div class="product-meta-header">
          <div class="product-brand-row">
            <span class="brand-text-red">DAGGER BRAND &bull; BIRLA PRECISION</span>
            <span class="std-pill">Standard: IS : 5101 / ISO 235</span>
            <span class="std-pill">HSN Code: 8207</span>
          </div>
          <h1 class="product-page-title">HSS Parallel Shank Twist Drills — Jobber Series</h1>
          <p class="product-lead-desc">
            High-speed steel drills for general engineering, automotive, aerospace and fabrication applications. Manufactured to Indian Tool Manufacturers (ITM) standards with precision ground flutes for accurate, efficient drilling.
          </p>
        </div>

        <!-- 1. Step 1: Add sizes and quantity -->
        <div class="config-step-card" id="step1Card">
          <div class="step-header-row">
            <div class="step-title-group">
              <span class="step-num-circle">1</span>
              <div class="step-title-text">
                <h2 class="step-heading">Add sizes and quantity</h2>
                <p class="step-subheading" id="stepSubheading">Enter the drill size (in mm) and quantity. You can add multiple sizes.</p>
              </div>
            </div>
            <div class="unit-toggle-segmented" id="unitToggleSegmented" role="group" aria-label="Unit of measure">
              <button type="button" class="unit-toggle-btn is-active" data-unit="mm" id="unitBtnMm">Metric (mm)</button>
              <button type="button" class="unit-toggle-btn" data-unit="inch" id="unitBtnInch">Inch</button>
            </div>
          </div>

          <!-- Controls Row: Drill Size, Quantity, Add to list -->
          <div class="step-controls-row">
            
            <!-- Col 1: Drill Size -->
            <div class="step-control-col dia-col">
              <label class="control-label" id="diaControlLabel" for="diaSearchInput">Drill Size (mm)</label>
              <div class="dia-combobox-wrapper" id="diaComboboxWrapper">
                <input 
                  type="text" 
                  id="diaSearchInput" 
                  class="dia-select-input" 
                  placeholder="Select or type size (e.g. 3.5)" 
                  autocomplete="off"
                >
                <button type="button" class="dia-toggle-dropdown-btn" id="diaToggleDropdownBtn" aria-label="Toggle diameter options">
                  <svg class="dia-chevron-icon" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
                </button>
                <div class="dia-dropdown-menu" id="diaDropdownMenu">
                  <div class="dia-menu-scroll" id="diaMenuScroll">
                    <!-- Populated dynamically via JS -->
                  </div>
                </div>
              </div>
            </div>

            <!-- Col 2: Quantity (pcs) -->
            <div class="step-control-col qty-col">
              <div class="qty-label-wrap">
                <label class="control-label" for="stepQtyInput">Quantity (pcs)</label>
              </div>
              <div class="qty-stepper-box">
                <button type="button" class="qty-step-btn" id="stepQtyMinus" aria-label="Decrease quantity">&minus;</button>
                <input type="number" id="stepQtyInput" class="qty-step-input" value="10" min="1" step="1">
                <button type="button" class="qty-step-btn" id="stepQtyPlus" aria-label="Increase quantity">&plus;</button>
              </div>
            </div>

            <!-- Col 3: Add to list button -->
            <div class="step-control-col add-col">
              <button type="button" class="btn-add-to-list" id="addToListBtn">
                <span class="btn-plus-icon">+</span> Add to list
              </button>
            </div>

          </div>

          <!-- Popular Sizes Row -->
          <div class="popular-sizes-row">
            <span class="popular-sizes-label">Popular sizes:</span>
            <div class="popular-sizes-list" id="popularSizesList">
              <button type="button" class="popular-size-pill" data-val="2.00">2.00</button>
              <button type="button" class="popular-size-pill" data-val="3.00">3.00</button>
              <button type="button" class="popular-size-pill" data-val="4.00">4.00</button>
              <button type="button" class="popular-size-pill" data-val="5.00">5.00</button>
              <button type="button" class="popular-size-pill" data-val="6.00">6.00</button>
              <button type="button" class="popular-size-pill" data-val="8.00">8.00</button>
              <button type="button" class="popular-size-pill" data-val="10.00">10.00</button>
              <button type="button" class="popular-size-pill" data-val="12.00">12.00</button>
            </div>
          </div>

        </div>

        <!-- 2. Step 2: Selected sizes for quotation -->
        <div class="config-step-card" id="step2Card">
          <div class="step-header-row">
            <div class="step-title-group">
              <span class="step-num-circle">2</span>
              <h2 class="step-heading">Selected sizes for quotation</h2>
            </div>
            <button type="button" class="btn-clear-all" id="clearAllSizesBtn">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
              </svg>
              <span>Clear all</span>
            </button>
          </div>

          <!-- Quotation Table -->
          <div class="quotation-table-wrapper">
            <table class="quotation-table" id="quotationTable" style="display:none;">
              <thead>
                <tr>
                  <th class="th-sno">S.No.</th>
                  <th class="th-size" id="colHeaderSize">Size (mm)</th>
                  <th class="th-qty">Quantity (pcs)</th>
                  <th class="th-avail">Availability</th>
                  <th class="th-action">Action</th>
                </tr>
              </thead>
              <tbody id="quotationTableBody">
                <!-- Populated dynamically via JS when sizes are selected -->
              </tbody>
            </table>
            <div class="quotation-empty-state" id="quotationEmptyState">
              <p>No sizes selected yet. Use Step 1 above to add drill sizes for quotation.</p>
            </div>
          </div>

          <!-- Next Step Banner Box -->
          <div class="next-step-box">
            <div class="next-step-left">
              <div class="next-step-info-icon">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="#DC2626">
                  <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                </svg>
              </div>
              <div class="next-step-content">
                <div class="next-step-title">Next Step</div>
                <p class="next-step-desc">
                  Click on &ldquo;Add to Cart&rdquo; to add these sizes to your cart. You can then request a quotation directly from your cart.
                </p>
              </div>
            </div>
            <div class="next-step-right">
              <button type="button" class="btn-request-quote-main" id="heroAddToCartBtn">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="9" cy="21" r="1"></circle>
                  <circle cx="20" cy="21" r="1"></circle>
                  <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span>Add to Cart &rarr;</span>
              </button>
            </div>
          </div>

        </div>

      </div>

    </div>

  </div>
</section>

<!-- Quotation workflow is now hosted on the dedicated page: quotation.php -->
<div id="enquiry" style="display:none;" aria-hidden="true"></div>

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


<?php
include __DIR__ . '/../includes/footer.php';
?>
