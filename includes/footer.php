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
          <button type="button" class="back-to-top-btn" id="backToTopBtn" aria-label="Back to Top">
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

  <!-- Instant Checkout / Commercial Order Modal -->
  <div class="checkout-modal-overlay" id="checkoutModalOverlay"></div>
  <div class="checkout-modal" id="checkoutModal" role="dialog" aria-modal="true" aria-labelledby="checkoutModalTitle">
    <button type="button" class="checkout-modal-close" id="checkoutModalClose" aria-label="Close Checkout">&times;</button>
    <div class="checkout-modal-header">
      <div class="checkout-badge-row">
        <span class="checkout-secure-badge">
          <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
          Birla Precision Direct Factory Checkout
        </span>
      </div>
      <h3 id="checkoutModalTitle">Commercial Purchase Order Checkout</h3>
      <p>Direct factory procurement with official tax invoice, dispatch tracking, and authentic IS:5101 certification.</p>
    </div>

    <div class="checkout-modal-body" id="checkoutModalBody">
      <!-- Order Summary Card -->
      <div class="checkout-order-summary">
        <h4 class="checkout-subhead">Order Summary</h4>
        <div class="checkout-items-preview" id="checkoutItemsPreview"></div>
        <div class="checkout-totals-box">
          <div class="checkout-row">
            <span>Catalogue Subtotal</span>
            <strong id="checkoutSubtotal">₹ 0.00</strong>
          </div>
          <div class="checkout-row">
            <span>Applicable GST (18%)</span>
            <span id="checkoutGst">₹ 0.00</span>
          </div>
          <div class="checkout-row">
            <span>Freight &amp; Insurance</span>
            <span class="text-free-shipping">F.O.R. Included</span>
          </div>
          <div class="checkout-row checkout-grand-total">
            <span>Total Payable Amount</span>
            <strong id="checkoutGrandTotal">₹ 0.00</strong>
          </div>
        </div>
      </div>

      <!-- Commercial Buyer Details Form -->
      <form class="checkout-form" id="checkoutForm">
        <h4 class="checkout-subhead">Commercial Buyer Details</h4>
        <div class="form-row-2col">
          <div class="form-group">
            <label class="form-label" for="coCompanyName">Company / Firm Name *</label>
            <input type="text" id="coCompanyName" class="form-control" placeholder="e.g. Apex Industrial Solutions Pvt Ltd" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="coGstin">GSTIN Number *</label>
            <input type="text" id="coGstin" class="form-control" placeholder="e.g. 27AAACB1234F1Z5" required>
          </div>
        </div>
        <div class="form-row-2col">
          <div class="form-group">
            <label class="form-label" for="coContactName">Contact Person *</label>
            <input type="text" id="coContactName" class="form-control" placeholder="e.g. Rajesh Sharma" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="coPhone">Phone / Mobile *</label>
            <input type="tel" id="coPhone" class="form-control" placeholder="e.g. +91 98765 43210" required>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label" for="coEmail">Commercial Email *</label>
          <input type="email" id="coEmail" class="form-control" placeholder="e.g. procurement@company.com" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="coDeliveryAddress">Delivery Plant Address &amp; Pincode *</label>
          <textarea id="coDeliveryAddress" class="form-control" rows="2" placeholder="Plant / Warehouse address for freight dispatch" required></textarea>
        </div>

        <!-- Payment Method Selection -->
        <h4 class="checkout-subhead" style="margin-top:16px;">Payment / Credit Terms</h4>
        <div class="checkout-payment-methods">
          <label class="payment-option is-active">
            <input type="radio" name="payMethod" value="neft" checked>
            <div class="pay-option-content">
              <strong>Bank Wire (RTGS / NEFT)</strong>
              <span>Immediate dispatch upon wire confirmation</span>
            </div>
          </label>
          <label class="payment-option">
            <input type="radio" name="payMethod" value="credit">
            <div class="pay-option-content">
              <strong>Commercial Credit Line (30 Days)</strong>
              <span>Approved BPTL distributor / OEM corporate accounts</span>
            </div>
          </label>
          <label class="payment-option">
            <input type="radio" name="payMethod" value="online">
            <div class="pay-option-content">
              <strong>Instant Online / UPI Gateway</strong>
              <span>Corporate Credit Card / NetBanking / UPI</span>
            </div>
          </label>
        </div>

        <button type="submit" class="btn-confirm-order" id="checkoutSubmitBtn">
          <span class="btn-submit-text">Confirm &amp; Place Commercial Order</span>
          <span class="btn-submit-spinner" id="checkoutSpinner" style="display:none;"></span>
        </button>
      </form>
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
        <button type="button" class="btn btn-primary" id="checkoutDoneBtn">Done / Continue Browsing</button>
      </div>
    </div>
  </div>

  <!-- Customer & Distributor Login Modal -->
  <div class="login-modal-overlay" id="loginModalOverlay"></div>
  <div class="login-modal" id="loginModal" role="dialog" aria-modal="true" aria-labelledby="loginModalTitle">
    <button type="button" class="login-modal-close" id="loginModalClose" aria-label="Close Login">&times;</button>
    <div class="login-modal-header">
      <img src="<?php echo $base_url; ?>assets/images/brand/birla_precision_logo.png" alt="Birla Precision" class="login-modal-logo">
      <h3 id="loginModalTitle">Customer &amp; Distributor Portal</h3>
      <p>Sign in to access distributor pricing tiers, real-time dispatch tracking, and commercial orders.</p>
    </div>
    <form class="login-modal-form" id="loginForm" onsubmit="event.preventDefault(); alert('Demo: Authenticated to Birla Precision Customer Portal!'); document.getElementById('loginModal').classList.remove('is-open'); document.getElementById('loginModalOverlay').classList.remove('is-open');">
      <div class="form-group">
        <label class="form-label" for="loginEmail">Email / Account Code</label>
        <input type="text" id="loginEmail" class="form-control" placeholder="e.g. distributor@birlaprecision.com" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="loginPassword">Password</label>
        <input type="password" id="loginPassword" class="form-control" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" required>
      </div>
      <div class="login-form-options">
        <label class="login-remember-me">
          <input type="checkbox" checked> Remember me
        </label>
        <a href="#" class="login-forgot-link" onclick="alert('Please contact your Birla Precision sales representative or email info@birlaprecision.com to reset distributor credentials.'); return false;">Forgot Password?</a>
      </div>
      <button type="submit" class="btn btn-primary" style="width:100%;margin-top:14px;">
        Sign In to Portal
      </button>
      <div class="distributor-register-note">
        <span>New industrial partner?</span>
        <a href="<?php echo $base_url; ?>products/parallel-shank-twist-drills.php#enquiry">Apply for Dealership &rarr;</a>
      </div>
    </form>
  </div>

  <!-- Floating WhatsApp & Customer Support Widget (Matching iBELL screenshots) -->
  <div class="floating-chat-widget" id="floatingChatWidget">
    <div class="chat-pill" id="chatPill">
      <a href="https://wa.me/912532352315?text=Hello%20Birla%20Precision,%20I%20am%20inquiring%20about%20Dagger%20Brand%20HSS%20Jobber%20Drills" target="_blank" rel="noopener" class="chat-pill-text">
        Chat with us
      </a>
      <button type="button" class="chat-pill-close" id="chatPillClose" aria-label="Dismiss chat pill">&times;</button>
    </div>
    <a href="https://wa.me/912532352315?text=Hello%20Birla%20Precision,%20I%20am%20inquiring%20about%20Dagger%20Brand%20HSS%20Jobber%20Drills" target="_blank" rel="noopener" class="floating-wa-btn" aria-label="Open WhatsApp Chat">
      <svg viewBox="0 0 24 24" class="wa-icon">
        <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19.01L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.35C9.36 7.35 9.09 7.41 8.85 7.67C8.62 7.94 7.96 8.56 7.96 9.83C7.96 11.1 8.88 12.33 9.01 12.5C9.14 12.67 10.79 15.22 13.33 16.32C15.44 17.23 15.87 17.05 16.33 17.01C16.8 16.96 17.83 16.39 18.05 15.77C18.26 15.15 18.26 14.62 18.2 14.51C18.14 14.4 17.98 14.34 17.74 14.22C17.5 14.1 16.33 13.52 16.11 13.44C15.89 13.36 15.73 13.32 15.57 13.56C15.41 13.8 14.94 14.34 14.8 14.51C14.66 14.67 14.52 14.69 14.28 14.57C14.04 14.45 13.28 14.2 12.37 13.39C11.66 12.76 11.19 11.98 11.05 11.74C10.91 11.5 11.04 11.37 11.16 11.25C11.26 11.15 11.39 10.98 11.51 10.84C11.63 10.7 11.67 10.6 11.75 10.44C11.83 10.28 11.79 10.14 11.73 10.02C11.67 9.9 11.21 8.76 11.01 8.29C10.83 7.83 10.64 7.89 10.49 7.88C10.35 7.88 10.18 7.87 10.02 7.87C9.85 7.87 9.58 7.93 9.53 7.35Z"/>
      </svg>
    </a>
  </div>

  <!-- Global JavaScript -->
  <script src="<?php echo $base_url; ?>assets/js/main.js"></script>
  <?php if ($current_page === 'home'): ?>
    <script src="<?php echo $base_url; ?>assets/js/home.js"></script>
  <?php elseif ($current_page === 'product'): ?>
    <script src="<?php echo $base_url; ?>assets/js/product.js"></script>
  <?php endif; ?>

</body>
</html>
