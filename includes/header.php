<?php
/**
 * Birla Precision Technologies - Shared Site Header
 * Exact design implementation matching design specifications:
 * - Color Palette: White #FFFFFF, Light Gray #F4F5F6, Charcoal #25292D, Brand Red #D92D30
 * - Typography: Montserrat (Nav links 13-14px wt 600, Headings 30-40px wt 700, Body 15-17px wt 400, Buttons 14-15px wt 600)
 * - 3-Tier Navbar with 3-Column Mega Menu
 */

if (!isset($current_page)) {
    $current_page = 'home';
}

$base_url = (isset($is_subfolder) && $is_subfolder) ? '../' : './';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($page_title ?? 'Birla Precision Technologies | Dagger Brand Industrial Tooling'); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($page_description ?? 'Birla Precision Technologies Limited (BPTL) and Dagger Brand — Precision HSS Parallel Shank Jobber Drills, Industrial Cutting Tools, and Tooling Solutions since 1937.'); ?>">
  
  <!-- Favicon / Branding -->
  <link rel="icon" type="image/png" href="<?php echo $base_url; ?>assets/images/brand/dagger_brand_logo.png">
  
  <!-- Google Fonts: Montserrat (Weights 400, 500, 600, 700, 800) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

  <!-- CSS Stylesheets -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/main.css">
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/aos.css">
  <?php if ($current_page === 'home'): ?>
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/home.css">
  <?php elseif ($current_page === 'product'): ?>
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/product.css">
  <?php endif; ?>
