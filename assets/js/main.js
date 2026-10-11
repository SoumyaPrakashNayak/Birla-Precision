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
    return '₹ ' + parseFloat(num).toLocaleString('en-IN', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  }

  function updateCartUI() {
    var cart = getCart();
    var totalCount = 0;
    var totalAmount = 0;

    cart.forEach(function (item) {
      totalCount += (item.qty || 0);
      totalAmount += (item.total || 0);
    });

    // Update navbar badge
    if (navCartBadge) {
      navCartBadge.textContent = totalCount;
      if (totalCount > 0) {
        navCartBadge.classList.add('has-items');
      } else {
        navCartBadge.classList.remove('has-items');
      }
    }

    if (cartDrawerCount) {
      cartDrawerCount.textContent = totalCount + (totalCount === 1 ? ' Item' : ' Items');
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
          var row = document.createElement('div');
          row.className = 'cart-item-row';
          row.innerHTML =
            '<img src="' + (item.img || 'assets/images/products/gallery_thumb_1.jpg') + '" alt="' + item.title + '" class="cart-item-img">' +
            '<div class="cart-item-info">' +
              '<div class="cart-item-title">' + item.title + '</div>' +
              '<div class="cart-item-meta">' + item.variantName + ' &bull; ' + item.diaText + '</div>' +
              '<div class="cart-item-price">' + item.qty + ' pcs &times; ' + formatPriceINR(item.unitPrice) + ' = ' + formatPriceINR(item.total) + '</div>' +
            '</div>' +
            '<div class="cart-item-actions">' +
              '<button type="button" class="cart-item-remove-btn" data-index="' + index + '" aria-label="Remove item" title="Remove">&times;</button>' +
            '</div>';
          cartItemsList.appendChild(row);
        });

        // Add remove handlers
        var removeBtns = cartItemsList.querySelectorAll('.cart-item-remove-btn');
        removeBtns.forEach(function (btn) {
          btn.addEventListener('click', function () {
            var idx = parseInt(btn.getAttribute('data-index'), 10);
            var currentCart = getCart();
            currentCart.splice(idx, 1);
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
    }
  });

  // Expose BirlaCart globally
  window.BirlaCart = {
    get: getCart,
    save: saveCart,
    add: function (item) {
      var cart = getCart();
      // Check if duplicate item exists (matching dia and variant)
      var found = false;
      for (var i = 0; i < cart.length; i++) {
        if (cart[i].dia === item.dia && cart[i].variant === item.variant) {
          cart[i].qty += item.qty;
          cart[i].total = (cart[i].unitPrice || 0) * cart[i].qty;
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
