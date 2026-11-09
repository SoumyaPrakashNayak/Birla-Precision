<?php
/**
 * Birla Precision Technologies - Shared Site Header
 * Exact design implementation matching design specifications:
 * - Color Palette: White #FFFFFF, Light Gray #F4F5F6, Charcoal #25292D, Brand Red #D92D30
 * - Typography: Montserrat (Nav links 13-14px wt 600, Headings 30-40px wt 700, Body 15-17px wt 400, Buttons 14-15px wt 600)
 * - 3-Tier Navbar with 3-Column Mega Menu
 */

require_once __DIR__ . '/db.php';

if (!isset($current_page)) {
    $current_page = 'home';
}

$base_url = (isset($is_subfolder) && $is_subfolder) ? '../' : './';

// Fetch dynamic categories tree with subcategories and products
$nav_categories_tree = get_categories_tree(true);
$nav_products = get_all_products();

if (empty($nav_categories_tree)) {
    $nav_categories_tree = [
        [
            'id' => 1,
            'name' => 'HSS Twist Drills',
            'slug' => 'twist_drills',
            'image' => 'assets/images/products/mega_menu_featured_card.png',
            'subcategories' => [
                [
                    'id' => 1,
                    'name' => 'HSS Parallel Shank Twist Drills (Jobber Series)',
                    'slug' => 'jobber-series',
                    'products' => [
                        ['title' => 'HSS Parallel Shank Twist Drills (Jobber Series)', 'slug' => 'parallel-shank-twist-drills']
                    ]
                ]
            ],
            'direct_products' => [],
            'all_products' => [
                ['title' => 'HSS Parallel Shank Twist Drills (Jobber Series)', 'slug' => 'parallel-shank-twist-drills']
            ]
        ]
    ];
}
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
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/main.css?v=<?php echo file_exists(__DIR__ . '/../assets/css/main.css') ? filemtime(__DIR__ . '/../assets/css/main.css') : '1.0'; ?>">
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/aos.css">
  <?php if ($current_page === 'home'): ?>
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/home.css?v=<?php echo file_exists(__DIR__ . '/../assets/css/home.css') ? filemtime(__DIR__ . '/../assets/css/home.css') : '1.0'; ?>">
  <?php elseif ($current_page === 'product' || $current_page === 'quotation'): ?>
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/product.css?v=<?php echo file_exists(__DIR__ . '/../assets/css/product.css') ? filemtime(__DIR__ . '/../assets/css/product.css') : '1.0'; ?>">
  <?php elseif ($current_page === 'products'): ?>
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/products.css?v=<?php echo file_exists(__DIR__ . '/../assets/css/products.css') ? filemtime(__DIR__ . '/../assets/css/products.css') : '1.0'; ?>">
  <?php endif; ?>
