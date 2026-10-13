<?php
/**
 * Birla Precision Technologies Limited / Dagger Brand
 * Dynamic Product Detail Page Template (products/view.php)
 * Follows the EXACT same layout and two-step quotation configurator template
 * as the flagship HSS Parallel Shank Twist Drills page.
 */

require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/db.php';

$current_page = 'product';
$is_subfolder = true;

// Retrieve product by id or slug
$id_or_slug = isset($_GET['id']) ? trim($_GET['id']) : (isset($_GET['slug']) ? trim($_GET['slug']) : '');

if (empty($id_or_slug)) {
    // Default to flagship product if not specified
    $id_or_slug = 'parallel-shank-twist-drills';
}

$product = get_product_by_id_or_slug($id_or_slug);

if (!$product) {
    // If not found, fallback to first active product or redirect to products list
    $all = get_all_products(1);
    if (!empty($all)) {
        $product = get_product_by_id_or_slug($all[0]['id']);
    } else {
        header('Location: ../products.php');
        exit;
    }
}

$page_title = htmlspecialchars($product['title']) . ' — ' . htmlspecialchars($product['standard'] ?? 'IS : 5101') . ' | Birla Precision';
$page_description = htmlspecialchars($product['description'] ?? 'Industrial precision tooling from Birla Precision Technologies Limited and Dagger Brand.');

// Parse gallery images
$gallery_images = [];
if (!empty($product['gallery_json'])) {
    $gallery_images = json_decode($product['gallery_json'], true) ?: [];
}
if (empty($gallery_images)) {
    $gallery_images = [
        $product['image'] ?? 'assets/images/products/gallery_view_1.jpg',
        'assets/images/products/gallery_view_2.jpg',
        'assets/images/products/gallery_view_3.jpg',
        'assets/images/products/gallery_view_4.jpg',
        'assets/images/products/gallery_view_5.jpg'
    ];
}

// Format sizes for front-end JS configurator
$formatted_sizes = [];
$popular_sizes = [];
if (!empty($product['sizes'])) {
    foreach ($product['sizes'] as $sz) {
        $formatted_sizes[] = [
            'mm' => $sz['size_mm'],
            'diameter_float' => (float)$sz['size_mm'],
            'inch' => !empty($sz['size_inch']) ? $sz['size_inch'] : null,
            'dg' => !empty($sz['dg']) ? $sz['dg'] : null,
            'moq' => 1
        ];
        if (!empty($sz['is_popular'])) {
            $popular_sizes[] = $sz['size_mm'];
        }
    }
} else {
    // Fallback standard metric sizes if none entered
    $popular_sizes = ['2.00', '3.00', '4.00', '5.00', '6.00', '8.00', '10.00', '12.00'];
    foreach ($popular_sizes as $ps) {
        $formatted_sizes[] = [
            'mm' => $ps,
            'diameter_float' => (float)$ps,
            'inch' => null,
            'dg' => null,
            'moq' => 1
        ];
    }
}

if (empty($popular_sizes) && !empty($formatted_sizes)) {
    $popular_sizes = array_slice(array_column($formatted_sizes, 'mm'), 0, 8);
}

$main_img_url = '../' . ltrim($gallery_images[0], '/');

include __DIR__ . '/../includes/header.php';
?>

