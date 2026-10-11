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

});
