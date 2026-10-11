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
  var autoplayInterval = 7500;
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

  // Pause on hover or focus
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

  // Initialize
  showSlide(0);
  startAutoplay();

});