<!-- Breadcrumb Navigation -->
<nav class="breadcrumb-nav" aria-label="Breadcrumbs">
  <div class="container">
    <ol class="breadcrumb-list">
      <li><a href="../index.php">Home</a></li>
      <li class="breadcrumb-separator">&rsaquo;</li>
      <li><a href="../products.php">Products</a></li>
      <li class="breadcrumb-separator">&rsaquo;</li>
      <li><a href="../products.php#<?= htmlspecialchars($product['category'] ?? 'twist_drills') ?>"><?= htmlspecialchars($product['category_name'] ?? 'HSS Twist Drills') ?></a></li>
      <li class="breadcrumb-separator">&rsaquo;</li>
      <li class="breadcrumb-current" aria-current="page"><?= htmlspecialchars($product['title']) ?></li>
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
          
          <div class="gallery-stage" id="galleryStage">
            <div class="gallery-badges-strip">
              <span class="gallery-badge gallery-badge-red"><?= htmlspecialchars($product['brand'] ?? 'DAGGER BRAND') ?></span>
              <span class="gallery-badge gallery-badge-charcoal"><?= htmlspecialchars($product['standard'] ?? 'IS : 5101') ?></span>
              <span class="gallery-badge gallery-badge-charcoal">HSN <?= htmlspecialchars($product['hsn_code'] ?? '8207') ?></span>
            </div>

            <img 
              src="<?= htmlspecialchars($main_img_url) ?>" 
              alt="<?= htmlspecialchars($product['title']) ?>" 
              id="galleryMainImage" 
              class="gallery-main-image"
              onerror="this.src='../assets/images/products/gallery_view_1.jpg'"
            >

            <button type="button" class="gallery-zoom-btn" id="galleryZoomBtn" aria-label="Zoom Product Image" title="Zoom Product Photograph">
              <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
            </button>
          </div>

          <!-- Gallery Thumbnails Strip -->
          <div class="gallery-thumbnails-row">
            <?php foreach ($gallery_images as $gidx => $gimg): 
              $thumb_url = '../' . ltrim($gimg, '/');
            ?>
              <button 
                type="button" 
                class="gallery-thumb-btn <?= $gidx === 0 ? 'is-active' : '' ?>" 
                data-full-img="<?= htmlspecialchars($thumb_url) ?>"
                data-caption="<?= htmlspecialchars($product['title']) ?> - View <?= $gidx + 1 ?>"
                aria-label="View Product Angle <?= $gidx + 1 ?>"
              >
                <img src="<?= htmlspecialchars($thumb_url) ?>" alt="" onerror="this.src='../assets/images/products/gallery_thumb_1.jpg'">
              </button>
            <?php endforeach; ?>
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
            <span class="brand-text-red"><?= htmlspecialchars(strtoupper($product['brand'] ?? 'DAGGER BRAND • BIRLA PRECISION')) ?></span>
            <span class="std-pill">Standard: <?= htmlspecialchars($product['standard'] ?? 'IS : 5101 / ISO 235') ?></span>
            <span class="std-pill">HSN Code: <?= htmlspecialchars($product['hsn_code'] ?? '8207') ?></span>
          </div>
          <h1 class="product-page-title"><?= htmlspecialchars($product['title']) ?></h1>
          <p class="product-lead-desc">
            <?= htmlspecialchars($product['description'] ?? 'Precision engineered industrial tooling conforming strictly to national and international manufacturing specifications.') ?>
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
                  placeholder="Select or type size (e.g. <?= htmlspecialchars($popular_sizes[0] ?? '3.00') ?>)" 
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
              <?php foreach ($popular_sizes as $pop_s): ?>
                <button type="button" class="popular-size-pill" data-val="<?= htmlspecialchars($pop_s) ?>"><?= htmlspecialchars($pop_s) ?></button>
              <?php endforeach; ?>
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

<!-- Technical Details Tab Section -->
<?php if (!empty($product['full_details'])): ?>
<section style="background:#FFF;padding:50px 0;border-top:1px solid #E5E7EB;border-bottom:1px solid #E5E7EB;">
  <div class="container" style="max-width:960px;">
    <h3 style="font-size:22px;font-weight:700;color:#111827;margin-bottom:16px;">Engineering &amp; Manufacturing Overview</h3>
    <div style="font-size:15px;line-height:1.7;color:#374151;white-space:pre-line;">
      <?= htmlspecialchars($product['full_details']) ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Gallery Lightbox Modal -->
<div class="gallery-lightbox-modal" id="galleryLightboxModal" aria-hidden="true" role="dialog">
  <div class="lightbox-backdrop" id="lightboxBackdrop"></div>
  <div class="lightbox-dialog">
    <button type="button" class="lightbox-close-btn" id="lightboxCloseBtn" aria-label="Close Lightbox">&times;</button>
    <div class="lightbox-body">
      <img src="<?= htmlspecialchars($main_img_url) ?>" alt="Enlarged Product Photograph" id="lightboxImage" class="lightbox-image">
    </div>
    <div class="lightbox-footer">
      <span class="lightbox-caption" id="lightboxCaption"><?= htmlspecialchars($product['title']) ?></span>
    </div>
  </div>
</div>

<!-- Dynamic Injection of Product Specific Sizes for product.js -->
<script>
  window.__BPTL_CURRENT_PRODUCT_ID = <?= json_encode((int)$product['id']) ?>;
  window.__BPTL_CURRENT_PRODUCT_TITLE = <?= json_encode($product['title']) ?>;
  window.__BPTL_CURRENT_PRODUCT_IMG = <?= json_encode($product['image'] ?? 'assets/images/collections/jobber_drills.png') ?>;
  window.__BPTL_CURRENT_PRODUCT_SIZES = <?= json_encode($formatted_sizes) ?>;
  window.__BPTL_CURRENT_POPULAR_SIZES = <?= json_encode($popular_sizes) ?>;
</script>

<?php
include __DIR__ . '/../includes/footer.php';
?>
