/**
 * Birla Precision Technologies — Dedicated Product Page Interactions
 * Real-time Diameter & Variant Configurator, Live Pricing & Enquiry Sync
 * Supporting MM, INCH, and DG (Gauge) Unit Dropdown & Filter Modes
 * Native Vanilla JavaScript
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  // Global State
  var currentDiameter = '3.17'; // Default popular diameter
  var currentVariant = 'itm_std'; // Default standard variant
  var allSizesData = [];
  var allVariantsMap = {};
  var collectiveItems = [];

  // DOM Elements
  var diaSearchInput = document.getElementById('diaSearchInput');
  var diaDropdownWrapper = document.getElementById('diaDropdownWrapper');
  var diaInputContainer = document.getElementById('diaInputContainer');
  var diaDropdownMenu = document.getElementById('diaDropdownMenu');
  var diaMenuScroll = document.getElementById('diaMenuScroll');
  var addDiaToListBtn = document.getElementById('addDiaToListBtn');
  var quickAddPills = document.getElementById('quickAddPills');
  var variantCards = document.querySelectorAll('.variant-item-card');
  var selectedDiaText = document.getElementById('selectedDiaText');
  var diaChangeBtn = document.getElementById('diaChangeBtn');
  var commMoqDisplay = document.getElementById('commMoqDisplay');
  var collectiveItemsContainer = document.getElementById('collectiveItemsContainer');
  var collectiveCountBadge = document.getElementById('collectiveCountBadge');
  var collectiveAddMoreBtn = document.getElementById('collectiveAddMoreBtn');
  var addToCartBtn = document.getElementById('addToCartBtn');
  var cartBtnText = document.getElementById('cartBtnText');
  var requestQuotationBtn = document.getElementById('requestQuotationBtn');
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

        // Initialize collective list with initial selected diameter
        var initMoq = 200;
        var initRow = allSizesData.find(function (r) {
          return parseFloat(r.mm) === parseFloat(currentDiameter);
        });
        if (initRow) initMoq = parseInt(initRow.moq, 10) || 100;
        var initVarInfo = allVariantsMap[currentVariant] || { name: 'ITM STD.' };

        collectiveItems = [
          {
            mm: currentDiameter,
            variant: currentVariant,
            variantName: initVarInfo.name || 'ITM STD.',
            qty: initMoq,
            moq: initMoq
          }
        ];

        // Initialize UI with loaded data
        renderDiameterDropdownMenu();
        updateConfiguratorState();
        renderCollectiveList();

        // Check if redirected from cart or hash is #enquiry
        if (window.location.hash === '#enquiry' || (window.BirlaCart && window.BirlaCart.get().length > 0)) {
          syncEnquiryForm();
        }
      }
    })
    .catch(function (err) {
      console.warn('Could not fetch dynamic API data, using embedded state:', err);
    });

  // 4. Render Diameter Dropdown Items (Metric mm only)
  function renderDiameterDropdownMenu(filterQuery) {
    if (!diaMenuScroll) return;

    var query = (filterQuery || '').toLowerCase().trim();
    var filtered = allSizesData.filter(function (row) {
      if (!row || !row.mm) return false;
      if (query) {
        return (row.mm || '').toLowerCase().indexOf(query) !== -1;
      }
      return true;
    });

    diaMenuScroll.innerHTML = '';

    if (filtered.length === 0) {
      var emptyMsg = document.createElement('div');
      emptyMsg.className = 'dia-menu-item';
      emptyMsg.style.color = '#888';
      emptyMsg.textContent = 'No matching metric diameters found';
      diaMenuScroll.appendChild(emptyMsg);
      return;
    }

    filtered.forEach(function (row) {
      var item = document.createElement('div');
      item.className = 'dia-menu-item' + (row.mm === currentDiameter ? ' is-selected' : '');
      item.innerHTML = '<span>' + escapeHtml(row.mm) + ' mm</span>';

      item.addEventListener('click', function (e) {
        e.stopPropagation();
        selectDiameter(row.mm);
        closeDiameterDropdown();
      });

      diaMenuScroll.appendChild(item);
    });
  }

  function formatDiameterLabel(row) {
    if (!row) return '';
    return row.mm + ' mm';
  }

  // 5. Diameter Dropdown Open / Close Behavior
  function openDiameterDropdown() {
    if (diaDropdownMenu && diaInputContainer) {
      diaDropdownMenu.classList.add('is-open');
      diaInputContainer.classList.add('is-open');
      renderDiameterDropdownMenu(diaSearchInput ? diaSearchInput.value : '');
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

  // 6. Select Diameter (in mm)
  function selectDiameter(mm) {
    currentDiameter = mm;
    updateConfiguratorState();
  }

  // 7. Variant Cards Selection
  variantCards.forEach(function (card) {
    card.addEventListener('click', function () {
      var variantCode = this.getAttribute('data-variant');
      if (variantCode) {
        currentVariant = variantCode;
        updateConfiguratorState();
      }
    });
  });

  // 8. Update Full Configurator UI State (Metric mm only, NO prices displayed)
  function updateConfiguratorState() {
    var sizeRow = allSizesData.find(function (r) {
      return parseFloat(r.mm) === parseFloat(currentDiameter);
    });

    if (!sizeRow && allSizesData.length > 0) {
      sizeRow = allSizesData[0];
      currentDiameter = sizeRow.mm;
    }

    if (!sizeRow) return;

    // Update Input Display in mm only
    if (diaSearchInput) {
      diaSearchInput.value = sizeRow.mm + ' mm';
    }

    // Update Summary Box in mm only
    if (selectedDiaText) {
      selectedDiaText.textContent = sizeRow.mm + ' mm';
    }

    // Update Variant Cards Active Class
    variantCards.forEach(function (card) {
      var vCode = card.getAttribute('data-variant');
      if (vCode === currentVariant) {
        card.classList.add('is-active');
      } else {
        card.classList.remove('is-active');
      }

      var stockTag = card.querySelector('.variant-stock-pill');
      if (stockTag) {
        stockTag.className = 'variant-stock-pill stock-in';
        stockTag.innerHTML = '<span class="stock-dot"></span> In Stock';
      }
    });

    // Update MOQ Display
    var moq = sizeRow.moq || 100;
    if (commMoqDisplay) {
      commMoqDisplay.textContent = 'MOQ: ' + moq + ' pcs (Multiples of 10)';
    }

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

  // 9. Collective Multi-Size Management
  function renderCollectiveList() {
    if (!collectiveItemsContainer) return;
    collectiveItemsContainer.innerHTML = '';

    if (collectiveItems.length === 0) {
      var emptyDiv = document.createElement('div');
      emptyDiv.className = 'collective-empty-msg';
      emptyDiv.style.padding = '14px';
      emptyDiv.style.textAlign = 'center';
      emptyDiv.style.color = '#9CA3AF';
      emptyDiv.style.fontSize = '12px';
      emptyDiv.textContent = 'No sizes selected. Pick a size in mm above and click "+ Add Size".';
      collectiveItemsContainer.appendChild(emptyDiv);

      if (collectiveCountBadge) collectiveCountBadge.textContent = '0 Sizes';
      if (cartBtnText) cartBtnText.textContent = 'Add to Cart';
      syncEnquiryForm();
      return;
    }

    collectiveItems.forEach(function (item, idx) {
      var row = document.createElement('div');
      row.className = 'collective-item-row';
      row.innerHTML =
        '<div class="c-item-left">' +
          '<span class="c-size-badge">' + escapeHtml(item.mm) + ' mm</span>' +
          '<span class="c-variant-badge">' + escapeHtml(item.variantName) + '</span>' +
          '<span class="c-moq-label">MOQ: ' + item.moq + ' pcs</span>' +
        '</div>' +
        '<div class="c-item-right">' +
          '<div class="c-stepper-box">' +
            '<button type="button" class="c-step-btn c-step-minus" data-idx="' + idx + '" aria-label="Decrease quantity">&minus;</button>' +
            '<input type="number" class="c-step-input" data-idx="' + idx + '" value="' + item.qty + '" min="' + item.moq + '" step="10">' +
            '<button type="button" class="c-step-btn c-step-plus" data-idx="' + idx + '" aria-label="Increase quantity">&plus;</button>' +
          '</div>' +
          '<span class="c-pcs-tag">pcs</span>' +
          '<button type="button" class="c-item-remove-btn" data-idx="' + idx + '" title="Remove ' + item.mm + ' mm" aria-label="Remove ' + item.mm + ' mm">' +
            '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' +
              '<line x1="18" y1="6" x2="6" y2="18"></line>' +
              '<line x1="6" y1="6" x2="18" y2="18"></line>' +
            '</svg>' +
          '</button>' +
        '</div>';

      collectiveItemsContainer.appendChild(row);
    });

    // Wire up stepper decrease
    var minusBtns = collectiveItemsContainer.querySelectorAll('.c-step-minus');
    minusBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var idx = parseInt(this.getAttribute('data-idx'), 10);
        if (!collectiveItems[idx]) return;
        var moq = collectiveItems[idx].moq || 100;
        var newQty = collectiveItems[idx].qty - 10;
        if (newQty < moq) newQty = moq;
        collectiveItems[idx].qty = newQty;
        renderCollectiveList();
      });
    });

    // Wire up stepper increase
    var plusBtns = collectiveItemsContainer.querySelectorAll('.c-step-plus');
    plusBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var idx = parseInt(this.getAttribute('data-idx'), 10);
        if (!collectiveItems[idx]) return;
        collectiveItems[idx].qty += 10;
        renderCollectiveList();
      });
    });

    // Wire up direct input change
    var inputs = collectiveItemsContainer.querySelectorAll('.c-step-input');
    inputs.forEach(function (inp) {
      inp.addEventListener('change', function () {
        var idx = parseInt(this.getAttribute('data-idx'), 10);
        if (!collectiveItems[idx]) return;
        var moq = collectiveItems[idx].moq || 100;
        var val = parseInt(this.value, 10);
        if (isNaN(val) || val < moq) val = moq;
        var rem = val % 10;
        if (rem !== 0) val = Math.ceil(val / 10) * 10;
        collectiveItems[idx].qty = val;
        renderCollectiveList();
      });
    });

    // Wire up remove size button
    var removeBtns = collectiveItemsContainer.querySelectorAll('.c-item-remove-btn');
    removeBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var idx = parseInt(this.getAttribute('data-idx'), 10);
        collectiveItems.splice(idx, 1);
        renderCollectiveList();
      });
    });

    // Update count badge & button text
    if (collectiveCountBadge) {
      collectiveCountBadge.textContent = collectiveItems.length + (collectiveItems.length === 1 ? ' Size' : ' Sizes');
    }
    if (cartBtnText) {
      var totalPcs = collectiveItems.reduce(function (sum, it) { return sum + it.qty; }, 0);
      cartBtnText.textContent = 'Add ' + collectiveItems.length + ' Size' + (collectiveItems.length === 1 ? '' : 's') + ' (' + totalPcs + ' pcs) to Cart';
    }

    syncEnquiryForm();
  }

  function addSizeToCollective(mm, variant) {
    var sizeRow = allSizesData.find(function (r) {
      return parseFloat(r.mm) === parseFloat(mm);
    });
    if (!sizeRow) return;
    var targetVariant = variant || currentVariant;
    var moq = parseInt(sizeRow.moq, 10) || 100;
    var variantInfo = allVariantsMap[targetVariant] || { name: targetVariant.toUpperCase() };
    var variantName = variantInfo.name || targetVariant.toUpperCase();

    var existing = collectiveItems.find(function (it) {
      return parseFloat(it.mm) === parseFloat(sizeRow.mm) && it.variant === targetVariant;
    });

    if (existing) {
      existing.qty += 10;
    } else {
      collectiveItems.push({
        mm: sizeRow.mm,
        variant: targetVariant,
        variantName: variantName,
        qty: moq,
        moq: moq
      });
    }

    currentDiameter = sizeRow.mm;
    updateConfiguratorState();
    renderCollectiveList();
  }

  var enquiryCartSummaryBox = document.getElementById('enquiryCartSummaryBox');
  var enquirySummaryCount = document.getElementById('enquirySummaryCount');
  var enquirySummaryItems = document.getElementById('enquirySummaryItems');

  function syncEnquiryForm(customItems) {
    var itemsToSync = customItems;
    if (!itemsToSync || !Array.isArray(itemsToSync) || itemsToSync.length === 0) {
      if (collectiveItems && collectiveItems.length > 0) {
        itemsToSync = collectiveItems;
      } else if (window.BirlaCart && typeof window.BirlaCart.get === 'function') {
        itemsToSync = window.BirlaCart.get();
      }
    }

    if (!itemsToSync || itemsToSync.length === 0) {
      if (enquiryCartSummaryBox) enquiryCartSummaryBox.style.display = 'none';
      return;
    }

    // Render visual breakdown box in enquiry card
    if (enquiryCartSummaryBox && enquirySummaryItems) {
      enquiryCartSummaryBox.style.display = 'block';
      if (enquirySummaryCount) {
        enquirySummaryCount.textContent = itemsToSync.length + (itemsToSync.length === 1 ? ' Item' : ' Items');
      }
      enquirySummaryItems.innerHTML = '';

      itemsToSync.forEach(function (it) {
        var dia = it.diaText || (it.mm ? (it.mm + ' mm') : '');
        var vName = it.variantName || 'ITM STD.';
        var qty = it.qty || 100;
        var chip = document.createElement('div');
        chip.className = 'enquiry-summary-chip';
        chip.innerHTML =
          '<div class="chip-main">' +
            '<strong class="chip-dia">' + escapeHtml(dia) + '</strong>' +
            '<span class="chip-variant">' + escapeHtml(vName) + '</span>' +
          '</div>' +
          '<div class="chip-qty-wrap">' +
            '<span class="chip-qty">' + qty + ' pcs</span>' +
          '</div>';
        enquirySummaryItems.appendChild(chip);
      });
    }

    if (enquiryDiaInput) {
      var diaDescriptions = itemsToSync.map(function (it) {
        var dia = it.diaText || (it.mm ? (it.mm + ' mm') : '');
        var vName = it.variantName || 'ITM STD.';
        var qty = it.qty || 100;
        return dia + ' (' + qty + ' pcs - ' + vName + ')';
      });
      enquiryDiaInput.value = diaDescriptions.join(', ');
    }

    var totalQty = itemsToSync.reduce(function (sum, it) { return sum + (parseInt(it.qty, 10) || 0); }, 0);
    if (enquiryQuantityInput) {
      enquiryQuantityInput.value = totalQty;
    }

    if (enquiryVariantInput) {
      var vNames = itemsToSync.map(function (it) { return it.variantName || 'ITM STD.'; })
        .filter(function (v, i, a) { return a.indexOf(v) === i; });
      enquiryVariantInput.value = vNames.join(' / ');
    }

    if (enquiryPriceBasisInput) {
      enquiryPriceBasisInput.value = 'Official B2B Quotation on Request (IS : 5101 Conformance)';
    }

    // Populate message with detailed list if message is empty
    var enquiryMessageInput = document.getElementById('enquiryMessageInput');
    if (enquiryMessageInput && !enquiryMessageInput.value.trim()) {
      var msgLines = ['Kindly provide official quotation for the following tooling specifications:'];
      itemsToSync.forEach(function (it, idx) {
        var dia = it.diaText || (it.mm ? (it.mm + ' mm') : '');
        var vName = it.variantName || 'ITM STD.';
        var qty = it.qty || 100;
        msgLines.push((idx + 1) + '. HSS Jobber Series Drill — ' + dia + ' — Variant: ' + vName + ' — Quantity: ' + qty + ' pcs');
      });
      msgLines.push('\nDelivery terms: F.O.R. Destination. Please share best commercial discount and delivery timeline.');
      enquiryMessageInput.value = msgLines.join('\n');
    }
  }

  window.syncCartToEnquiryForm = syncEnquiryForm;

  // Quick-Add Popular Metric Sizes Buttons
  var quickBtns = document.querySelectorAll('.quick-size-btn');
  quickBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var mm = this.getAttribute('data-mm');
      if (mm) {
        addSizeToCollective(mm, currentVariant);
      }
    });
  });

  // + Add Size Button next to Diameter Search
  if (addDiaToListBtn) {
    addDiaToListBtn.addEventListener('click', function () {
      addSizeToCollective(currentDiameter, currentVariant);
    });
  }

  // + Add Another Size Button inside Collective Box
  if (collectiveAddMoreBtn) {
    collectiveAddMoreBtn.addEventListener('click', function () {
      openDiameterDropdown();
      if (diaSearchInput) {
        diaSearchInput.focus();
        diaSearchInput.select();
      }
    });
  }

  // Add All Selected Sizes to Cart Handler
  if (addToCartBtn) {
    addToCartBtn.addEventListener('click', function () {
      if (collectiveItems.length === 0) {
        addSizeToCollective(currentDiameter, currentVariant);
      }

      addToCartBtn.disabled = true;
      var originalText = cartBtnText ? cartBtnText.textContent : 'Add Selected Sizes to Cart';
      if (cartBtnText) {
        cartBtnText.innerHTML = '<span class="cart-btn-spinner"></span> Adding ' + collectiveItems.length + ' Sizes to Cart...';
      }

      setTimeout(function () {
        collectiveItems.forEach(function (item) {
          if (window.BirlaCart && typeof window.BirlaCart.add === 'function') {
            window.BirlaCart.add({
              dia: item.mm,
              variant: item.variant,
              title: 'HSS Jobber Series Twist Drill',
              variantName: item.variantName,
              diaText: item.mm + ' mm',
              qty: item.qty,
              unitPrice: 0,
              total: 0,
              moq: item.moq,
              img: 'assets/images/products/gallery_thumb_1.jpg'
            });
          }
        });

        addToCartBtn.disabled = false;
        if (cartBtnText) {
          cartBtnText.textContent = 'Added ' + collectiveItems.length + ' Sizes to Cart ✓';
          addToCartBtn.classList.add('is-added');
          setTimeout(function () {
            cartBtnText.textContent = originalText;
            addToCartBtn.classList.remove('is-added');
          }, 1800);
        }
      }, 350);
    });
  }

  // Request Quotation Button Handler
  if (requestQuotationBtn) {
    requestQuotationBtn.addEventListener('click', function () {
      syncEnquiryForm();
    });
  }

  // 10. Helper Functions
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
