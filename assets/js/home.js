/**
 * Birla Precision Technologies — Homepage Carousel & Interactions
 * Native JavaScript (Vanilla)
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  var carouselSection = document.getElementById('heroCarousel');
  if (!carouselSection) return;

  var slides = carouselSection.querySelectorAll('.hero-slide');
  var dots = carouselSection.querySelectorAll('.carousel-dot');
  var prevBtn = carouselSection.querySelector('.carousel-btn-prev');
  var nextBtn = carouselSection.querySelector('.carousel-btn-next');

  if (slides.length <= 1) return;

  var currentIndex = 0;
  var autoplayTimer = null;
  var autoplayInterval = 4000; // 4.0 seconds automatic slideshow
  var isPaused = false;
  var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function showSlide(index) {
    if (index >= slides.length) index = 0;
    if (index < 0) index = slides.length - 1;

    slides.forEach(function (slide, i) {
      if (i === index) {
        slide.classList.add('is-active');
        slide.setAttribute('aria-hidden', 'false');
      } else {
        slide.classList.remove('is-active');
        slide.setAttribute('aria-hidden', 'true');
      }
    });

    dots.forEach(function (dot, i) {
      if (i === index) {
        dot.classList.add('is-active');
        dot.setAttribute('aria-current', 'true');
      } else {
        dot.classList.remove('is-active');
        dot.removeAttribute('aria-current');
      }
    });

    currentIndex = index;
  }

  function nextSlide() {
    showSlide(currentIndex + 1);
  }

  function prevSlide() {
    showSlide(currentIndex - 1);
  }

  function startAutoplay() {
    if (prefersReducedMotion) return;
    stopAutoplay();
    autoplayTimer = setInterval(function () {
      if (!isPaused) {
        nextSlide();
      }
    }, autoplayInterval);
  }

  function stopAutoplay() {
    if (autoplayTimer) {
      clearInterval(autoplayTimer);
      autoplayTimer = null;
    }
  }

  // Event Listeners for Prev/Next
  if (prevBtn) {
    prevBtn.addEventListener('click', function () {
      prevSlide();
      startAutoplay();
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', function () {
      nextSlide();
      startAutoplay();
    });
  }

  // Dots
  dots.forEach(function (dot) {
    dot.addEventListener('click', function () {
      var slideIdx = parseInt(dot.getAttribute('data-slide-to'), 10);
      if (!isNaN(slideIdx)) {
        showSlide(slideIdx);
        startAutoplay();
      }
    });
  });

  // Pause on hover or focus, resume on leave
  carouselSection.addEventListener('mouseenter', function () {
    isPaused = true;
  });

  carouselSection.addEventListener('mouseleave', function () {
    isPaused = false;
  });

  carouselSection.addEventListener('focusin', function () {
    isPaused = true;
  });

  carouselSection.addEventListener('focusout', function () {
    isPaused = false;
  });

  // Touch Swipe for Mobile
  var touchStartX = 0;
  var touchEndX = 0;

  carouselSection.addEventListener('touchstart', function (e) {
    touchStartX = e.changedTouches[0].screenX;
  }, { passive: true });

  carouselSection.addEventListener('touchend', function (e) {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
  }, { passive: true });

  function handleSwipe() {
    var threshold = 50;
    if (touchEndX < touchStartX - threshold) {
      nextSlide();
      startAutoplay();
    } else if (touchEndX > touchStartX + threshold) {
      prevSlide();
      startAutoplay();
    }
  }

  // Keyboard navigation when focused
  carouselSection.addEventListener('keydown', function (e) {
    if (e.key === 'ArrowLeft') {
      prevSlide();
      startAutoplay();
    } else if (e.key === 'ArrowRight') {
      nextSlide();
      startAutoplay();
    }
  });

  // Initialize Hero Carousel Autoplay
  showSlide(0);
  startAutoplay();

  // --------------------------------------------------------------------------
  // Precision Drilling Solutions Card — Automatic Slideshow & Interactive Gallery
  // --------------------------------------------------------------------------
  var solCard = document.getElementById('precisionSolutionsCard');
  var solMainImg = document.getElementById('solMainImage') || document.getElementById('solMainImg');
  var solThumbBtns = document.querySelectorAll('.sol-thumb-item');
  var solPrevBtn = document.getElementById('solThumbPrev');
  var solNextBtn = document.getElementById('solThumbNext');

  var currentSolIndex = 0;
  var solAutoplayTimer = null;
  var solAutoplayInterval = 3500; // 3.5 seconds automatic progression
  var isSolPaused = false;

  function switchSolImage(index) {
    if (!solThumbBtns || solThumbBtns.length === 0) return;
    if (index >= solThumbBtns.length) index = 0;
    if (index < 0) index = solThumbBtns.length - 1;

    solThumbBtns.forEach(function (btn, i) {
      if (i === index) {
        btn.classList.add('is-active');
      } else {
        btn.classList.remove('is-active');
      }
    });

    var targetBtn = solThumbBtns[index];
    var fullSrc = targetBtn.getAttribute('data-full-src');
    if (fullSrc && solMainImg) {
      solMainImg.classList.add('is-loading');
      var imgPreload = new Image();
      imgPreload.onload = function () {
        solMainImg.src = fullSrc;
        setTimeout(function () {
          solMainImg.classList.remove('is-loading');
        }, 60);
      };
      imgPreload.onerror = function () {
        solMainImg.src = fullSrc;
        solMainImg.classList.remove('is-loading');
      };
      imgPreload.src = fullSrc;
    }
    currentSolIndex = index;
  }

  function startSolAutoplay() {
    stopSolAutoplay();
    solAutoplayTimer = setInterval(function () {
      if (!isSolPaused) {
        switchSolImage(currentSolIndex + 1);
      }
    }, solAutoplayInterval);
  }

  function stopSolAutoplay() {
    if (solAutoplayTimer) {
      clearInterval(solAutoplayTimer);
      solAutoplayTimer = null;
    }
  }

  solThumbBtns.forEach(function (btn, idx) {
    btn.addEventListener('click', function () {
      switchSolImage(idx);
      startSolAutoplay();
    });
  });

  if (solPrevBtn) {
    solPrevBtn.addEventListener('click', function () {
      switchSolImage(currentSolIndex - 1);
      startSolAutoplay();
    });
  }

  if (solNextBtn) {
    solNextBtn.addEventListener('click', function () {
      switchSolImage(currentSolIndex + 1);
      startSolAutoplay();
    });
  }

  if (solCard) {
    solCard.addEventListener('mouseenter', function () {
      isSolPaused = true;
    });
    solCard.addEventListener('mouseleave', function () {
      isSolPaused = false;
    });
  }

  // Start automatic slideshow for Solutions Gallery
  startSolAutoplay();

  // Smooth Scroll-Scaling:
  // As user scrolls down the webpage, causes the entire section card to scale down or up smoothly
  if (solCard && window.matchMedia('(min-width: 768px)').matches) {
    var ticking = false;

    function updateCardScaleOnScroll() {
      var rect = solCard.getBoundingClientRect();
      var windowH = window.innerHeight;
      
      // Calculate how close the center of the card is to the center of the viewport
      var cardCenterY = rect.top + rect.height / 2;
      var viewCenterY = windowH / 2;
      var distFromCenter = Math.abs(cardCenterY - viewCenterY);
      var maxDist = windowH * 0.85;
      
      // Normalized distance 0 (at center) to 1 (far away)
      var normDist = Math.min(1, Math.max(0, distFromCenter / maxDist));
      
      // Scale smoothly: 1.0 at center, scaling down to 0.93 when scrolling above or below
      var scale = 1.0 - (0.07 * normDist);
      scale = Math.round(scale * 1000) / 1000;
      
      solCard.style.setProperty('--sol-scroll-scale', scale);
      ticking = false;
    }

    window.addEventListener('scroll', function () {
      if (!ticking) {
        requestAnimationFrame(updateCardScaleOnScroll);
        ticking = true;
      }
    }, { passive: true });

    // Initial check
    updateCardScaleOnScroll();
  }

  // --------------------------------------------------------------------------
  // Foundation in Numbers — Rolling Counter Animation (Image 1 Reference)
  // --------------------------------------------------------------------------
  var foundationSection = document.getElementById('about');
  var statRollNumbers = document.querySelectorAll('.stat-roll-number');

  if (foundationSection && statRollNumbers.length > 0) {
    var hasCountersAnimated = false;

    function runRollAnimation() {
      if (hasCountersAnimated) return;
      hasCountersAnimated = true;

      statRollNumbers.forEach(function (numEl) {
        var targetVal = parseInt(numEl.getAttribute('data-target'), 10) || 0;
        var duration = 2000; // 2 seconds
        var startTime = null;

        function animateNumber(now) {
          if (!startTime) startTime = now;
          var elapsed = now - startTime;
          var progress = Math.min(elapsed / duration, 1);

          // Smooth exponential ease-out
          var ease = (progress === 1) ? 1 : (1 - Math.pow(2, -10 * progress));
          var current = Math.floor(ease * targetVal);

          numEl.textContent = current.toLocaleString('en-US');

          if (progress < 1) {
            window.requestAnimationFrame(animateNumber);
          } else {
            numEl.textContent = targetVal.toLocaleString('en-US');
          }
        }

        window.requestAnimationFrame(animateNumber);
      });
    }

    if ('IntersectionObserver' in window) {
      var counterObserver = new IntersectionObserver(function (entries, observer) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            runRollAnimation();
            observer.unobserve(entry.target);
          }
        });
      }, {
        threshold: 0.2,
        rootMargin: '0px 0px -40px 0px'
      });

      counterObserver.observe(foundationSection);
    } else {
      runRollAnimation();
    }
  }

});
