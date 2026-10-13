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

      // Interactive Mega Menu Category Switcher (Strictly Listed Categories)
      var megaCatItems = productsNavItem.querySelectorAll('.mega-col-categories .mega-item[data-target]');
      var megaGroups = productsNavItem.querySelectorAll('.mega-col-subseries .mega-products-group');
      megaCatItems.forEach(function (catItem) {
        catItem.addEventListener('mouseenter', function () {
          var targetId = 'group-' + this.getAttribute('data-target');
          megaCatItems.forEach(function (ci) { ci.classList.remove('is-active-cat'); });
          this.classList.add('is-active-cat');
          megaGroups.forEach(function (grp) {
            grp.style.display = (grp.id === targetId) ? 'block' : 'none';
          });
        });
      });
    }
  }

  // 4. In-Footer Static Back to Top Button
  var footerBackToTopBtn = document.getElementById('footerBackToTopBtn');
  if (footerBackToTopBtn) {
    footerBackToTopBtn.addEventListener('click', function () {
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

  // 7b. Floating Move To Top Arrow Button (Bottom-Right, Reference Design)
  var floatingTopArrowBtn = document.getElementById('floatingTopArrowBtn');
  if (floatingTopArrowBtn) {
    function toggleFloatingTopArrow() {
      var scrollY = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
      if (scrollY > 250) {
        floatingTopArrowBtn.classList.add('is-visible');
      } else {
        floatingTopArrowBtn.classList.remove('is-visible');
      }
    }

    window.addEventListener('scroll', toggleFloatingTopArrow, { passive: true });
    toggleFloatingTopArrow();

    floatingTopArrowBtn.addEventListener('click', function (e) {
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
      var list = data ? JSON.parse(data) : [];
      if (Array.isArray(list)) {
        list.forEach(function (item) {
          if (!item.qty || item.qty < 1) {
            item.qty = 1;
          }
        });
      }
      return list;
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

  // Expose global BirlaCart API for product pages & batch additions
  window.BirlaCart = {
    get: getCart,
    save: saveCart,
    add: function (item) {
      var cart = getCart();
      var existing = cart.find(function (it) {
        return it.dia === item.dia && it.variant === item.variant;
      });
      var itemQty = parseInt(item.qty, 10) || 1;
      if (itemQty < 1) itemQty = 1;
      if (existing) {
        existing.qty += itemQty;
        existing.total = (existing.unitPrice || 0) * existing.qty;
      } else {
        item.qty = itemQty;
        item.moq = 1;
        cart.push(item);
      }
      saveCart(cart);
      openCartDrawer();
    },
    open: openCartDrawer,
    close: closeCartDrawer
  };

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

    var cartClearAllBtn = document.getElementById('cartClearAllBtn');
    if (cartClearAllBtn) {
      cartClearAllBtn.style.display = cart.length > 0 ? 'inline-block' : 'none';
      if (!cartClearAllBtn._wired) {
        cartClearAllBtn._wired = true;
        cartClearAllBtn.addEventListener('click', function (e) {
          e.stopPropagation();
          if (confirm('Clear all items from your cart?')) {
            try {
              localStorage.removeItem('birla_cart');
              localStorage.removeItem('birla_quotation_items');
            } catch (err) {}
            saveCart([]);
            if (typeof window.syncQuotationOnCartClear === 'function') {
              window.syncQuotationOnCartClear();
            }
          }
        });
      }
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

        var cartSummaryScope = document.getElementById('cartSummaryScope');
        if (cartSummaryScope) {
          cartSummaryScope.textContent = totalLineItems + ' Product' + (totalLineItems === 1 ? '' : 's') + ' (' + totalPieces + ' total pieces)';
        }

        if (cartDrawerTotal) {
          cartDrawerTotal.textContent = 'Quote on Request';
        }

        if (cartBuyNowBtn) {
          cartBuyNowBtn.innerHTML =
            '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="buy-btn-icon">' +
              '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>' +
              '<polyline points="14 2 14 8 20 8"></polyline>' +
              '<line x1="16" y1="13" x2="8" y2="13"></line>' +
              '<line x1="16" y1="17" x2="8" y2="17"></line>' +
              '<polyline points="10 9 9 9 8 9"></polyline>' +
            '</svg>' +
            '<span id="cartQuoteBtnText">Request Official Quotation</span>' +
            '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="buy-btn-arrow">' +
              '<line x1="5" y1="12" x2="19" y2="12"></line>' +
              '<polyline points="12 5 19 12 12 19"></polyline>' +
            '</svg>';
        }

        cartItemsList.innerHTML = '';
        cart.forEach(function (item, index) {
          var moq = parseInt(item.moq, 10) || 100;
          item.unitPrice = 0;
          item.total = 0;

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
            '<div class="cart-card-qty-strip">' +
              '<div class="cart-qty-ctrl-group">' +
                '<span class="cart-qty-ctrl-label">Quantity to Quote:</span>' +
                '<div class="cart-stepper-box">' +
                  '<button type="button" class="cart-step-btn cart-step-minus" data-index="' + index + '" aria-label="Decrease quantity"' + (item.qty <= 1 ? ' disabled aria-disabled="true"' : '') + '>&minus;</button>' +
                  '<input type="text" class="cart-step-input" data-index="' + index + '" value="' + item.qty + '">' +
                  '<button type="button" class="cart-step-btn cart-step-plus" data-index="' + index + '" aria-label="Increase quantity">&plus;</button>' +
                '</div>' +
                '<span class="cart-pcs-unit">pcs</span>' +
              '</div>' +
              '<div class="cart-quote-tag">' +
                '<span class="cart-quote-badge">Official Quote on Request</span>' +
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
                  '<span class="info-label">Order Unit</span>' +
                  '<span class="info-val">Precision Drill (Pieces)</span>' +
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

        // Add interactive handlers for - and + steppers inside cart
        var minusBtns = cartItemsList.querySelectorAll('.cart-step-minus');
        minusBtns.forEach(function (btn) {
          btn.addEventListener('click', function () {
            var idx = parseInt(btn.getAttribute('data-index'), 10);
            var currentCart = getCart();
            if (!currentCart[idx]) return;
            if (currentCart[idx].qty > 1) {
              var newQty = Math.max(1, currentCart[idx].qty - (currentCart[idx].qty > 10 ? 10 : 1));
              currentCart[idx].qty = newQty;
              currentCart[idx].total = (currentCart[idx].unitPrice || 0) * newQty;
              saveCart(currentCart);
            }
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
            if (isNaN(val) || val < 1) val = 1;
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
        var coPriceText = (item.total && parseFloat(item.total) > 0) ? formatPriceINR(item.total) : 'Quote on Request';
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
              '<span class="co-item-price">' + coPriceText + '</span>' +
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

      if (finalSub > 0) {
        var gst = Math.round((finalSub * 0.18) * 100) / 100;
        var grand = Math.round((finalSub + gst) * 100) / 100;

        checkoutSubtotal.textContent = formatPriceINR(finalSub);
        checkoutGst.textContent = formatPriceINR(gst);
        checkoutGrandTotal.textContent = formatPriceINR(grand);
      } else {
        checkoutSubtotal.textContent = 'Quote on Request';
        checkoutGst.textContent = 'Applicable on Invoicing';
        checkoutGrandTotal.textContent = 'Official Quote on Request';
      }
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

  function redirectToQuotationWithCart() {
    var cart = getCart();
    if (cart.length === 0) {
      alert('Your cart is empty. Please select drill sizes to request an official quotation.');
      return;
    }

    closeCartDrawer();

    var isSubfolder = window.location.pathname.indexOf('/products/') !== -1;
    var targetUrl = (isSubfolder ? '../' : './') + 'quotation.php';
    window.location.href = targetUrl;
  }

  // Ensure any link pointing to #enquiry reveals the enquiry section
  document.querySelectorAll('a[href*="#enquiry"]').forEach(function (link) {
    link.addEventListener('click', function () {
      var enquirySec = document.getElementById('enquiry');
      if (enquirySec) {
        enquirySec.style.display = 'block';
      }
    });
  });

  if (cartBuyNowBtn) {
    cartBuyNowBtn.addEventListener('click', function (e) {
      e.preventDefault();
      redirectToQuotationWithCart();
    });
  }

  window.redirectToQuotationWithCart = redirectToQuotationWithCart;

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
      var cart = getCart();
      var isQuoteRequest = cart.reduce(function(acc, i){ return acc + (parseFloat(i.total) || 0); }, 0) === 0;
      var submitText = checkoutSubmitBtn ? checkoutSubmitBtn.querySelector('.btn-submit-text') : null;
      if (submitText) submitText.textContent = isQuoteRequest ? 'Submitting B2B Quotation Request...' : 'Generating B2B Purchase Order...';

      setTimeout(function () {
        if (checkoutSpinner) checkoutSpinner.style.display = 'none';
        if (checkoutSubmitBtn) checkoutSubmitBtn.disabled = false;
        if (submitText) submitText.textContent = isQuoteRequest ? 'Submit Official Quotation Request' : 'Confirm & Place Commercial Order';

        var poNum = (isQuoteRequest ? 'RFQ-' : 'BPTL-') + '2026-' + Math.floor(1000 + Math.random() * 9000);
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
  // 9. Customer / Distributor Login Modal & Dynamic User State (Reference Pill)
  // --------------------------------------------------------------------------
  var navLoginBtn = document.getElementById('navLoginBtn');
  var navUserDropdownWrap = document.getElementById('navUserDropdownWrap');
  var navUserPillBtn = document.getElementById('navUserPillBtn');
  var navUserDropdownMenu = document.getElementById('navUserDropdownMenu');
  var userPillAvatar = document.getElementById('userPillAvatar');
  var userPillName = document.getElementById('userPillName');
  var dropdownUserAvatar = document.getElementById('dropdownUserAvatar');
  var dropdownUserFullName = document.getElementById('dropdownUserFullName');
  var dropdownUserRole = document.getElementById('dropdownUserRole');
  var navLogoutBtn = document.getElementById('navLogoutBtn');
  var dropdownCartAction = document.getElementById('dropdownCartAction');

  var loginModal = document.getElementById('loginModal');
  var loginModalOverlay = document.getElementById('loginModalOverlay');
  var loginModalClose = document.getElementById('loginModalClose');
  var loginForm = document.getElementById('loginForm');
  var loginEmail = document.getElementById('loginEmail');
  var loginPassword = document.getElementById('loginPassword');
  var loginSubmitBtn = document.getElementById('loginSubmitBtn');
  var forgotPwLink = document.getElementById('forgotPwLink');

  function getAuthUser() {
    try {
      var raw = localStorage.getItem('birla_user');
      if (raw) {
        var parsed = JSON.parse(raw);
        if (parsed && parsed.loggedIn) return parsed;
      }
    } catch (e) {
      console.warn('Error reading birla_user', e);
    }
    return null;
  }

  function setAuthUser(userData) {
    try {
      localStorage.setItem('birla_user', JSON.stringify(userData));
    } catch (e) {
      console.warn('Error saving birla_user', e);
    }
    updateAuthUI();
  }

  function clearAuthUser() {
    try {
      localStorage.removeItem('birla_user');
    } catch (e) {
      console.warn('Error clearing birla_user', e);
    }
    updateAuthUI();
  }

  function formatDisplayName(input) {
    if (!input) return 'Soumya';
    var trimmed = String(input).trim();
    if (!trimmed) return 'Soumya';

    if (trimmed.indexOf('@') !== -1) {
      var beforeAt = trimmed.split('@')[0];
      var seg = beforeAt.split(/[._-]/)[0];
      if (seg) {
        return seg.charAt(0).toUpperCase() + seg.slice(1).toLowerCase();
      }
    }

    var words = trimmed.split(/\s+/);
    if (words.length > 0 && words[0]) {
      return words[0].charAt(0).toUpperCase() + words[0].slice(1);
    }
    return 'Soumya';
  }

  function updateAuthUI() {
    var user = getAuthUser();
    if (user && user.loggedIn) {
      // User is logged in: show the [S] Hi, Soumya pill, hide LOGIN link
      if (navLoginBtn) navLoginBtn.style.display = 'none';
      if (navUserDropdownWrap) navUserDropdownWrap.style.display = 'inline-block';

      var displayName = user.name || 'Soumya';
      var initial = (user.initial || displayName.charAt(0) || 'S').toUpperCase();

      if (userPillAvatar) userPillAvatar.textContent = initial;
      if (userPillName) userPillName.textContent = 'Hi, ' + displayName;
      if (dropdownUserAvatar) dropdownUserAvatar.textContent = initial;
      if (dropdownUserFullName) dropdownUserFullName.textContent = user.fullName || displayName;
      if (dropdownUserRole) dropdownUserRole.textContent = user.role || 'Distributor Account';
    } else {
      // Logged out: show LOGIN link, hide pill button
      if (navLoginBtn) navLoginBtn.style.display = 'flex';
      if (navUserDropdownWrap) {
        navUserDropdownWrap.style.display = 'none';
        if (navUserDropdownMenu) navUserDropdownMenu.classList.remove('is-open');
        if (navUserPillBtn) navUserPillBtn.setAttribute('aria-expanded', 'false');
      }
    }
  }

  // Toggle User Account Dropdown
  if (navUserPillBtn && navUserDropdownMenu) {
    navUserPillBtn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var isOpen = navUserDropdownMenu.classList.contains('is-open');
      if (isOpen) {
        navUserDropdownMenu.classList.remove('is-open');
        navUserPillBtn.setAttribute('aria-expanded', 'false');
      } else {
        navUserDropdownMenu.classList.add('is-open');
        navUserPillBtn.setAttribute('aria-expanded', 'true');
      }
    });

    document.addEventListener('click', function (e) {
      if (navUserDropdownWrap && !navUserDropdownWrap.contains(e.target)) {
        navUserDropdownMenu.classList.remove('is-open');
        navUserPillBtn.setAttribute('aria-expanded', 'false');
      }
    });
  }

  if (navLogoutBtn) {
    navLogoutBtn.addEventListener('click', function (e) {
      e.preventDefault();
      clearAuthUser();
    });
  }

  if (dropdownCartAction) {
    dropdownCartAction.addEventListener('click', function (e) {
      e.preventDefault();
      if (navUserDropdownMenu) navUserDropdownMenu.classList.remove('is-open');
      openCartDrawer();
    });
  }

  function openLoginModal() {
    if (loginModal && loginModalOverlay) {
      loginModal.classList.add('is-open');
      loginModalOverlay.classList.add('is-open');
      document.body.style.overflow = 'hidden';
      if (loginEmail) {
        setTimeout(function () {
          loginEmail.focus();
          if (loginEmail.select) loginEmail.select();
        }, 150);
      }
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
      var rawVal = (loginEmail ? loginEmail.value : '').trim();
      if (!rawVal) rawVal = 'Soumya';

      if (loginSubmitBtn) {
        loginSubmitBtn.disabled = true;
        loginSubmitBtn.innerHTML = '<span>Signing In...</span>';
      }

      setTimeout(function () {
        if (loginSubmitBtn) {
          loginSubmitBtn.disabled = false;
          loginSubmitBtn.innerHTML = '<span>Sign In to Portal</span><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.5" class="btn-arrow-icon"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>';
        }

        var firstName = formatDisplayName(rawVal);
        var userData = {
          name: firstName,
          fullName: rawVal,
          initial: firstName.charAt(0).toUpperCase(),
          role: 'Distributor Account',
          loggedIn: true,
          timestamp: new Date().toISOString()
        };

        setAuthUser(userData);
        closeLoginModal();
      }, 350);
    });
  }

  if (forgotPwLink) {
    forgotPwLink.addEventListener('click', function (e) {
      e.preventDefault();
      var emailVal = (loginEmail && loginEmail.value) ? loginEmail.value.trim() : 'your commercial email';
      alert('Password reset link has been dispatched to ' + emailVal + '. Please check your inbox.');
    });
  }

  // Initialize Auth state on load
  updateAuthUI();

  // Expose BirlaAuth API globally
  window.BirlaAuth = {
    get: getAuthUser,
    login: function (name) {
      var displayName = formatDisplayName(name || 'Soumya');
      setAuthUser({
        name: displayName,
        fullName: name || 'Soumya',
        initial: displayName.charAt(0).toUpperCase(),
        role: 'Distributor Account',
        loggedIn: true
      });
    },
    logout: clearAuthUser,
    update: updateAuthUI
  };

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
