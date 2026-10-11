<?php
/**
 * Birla Precision Technologies - Shared Site Footer
 * Comprehensive Industrial Footer with verified corporate information
 */
$base_url = (isset($is_subfolder) && $is_subfolder) ? '../' : './';
?>
  <!-- Site Footer -->
  <footer class="site-footer" id="siteFooter">
    <div class="container">
      
      <div class="footer-grid">
        
        <!-- Column 1: Brand & Heritage -->
        <div class="footer-col">
          <img src="<?php echo $base_url; ?>assets/images/brand/birla_precision_logo.png" alt="Birla Precision" class="footer-brand-logo">
          <p class="footer-text">
            Birla Precision Technologies Limited (BPTL) stands as one of India's most trusted tooling solution providers, with a legacy dating back to 1937 when Indian Tool Manufacturers (ITM) pioneered the manufacture of High-Speed Steel cutting tools.
          </p>
          <p class="footer-text" style="font-size:0.8rem;color:#78909C;">
            Three state-of-the-art manufacturing plants at Nashik, Aurangabad, and Chalisgaon. Serving customers across 50+ countries.
          </p>
          <a href="https://www.birlaprecision.com" target="_blank" rel="noopener" class="footer-link" style="color:var(--color-primary-light);font-weight:600;">
            Visit Official Portal: birlaprecision.com &rarr;
          </a>
        </div>

        <!-- Column 2: Navigation Links -->
        <div class="footer-col">
          <h4 class="footer-col-title">Navigation</h4>
          <ul class="footer-links-list">
            <li><a href="<?php echo $base_url; ?>index.php" class="footer-link">Home</a></li>
            <li><a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php" class="footer-link">Parallel Shank Jobber Drills</a></li>
            <li><a href="<?php echo $base_url; ?>index.php#about" class="footer-link">About Company & Heritage</a></li>
            <li><a href="<?php echo $base_url; ?>index.php#applications" class="footer-link">Industrial Applications</a></li>
            <li><a href="<?php echo $base_url; ?>index.php#catalogue" class="footer-link">April 2026 Price List</a></li>
            <li><a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php#enquiry" class="footer-link">Request Updated Quote</a></li>
          </ul>
        </div>

        <!-- Column 3: Product Family & Variants -->
        <div class="footer-col">
          <h4 class="footer-col-title">Drill Programme</h4>
          <ul class="footer-links-list">
            <li>
              <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php" class="footer-link" style="color:#FFF;font-weight:600;">
                HSS Parallel Shank Twist Drills
              </a>
            </li>
            <li><a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php?variant=itm_std" class="footer-link">ITM STD. (HSS M2)</a></li>
            <li><a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php?variant=itm_std_tin" class="footer-link">ITM STD. TIN (TiN Gold Coated)</a></li>
            <li><a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php?variant=panther" class="footer-link">PANTHER (CNC Point Geometry)</a></li>
            <li><a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php?variant=ninja" class="footer-link">NINJA (HSS M35 Cobalt)</a></li>
            <li><a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php?variant=forgeline" class="footer-link">FORGELINE (Forged Steel & Cast Iron)</a></li>
            <li><a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php?variant=hathyar" class="footer-link">HATHYAR (Heavy Duty Workshop)</a></li>
          </ul>
        </div>

        <!-- Column 4: Verified Contact & Corporate Office -->
        <div class="footer-col">
          <h4 class="footer-col-title">Corporate & Sales</h4>
          
          <div class="footer-contact-item">
            <svg class="footer-contact-icon" viewBox="0 0 24 24">
              <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
            </svg>
            <div class="footer-contact-content">
              <strong>Registered Office</strong>
              <p>Dalamal House, 1st Floor, Jamnalal Bajaj Marg, Nariman Point, Mumbai, Maharashtra 400021</p>
            </div>
          </div>

          <div class="footer-contact-item">
            <svg class="footer-contact-icon" viewBox="0 0 24 24">
              <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
            </svg>
            <div class="footer-contact-content">
              <strong>Customer Care / Sales</strong>
              <p>(0253) 2352315</p>
            </div>
          </div>

          <div class="footer-contact-item">
            <svg class="footer-contact-icon" viewBox="0 0 24 24">
              <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
            </svg>
            <div class="footer-contact-content">
              <strong>Email Inquiries</strong>
              <p><a href="mailto:info@birlaprecision.com" style="color:#FFF;">info@birlaprecision.com</a></p>
            </div>
          </div>

        </div>

      </div>

      <!-- Bottom Bar -->
      <div class="footer-bottom">
        <div>
          <p>&copy; <?php echo date('Y'); ?> Birla Precision Technologies Limited. All Rights Reserved.</p>
          <p style="font-size:0.75rem;color:#78909C;margin-top:4px;">
            Catalogue prices shown are base prices per 10 pieces as per the 01/04/2026 Price List. Applicable GST & taxes extra.
          </p>
        </div>
        <div>
          <button type="button" class="footer-back-to-top" id="footerBackToTopBtn" aria-label="Back to Top">
            Back to Top
            <svg viewBox="0 0 24 24">
              <path d="M7.41 15.41L12 10.83l4.59 4.58L18 14l-6-6-6 6z"/>
            </svg>
          </button>
        </div>
      </div>

    </div>
  </footer>

  <!-- Slide-out Cart Drawer -->
  <div class="cart-drawer-overlay" id="cartDrawerOverlay"></div>
  <!-- Commercial Cart Slide-out Drawer (Matching Image 2 Reference Design) -->
  <aside class="cart-slide-drawer" id="cartSlideDrawer" aria-label="Shopping Cart">
    
    <!-- Drawer Header matching Image 2 Reference (Dark Header with drill graphic & red cart) -->
    <div class="cart-drawer-header">
      <div class="cart-header-left-col">
        <div class="cart-header-icon-box">
          <svg viewBox="0 0 24 24" class="cart-red-icon" fill="currentColor">
            <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
          </svg>
        </div>
        <div class="cart-header-title-wrap">
          <h3 class="cart-drawer-main-title">Commercial Cart</h3>
          <span class="cart-drawer-subtitle" id="cartDrawerCount">0 Products (0 pcs)</span>
        </div>
      </div>
      <div class="cart-header-right-col">
        <span class="cart-header-tagline">PRECISION TOOLS<br>FOR INDUSTRY</span>
        <button type="button" class="cart-drawer-close" id="cartDrawerClose" aria-label="Close Cart">
          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
      </div>
    </div>

    <!-- Cart Body (Scrollable items list) -->
    <div class="cart-drawer-body" id="cartDrawerBody">
      <!-- Empty state -->
      <div class="cart-empty-state" id="cartEmptyState">
        <div class="cart-empty-icon-box">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
          </svg>
        </div>
        <h4>Your Cart is Empty</h4>
        <p>Explore our HSS Parallel Shank Twist Drills (Jobber Series) catalogue and add required diameters based on Minimum Order Quantities (MOQ).</p>
        <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php" class="btn btn-primary" style="margin-top:12px;">
          Configure Jobber Drills &rarr;
        </a>
      </div>

      <!-- Rendered Items List -->
      <div class="cart-items-list" id="cartItemsList" style="display:none;"></div>

      <!-- Apply Coupon Accordion (matching Image 2 Reference) -->
      <div class="cart-coupon-accordion" id="cartCouponAccordion" style="display:none;">
        <button type="button" class="coupon-accordion-header" id="couponToggleBtn">
          <div class="coupon-header-left">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="coupon-tag-icon">
              <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
              <line x1="7" y1="7" x2="7.01" y2="7"></line>
            </svg>
            <span class="coupon-accordion-title">Apply Coupon <span class="coupon-opt-tag">(Optional)</span></span>
          </div>
          <svg viewBox="0 0 24 24" width="16" height="16" class="coupon-chevron" id="couponChevron" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="coupon-accordion-body" id="couponAccordionBody" style="display:none;">
          <div class="coupon-input-group">
            <input type="text" id="couponCodeInput" class="coupon-code-input" placeholder="Enter coupon code (e.g. BIRLA10)">
            <button type="button" class="coupon-apply-action-btn" id="couponApplyBtn">Apply</button>
          </div>
          <div class="coupon-feedback-msg" id="couponFeedback" style="display:none;"></div>
        </div>
      </div>
    </div>

    <!-- Cart Drawer Footer (matching Image 2 Reference) -->
    <div class="cart-drawer-footer" id="cartDrawerFooter" style="display:none;">
      
      <!-- Estimated Total Row -->
      <div class="cart-summary-total-box">
        <div class="cart-estimated-total-row">
          <span class="estimated-total-label">Estimated Total</span>
          <strong class="estimated-total-value" id="cartDrawerTotal">₹ 0.00</strong>
        </div>
        <p class="cart-tax-notice">Taxes and freight extra as applicable. Commercial pricing based on April 2026 Price List.</p>
      </div>

      <!-- Action Buttons Row (Matching Image 2) -->
      <div class="cart-actions-column">
        <!-- 1. Primary Red Buy Now Button with cart icon & right arrow -->
        <button type="button" class="btn-cart-buy-now" id="cartBuyNowBtn">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="buy-btn-icon">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
          </svg>
          <span>Proceed to Buy / Instant Checkout</span>
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="buy-btn-arrow">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </button>

        <!-- 2. Secondary Request Official PO Quotation Button -->
        <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php#enquiry" class="btn-checkout-quote" id="cartCheckoutQuoteBtn">
          <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="quote-btn-icon">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
          </svg>
          <span>Request Official PO Quotation</span>
        </a>

        <!-- 3. Tertiary Clear Cart Button with Trash Can icon -->
        <button type="button" class="btn-clear-cart" id="cartClearBtn">
          <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
          </svg>
          <span>Clear Cart</span>
        </button>
      </div>

      <!-- Footer Trust Badges Strip (3 items from Image 2) -->
      <div class="cart-trust-badges-strip">
        <div class="cart-trust-item">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
            <polyline points="9 12 11 14 15 10"></polyline>
          </svg>
          <span>Secure &amp; Reliable</span>
        </div>
        <div class="cart-trust-item">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="1" y="3" width="15" height="13"></rect>
            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
            <circle cx="5.5" cy="18.5" r="2.5"></circle>
            <circle cx="18.5" cy="18.5" r="2.5"></circle>
          </svg>
          <span>Pan India Delivery</span>
        </div>
        <div class="cart-trust-item">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
          </svg>
          <span>Bulk &amp; Institutional Orders</span>
        </div>
      </div>

    </div>
  </aside>

  <!-- Instant Checkout / Commercial Order Modal (Image 2 Reference) -->
  <div class="checkout-modal-overlay" id="checkoutModalOverlay"></div>
  <div class="checkout-modal" id="checkoutModal" role="dialog" aria-modal="true" aria-labelledby="checkoutModalTitle">
    
    <!-- Top Header Banner with Workshop Background, Logo, Badges & Stepper -->
    <div class="checkout-modal-header-banner">
      <button type="button" class="checkout-modal-close" id="checkoutModalClose" aria-label="Close Checkout">&times;</button>
      
      <div class="checkout-banner-content">
        <div class="checkout-banner-top-row">
          <div class="checkout-brand-group">
            <img src="<?php echo $base_url; ?>assets/images/brand/birla_precision_logo.png" alt="Birla Precision Technologies" class="checkout-brand-logo">
            <span class="checkout-factory-badge">
              <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
              </svg>
              Direct Factory Checkout
            </span>
          </div>
          <div class="checkout-dagger-tag">
            <span class="dagger-tag-title">DAGGER BRAND</span>
            <span class="dagger-tag-sub">SINCE 1937</span>
            <div class="dagger-tag-accent"></div>
          </div>
        </div>

        <div class="checkout-banner-title-wrap">
          <h3 id="checkoutModalTitle" class="checkout-banner-heading">Commercial Purchase Order Checkout</h3>
          <p class="checkout-banner-subtitle">
            Place your order with official tax invoice, dispatch tracking, and authentic IS:5101 certified products.
          </p>
        </div>

        <!-- 3-Step Progress Indicator -->
        <div class="checkout-stepper-progress">
          <div class="step-indicator-item is-active">
            <div class="step-indicator-num">1</div>
            <span class="step-indicator-label">Order Details</span>
          </div>
          <div class="step-indicator-divider is-active"></div>
          <div class="step-indicator-item">
            <div class="step-indicator-num">2</div>
            <span class="step-indicator-label">Buyer Information</span>
          </div>
          <div class="step-indicator-divider"></div>
          <div class="step-indicator-item">
            <div class="step-indicator-num">3</div>
            <span class="step-indicator-label">Payment &amp; Confirm</span>
          </div>
        </div>
      </div>
    </div>

    <!-- 2-Column Body Content -->
    <div class="checkout-modal-body" id="checkoutModalBody">
      <div class="checkout-grid-container">
        
        <!-- Left Column: Order Summary, Commercial Buyer Details & Payment Terms -->
        <div class="checkout-col-main">
          <form id="checkoutForm">
            
            <!-- 1. Order Summary Card -->
            <div class="co-section-card">
              <div class="co-section-header">
                <div class="co-header-title">
                  <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" class="co-red-icon">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                  </svg>
                  <h4>Order Summary</h4>
                </div>
                <button type="button" class="co-edit-cart-link" id="checkoutEditCartBtn">
                  <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                  <span id="coEditCartText">Edit Cart (1 item)</span>
                </button>
              </div>

              <!-- Dynamic Product Items Container -->
              <div class="co-items-list" id="checkoutItemsPreview"></div>

              <!-- Summary Totals Table -->
              <div class="co-totals-breakdown">
                <div class="co-total-line">
                  <span>Catalogue Subtotal</span>
                  <strong id="checkoutSubtotal">₹ 0.00</strong>
                </div>
                <div class="co-total-line">
                  <span>Applicable GST (18%)</span>
                  <strong id="checkoutGst">₹ 0.00</strong>
                </div>
                <div class="co-total-line">
                  <span class="line-label-with-tooltip">
                    Freight &amp; Insurance
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                  </span>
                  <span class="co-text-for">F.O.R. Included</span>
                </div>
                <div class="co-total-line co-grand-payable-row">
                  <span class="co-payable-label">Total Payable Amount</span>
                  <strong class="co-payable-amount" id="checkoutGrandTotal">₹ 0.00</strong>
                </div>
              </div>

              <!-- Blue Callout Notice -->
              <div class="co-tax-alert-callout">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="12" cy="12" r="10"></circle>
                  <line x1="12" y1="16" x2="12" y2="12"></line>
                  <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
                <span>Final tax invoice will be issued with applicable GST and dispatch details.</span>
              </div>
            </div>

            <!-- 2. Commercial Buyer Details Card -->
            <div class="co-section-card">
              <div class="co-section-header">
                <div class="co-header-title">
                  <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" class="co-red-icon">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                  </svg>
                  <h4>Commercial Buyer Details</h4>
                </div>
                <span class="co-required-badge">All fields are required *</span>
              </div>

              <div class="co-form-grid">
                <div class="co-form-row co-row-2col">
                  <div class="form-group">
                    <label class="form-label" for="coCompanyName">Company / Firm Name *</label>
                    <div class="input-with-icon">
                      <svg viewBox="0 0 24 24" class="input-prefix-icon" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 21h18M9 8h1m-1 4h1m-1 4h1m4-8h1m-1 4h1m-1 4h1M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"></path>
                      </svg>
                      <input type="text" id="coCompanyName" class="portal-input" placeholder="e.g. Apex Industrial Solutions Pvt. Ltd." required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="coGstin">GSTIN Number *</label>
                    <div class="input-with-icon">
                      <svg viewBox="0 0 24 24" class="input-prefix-icon" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                      </svg>
                      <input type="text" id="coGstin" class="portal-input" placeholder="e.g. 27AAACB1234F1Z5" required>
                    </div>
                  </div>
                </div>

                <div class="co-form-row co-row-2col">
                  <div class="form-group">
                    <label class="form-label" for="coContactName">Contact Person *</label>
                    <div class="input-with-icon">
                      <svg viewBox="0 0 24 24" class="input-prefix-icon" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                      </svg>
                      <input type="text" id="coContactName" class="portal-input" placeholder="e.g. Rajesh Sharma" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="coPhone">Phone / Mobile *</label>
                    <div class="input-with-icon">
                      <svg viewBox="0 0 24 24" class="input-prefix-icon" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                      </svg>
                      <input type="tel" id="coPhone" class="portal-input" placeholder="e.g. +91 98765 43210" required>
                    </div>
                  </div>
                </div>

                <div class="co-form-row">
                  <div class="form-group">
                    <label class="form-label" for="coEmail">Commercial Email *</label>
                    <div class="input-with-icon">
                      <svg viewBox="0 0 24 24" class="input-prefix-icon" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                      </svg>
                      <input type="email" id="coEmail" class="portal-input" placeholder="e.g. procurement@company.com" required>
                    </div>
                  </div>
                </div>

                <div class="co-form-row">
                  <div class="form-group">
                    <label class="form-label" for="coDeliveryAddress">Delivery Plant Address &amp; Pincode *</label>
                    <div class="input-with-icon textarea-icon-wrapper">
                      <svg viewBox="0 0 24 24" class="input-prefix-icon textarea-prefix-icon" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                      </svg>
                      <textarea id="coDeliveryAddress" class="portal-input portal-textarea" rows="2" maxlength="250" placeholder="Plant / Warehouse address for freight and delivery coordination" required></textarea>
                    </div>
                    <div class="textarea-char-count"><span id="addressCharCount">0</span>/250</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 3. Payment / Credit Terms Card -->
            <div class="co-section-card">
              <div class="co-section-header">
                <div class="co-header-title">
                  <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" class="co-red-icon">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                    <line x1="1" y1="10" x2="23" y2="10"></line>
                  </svg>
                  <h4>Payment / Credit Terms</h4>
                </div>
                <span class="co-required-badge">Choose the most convenient option</span>
              </div>

              <div class="co-payment-options-grid">
                <!-- Option 1: Bank Wire -->
                <label class="co-pay-option-card is-active">
                  <input type="radio" name="payMethod" value="neft" checked class="co-radio-input">
                  <div class="co-radio-bullet"></div>
                  <div class="co-pay-icon-box">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                      <line x1="4" y1="21" x2="20" y2="21"></line>
                      <line x1="2" y1="10" x2="22" y2="10"></line>
                      <polygon points="12 2 2 7 22 7"></polygon>
                      <line x1="6" y1="10" x2="6" y2="21"></line>
                      <line x1="10" y1="10" x2="10" y2="21"></line>
                      <line x1="14" y1="10" x2="14" y2="21"></line>
                      <line x1="18" y1="10" x2="18" y2="21"></line>
                    </svg>
                  </div>
                  <div class="co-pay-text">
                    <strong>Bank Wire (RTGS / NEFT)</strong>
                    <span>Immediate dispatch upon wire confirmation</span>
                  </div>
                </label>

                <!-- Option 2: Commercial Credit Line -->
                <label class="co-pay-option-card">
                  <input type="radio" name="payMethod" value="credit" class="co-radio-input">
                  <div class="co-radio-bullet"></div>
                  <div class="co-pay-icon-box">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                      <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                      <line x1="16" y1="2" x2="16" y2="6"></line>
                      <line x1="8" y1="2" x2="8" y2="6"></line>
                      <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                  </div>
                  <div class="co-pay-text">
                    <strong>Commercial Credit Line (30 Days)</strong>
                    <span>Approved BPTL distributor / OEM corporate accounts</span>
                  </div>
                </label>

                <!-- Option 3: Instant Online / UPI Gateway -->
                <label class="co-pay-option-card">
                  <input type="radio" name="payMethod" value="online" class="co-radio-input">
                  <div class="co-radio-bullet"></div>
                  <div class="co-pay-icon-box">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                      <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                      <line x1="1" y1="10" x2="23" y2="10"></line>
                    </svg>
                  </div>
                  <div class="co-pay-text">
                    <strong>Instant Online / UPI Gateway</strong>
                    <span>Corporate Credit Card / NetBanking / UPI</span>
                  </div>
                </label>
              </div>
            </div>

            <!-- Terms Checkbox & Primary Submit Button -->
            <div class="co-submit-section">
              <label class="custom-checkbox-label">
                <input type="checkbox" id="checkoutAgreeTerms" checked required class="custom-checkbox-input">
                <span class="custom-checkbox-box"></span>
                <span class="checkbox-text">
                  I agree to the <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php#enquiry" target="_blank" class="text-red">Terms &amp; Conditions</a> and confirm that the above information is correct.
                </span>
              </label>

              <button type="submit" class="btn-checkout-confirm" id="checkoutSubmitBtn">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5">
                  <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                  <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <span class="btn-submit-text">Confirm &amp; Place Commercial Order</span>
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" class="btn-arrow-icon">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
                <span class="btn-submit-spinner" id="checkoutSpinner" style="display:none;"></span>
              </button>
            </div>
          </form>
        </div>

        <!-- Right Column: Sidebar (Why Order Direct?, Need Assistance?, Large Order?) -->
        <div class="checkout-col-sidebar">
          
          <!-- Card 1: Why Order Direct? -->
          <div class="co-sidebar-card">
            <div class="sidebar-card-title">
              <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#DC2626" stroke-width="2.5">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                <polyline points="9 12 11 14 15 10"></polyline>
              </svg>
              <h5>Why Order Direct?</h5>
            </div>
            <ul class="co-benefits-list">
              <li>
                <div class="benefit-icon-box">
                  <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                </div>
                <div class="benefit-text">
                  <strong>Official Tax Invoice</strong>
                  <span>with GST compliance</span>
                </div>
              </li>
              <li>
                <div class="benefit-icon-box">
                  <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 11 14 15 10"></polyline></svg>
                </div>
                <div class="benefit-text">
                  <strong>Authentic IS:5101</strong>
                  <span>certified products</span>
                </div>
              </li>
              <li>
                <div class="benefit-icon-box">
                  <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                </div>
                <div class="benefit-text">
                  <strong>Real-time Dispatch</strong>
                  <span>Tracking</span>
                </div>
              </li>
              <li>
                <div class="benefit-icon-box">
                  <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                </div>
                <div class="benefit-text">
                  <strong>Dedicated Support</strong>
                  <span>for commercial orders</span>
                </div>
              </li>
            </ul>
          </div>

          <!-- Card 2: Need Assistance? -->
          <div class="co-sidebar-card">
            <div class="sidebar-card-title">
              <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#DC2626" stroke-width="2">
                <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
                <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
              </svg>
              <h5>Need Assistance?</h5>
            </div>
            <p class="sidebar-help-desc">Our team is here to help with pricing, payment terms, and delivery timelines.</p>
            <div class="sidebar-contact-links">
              <a href="tel:+912532352315" class="sidebar-contact-item">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#DC2626" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                <span>+91 253 2352315</span>
              </a>
              <a href="mailto:sales@birlaprecision.com" class="sidebar-contact-item">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#DC2626" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                <span>sales@birlaprecision.com</span>
              </a>
            </div>
          </div>

          <!-- Card 3: Large Order or Custom Requirement? -->
          <div class="co-sidebar-card co-sidebar-custom-card">
            <div class="custom-card-icon-title">
              <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#DC2626" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
              </svg>
              <h5>Large Order or Custom Requirement?</h5>
            </div>
            <p class="custom-card-desc">Contact our sales team for special pricing and customized solutions.</p>
            <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php#enquiry" class="btn-custom-quote">
              <span>Request &amp; Quotation</span>
              <span class="btn-arrow">&rarr;</span>
            </a>
          </div>

        </div>
      </div>
    </div>

    <!-- Success Confirmation State (shown after placing order) -->
    <div class="checkout-success-view" id="checkoutSuccessView" style="display:none;">
      <div class="success-icon-box">
        <svg viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
      </div>
      <h3>Commercial Order Confirmed!</h3>
      <p class="success-po-tag">Purchase Order Reference: <strong id="successPoNumber">BPTL-2026-9842</strong></p>
      <p class="success-desc">
        Thank you for choosing Birla Precision Technologies. An official proforma tax invoice and dispatch tracking timeline have been sent to your commercial email.
      </p>
      <div class="success-actions">
        <button type="button" class="btn-checkout-confirm" id="checkoutDoneBtn" style="max-width:280px; margin: 0 auto;">Done / Continue Browsing</button>
      </div>
    </div>
  </div>

  <!-- Customer & Distributor Login Modal (Image 1 Reference) -->
  <div class="login-modal-overlay" id="loginModalOverlay"></div>
  <div class="login-modal" id="loginModal" role="dialog" aria-modal="true" aria-labelledby="loginModalTitle">
    <button type="button" class="login-modal-close" id="loginModalClose" aria-label="Close Login">&times;</button>
    
    <div class="login-modal-grid">
      <!-- Left Column: Branding, Features & Precision Drill Imagery -->
      <div class="login-grid-left">
        <div class="login-left-content">
          <div class="login-brand-header">
            <img src="<?php echo $base_url; ?>assets/images/brand/birla_precision_logo.png" alt="Birla Precision Technologies" class="login-brand-logo">
          </div>
          
          <div class="login-hero-titles">
            <h2 class="portal-main-heading">Customer &amp;<br>Distributor <span class="text-red">Portal</span></h2>
            <div class="portal-heading-accent"></div>
            <p class="portal-desc">
              Access distributor pricing tiers, real-time dispatch tracking, and manage your commercial orders &mdash; all in one place.
            </p>
          </div>

          <!-- 4 Feature Cards -->
          <div class="portal-features-list">
            <div class="portal-feature-item">
              <div class="feature-icon-pill">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                  <line x1="7" y1="7" x2="7.01" y2="7"></line>
                </svg>
              </div>
              <div class="feature-text">
                <strong>Exclusive Pricing</strong>
                <span>View distributor pricing tiers and offers.</span>
              </div>
            </div>

            <div class="portal-feature-item">
              <div class="feature-icon-pill">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                  <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                  <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
              </div>
              <div class="feature-text">
                <strong>Order Management</strong>
                <span>Place and track commercial orders.</span>
              </div>
            </div>

            <div class="portal-feature-item">
              <div class="feature-icon-pill">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="1" y="3" width="15" height="13"></rect>
                  <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                  <circle cx="5.5" cy="18.5" r="2.5"></circle>
                  <circle cx="18.5" cy="18.5" r="2.5"></circle>
                </svg>
              </div>
              <div class="feature-text">
                <strong>Real-Time Dispatch</strong>
                <span>Track shipments and delivery status.</span>
              </div>
            </div>

            <div class="portal-feature-item">
              <div class="feature-icon-pill">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                  <polyline points="14 2 14 8 20 8"></polyline>
                  <line x1="16" y1="13" x2="8" y2="13"></line>
                  <line x1="16" y1="17" x2="8" y2="17"></line>
                  <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
              </div>
              <div class="feature-text">
                <strong>Sales Support</strong>
                <span>Access catalogues, technical data and support.</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Right overlay graphic with precision drill bits -->
        <div class="login-drills-graphic">
          <img src="<?php echo $base_url; ?>assets/images/products/hss_jobber_drills_showcase.png" alt="Precision Drills" class="login-drills-img">
        </div>
      </div>

      <!-- Right Column: Sign In Form -->
      <div class="login-grid-right">
        <div class="login-form-wrapper">
          <div class="login-right-heading">
            <h3 id="loginModalTitle" class="login-title">Welcome Back</h3>
            <p class="login-subtitle">Sign in to access your distributor account.</p>
          </div>

          <form class="login-portal-form" id="loginForm">
            <div class="form-group">
              <label class="form-label" for="loginEmail">Email / Username / Account Code</label>
              <div class="input-with-icon">
                <svg viewBox="0 0 24 24" class="input-prefix-icon" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                  <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
                <input type="text" id="loginEmail" class="portal-input" placeholder="e.g. Soumya or distributor@birlaprecision.com" value="Soumya" required>
              </div>
            </div>

            <div class="form-group">
              <div class="password-label-row">
                <label class="form-label" for="loginPassword">Password</label>
                <a href="#forgot" class="link-forgot-pw" id="forgotPwLink">Forgot Password?</a>
              </div>
              <div class="input-with-icon">
                <svg viewBox="0 0 24 24" class="input-prefix-icon" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                  <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <input type="password" id="loginPassword" class="portal-input" placeholder="••••••••••••" value="password123" required>
              </div>
            </div>

            <div class="login-remember-row">
              <label class="custom-checkbox-label">
                <input type="checkbox" id="loginRememberCheck" checked class="custom-checkbox-input">
                <span class="custom-checkbox-box"></span>
                <span class="checkbox-text">Remember me on this device</span>
              </label>
            </div>

            <button type="submit" class="btn-portal-submit" id="loginSubmitBtn">
              <span>Sign In to Portal</span>
              <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.5" class="btn-arrow-icon">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </button>

            <div class="portal-divider-row">
              <span>OR</span>
            </div>

            <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php#enquiry" class="btn-dealership-apply">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 21h18M9 8h1m-1 4h1m-1 4h1m4-8h1m-1 4h1m-1 4h1M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"></path>
              </svg>
              <span>Apply for Dealership</span>
              <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </a>

            <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php#enquiry" class="portal-partner-banner">
              <div class="partner-banner-icon">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                  <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                </svg>
              </div>
              <div class="partner-banner-info">
                <strong>New industrial partner?</strong>
                <p>Apply for dealership to access exclusive pricing and partner benefits.</p>
              </div>
              <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" class="partner-arrow">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </a>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Floating WhatsApp Widget (Bottom-Left) -->
  <div class="floating-whatsapp-widget" id="floatingWhatsappWidget">
    <a href="https://wa.me/912532352315?text=Hello%20Birla%20Precision,%20I%20am%20inquiring%20about%20Dagger%20Brand%20HSS%20Jobber%20Drills" target="_blank" rel="noopener" class="floating-wa-btn" aria-label="Chat with us on WhatsApp" title="Chat on WhatsApp">
      <svg viewBox="0 0 24 24" class="wa-icon">
        <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19.01L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.35C9.36 7.35 9.09 7.41 8.85 7.67C8.62 7.94 7.96 8.56 7.96 9.83C7.96 11.1 8.88 12.33 9.01 12.5C9.14 12.67 10.79 15.22 13.33 16.32C15.44 17.23 15.87 17.05 16.33 17.01C16.8 16.96 17.83 16.39 18.05 15.77C18.26 15.15 18.26 14.62 18.2 14.51C18.14 14.4 17.98 14.34 17.74 14.22C17.5 14.1 16.33 13.52 16.11 13.44C15.89 13.36 15.73 13.32 15.57 13.56C15.41 13.8 14.94 14.34 14.8 14.51C14.66 14.67 14.52 14.69 14.28 14.57C14.04 14.45 13.28 14.2 12.37 13.39C11.66 12.76 11.19 11.98 11.05 11.74C10.91 11.5 11.04 11.37 11.16 11.25C11.26 11.15 11.39 10.98 11.51 10.84C11.63 10.7 11.67 10.6 11.75 10.44C11.83 10.28 11.79 10.14 11.73 10.02C11.67 9.9 11.21 8.76 11.01 8.29C10.83 7.83 10.64 7.89 10.49 7.88C10.35 7.88 10.18 7.87 10.02 7.87C9.85 7.87 9.58 7.93 9.53 7.35Z"/>
      </svg>
    </a>
  </div>

  <!-- Floating Move to Top Arrow Button (Bottom-Right, matching Reference Design) -->
  <button type="button" class="floating-top-arrow-btn" id="floatingTopArrowBtn" aria-label="Move to top" title="Move to top">
    <img src="<?php echo $base_url; ?>assets/images/icons/move_to_top_arrow.png" alt="Move to top" class="floating-top-arrow-img">
  </button>

  <!-- Global JavaScript -->
  <script src="<?php echo $base_url; ?>assets/js/main.js?v=<?php echo file_exists(__DIR__ . '/../assets/js/main.js') ? filemtime(__DIR__ . '/../assets/js/main.js') : '1.0'; ?>"></script>
  <?php if ($current_page === 'home'): ?>
    <script src="<?php echo $base_url; ?>assets/js/home.js?v=<?php echo file_exists(__DIR__ . '/../assets/js/home.js') ? filemtime(__DIR__ . '/../assets/js/home.js') : '1.0'; ?>"></script>
  <?php elseif ($current_page === 'product'): ?>
    <script src="<?php echo $base_url; ?>assets/js/product.js?v=<?php echo file_exists(__DIR__ . '/../assets/js/product.js') ? filemtime(__DIR__ . '/../assets/js/product.js') : '1.0'; ?>"></script>
  <?php endif; ?>

</body>
</html>
