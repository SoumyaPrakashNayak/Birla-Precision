/**
 * Birla Precision Technologies — Dedicated Product Page Interactions
 * Real-time Diameter & Variant Configurator, Live Pricing & Enquiry Sync
 * Supporting MM, INCH, and DG (Gauge) Unit Dropdown & Filter Modes
 * Native Vanilla JavaScript
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  // Global State
  var currentDiameter = '3.17'; // Default popular diameter (1/8")
  var currentVariant = 'itm_std'; // Default standard variant
  var currentUnit = 'mm'; // 'mm', 'inch', 'dg'
  var allSizesData = [];
  var allVariantsMap = {};

  // DOM Elements
  var diaSearchInput = document.getElementById('diaSearchInput');
  var diaDropdownWrapper = document.getElementById('diaDropdownWrapper');
  var diaInputContainer = document.getElementById('diaInputContainer');
  var diaDropdownMenu = document.getElementById('diaDropdownMenu');
  var diaMenuScroll = document.getElementById('diaMenuScroll');
  var unitSelectBox = document.getElementById('unitSelectBox');
  var unitPills = document.querySelectorAll('.unit-pill-btn');
  var variantCards = document.querySelectorAll('.variant-item-card');
  var selectedDiaText = document.getElementById('selectedDiaText');
  var diaChangeBtn = document.getElementById('diaChangeBtn');
  var commPriceDisplay = document.getElementById('commPriceDisplay');
  var commMoqDisplay = document.getElementById('commMoqDisplay');
  var cartQtyInput = document.getElementById('cartQtyInput');
  var cartQtyMinus = document.getElementById('cartQtyMinus');
  var cartQtyPlus = document.getElementById('cartQtyPlus');
  var cartMoqPill = document.getElementById('cartMoqPill');
  var cartSubtotalDisplay = document.getElementById('cartSubtotalDisplay');
  var addToCartBtn = document.getElementById('addToCartBtn');
  var cartBtnText = document.getElementById('cartBtnText');
  var catalogueTableBody = document.getElementById('catalogueTableBody');
  var tableSearchInput = document.getElementById('tableSearchInput');
  var tableRowsCount = document.getElementById('tableRowsCount');

  // Enquiry Form Elements
  var enquiryForm = document.getElementById('productEnquiryForm');
  var enquiryDiaInput = document.getElementById('enquiryDiaInput');
  var enquiryVariantInput = document.getElementById('enquiryVariantInput');
  var enquiryQuantityInput = document.getElementById('enquiryQuantityInput');
  var enquiryPriceBasisInput = document.getElementById('enquiryPriceBasisInput');
  var enquiryMoqNotice = document.getElementById('enquiryMoqNotice');
  var enquiryFeedback = document.getElementById('enquiryFeedback');
  var enquirySubmitBtn = document.getElementById('enquirySubmitBtn');

  // Tab Elements
  var tabButtons = document.querySelectorAll('.tab-btn');
  var tabPanels = document.querySelectorAll('.tab-content-panel');

  // Gallery Elements
  var galleryStage = document.querySelector('.gallery-stage');
  var galleryMainImage = document.getElementById('galleryMainImage');
  var galleryThumbs = document.querySelectorAll('.gallery-thumb-btn');
  var galleryZoomBtn = document.getElementById('galleryZoomBtn');
  var galleryLightboxModal = document.getElementById('galleryLightboxModal');
  var lightboxBackdrop = document.getElementById('lightboxBackdrop');
  var lightboxCloseBtn = document.getElementById('lightboxCloseBtn');
  var lightboxImage = document.getElementById('lightboxImage');
  var lightboxCaption = document.getElementById('lightboxCaption');

  var currentFullImgUrl = galleryMainImage ? galleryMainImage.src : '';
  var currentCaption = 'Jobber Drills Series Lineup on Architectural Pedestals';

  // 1. Gallery Thumbnail Switcher
  if (galleryThumbs.length > 0 && galleryMainImage) {
    galleryThumbs.forEach(function (thumb) {
      thumb.addEventListener('click', function () {
        galleryThumbs.forEach(function (t) { t.classList.remove('is-active'); });
        thumb.classList.add('is-active');
        var fullSrc = thumb.getAttribute('data-full-img');
        var caption = thumb.getAttribute('data-caption') || 'HSS Parallel Shank Jobber Series';
        if (fullSrc) {
          currentFullImgUrl = fullSrc;
          currentCaption = caption;
          galleryMainImage.classList.add('is-loading');
          var preloadImg = new Image();
          preloadImg.onload = function () {
            galleryMainImage.src = fullSrc;
            galleryMainImage.alt = caption;
            galleryMainImage.classList.remove('is-loading');
          };
          preloadImg.src = fullSrc;
        }
      });
    });
  }

  // Gallery Lightbox Zoom Handlers
  function openLightbox() {
    if (!galleryLightboxModal || !lightboxImage) return;
    lightboxImage.src = currentFullImgUrl || (galleryMainImage ? galleryMainImage.src : '');
    if (lightboxCaption) {
      lightboxCaption.textContent = currentCaption;
    }
    galleryLightboxModal.classList.add('is-open');
    galleryLightboxModal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox() {
    if (!galleryLightboxModal) return;
    galleryLightboxModal.classList.remove('is-open');
    galleryLightboxModal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  if (galleryZoomBtn) {
    galleryZoomBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      openLightbox();
    });
  }

  if (galleryStage) {
    galleryStage.addEventListener('click', function (e) {
      if (e.target.closest('.gallery-badges-strip')) return;
      openLightbox();
    });
  }

  if (lightboxCloseBtn) {
    lightboxCloseBtn.addEventListener('click', closeLightbox);
  }

  if (lightboxBackdrop) {
    lightboxBackdrop.addEventListener('click', closeLightbox);
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && galleryLightboxModal && galleryLightboxModal.classList.contains('is-open')) {
      closeLightbox();
    }
  });

  // 2. Tab Navigation
  if (tabButtons.length > 0) {
    tabButtons.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var targetTab = btn.getAttribute('data-tab');
        tabButtons.forEach(function (b) { b.classList.remove('is-active'); });
        tabPanels.forEach(function (p) { p.classList.remove('is-active'); });

        btn.classList.add('is-active');
        var panel = document.getElementById('tab-' + targetTab);
        if (panel) {
          panel.classList.add('is-active');
        }
      });
    });
  }

  // 3. Load Catalogue Data from API
  fetch('../api/get_product_data.php?action=all')
    .then(function (res) { return res.json(); })
    .then(function (json) {
      if (json && json.status === 'success') {
        allSizesData = json.sizes || [];
        allVariantsMap = json.variants || {};

        // Parse URL params
        var urlParams = new URLSearchParams(window.location.search);
        var paramDia = urlParams.get('dia');
        var paramVar = urlParams.get('variant');

        if (paramDia) {
          var matched = findSizeMatch(paramDia);
          if (matched) {
            currentDiameter = matched.mm;
          }
        }
        if (paramVar && allVariantsMap[paramVar]) {
          currentVariant = paramVar;
        }

        // Initialize UI with loaded data
        renderDiameterDropdownMenu();
        updateConfiguratorState();
        renderCatalogueTable(allSizesData);
      }
    })
    .catch(function (err) {
      console.warn('Could not fetch dynamic API data, using embedded state:', err);
    });

  // 4. Unit Selector Sync (Dropdown box + Toggle Pills)
  function setUnit(unit) {
    currentUnit = unit;
    if (unitSelectBox) {
      unitSelectBox.value = unit;
    }
    unitPills.forEach(function (pill) {
      if (pill.getAttribute('data-unit') === unit) {
        pill.classList.add('is-active');
        pill.setAttribute('aria-checked', 'true');
      } else {
        pill.classList.remove('is-active');
        pill.setAttribute('aria-checked', 'false');
      }
    });
    renderDiameterDropdownMenu();
  }

  if (unitSelectBox) {
    unitSelectBox.addEventListener('change', function () {
      setUnit(this.value);
    });
  }

  unitPills.forEach(function (pill) {
    pill.addEventListener('click', function () {
      var unit = this.getAttribute('data-unit');
      setUnit(unit);
    });
  });

  // 5. Render Diameter Dropdown Items
  function renderDiameterDropdownMenu(filterQuery) {
    if (!diaMenuScroll) return;

    var query = (filterQuery || '').toLowerCase().trim();
    var filtered = allSizesData.filter(function (row) {
      if (!row) return false;

      // Unit filter
      if (currentUnit === 'inch' && !row.inch) return false;
      if (currentUnit === 'dg' && !row.dg) return false;

      // Text query filter
      if (query) {
        var mmMatch = (row.mm || '').toLowerCase().indexOf(query) !== -1;
        var inchMatch = (row.inch || '').toLowerCase().indexOf(query) !== -1;
        var dgMatch = (row.dg || '').toLowerCase().indexOf(query) !== -1;
        return mmMatch || inchMatch || dgMatch;
      }
      return true;
    });

    diaMenuScroll.innerHTML = '';

    if (filtered.length === 0) {
      var emptyMsg = document.createElement('div');
      emptyMsg.className = 'dia-menu-item';
      emptyMsg.style.color = '#888';
      emptyMsg.textContent = 'No matching diameters found';
      diaMenuScroll.appendChild(emptyMsg);
      return;
    }

    filtered.forEach(function (row) {
      var item = document.createElement('div');
      item.className = 'dia-menu-item' + (row.mm === currentDiameter ? ' is-selected' : '');
      
      var label = formatDiameterLabel(row, currentUnit);
      item.innerHTML = '<span>' + label + '</span>';

      item.addEventListener('click', function (e) {
        e.stopPropagation();
        selectDiameter(row.mm);
        closeDiameterDropdown();
      });

      diaMenuScroll.appendChild(item);
    });
  }

  function formatDiameterLabel(row, unit) {
    if (unit === 'inch' && row.inch) {
      return row.inch + ' inch (' + row.mm + ' mm)';
    } else if (unit === 'dg' && row.dg) {
      return 'DG ' + row.dg + ' (' + row.mm + ' mm)';
    } else {
      var text = row.mm + ' mm';
      if (row.inch) text += ' (' + row.inch + ' inch)';
      else if (row.dg) text += ' (DG ' + row.dg + ')';
      return text;
    }
  }

  // 6. Diameter Dropdown Open / Close Behavior
  function openDiameterDropdown() {
    if (diaDropdownMenu && diaInputContainer) {
      diaDropdownMenu.classList.add('is-open');
      diaInputContainer.classList.add('is-open');
      renderDiameterDropdownMenu(diaSearchInput.value);
    }
  }

  function closeDiameterDropdown() {
    if (diaDropdownMenu && diaInputContainer) {
      diaDropdownMenu.classList.remove('is-open');
      diaInputContainer.classList.remove('is-open');
    }
  }

  if (diaInputContainer && diaSearchInput) {
    diaInputContainer.addEventListener('click', function () {
      openDiameterDropdown();
      diaSearchInput.focus();
    });

    diaSearchInput.addEventListener('focus', function () {
      openDiameterDropdown();
    });

    diaSearchInput.addEventListener('input', function () {
      renderDiameterDropdownMenu(this.value);
    });

    document.addEventListener('click', function (e) {
      if (diaDropdownWrapper && !diaDropdownWrapper.contains(e.target)) {
        closeDiameterDropdown();
      }
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        closeDiameterDropdown();
      }
    });
  }

  if (diaChangeBtn) {
    diaChangeBtn.addEventListener('click', function () {
      openDiameterDropdown();
      if (diaSearchInput) {
        diaSearchInput.focus();
        diaSearchInput.select();
      }
    });
  }

  // 7. Select Diameter
  function selectDiameter(mm) {
    currentDiameter = mm;
    updateConfiguratorState();
  }

  // 8. Variant Cards Selection
  variantCards.forEach(function (card) {
    card.addEventListener('click', function () {
      var variantCode = this.getAttribute('data-variant');
      if (variantCode) {
        currentVariant = variantCode;
        updateConfiguratorState();
      }
    });
  });

  // 9. Update Full Configurator UI State
  function updateConfiguratorState() {
    var sizeRow = allSizesData.find(function (r) {
      return parseFloat(r.mm) === parseFloat(currentDiameter);
    });

    if (!sizeRow && allSizesData.length > 0) {
      sizeRow = allSizesData[0];
      currentDiameter = sizeRow.mm;
    }

    if (!sizeRow) return;

    // Update Input Display
    if (diaSearchInput) {
      diaSearchInput.value = formatDiameterLabel(sizeRow, currentUnit);
    }

    // Update Summary Box
    if (selectedDiaText) {
      selectedDiaText.textContent = formatDiameterLabel(sizeRow, 'mm');
    }

    // Update Variant Cards Active Class
    variantCards.forEach(function (card) {
      var vCode = card.getAttribute('data-variant');
      if (vCode === currentVariant) {
        card.classList.add('is-active');
      } else {
        card.classList.remove('is-active');
      }

      // Update in stock or unavailable
      var price = sizeRow[vCode];
      var stockTag = card.querySelector('.variant-stock-pill');
      if (stockTag) {
        if (price !== null && price !== undefined) {
          stockTag.className = 'variant-stock-pill stock-in';
          stockTag.innerHTML = '<span class="stock-dot"></span> In Stock';
        } else {
          stockTag.className = 'variant-stock-pill stock-limited';
          stockTag.innerHTML = '<span class="stock-dot"></span> Custom Order';
        }
      }
    });

    // Update Commercial Price
    var currentPrice = sizeRow[currentVariant];
    if (commPriceDisplay) {
      if (currentPrice !== null && currentPrice !== undefined) {
        commPriceDisplay.textContent = '₹ ' + formatINR(currentPrice);
      } else {
        commPriceDisplay.textContent = 'Available on Request';
      }
    }

    // Update MOQ Display
    var moq = sizeRow.moq || 100;
    if (commMoqDisplay) {
      commMoqDisplay.textContent = moq + ' Pieces';
    }

    // Update Enquiry Form
    if (enquiryDiaInput) {
      enquiryDiaInput.value = sizeRow.mm + ' mm' + (sizeRow.inch ? ' (' + sizeRow.inch + '")' : '');
    }
    if (enquiryVariantInput && allVariantsMap[currentVariant]) {
      enquiryVariantInput.value = allVariantsMap[currentVariant].name;
    }
    if (enquiryQuantityInput) {
      enquiryQuantityInput.value = moq;
      enquiryQuantityInput.min = moq;
    }
    if (enquiryMoqNotice) {
      enquiryMoqNotice.textContent = 'Standard MOQ for ' + sizeRow.mm + ' mm is ' + moq + ' pcs (Multiples of 10).';
    }
    if (enquiryPriceBasisInput) {
      if (currentPrice) {
        enquiryPriceBasisInput.value = 'Catalogue ₹ ' + formatINR(currentPrice) + ' per 10 pcs (April 2026 Price List)';
      } else {
        enquiryPriceBasisInput.value = 'Quotation on Request (April 2026 Price List)';
      }
    }

    // Update Cart Quantity & MOQ pill
    var currentMoq = parseInt(sizeRow.moq, 10) || 100;
    if (cartMoqPill) {
      cartMoqPill.textContent = 'MOQ: ' + currentMoq + ' pcs';
    }
    if (cartQtyInput) {
      cartQtyInput.min = currentMoq;
      cartQtyInput.step = currentMoq;
      var curVal = parseInt(cartQtyInput.value, 10);
      if (isNaN(curVal) || curVal < currentMoq) {
        cartQtyInput.value = currentMoq;
      }
    }
    updateCartSubtotal(sizeRow);

    // Highlight row in full table
    var rows = catalogueTableBody ? catalogueTableBody.querySelectorAll('tr') : [];
    rows.forEach(function (tr) {
      if (tr.getAttribute('data-dia') === sizeRow.mm) {
        tr.classList.add('is-selected-row');
      } else {
        tr.classList.remove('is-selected-row');
      }
    });
  }

  // Helper to get currently active size row object
  function getCurrentSizeRow() {
    var sizeRow = allSizesData.find(function (r) {
      return parseFloat(r.mm) === parseFloat(currentDiameter);
    });
    return sizeRow || (allSizesData.length > 0 ? allSizesData[0] : null);
  }

  // Update Cart Subtotal display
  function updateCartSubtotal(row) {
    if (!cartSubtotalDisplay) return;
    var size = row || getCurrentSizeRow();
    if (!size) return;
    var moq = parseInt(size.moq, 10) || 100;
    var qty = cartQtyInput ? (parseInt(cartQtyInput.value, 10) || moq) : moq;
    if (qty < moq) qty = moq;

    var currentPrice = size[currentVariant];
    if (currentPrice !== null && currentPrice !== undefined && !isNaN(parseFloat(currentPrice))) {
      var unitPrice = parseFloat(currentPrice) / 10.0;
      var subtotal = unitPrice * qty;
      cartSubtotalDisplay.textContent = '₹ ' + formatINR(subtotal);
    } else {
      cartSubtotalDisplay.textContent = 'Quote Required';
    }
  }

  // 9b. Commercial Cart Stepper & Add to Cart Handlers (multiples of 10 pcs as per catalogue)
  if (cartQtyMinus) {
    cartQtyMinus.addEventListener('click', function () {
      var row = getCurrentSizeRow();
      var moq = row ? (parseInt(row.moq, 10) || 100) : 100;
      var step = 10;
      var curVal = cartQtyInput ? (parseInt(cartQtyInput.value, 10) || moq) : moq;
      var newVal = curVal - step;
      if (newVal < moq) newVal = moq;
      if (cartQtyInput) cartQtyInput.value = newVal;
      updateCartSubtotal(row);
    });
  }

  if (cartQtyPlus) {
    cartQtyPlus.addEventListener('click', function () {
      var row = getCurrentSizeRow();
      var moq = row ? (parseInt(row.moq, 10) || 100) : 100;
      var step = 10;
      var curVal = cartQtyInput ? (parseInt(cartQtyInput.value, 10) || moq) : moq;
      var newVal = curVal + step;
      if (cartQtyInput) cartQtyInput.value = newVal;
      updateCartSubtotal(row);
    });
  }

  if (cartQtyInput) {
    cartQtyInput.addEventListener('change', function () {
      var row = getCurrentSizeRow();
      var moq = row ? (parseInt(row.moq, 10) || 100) : 100;
      var val = parseInt(this.value, 10);
      if (isNaN(val) || val < moq) {
        val = moq;
      } else {
        var rem = val % 10;
        if (rem !== 0) {
          val = Math.ceil(val / 10) * 10;
        }
      }
      this.value = val;
      updateCartSubtotal(row);
    });

    cartQtyInput.addEventListener('input', function () {
      var row = getCurrentSizeRow();
      updateCartSubtotal(row);
    });
  }

  if (addToCartBtn) {
    addToCartBtn.addEventListener('click', function () {
      var row = getCurrentSizeRow();
      if (!row) return;
      var moq = parseInt(row.moq, 10) || 100;
      var qty = cartQtyInput ? (parseInt(cartQtyInput.value, 10) || moq) : moq;
      if (qty < moq) qty = moq;

      var currentPrice = row[currentVariant];
      var unitPrice = (currentPrice !== null && currentPrice !== undefined && !isNaN(parseFloat(currentPrice))) ? (parseFloat(currentPrice) / 10.0) : 0;
      var total = unitPrice * qty;
      var variantInfo = allVariantsMap[currentVariant] || { name: currentVariant.toUpperCase() };

      var cartItem = {
        dia: row.mm,
        variant: currentVariant,
        title: 'HSS Jobber Series Twist Drill',
        variantName: variantInfo.name || currentVariant.toUpperCase(),
        diaText: row.mm + ' mm' + (row.inch ? ' (' + row.inch + '")' : ''),
        qty: qty,
        unitPrice: unitPrice,
        total: total,
        moq: moq,
        img: 'assets/images/products/gallery_thumb_1.jpg'
      };

      // Show loader state on button
      addToCartBtn.disabled = true;
      var originalText = cartBtnText ? cartBtnText.textContent : 'Add to Cart';
      if (cartBtnText) {
        cartBtnText.innerHTML = '<span class="cart-btn-spinner"></span> Adding to Cart...';
      }

      setTimeout(function () {
        if (window.BirlaCart && typeof window.BirlaCart.add === 'function') {
          window.BirlaCart.add(cartItem);
        }

        addToCartBtn.disabled = false;
        if (cartBtnText) {
          cartBtnText.textContent = 'Added ' + qty + ' pcs to Cart ✓';
          addToCartBtn.classList.add('is-added');
          setTimeout(function () {
            cartBtnText.textContent = originalText;
            addToCartBtn.classList.remove('is-added');
          }, 1800);
        }
      }, 400);
    });
  }

  // 10. Render Full Catalogue Table
  function renderCatalogueTable(data) {
    if (!catalogueTableBody) return;
    catalogueTableBody.innerHTML = '';

    if (tableRowsCount) {
      tableRowsCount.textContent = 'Showing ' + data.length + ' diameter specifications (IS : 5101)';
    }

    data.forEach(function (row) {
      var tr = document.createElement('tr');
      tr.setAttribute('data-dia', row.mm);
      if (row.mm === currentDiameter) {
        tr.className = 'is-selected-row';
      }

      var html = '<td class="dia-cell"><strong>' + escapeHtml(row.mm) + '</strong></td>';
      html += '<td>' + (row.inch ? escapeHtml(row.inch) : '<span class="price-dash">-</span>') + '</td>';
      html += '<td>' + (row.dg ? escapeHtml(row.dg) : '<span class="price-dash">-</span>') + '</td>';

      ['itm_std', 'itm_std_tin', 'panther', 'ninja', 'forgeline', 'hathyar'].forEach(function (v) {
        if (row[v]) {
          html += '<td><span class="price-tag-table">₹' + formatINR(row[v]) + '</span></td>';
        } else {
          html += '<td><span class="price-dash">—</span></td>';
        }
      });

      html += '<td><span class="badge badge-light">' + (row.moq || 100) + '</span></td>';
      tr.innerHTML = html;

      tr.addEventListener('click', function () {
        selectDiameter(row.mm);
        // Scroll to configurator
        var overview = document.getElementById('productOverview');
        if (overview) {
          overview.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });

      catalogueTableBody.appendChild(tr);
    });
  }

  // 11. Table Filter Search
  if (tableSearchInput) {
    tableSearchInput.addEventListener('input', function () {
      var val = this.value.trim().toLowerCase();
      var filtered = allSizesData.filter(function (r) {
        if (!val) return true;
        var mm = (r.mm || '').toLowerCase();
        var inch = (r.inch || '').toLowerCase();
        var dg = (r.dg || '').toLowerCase();
        return mm.indexOf(val) !== -1 || inch.indexOf(val) !== -1 || dg.indexOf(val) !== -1;
      });
      renderCatalogueTable(filtered);
    });
  }

  // 12. Helper Functions
  function findSizeMatch(query) {
    if (!query) return null;
    var q = query.trim().toLowerCase();
    for (var i = 0; i < allSizesData.length; i++) {
      var row = allSizesData[i];
      if (row.mm === q || parseFloat(row.mm) === parseFloat(q)) return row;
      if (row.inch && row.inch.toLowerCase() === q) return row;
      if (row.dg && ('dg ' + row.dg).toLowerCase() === q) return row;
    }
    return null;
  }

  function formatINR(val) {
    var num = parseFloat(val);
    if (isNaN(num)) return val;
    return num.toLocaleString('en-IN', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
  }

  function escapeHtml(text) {
    if (text === null || text === undefined) return '';
    return String(text)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

});
