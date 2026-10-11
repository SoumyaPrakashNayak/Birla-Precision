/**
 * Birla Precision Technologies — Global JavaScript
 * Native browser APIs only (No jQuery, No frameworks)
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  // 1. Sticky Header
  var siteHeader = document.getElementById('siteHeader');
  if (siteHeader) {
    var headerOffset = siteHeader.offsetTop || 0;
    window.addEventListener('scroll', function () {
      if (window.scrollY > headerOffset + 80) {
        siteHeader.classList.add('is-sticky');
      } else {
        siteHeader.classList.remove('is-sticky');
      }
    }, { passive: true });
  }

  // 2. Mobile Navigation Drawer
  var mobileMenuOpen = document.getElementById('mobileMenuOpen');
  var mobileMenuClose = document.getElementById('mobileMenuClose');
  var mobileDrawer = document.getElementById('mobileDrawer');

  if (mobileMenuOpen && mobileDrawer) {
    mobileMenuOpen.addEventListener('click', function () {
      mobileDrawer.classList.add('is-active');
      document.body.style.overflow = 'hidden';
    });

    if (mobileMenuClose) {
      mobileMenuClose.addEventListener('click', function () {
        mobileDrawer.classList.remove('is-active');
        document.body.style.overflow = '';
      });
    }

    mobileDrawer.addEventListener('click', function (e) {
      if (e.target === mobileDrawer) {
        mobileDrawer.classList.remove('is-active');
        document.body.style.overflow = '';
      }
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && mobileDrawer.classList.contains('is-active')) {
        mobileDrawer.classList.remove('is-active');
        document.body.style.overflow = '';
      }
    });
  }

  // 3. Products Mega Menu Keyboard & Click Accessibility
  var productsNavItem = document.getElementById('productsNavItem');
  if (productsNavItem) {
    var megaMenuCard = productsNavItem.querySelector('.mega-menu-card, .nav-dropdown');
    var megaTrigger = productsNavItem.querySelector('.nav-bar-link, .nav-link');

    if (megaTrigger && megaMenuCard) {
      megaTrigger.addEventListener('click', function (e) {
        // Toggle on mobile/tablet or click
        if (window.innerWidth <= 1024) {
          e.preventDefault();
          productsNavItem.classList.toggle('is-open');
          var isExpanded = productsNavItem.classList.contains('is-open');
          megaTrigger.setAttribute('aria-expanded', isExpanded);
        }
      });

      megaTrigger.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ' || e.key === 'ArrowDown') {
          e.preventDefault();
          productsNavItem.classList.toggle('is-open');
          var isExpanded = productsNavItem.classList.contains('is-open');
          megaTrigger.setAttribute('aria-expanded', isExpanded);
        }
      });

      document.addEventListener('click', function (e) {
        if (!productsNavItem.contains(e.target)) {
          productsNavItem.classList.remove('is-open');
          megaTrigger.setAttribute('aria-expanded', 'false');
        }
      });

      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && productsNavItem.classList.contains('is-open')) {
          productsNavItem.classList.remove('is-open');
          megaTrigger.setAttribute('aria-expanded', 'false');
          megaTrigger.focus();
        }
      });
    }
  }

  // 4. Back to Top Button
  var backToTopBtn = document.getElementById('backToTopBtn');
  if (backToTopBtn) {
    backToTopBtn.addEventListener('click', function () {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }

  // 5. Native Animate On Scroll (AOS) Engine (Intersection Observer)
  var aosElements = document.querySelectorAll('[data-aos], .reveal');
  if ('IntersectionObserver' in window && aosElements.length > 0) {
    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (!prefersReducedMotion) {
      var aosObserver = new IntersectionObserver(function (entries, observer) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('aos-animate');
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      }, {
        root: null,
        rootMargin: '0px 0px -20px 0px',
        threshold: 0.05
      });

      aosElements.forEach(function (el) {
        var rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom > 0) {
          el.classList.add('aos-animate');
          el.classList.add('is-visible');
        } else {
          aosObserver.observe(el);
        }
      });
    } else {
      aosElements.forEach(function (el) {
        el.classList.add('aos-animate');
        el.classList.add('is-visible');
      });
    }
  } else {
    aosElements.forEach(function (el) {
      el.classList.add('aos-animate');
      el.classList.add('is-visible');
    });
  }

  // 6. Header Search Form behavior
  var searchForm = document.getElementById('headerSearchForm');
  var searchInput = document.getElementById('headerSearchInput');
  if (searchForm && searchInput) {
    searchForm.addEventListener('submit', function (e) {
      var val = searchInput.value.trim();
      if (!val) {
        // Just let it navigate to product page if empty
        return;
      }
    });
  }

  // 7. Floating Chat Pill Close
  var chatPillClose = document.getElementById('chatPillClose');
  var chatPill = document.getElementById('chatPill');
  if (chatPillClose && chatPill) {
    chatPillClose.addEventListener('click', function (e) {
      e.preventDefault();
      chatPill.style.display = 'none';
    });
  }

  // 7b. Move To Top Floating Arrow
  var backToTopBtn = document.getElementById('backToTopBtn');
  if (backToTopBtn) {
    function toggleBackToTop() {
      var scrollY = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
      if (scrollY > 300) {
        backToTopBtn.classList.add('is-visible');
      } else {
        backToTopBtn.classList.remove('is-visible');
      }
    }

    window.addEventListener('scroll', toggleBackToTop, { passive: true });
    toggleBackToTop();

    backToTopBtn.addEventListener('click', function (e) {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }

  // --------------------------------------------------------------------------
  // 8. Global Shopping Cart State & Slide Drawer (Image 2 Reference)
  // --------------------------------------------------------------------------
  var navCartBtn = document.getElementById('navCartBtn');
  var navCartBadge = document.getElementById('navCartBadge');
  var cartSlideDrawer = document.getElementById('cartSlideDrawer');
  var cartDrawerOverlay = document.getElementById('cartDrawerOverlay');
  var cartDrawerClose = document.getElementById('cartDrawerClose');
  var cartEmptyState = document.getElementById('cartEmptyState');
  var cartItemsList = document.getElementById('cartItemsList');
  var cartDrawerFooter = document.getElementById('cartDrawerFooter');
  var cartDrawerTotal = document.getElementById('cartDrawerTotal');
  var cartDrawerCount = document.getElementById('cartDrawerCount');
  var cartClearBtn = document.getElementById('cartClearBtn');
  var cartBuyNowBtn = document.getElementById('cartBuyNowBtn');

  // Checkout Modal Elements
  var checkoutModal = document.getElementById('checkoutModal');
  var checkoutModalOverlay = document.getElementById('checkoutModalOverlay');
  var checkoutModalClose = document.getElementById('checkoutModalClose');
  var checkoutModalBody = document.getElementById('checkoutModalBody');
  var checkoutSuccessView = document.getElementById('checkoutSuccessView');
  var checkoutItemsPreview = document.getElementById('checkoutItemsPreview');
  var checkoutSubtotal = document.getElementById('checkoutSubtotal');
  var checkoutGst = document.getElementById('checkoutGst');
  var checkoutGrandTotal = document.getElementById('checkoutGrandTotal');
  var checkoutForm = document.getElementById('checkoutForm');
  var checkoutSubmitBtn = document.getElementById('checkoutSubmitBtn');
  var checkoutSpinner = document.getElementById('checkoutSpinner');
  var successPoNumber = document.getElementById('successPoNumber');
  var checkoutDoneBtn = document.getElementById('checkoutDoneBtn');

  // Coupon Accordion Elements
  var cartCouponAccordion = document.getElementById('cartCouponAccordion');
  var couponToggleBtn = document.getElementById('couponToggleBtn');
  var couponAccordionBody = document.getElementById('couponAccordionBody');
  var couponCodeInput = document.getElementById('couponCodeInput');
  var couponApplyBtn = document.getElementById('couponApplyBtn');
  var couponFeedback = document.getElementById('couponFeedback');
  var appliedCoupon = null; // { code: 'BIRLA10', percent: 10 }

  // Check URL parameter to easily reset cart if requested: ?clearcart=1
  if (window.location.search.indexOf('clearcart=1') !== -1) {
    try { localStorage.removeItem('birla_cart'); } catch(e) {}
  }

  function getCart() {
    try {
      var data = localStorage.getItem('birla_cart');
      return data ? JSON.parse(data) : [];
    } catch (e) {
      return [];
    }
  }

  function saveCart(cart) {
    try {
      localStorage.setItem('birla_cart', JSON.stringify(cart));
    } catch (e) {}
    updateCartUI();
  }

  function formatPriceINR(num) {
    return '₹ ' + parseFloat(num || 0).toLocaleString('en-IN', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  }

  function escapeHtml(text) {
    if (text === null || text === undefined) return '';
    return String(text)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  // Resolve image URLs relative to current page location (root vs /products/)
  function resolveAssetUrl(src) {
    if (!src) return 'assets/images/products/gallery_thumb_1.jpg';
    if (src.indexOf('http://') === 0 || src.indexOf('https://') === 0 || src.indexOf('data:') === 0) {
      return src;
    }
    var clean = src.replace(/^\.?\.\//, '').replace(/^\//, '');
    var isSubfolder = window.location.pathname.indexOf('/products/') !== -1;
    return (isSubfolder ? '../' : './') + clean;
  }

  function updateCartUI() {
    var cart = getCart();
    var totalLineItems = cart.length;
    var totalPieces = 0;
    var totalAmount = 0;

    cart.forEach(function (item) {
      totalPieces += (parseInt(item.qty, 10) || 0);
      totalAmount += (parseFloat(item.total) || 0);
    });

    // Update navbar badge: STRICTLY hide when empty / initial load!
    if (navCartBadge) {
      if (totalPieces > 0) {
        navCartBadge.textContent = totalPieces;
        navCartBadge.setAttribute('title', totalLineItems + ' product(s) • ' + totalPieces + ' total pieces');
        navCartBadge.classList.add('has-items');
        navCartBadge.style.display = 'inline-flex';
      } else {
        navCartBadge.classList.remove('has-items');
        navCartBadge.style.display = 'none';
        navCartBadge.textContent = '0';
      }
    }

    if (cartDrawerCount) {
      cartDrawerCount.textContent = totalLineItems + (totalLineItems === 1 ? ' Product' : ' Products') + ' (' + totalPieces + ' pcs)';
    }

    // Render Drawer contents matching Image 2 Reference Design
    if (cartItemsList && cartEmptyState && cartDrawerFooter) {
      if (cart.length === 0) {
        cartEmptyState.style.display = 'block';
        cartItemsList.style.display = 'none';
        cartItemsList.innerHTML = '';
        if (cartCouponAccordion) cartCouponAccordion.style.display = 'none';
        cartDrawerFooter.style.display = 'none';
        appliedCoupon = null;
      } else {
        cartEmptyState.style.display = 'none';
        cartItemsList.style.display = 'flex';
        if (cartCouponAccordion) cartCouponAccordion.style.display = 'block';
        cartDrawerFooter.style.display = 'block';

        // Calculate total with coupon discount if applied
        var finalTotal = totalAmount;
        if (appliedCoupon && appliedCoupon.percent) {
          var discountAmt = (totalAmount * appliedCoupon.percent) / 100.0;
          finalTotal = Math.max(0, totalAmount - discountAmt);
        }

        if (cartDrawerTotal) {
          cartDrawerTotal.textContent = formatPriceINR(finalTotal);
        }

        cartItemsList.innerHTML = '';
        cart.forEach(function (item, index) {
          var moq = parseInt(item.moq, 10) || 100;
          var card = document.createElement('div');
          card.className = 'cart-item-card';
          card.innerHTML =
            '<div class="cart-card-top">' +
              '<div class="cart-card-thumb-wrap">' +
                '<img src="' + resolveAssetUrl(item.img) + '" alt="' + escapeHtml(item.title) + '" class="cart-card-thumb-img" onerror="this.onerror=null;this.src=\'' + resolveAssetUrl('assets/images/products/gallery_thumb_1.jpg') + '\';">' +
              '</div>' +
              '<div class="cart-card-details">' +
                '<div class="cart-card-header-row">' +
                  '<h4 class="cart-card-title">' + escapeHtml(item.title) + '</h4>' +
                  '<button type="button" class="cart-item-trash-btn" data-index="' + index + '" aria-label="Remove item" title="Remove item">' +
                    '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' +
                      '<polyline points="3 6 5 6 21 6"></polyline>' +
                      '<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>' +
                    '</svg>' +
                  '</button>' +
                '</div>' +
                '<div class="cart-card-subtitle">' + escapeHtml(item.variantName) + ' &bull; ' + escapeHtml(item.diaText) + '</div>' +
                '<div class="cart-card-badges">' +
                  '<span class="cart-badge-dagger">DAGGER BRAND</span>' +
                  '<span class="cart-badge-gray">IS : 5101</span>' +
                  '<span class="cart-badge-gray">HSN 8207</span>' +
                '</div>' +
              '</div>' +
            '</div>' +
            '<div class="cart-card-pricing-grid">' +
              '<div class="pricing-col">' +
                '<span class="pricing-label">Rate (per piece)</span>' +
                '<span class="pricing-rate-val">' + formatPriceINR(item.unitPrice) + ' / pc</span>' +
              '</div>' +
              '<div class="pricing-col">' +
                '<span class="pricing-label">Quantity (pcs)</span>' +
                '<div class="cart-stepper-box">' +
                  '<button type="button" class="cart-step-btn cart-step-minus" data-index="' + index + '" aria-label="Decrease quantity">&minus;</button>' +
                  '<input type="text" class="cart-step-input" data-index="' + index + '" value="' + item.qty + '">' +
                  '<button type="button" class="cart-step-btn cart-step-plus" data-index="' + index + '" aria-label="Increase quantity">&plus;</button>' +
                '</div>' +
              '</div>' +
              '<div class="pricing-col pricing-col-total">' +
                '<span class="pricing-label">Total</span>' +
                '<span class="pricing-total-val">' + formatPriceINR(item.total) + '</span>' +
              '</div>' +
            '</div>' +
            '<div class="cart-order-info-section">' +
              '<div class="order-info-title-row">' +
                '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' +
                  '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>' +
                  '<polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>' +
                  '<line x1="12" y1="22.08" x2="12" y2="12"></line>' +
                '</svg>' +
                '<span>Order Information</span>' +
              '</div>' +
              '<div class="order-info-grid">' +
                '<div class="order-info-col">' +
                  '<span class="info-label">Minimum Order Quantity (MOQ)</span>' +
                  '<span class="info-val">' + moq + ' pcs</span>' +
                '</div>' +
                '<div class="order-info-col">' +
                  '<span class="info-label">Order Multiple</span>' +
                  '<span class="info-val">10 pcs only</span>' +
                '</div>' +
              '</div>' +
              '<div class="order-info-alert-banner">' +
                '<svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2">' +
                  '<circle cx="12" cy="12" r="10"></circle>' +
                  '<line x1="12" y1="16" x2="12" y2="12"></line>' +
                  '<line x1="12" y1="8" x2="12.01" y2="8"></line>' +
                '</svg>' +
                '<span>Orders must be in multiples of 10 pieces as per catalogue.</span>' +
              '</div>' +
            '</div>';
          cartItemsList.appendChild(card);
        });

        // Add interactive handlers for trash item removal
        var trashBtns = cartItemsList.querySelectorAll('.cart-item-trash-btn');
        trashBtns.forEach(function (btn) {
          btn.addEventListener('click', function () {
            var idx = parseInt(btn.getAttribute('data-index'), 10);
            var currentCart = getCart();
            currentCart.splice(idx, 1);
            saveCart(currentCart);
          });
        });

        // Add interactive handlers for - and + steppers inside cart (multiples of 10)
        var minusBtns = cartItemsList.querySelectorAll('.cart-step-minus');
        minusBtns.forEach(function (btn) {
          btn.addEventListener('click', function () {
            var idx = parseInt(btn.getAttribute('data-index'), 10);
            var currentCart = getCart();
            if (!currentCart[idx]) return;
            var newQty = currentCart[idx].qty - 10;
            if (newQty <= 0) {
              currentCart.splice(idx, 1);
            } else {
              currentCart[idx].qty = newQty;
              currentCart[idx].total = (currentCart[idx].unitPrice || 0) * newQty;
            }
            saveCart(currentCart);
          });
        });

        var plusBtns = cartItemsList.querySelectorAll('.cart-step-plus');
        plusBtns.forEach(function (btn) {
          btn.addEventListener('click', function () {
            var idx = parseInt(btn.getAttribute('data-index'), 10);
            var currentCart = getCart();
            if (!currentCart[idx]) return;
            var newQty = currentCart[idx].qty + 10;
            currentCart[idx].qty = newQty;
            currentCart[idx].total = (currentCart[idx].unitPrice || 0) * newQty;
            saveCart(currentCart);
          });
        });

        var qtyInputs = cartItemsList.querySelectorAll('.cart-step-input');
        qtyInputs.forEach(function (input) {
          input.addEventListener('change', function () {
            var idx = parseInt(this.getAttribute('data-index'), 10);
            var currentCart = getCart();
            if (!currentCart[idx]) return;
            var val = parseInt(this.value, 10);
            if (isNaN(val) || val <= 0) val = 10;
            var rem = val % 10;
            if (rem !== 0) val = Math.ceil(val / 10) * 10;
            currentCart[idx].qty = val;
            currentCart[idx].total = (currentCart[idx].unitPrice || 0) * val;
            saveCart(currentCart);
          });
        });

      }
    }
  }

  // Coupon Accordion Toggle & Apply Event Listeners
  if (couponToggleBtn && cartCouponAccordion && couponAccordionBody) {
    couponToggleBtn.addEventListener('click', function () {
      var isOpen = cartCouponAccordion.classList.contains('is-open');
      if (isOpen) {
        cartCouponAccordion.classList.remove('is-open');
        couponAccordionBody.style.display = 'none';
      } else {
        cartCouponAccordion.classList.add('is-open');
        couponAccordionBody.style.display = 'block';
        if (couponCodeInput) couponCodeInput.focus();
      }
    });
  }

  if (couponApplyBtn && couponCodeInput && couponFeedback) {
    couponApplyBtn.addEventListener('click', function () {
      var code = (couponCodeInput.value || '').trim().toUpperCase();
      if (!code) {
        couponFeedback.textContent = 'Please enter a coupon code.';
        couponFeedback.className = 'coupon-feedback-msg is-error';
        couponFeedback.style.display = 'block';
        return;
      }
      if (code === 'BIRLA10' || code === 'BPTL10' || code === 'PRECISION10') {
        appliedCoupon = { code: code, percent: 10 };
        couponFeedback.textContent = 'Coupon ' + code + ' applied! 10% Commercial Discount.';
        couponFeedback.className = 'coupon-feedback-msg is-success';
        couponFeedback.style.display = 'block';
        updateCartUI();
      } else if (code === 'WELCOME5') {
        appliedCoupon = { code: code, percent: 5 };
        couponFeedback.textContent = 'Coupon WELCOME5 applied! 5% Commercial Discount.';
        couponFeedback.className = 'coupon-feedback-msg is-success';
        couponFeedback.style.display = 'block';
        updateCartUI();
      } else {
        appliedCoupon = null;
        couponFeedback.textContent = 'Invalid coupon. Try BIRLA10 for 10% discount.';
        couponFeedback.className = 'coupon-feedback-msg is-error';
        couponFeedback.style.display = 'block';
        updateCartUI();
      }
    });
  }

  function openCartDrawer() {
    updateCartUI();
    if (cartSlideDrawer && cartDrawerOverlay) {
      cartSlideDrawer.classList.add('is-open');
      cartDrawerOverlay.classList.add('is-open');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeCartDrawer() {
    if (cartSlideDrawer && cartDrawerOverlay) {
      cartSlideDrawer.classList.remove('is-open');
      cartDrawerOverlay.classList.remove('is-open');
      document.body.style.overflow = '';
    }
  }

  if (navCartBtn) {
    navCartBtn.addEventListener('click', function (e) {
      e.preventDefault();
      openCartDrawer();
    });
  }

  if (cartDrawerClose) {
    cartDrawerClose.addEventListener('click', closeCartDrawer);
  }

  if (cartDrawerOverlay) {
    cartDrawerOverlay.addEventListener('click', closeCartDrawer);
  }

  if (cartClearBtn) {
    cartClearBtn.addEventListener('click', function () {
      appliedCoupon = null;
      if (couponFeedback) couponFeedback.style.display = 'none';
      if (couponCodeInput) couponCodeInput.value = '';
      saveCart([]);
    });
  }

  // --------------------------------------------------------------------------
  // 8b. Commercial Checkout & Buy Now Feature (Matching Image 2 Reference)
  // --------------------------------------------------------------------------
  var checkoutEditCartBtn = document.getElementById('checkoutEditCartBtn');
  var coEditCartText = document.getElementById('coEditCartText');
  var coDeliveryAddress = document.getElementById('coDeliveryAddress');
  var addressCharCount = document.getElementById('addressCharCount');

  if (checkoutEditCartBtn) {
    checkoutEditCartBtn.addEventListener('click', function () {
      closeCheckoutModal();
      openCartDrawer();
    });
  }

  if (coDeliveryAddress && addressCharCount) {
    coDeliveryAddress.addEventListener('input', function () {
      addressCharCount.textContent = this.value.length;
    });
  }

  // Payment radio option card selection
  var payOptionCards = document.querySelectorAll('.co-pay-option-card');
  payOptionCards.forEach(function (card) {
    card.addEventListener('click', function () {
      payOptionCards.forEach(function (c) { c.classList.remove('is-active'); });
      card.classList.add('is-active');
      var radio = card.querySelector('.co-radio-input');
      if (radio) radio.checked = true;
    });
  });

  function openCheckoutModal() {
    var cart = getCart();
    if (cart.length === 0) {
      alert('Your cart is empty. Please add products to proceed with checkout.');
      return;
    }

    closeCartDrawer();

    if (coEditCartText) {
      coEditCartText.textContent = 'Edit Cart (' + cart.length + ' item' + (cart.length > 1 ? 's' : '') + ')';
    }

    if (checkoutItemsPreview && checkoutSubtotal && checkoutGst && checkoutGrandTotal) {
      var sub = 0;
      checkoutItemsPreview.innerHTML = '';
      cart.forEach(function (item) {
        sub += (item.total || 0);
        var previewRow = document.createElement('div');
        previewRow.className = 'co-item-row';
        previewRow.innerHTML =
          '<div class="co-item-thumb-box">' +
            '<img src="' + resolveAssetUrl(item.img) + '" alt="' + escapeHtml(item.title) + '" class="co-item-thumb-img" onerror="this.onerror=null;this.src=\'' + resolveAssetUrl('assets/images/products/gallery_thumb_1.jpg') + '\';">' +
          '</div>' +
          '<div class="co-item-info">' +
            '<div class="co-item-title-row">' +
              '<strong>' + escapeHtml(item.title) + '</strong>' +
              '<span class="co-item-qty">' + item.qty + ' pcs</span>' +
            '</div>' +
            '<div class="co-item-meta-row">' +
              '<span>' + escapeHtml(item.variantName || 'ITM STD.') + (item.diaText ? ' - ' + escapeHtml(item.diaText) : '') + '</span>' +
              '<span class="co-item-price">' + formatPriceINR(item.total) + '</span>' +
            '</div>' +
            '<div class="co-item-badges">' +
              '<span class="cart-badge-dagger">DAGGER BRAND</span>' +
              '<span class="cart-badge-gray">IS : 5101</span>' +
              '<span class="cart-badge-gray">HSN 8207</span>' +
            '</div>' +
          '</div>';
        checkoutItemsPreview.appendChild(previewRow);
      });

      var finalSub = sub;
      if (appliedCoupon && appliedCoupon.percent) {
        var discount = (sub * appliedCoupon.percent) / 100.0;
        finalSub = Math.max(0, sub - discount);
      }

      var gst = Math.round((finalSub * 0.18) * 100) / 100;
      var grand = Math.round((finalSub + gst) * 100) / 100;

      checkoutSubtotal.textContent = formatPriceINR(finalSub);
      checkoutGst.textContent = formatPriceINR(gst);
      checkoutGrandTotal.textContent = formatPriceINR(grand);
    }

    if (checkoutModalBody && checkoutSuccessView) {
      checkoutModalBody.style.display = 'block';
      checkoutSuccessView.style.display = 'none';
    }

    if (checkoutModal && checkoutModalOverlay) {
      checkoutModal.classList.add('is-open');
      checkoutModalOverlay.classList.add('is-open');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeCheckoutModal() {
    if (checkoutModal && checkoutModalOverlay) {
      checkoutModal.classList.remove('is-open');
      checkoutModalOverlay.classList.remove('is-open');
      document.body.style.overflow = '';
    }
  }

  if (cartBuyNowBtn) {
    cartBuyNowBtn.addEventListener('click', function (e) {
      e.preventDefault();
      openCheckoutModal();
    });
  }

  if (checkoutModalClose) {
    checkoutModalClose.addEventListener('click', closeCheckoutModal);
  }

  if (checkoutModalOverlay) {
    checkoutModalOverlay.addEventListener('click', closeCheckoutModal);
  }

  if (checkoutForm) {
    checkoutForm.addEventListener('submit', function (e) {
      e.preventDefault();
      if (checkoutSubmitBtn) checkoutSubmitBtn.disabled = true;
      if (checkoutSpinner) checkoutSpinner.style.display = 'inline-block';
      var submitText = checkoutSubmitBtn ? checkoutSubmitBtn.querySelector('.btn-submit-text') : null;
      if (submitText) submitText.textContent = 'Generating B2B Purchase Order...';

      setTimeout(function () {
        if (checkoutSpinner) checkoutSpinner.style.display = 'none';
        if (checkoutSubmitBtn) checkoutSubmitBtn.disabled = false;
        if (submitText) submitText.textContent = 'Confirm & Place Commercial Order';

        var poNum = 'BPTL-2026-' + Math.floor(1000 + Math.random() * 9000);
        if (successPoNumber) successPoNumber.textContent = poNum;

        if (checkoutModalBody && checkoutSuccessView) {
          checkoutModalBody.style.display = 'none';
          checkoutSuccessView.style.display = 'block';
        }

        // Clear cart upon order placement
        saveCart([]);
      }, 900);
    });
  }

  if (checkoutDoneBtn) {
    checkoutDoneBtn.addEventListener('click', function () {
      closeCheckoutModal();
    });
  }

  // --------------------------------------------------------------------------
  // 9. Customer / Distributor Login Modal (Image 1 Reference)
  // --------------------------------------------------------------------------
  var navLoginBtn = document.getElementById('navLoginBtn');
  var loginModal = document.getElementById('loginModal');
  var loginModalOverlay = document.getElementById('loginModalOverlay');
  var loginModalClose = document.getElementById('loginModalClose');
  var loginForm = document.getElementById('loginForm');
  var loginEmail = document.getElementById('loginEmail');
  var loginPassword = document.getElementById('loginPassword');
  var loginSubmitBtn = document.getElementById('loginSubmitBtn');
  var forgotPwLink = document.getElementById('forgotPwLink');

  function openLoginModal() {
    if (loginModal && loginModalOverlay) {
      loginModal.classList.add('is-open');
      loginModalOverlay.classList.add('is-open');
      document.body.style.overflow = 'hidden';
      if (loginEmail) setTimeout(function () { loginEmail.focus(); }, 150);
    }
  }

  function closeLoginModal() {
    if (loginModal && loginModalOverlay) {
      loginModal.classList.remove('is-open');
      loginModalOverlay.classList.remove('is-open');
      document.body.style.overflow = '';
    }
  }

  if (navLoginBtn) {
    navLoginBtn.addEventListener('click', function (e) {
      e.preventDefault();
      openLoginModal();
    });
  }

  if (loginModalClose) {
    loginModalClose.addEventListener('click', closeLoginModal);
  }

  if (loginModalOverlay) {
    loginModalOverlay.addEventListener('click', closeLoginModal);
  }

  if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var emailVal = (loginEmail ? loginEmail.value : '').trim();
      if (!emailVal) return;

      if (loginSubmitBtn) {
        loginSubmitBtn.disabled = true;
        loginSubmitBtn.innerHTML = '<span>Signing In...</span>';
      }

      setTimeout(function () {
        if (loginSubmitBtn) {
          loginSubmitBtn.disabled = false;
          loginSubmitBtn.innerHTML = '<span>Sign In to Portal</span><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.5" class="btn-arrow-icon"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>';
        }
        closeLoginModal();
        alert('Welcome back! Signed in to Birla Precision Distributor Portal as ' + emailVal);
      }, 700);
    });
  }

  if (forgotPwLink) {
    forgotPwLink.addEventListener('click', function (e) {
      e.preventDefault();
      var emailVal = (loginEmail && loginEmail.value) ? loginEmail.value.trim() : 'your commercial email';
      alert('Password reset link has been dispatched to ' + emailVal + '. Please check your inbox.');
    });
  }

  // Global keydown for closing drawer/modals
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      closeCartDrawer();
      closeLoginModal();
      closeCheckoutModal();
    }
  });

  // Expose BirlaCart globally
  window.BirlaCart = {
    get: getCart,
    save: saveCart,
    add: function (item) {
      var cart = getCart();
      var found = false;
      for (var i = 0; i < cart.length; i++) {
        if (cart[i].dia === item.dia && cart[i].variant === item.variant) {
          // Set to the newly configured order quantity!
          cart[i].qty = item.qty;
          cart[i].unitPrice = item.unitPrice;
          cart[i].total = (cart[i].unitPrice || 0) * cart[i].qty;
          if (item.img) cart[i].img = item.img;
          found = true;
          break;
        }
      }
      if (!found) {
        cart.push(item);
      }
      saveCart(cart);
      openCartDrawer();
    },
    open: openCartDrawer,
    close: closeCartDrawer,
    updateUI: updateCartUI
  };

  // Initial Cart UI sync on load
  updateCartUI();

});