</head>
<body>

  <!-- Site Header -->
  <header class="site-header" id="siteHeader">

    <!-- Main Header Bar -->
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

        <!-- Center Navigation Links (Home, Products, About Us, Contact) -->
        <nav class="header-nav-center" aria-label="Main Navigation">
          <ul class="nav-menu-bar">
            
            <!-- Home Link -->
            <li class="nav-bar-item <?php echo ($current_page === 'home') ? 'is-active' : ''; ?>">
              <a href="<?php echo $base_url; ?>index.php" class="nav-bar-link">Home</a>
            </li>

            <!-- Products Mega Menu Link (Fully Dynamic Categories, Subcategories & Products) -->
            <li class="nav-bar-item has-mega <?php echo ($current_page === 'products' || $current_page === 'product') ? 'is-active' : ''; ?>" id="productsNavItem">
              <a href="<?php echo $base_url; ?>products.php" class="nav-bar-link" id="productsMenuTrigger" aria-haspopup="true" aria-expanded="false">
                <span>Products</span>
                <svg class="nav-arrow-icon" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
              </a>

              <!-- 3-Column Mega Menu Panel -->
              <div class="mega-menu-card" id="productsMegaMenuCard" aria-label="Products Catalog Menu">
                <div class="mega-menu-inner">
                  
                  <!-- Column 1: Listed Categories (Dynamic) -->
                  <div class="mega-column mega-col-categories">
                    <div class="mega-subseries-heading" style="font-size:11px;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:0.8px;padding:4px 12px 8px;">Listed Categories</div>
                    <ul class="mega-list">
                      <?php 
                      $cat_idx = 0;
                      foreach ($nav_categories_tree as $c_item): 
                          $target_key = 'cat-' . preg_replace('/[^a-zA-Z0-9_-]/', '', $c_item['slug'] ?: (string)$c_item['id']);
                          $is_active_cat = ($cat_idx === 0) ? 'is-active-cat' : '';
                          $cat_idx++;
                      ?>
                        <li class="mega-item <?= $is_active_cat ?>" data-target="<?= $target_key ?>">
                          <a href="<?php echo $base_url; ?>products.php?cat=<?= urlencode($c_item['slug']); ?>" class="mega-item-link">
                            <span><?= htmlspecialchars($c_item['name']); ?></span>
                            <svg class="chevron-arrow" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
                          </a>
                        </li>
                      <?php endforeach; ?>
                      <li class="mega-item" style="margin-top:8px;padding-top:8px;border-top:1px solid #F1F5F9;">
                        <a href="<?php echo $base_url; ?>products.php" class="mega-item-link" style="color:var(--color-primary);font-weight:700;">
                          <span>All Products Space &rarr;</span>
                        </a>
                      </li>
                    </ul>
                  </div>

                  <!-- Column 2: Specific Subcategories & Products for the Category -->
                  <div class="mega-column mega-col-subseries">
                    <?php 
                    $cat_idx = 0;
                    foreach ($nav_categories_tree as $c_item): 
                        $target_key = 'cat-' . preg_replace('/[^a-zA-Z0-9_-]/', '', $c_item['slug'] ?: (string)$c_item['id']);
                        $grp_style = ($cat_idx === 0) ? '' : 'style="display:none;"';
                        $cat_idx++;
                    ?>
                      <div class="mega-products-group" id="group-<?= $target_key ?>" <?= $grp_style ?>>
                        <div class="mega-subseries-heading"><?= htmlspecialchars($c_item['name']); ?></div>
                        <ul class="mega-list">
                          <?php 
                          $has_subs = !empty($c_item['subcategories']);
                          $sub_idx = 0;

                          if ($has_subs):
                            foreach ($c_item['subcategories'] as $s_item):
                              $sub_idx++;
                              $sub_active = ($sub_idx === 1) ? 'is-active-sub' : '';
                              // Destination URL logic
                              $first_prod = !empty($s_item['products']) ? $s_item['products'][0] : null;
                              if ($first_prod && $first_prod['slug'] === 'parallel-shank-twist-drills') {
                                  $s_url = $base_url . 'products/parallel-shank-twist-drills.php';
                              } elseif ($first_prod) {
                                  $s_url = $base_url . 'products/view.php?slug=' . urlencode($first_prod['slug']);
                              } else {
                                  $s_url = $base_url . 'products.php?subcat=' . urlencode($s_item['slug']);
                              }
                          ?>
                              <li class="mega-item <?= $sub_active ?>">
                                <a href="<?= $s_url ?>" class="mega-item-link" title="<?= htmlspecialchars($s_item['name']) ?>">
                                  <span><?= htmlspecialchars($s_item['name']); ?></span>
                                  <svg class="chevron-arrow" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
                                </a>
                              </li>
                            <?php endforeach; ?>
                          <?php endif; ?>

                          <?php 
                          // If there are subcategories, only show direct products that do NOT belong to any subcategory
                          // If there are no subcategories, show all direct products
                          $direct_to_show = [];
                          if (!empty($c_item['direct_products'])) {
                            foreach ($c_item['direct_products'] as $p_item) {
                              if ($has_subs && !empty($p_item['subcategory_id'])) {
                                continue; // already represented by its subcategory
                              }
                              $direct_to_show[] = $p_item;
                            }
                          }
                          if (!empty($direct_to_show)):
                            foreach ($direct_to_show as $p_item):
                              $p_url = ($p_item['slug'] === 'parallel-shank-twist-drills')
                                  ? $base_url . 'products/parallel-shank-twist-drills.php'
                                  : $base_url . 'products/view.php?slug=' . urlencode($p_item['slug']);
                          ?>
                              <li class="mega-item">
                                <a href="<?= $p_url ?>" class="mega-item-link" title="<?= htmlspecialchars($p_item['title']) ?>">
                                  <span><?= htmlspecialchars($p_item['title']); ?></span>
                                  <svg class="chevron-arrow" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
                                </a>
                              </li>
                            <?php endforeach; ?>
                          <?php endif; ?>

                          <?php if (empty($c_item['subcategories']) && empty($direct_to_show)): ?>
                            <li class="mega-item" style="padding:10px 12px;color:#94A3B8;font-size:13px;">
                              No products listed under this category yet.
                            </li>
                          <?php endif; ?>
                        </ul>
                      </div>
                    <?php endforeach; ?>
                  </div>

                  <!-- Column 3: Featured Visual Card (Dynamic per Category) -->
                  <div class="mega-column mega-col-featured">
                    <?php 
                    $cat_idx = 0;
                    foreach ($nav_categories_tree as $c_item): 
                        $target_key = 'cat-' . preg_replace('/[^a-zA-Z0-9_-]/', '', $c_item['slug'] ?: (string)$c_item['id']);
                        $card_style = ($cat_idx === 0) ? '' : 'style="display:none;"';
                        $cat_idx++;
                        $card_img = !empty($c_item['image']) ? $base_url . $c_item['image'] : $base_url . 'assets/images/products/mega_menu_featured_card.png';
                    ?>
                      <div class="mega-featured-card-wrapper" id="feat-<?= $target_key ?>" <?= $card_style ?>>
                        <a href="<?php echo $base_url; ?>products.php?cat=<?= urlencode($c_item['slug']); ?>" class="mega-featured-card-link" title="Explore <?= htmlspecialchars($c_item['name']); ?>">
                          <img 
                            src="<?= htmlspecialchars($card_img) ?>" 
                            alt="<?= htmlspecialchars($c_item['name']); ?> - Birla Precision" 
                            class="mega-featured-card-img"
                            onerror="this.src='<?php echo $base_url; ?>assets/images/products/mega_menu_featured_card.png'"
                          >
                        </a>
                      </div>
                    <?php endforeach; ?>
                  </div>

                </div>
              </div>
            </li>

            <!-- About Us -->
            <li class="nav-bar-item">
              <a href="<?php echo $base_url; ?>index.php#about" class="nav-bar-link">About Us</a>
            </li>

            <!-- Contact -->
            <li class="nav-bar-item">
              <a href="<?php echo $base_url; ?>quotation.php" class="nav-bar-link">Contact</a>
            </li>

          </ul>
        </nav>

        <!-- Right Action Items: Login Profile & Shopping Cart Only -->
        <div class="header-action-group">
          
          <!-- User Profile / LOGIN matching Image 2 reference design -->
          <a href="#login" class="nav-profile-login-link" id="navLoginBtn" title="Customer & Distributor Login">
            <svg class="nav-profile-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span class="nav-login-label">LOGIN</span>
          </a>

          <!-- User Profile Pill after Login (Matching User Reference: [S] Hi, Soumya v) -->
          <div class="nav-user-dropdown-wrap" id="navUserDropdownWrap" style="display:none;">
            <button type="button" class="nav-user-pill-btn" id="navUserPillBtn" aria-label="User Account Menu" aria-haspopup="true" aria-expanded="false">
              <span class="user-pill-avatar" id="userPillAvatar">S</span>
              <span class="user-pill-name" id="userPillName">Hi, Soumya</span>
              <svg class="user-pill-chevron" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"></polyline>
              </svg>
            </button>
            
            <!-- User Dropdown Menu -->
            <div class="nav-user-dropdown-menu" id="navUserDropdownMenu">
              <div class="dropdown-user-header">
                <div class="dropdown-user-avatar" id="dropdownUserAvatar">S</div>
                <div class="dropdown-user-meta">
                  <strong class="dropdown-user-fullname" id="dropdownUserFullName">Soumya</strong>
                  <span class="dropdown-user-role" id="dropdownUserRole">Distributor Account</span>
                </div>
              </div>
              <div class="dropdown-menu-divider"></div>
              <a href="#cart" class="dropdown-menu-item" id="dropdownCartAction">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle>
                  <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span>Commercial Cart & Orders</span>
              </a>
              <a href="<?php echo $base_url; ?>index.php#catalogue" class="dropdown-menu-item">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                  <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                </svg>
                <span>2026 Price List & Catalogue</span>
              </a>
              <div class="dropdown-menu-divider"></div>
              <button type="button" class="dropdown-menu-item dropdown-logout-btn" id="navLogoutBtn">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                  <polyline points="16 17 21 12 16 7"></polyline>
                  <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span>Sign Out</span>
              </button>
            </div>
          </div>

          <!-- Shopping Cart Icon with Badge Counter matching Image 2 reference design -->
          <button type="button" class="nav-cart-btn" id="navCartBtn" aria-label="View Shopping Cart" title="Shopping Cart">
            <svg class="nav-cart-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="9" cy="21" r="1"></circle>
              <circle cx="20" cy="21" r="1"></circle>
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <span class="nav-cart-badge" id="navCartBadge" style="display:none;">0</span>
          </button>

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
        <li><a href="<?php echo $base_url; ?>products.php" style="color:var(--color-primary);font-weight:700;">ALL PRODUCTS CATALOGUE</a></li>
        <?php foreach ($nav_categories_tree as $c_item): ?>
          <li style="margin-top:10px;padding-top:10px;border-top:1px solid #F1F5F9;">
            <a href="<?php echo $base_url; ?>products.php?cat=<?= urlencode($c_item['slug']); ?>" style="font-weight:700;color:#1E293B;">
              📁 <?= htmlspecialchars(strtoupper($c_item['name'])); ?>
            </a>
          </li>
          <?php if (!empty($c_item['subcategories'])): ?>
            <?php foreach ($c_item['subcategories'] as $s_item): ?>
              <?php 
                $first_prod = !empty($s_item['products']) ? $s_item['products'][0] : null;
                $s_url = ($first_prod && $first_prod['slug'] === 'parallel-shank-twist-drills')
                    ? $base_url . 'products/parallel-shank-twist-drills.php'
                    : ($first_prod ? $base_url . 'products/view.php?slug=' . urlencode($first_prod['slug']) : $base_url . 'products.php?subcat=' . urlencode($s_item['slug']));
              ?>
              <li style="padding-left:16px;">
                <a href="<?= $s_url ?>"><?= htmlspecialchars($s_item['name']); ?></a>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>
        <?php endforeach; ?>
        <li style="margin-top:10px;padding-top:10px;border-top:1px solid #F1F5F9;"><a href="<?php echo $base_url; ?>index.php#about">ABOUT BIRLA PRECISION (SINCE 1937)</a></li>
        <li><a href="<?php echo $base_url; ?>quotation.php">CONTACT</a></li>
      </ul>
      <div style="margin-top:24px;padding-top:20px;border-top:1px solid #E5E7EB;color:#555;font-size:0.85rem;">
        <p style="margin-bottom:6px;"><strong style="color:#25292D;">Direct Support:</strong> +91 253 2352315</p>
        <p style="margin-bottom:6px;"><strong style="color:#25292D;">Email:</strong> info@birlaprecision.com</p>
      </div>
    </div>
  </div>