</head>
<body>

  <!-- Site Header (Exact replica of specified design) -->
  <header class="site-header" id="siteHeader">

    <!-- 1. Top Utility Bar (Charcoal #25292D) -->
    <div class="top-utility-bar">
      <div class="container top-utility-inner">
        
        <div class="top-tagline">
          Precision Tools for a Stronger Tomorrow
        </div>

        <div class="top-utility-links">
          <a href="<?php echo $base_url; ?>index.php#catalogue" class="top-util-link">
            <svg class="top-util-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
              <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
            </svg>
            <span>Catalogue (2026)</span>
          </a>

          <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php#enquiry" class="top-util-link">
            <svg class="top-util-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="3"></circle>
              <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
            </svg>
            <span>Technical Support</span>
          </a>

          <a href="tel:+912532352315" class="top-util-link">
            <svg class="top-util-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
            </svg>
            <span>+91 253 2352315</span>
          </a>

          <span class="top-divider">|</span>

          <div class="top-country-btn" title="Country: India">
            <svg class="top-util-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"></path>
              <circle cx="12" cy="10" r="3"></circle>
            </svg>
            <span>India</span>
            <svg class="top-chevron" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
          </div>
        </div>

      </div>
    </div>

    <!-- 2. Main Header Row (White #FFFFFF) -->
    <div class="header-main-row">
      <div class="container header-main-inner">
        
        <!-- Brand Logos -->
        <div class="brand-group">
          <a href="<?php echo $base_url; ?>index.php" class="brand-item-link" title="Birla Precision Technologies Limited">
            <img src="<?php echo $base_url; ?>assets/images/brand/birla_precision_logo.png" alt="Birla Precision Logo" class="brand-birla-logo">
          </a>
          <span class="brand-separator-line"></span>
          <a href="<?php echo $base_url; ?>index.php" class="brand-item-link" title="Dagger Brand Since 1937">
            <img src="<?php echo $base_url; ?>assets/images/brand/dagger_brand_logo.png" alt="Dagger Brand Logo" class="brand-dagger-logo">
          </a>
        </div>

        <!-- Center Search Pill Container -->
        <div class="header-search-wrap">
          <form class="search-pill-container" id="headerSearchForm" action="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php" method="GET">
            
            <div class="search-category-pill">
              <span>Jobber Series</span>
              <svg viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
            </div>

            <div class="search-input-box">
              <svg class="search-glass-icon" viewBox="0 0 24 24">
                <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
              </svg>
              <input 
                type="text" 
                name="dia" 
                id="headerSearchInput" 
                class="search-text-field" 
                placeholder="What are you looking for? (e.g. 6.80 mm, 1/4 inch...)" 
                autocomplete="off"
              >
            </div>

            <button type="submit" class="search-submit-red-btn" aria-label="Search Drills">
              <svg viewBox="0 0 24 24">
                <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
              </svg>
            </button>

          </form>
        </div>

        <!-- Right Action Items: Login Profile, Shopping Cart, Quick Enquiry & Request Quote -->
        <div class="header-action-group">
          
          <!-- User Profile / LOGIN matching Image 2 reference design -->
          <a href="#login" class="nav-profile-login-link" id="navLoginBtn" title="Customer & Distributor Login">
            <svg class="nav-profile-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span class="nav-login-label">LOGIN</span>
          </a>

          <!-- Shopping Cart Icon with Badge Counter matching Image 2 reference design -->
          <button type="button" class="nav-cart-btn" id="navCartBtn" aria-label="View Shopping Cart" title="Shopping Cart">
            <svg class="nav-cart-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="9" cy="21" r="1"></circle>
              <circle cx="20" cy="21" r="1"></circle>
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <span class="nav-cart-badge" id="navCartBadge">0</span>
          </button>

          <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php#enquiry" class="quick-enquiry-link" title="Quick Enquiry">
            <svg class="quick-enquiry-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
              <polyline points="14 2 14 8 20 8"></polyline>
              <line x1="16" y1="13" x2="8" y2="13"></line>
              <line x1="16" y1="17" x2="8" y2="17"></line>
              <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span class="quick-enquiry-text">Quick Enquiry</span>
          </a>

          <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php#enquiry" class="btn-request-quote">
            <span>Request Quote</span>
            <span class="btn-arrow">&rarr;</span>
          </a>

          <!-- Mobile Toggle Button -->
          <button class="nav-mobile-toggle" id="mobileMenuOpen" aria-label="Open Navigation Menu">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="3" y1="12" x2="21" y2="12"></line>
              <line x1="3" y1="6" x2="21" y2="6"></line>
              <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
          </button>

        </div>

      </div>
    </div>

    <!-- 3. Navigation Links Row (White #FFFFFF, bottom border) -->
    <nav class="header-nav-row" aria-label="Main Navigation">
      <div class="container">
        <ul class="nav-menu-bar">
          
          <!-- Home Link (Active with Red Text & Pill Indicator) -->
          <li class="nav-bar-item <?php echo ($current_page === 'home') ? 'is-active' : ''; ?>">
            <a href="<?php echo $base_url; ?>index.php" class="nav-bar-link">Home</a>
          </li>

          <!-- Products Mega Menu Link -->
          <li class="nav-bar-item has-mega <?php echo ($current_page === 'product') ? 'is-active' : ''; ?>" id="productsNavItem">
            <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php" class="nav-bar-link" id="productsMenuTrigger" aria-haspopup="true" aria-expanded="false">
              <span>Products</span>
              <svg class="nav-arrow-icon" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
            </a>

            <!-- 3-Column Mega Menu Panel -->
            <div class="mega-menu-card" id="productsMegaMenuCard" aria-label="Products Catalog Menu">
              <div class="mega-menu-inner">
                
                <!-- Column 1: Drill Categories -->
                <div class="mega-column mega-col-categories">
                  <ul class="mega-list">
                    <li class="mega-item is-active-cat">
                      <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php" class="mega-item-link">
                        <span>HSS Parallel Shank Twist Drills</span>
                        <svg class="chevron-arrow" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
                      </a>
                    </li>
                    <li class="mega-item">
                      <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php" class="mega-item-link">
                        <span>Taper Shank Drills</span>
                        <svg class="chevron-arrow" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
                      </a>
                    </li>
                    <li class="mega-item">
                      <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php" class="mega-item-link">
                        <span>Special Purpose Drills</span>
                        <svg class="chevron-arrow" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
                      </a>
                    </li>
                    <li class="mega-item">
                      <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php" class="mega-item-link">
                        <span>Step Drills</span>
                        <svg class="chevron-arrow" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
                      </a>
                    </li>
                    <li class="mega-item">
                      <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php" class="mega-item-link">
                        <span>Carbide Drills</span>
                        <svg class="chevron-arrow" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
                      </a>
                    </li>
                    <li class="mega-item">
                      <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php" class="mega-item-link">
                        <span>Industrial Tooling</span>
                        <svg class="chevron-arrow" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
                      </a>
                    </li>
                  </ul>
                </div>

                <!-- Column 2: Specific Series Under HSS Parallel Shank -->
                <div class="mega-column mega-col-subseries">
                  <div class="mega-subseries-heading">HSS Parallel Shank Twist Drills</div>
                  <ul class="mega-list">
                    <li class="mega-item is-active-sub">
                      <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php" class="mega-item-link">
                        <span>Jobber Series</span>
                        <span class="active-arrow-red">&rarr;</span>
                      </a>
                    </li>
                    <li class="mega-item">
                      <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php" class="mega-item-link">
                        <span>Stub Series</span>
                        <svg class="chevron-arrow" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
                      </a>
                    </li>
                    <li class="mega-item">
                      <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php" class="mega-item-link">
                        <span>Long Series</span>
                        <svg class="chevron-arrow" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
                      </a>
                    </li>
                    <li class="mega-item">
                      <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php" class="mega-item-link">
                        <span>Extra Long Series</span>
                        <svg class="chevron-arrow" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
                      </a>
                    </li>
                    <li class="mega-item">
                      <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php" class="mega-item-link">
                        <span>Centre Drills</span>
                        <svg class="chevron-arrow" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
                      </a>
                    </li>
                  </ul>
                </div>

                <!-- Column 3: Featured Visual Card -->
                <div class="mega-column mega-col-featured">
                  <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php" class="mega-featured-card-link" title="Explore Jobber Series Drill Programme">
                    <img 
                      src="<?php echo $base_url; ?>assets/images/products/mega_menu_featured_card.png" 
                      alt="Precision Holes Stronger Tomorrow - Birla Precision Jobber Series" 
                      class="mega-featured-card-img"
                    >
                  </a>
                </div>

              </div>
            </div>
          </li>

          <!-- Applications -->
          <li class="nav-bar-item">
            <a href="<?php echo $base_url; ?>index.php#applications" class="nav-bar-link">
              <span>Applications</span>
              <svg class="nav-arrow-icon" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
            </a>
          </li>

          <!-- About Us -->
          <li class="nav-bar-item">
            <a href="<?php echo $base_url; ?>index.php#about" class="nav-bar-link">About Us</a>
          </li>

          <!-- Resources -->
          <li class="nav-bar-item">
            <a href="<?php echo $base_url; ?>index.php#catalogue" class="nav-bar-link">
              <span>Resources</span>
              <svg class="nav-arrow-icon" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
            </a>
          </li>

          <!-- Contact -->
          <li class="nav-bar-item">
            <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php#enquiry" class="nav-bar-link">Contact</a>
          </li>

        </ul>
      </div>
    </nav>

  </header>

  <!-- Mobile Navigation Drawer -->
  <div class="mobile-nav-drawer" id="mobileDrawer">
    <div class="mobile-nav-content">
      <div class="mobile-nav-header">
        <img src="<?php echo $base_url; ?>assets/images/brand/birla_precision_logo.png" alt="Birla Precision" style="height:36px;object-fit:contain;">
        <button class="mobile-close-btn" id="mobileMenuClose" aria-label="Close Navigation Menu">&times;</button>
      </div>
      <ul class="mobile-nav-list">
        <li><a href="<?php echo $base_url; ?>index.php">HOME</a></li>
        <li><a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php" style="color:var(--color-primary);font-weight:700;">PRODUCTS: HSS Parallel Shank (Jobber Series)</a></li>
        <li><a href="<?php echo $base_url; ?>index.php#collection">COLLECTION LIST</a></li>
        <li><a href="<?php echo $base_url; ?>index.php#about">ABOUT BIRLA PRECISION (SINCE 1937)</a></li>
        <li><a href="<?php echo $base_url; ?>index.php#catalogue">APRIL 2026 PRICE LIST</a></li>
        <li><a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php#enquiry">REQUEST QUOTE &amp; CONTACT</a></li>
      </ul>
      <div style="margin-top:24px;padding-top:20px;border-top:1px solid #E5E7EB;color:#555;font-size:0.85rem;">
        <p style="margin-bottom:6px;"><strong style="color:#25292D;">Direct Support:</strong> +91 253 2352315</p>
        <p style="margin-bottom:6px;"><strong style="color:#25292D;">Email:</strong> info@birlaprecision.com</p>
      </div>
    </div>
  </div>
