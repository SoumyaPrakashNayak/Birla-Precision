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

  // --------------------------------------------------------------------------
  // 8. Global Shopping Cart State & Slide Drawer (Image 2 Reference)
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

    // Update navbar badge dynamically!
    if (navCartBadge) {
      navCartBadge.textContent = totalPieces;
      navCartBadge.setAttribute('title', totalLineItems + ' product(s) • ' + totalPieces + ' total pieces');
      if (totalPieces > 0) {
        navCartBadge.classList.add('has-items');
        navCartBadge.style.display = 'inline-flex';
      } else {
        navCartBadge.classList.remove('has-items');
        navCartBadge.textContent = '0';
      }
    }

    if (cartDrawerCount) {
      cartDrawerCount.textContent = totalLineItems + (totalLineItems === 1 ? ' Product' : ' Products') + ' (' + totalPieces + ' pcs)';
    }

    // Render Drawer contents
    if (cartItemsList && cartEmptyState && cartDrawerFooter) {
      if (cart.length === 0) {
        cartEmptyState.style.display = 'block';
        cartItemsList.style.display = 'none';
        cartItemsList.innerHTML = '';
        cartDrawerFooter.style.display = 'none';
      } else {
        cartEmptyState.style.display = 'none';
        cartItemsList.style.display = 'flex';
        cartDrawerFooter.style.display = 'block';

        if (cartDrawerTotal) {
          cartDrawerTotal.textContent = formatPriceINR(totalAmount);
        }

        cartItemsList.innerHTML = '';
        cart.forEach(function (item, index) {
          var step = item.moq || 10;
          var row = document.createElement('div');
          row.className = 'cart-item-row';
          row.innerHTML =
            '<img src="' + resolveAssetUrl(item.img) + '" alt="' + escapeHtml(item.title) + '" class="cart-item-img" onerror="this.onerror=null;this.src=\'' + resolveAssetUrl('assets/images/products/gallery_thumb_1.jpg') + '\';">' +
            '<div class="cart-item-info">' +
              '<div class="cart-item-header-row">' +
                '<div class="cart-item-title">' + escapeHtml(item.title) + '</div>' +
                '<button type="button" class="cart-item-remove-btn" data-index="' + index + '" aria-label="Remove item" title="Remove">&times;</button>' +
              '</div>' +
              '<div class="cart-item-meta">' + escapeHtml(item.variantName) + ' &bull; ' + escapeHtml(item.diaText) + '</div>' +
              '<div class="cart-item-unit-rate">Rate: ' + formatPriceINR(item.unitPrice) + ' / pc</div>' +
              '<div class="cart-item-stepper-row">' +
                '<div class="drawer-qty-stepper">' +
                  '<button type="button" class="drawer-step-btn drawer-step-minus" data-index="' + index + '" aria-label="Decrease quantity">&minus;</button>' +
                  '<input type="number" class="drawer-step-input" data-index="' + index + '" value="' + item.qty + '" min="' + step + '" step="' + step + '">' +
                  '<button type="button" class="drawer-step-btn drawer-step-plus" data-index="' + index + '" aria-label="Increase quantity">&plus;</button>' +
                '</div>' +
                '<span class="drawer-step-units">pcs</span>' +
                '<div class="cart-item-line-total">' + formatPriceINR(item.total) + '</div>' +
              '</div>' +
            '</div>';
          cartItemsList.appendChild(row);
        });

        // Add interactive handlers for item removal
        var removeBtns = cartItemsList.querySelectorAll('.cart-item-remove-btn');
        removeBtns.forEach(function (btn) {
          btn.addEventListener('click', function () {
            var idx = parseInt(btn.getAttribute('data-index'), 10);
            var currentCart = getCart();
            currentCart.splice(idx, 1);
            saveCart(currentCart);
          });
        });

        // Add interactive handlers for - and + steppers inside cart
        var minusBtns = cartItemsList.querySelectorAll('.drawer-step-minus');
        minusBtns.forEach(function (btn) {
          btn.addEventListener('click', function () {
            var idx = parseInt(btn.getAttribute('data-index'), 10);
            var currentCart = getCart();
            if (!currentCart[idx]) return;
            var step = currentCart[idx].moq || 10;
            var newQty = currentCart[idx].qty - step;
            if (newQty < step) {
              if (confirm('Remove ' + currentCart[idx].title + ' from your cart?')) {
                currentCart.splice(idx, 1);
              } else {
                return;
              }
            } else {
              currentCart[idx].qty = newQty;
              currentCart[idx].total = (currentCart[idx].unitPrice || 0) * newQty;
            }
            saveCart(currentCart);
          });
        });

        var plusBtns = cartItemsList.querySelectorAll('.drawer-step-plus');
        plusBtns.forEach(function (btn) {
          btn.addEventListener('click', function () {
            var idx = parseInt(btn.getAttribute('data-index'), 10);
            var currentCart = getCart();
            if (!currentCart[idx]) return;
            var step = currentCart[idx].moq || 10;
            currentCart[idx].qty += step;
            currentCart[idx].total = (currentCart[idx].unitPrice || 0) * currentCart[idx].qty;
            saveCart(currentCart);
          });
        });

        var qtyInputs = cartItemsList.querySelectorAll('.drawer-step-input');
        qtyInputs.forEach(function (input) {
          input.addEventListener('change', function () {
            var idx = parseInt(this.getAttribute('data-index'), 10);
            var currentCart = getCart();
            if (!currentCart[idx]) return;
            var step = currentCart[idx].moq || 10;
            var val = parseInt(this.value, 10);
            if (isNaN(val) || val < step) val = step;
            currentCart[idx].qty = val;
            currentCart[idx].total = (currentCart[idx].unitPrice || 0) * val;
            saveCart(currentCart);
          });
        });

      }
    }
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
      if (confirm('Clear all items from your commercial cart?')) {
        saveCart([]);
      }
    });
  }

  // --------------------------------------------------------------------------
  // 8b. Commercial Checkout & Buy Now Feature
  // --------------------------------------------------------------------------
  function openCheckoutModal() {
    var cart = getCart();
    if (cart.length === 0) {
      alert('Your cart is empty. Please add products to proceed with checkout.');
      return;
    }

    closeCartDrawer();

    if (checkoutItemsPreview && checkoutSubtotal && checkoutGst && checkoutGrandTotal) {
      var sub = 0;
      checkoutItemsPreview.innerHTML = '';
      cart.forEach(function (item) {
        sub += (item.total || 0);
        var previewRow = document.createElement('div');
        previewRow.className = 'checkout-preview-item';
        previewRow.innerHTML =
          '<span>' + escapeHtml(item.title) + ' (' + item.qty + ' pcs &bull; ' + escapeHtml(item.diaText) + ')</span>' +
          '<strong>' + formatPriceINR(item.total) + '</strong>';
        checkoutItemsPreview.appendChild(previewRow);
      });

      var gst = sub * 0.18;
      var grand = sub + gst;
      checkoutSubtotal.textContent = formatPriceINR(sub);
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

  // Payment radio option click handler
  var payOptions = document.querySelectorAll('.payment-option');
  payOptions.forEach(function (opt) {
    opt.addEventListener('click', function () {
      payOptions.forEach(function (o) { o.classList.remove('is-active'); });
      opt.classList.add('is-active');
    });
  });

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
  // 9. Customer / Distributor Login Modal (Image 2 Reference)
  // --------------------------------------------------------------------------
  var navLoginBtn = document.getElementById('navLoginBtn');
  var loginModal = document.getElementById('loginModal');
  var loginModalOverlay = document.getElementById('loginModalOverlay');
  var loginModalClose = document.getElementById('loginModalClose');

  function openLoginModal() {
    if (loginModal && loginModalOverlay) {
      loginModal.classList.add('is-open');
      loginModalOverlay.classList.add('is-open');
      document.body.style.overflow = 'hidden';
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
