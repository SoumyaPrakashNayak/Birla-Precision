/**
 * Birla Precision Technologies — Dedicated Product Page Interactions
 * Reference Design Implementation:
 * - Gallery with thumbnail switching & lightbox zoom
 * - Step 1: Add sizes and quantity with Metric/Inch toggle, Combobox search, Quantity stepper, Popular pills, and Add to list
 * - Step 2: Selected sizes for quotation with Live Table, Row steppers, In Stock indicators, Trash actions, and Clear all
 * - Next Step: Quotation Sync and Smooth Scroll to Enquiry Form
 * - Interactive technical specification tabs & enquiry submission
 * Native Vanilla JavaScript
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  // ==========================================================================
  // STATE MANAGEMENT
  // ==========================================================================

  var currentUnit = 'mm'; // 'mm' or 'inch'
  var allSizesData = [];
  var allVariantsMap = {};

  // Seeded quotation items matching Reference Design (Image 1)
  var defaultQuotationItems = [
    { id: 'seed-1', size: '3.00', unit: 'mm', qty: 50, moq: 200, availability: 'In Stock' },
    { id: 'seed-2', size: '5.00', unit: 'mm', qty: 100, moq: 200, availability: 'In Stock' },
    { id: 'seed-3', size: '10.00', unit: 'mm', qty: 25, moq: 100, availability: 'In Stock' }
  ];

  var quotationItems = [];
  try {
    var stored = localStorage.getItem('birla_quotation_items');
    if (stored) {
      quotationItems = JSON.parse(stored);
      if (!Array.isArray(quotationItems) || quotationItems.length === 0) {
        quotationItems = JSON.parse(JSON.stringify(defaultQuotationItems));
      }
    } else {
      quotationItems = JSON.parse(JSON.stringify(defaultQuotationItems));
    }
  } catch (e) {
    quotationItems = JSON.parse(JSON.stringify(defaultQuotationItems));
  }

  function saveQuotationItems() {
    try {
      localStorage.setItem('birla_quotation_items', JSON.stringify(quotationItems));
    } catch (e) {
      // storage unavailable
    }
    syncEnquiryForm();
  }

  // ==========================================================================
  // DOM ELEMENTS
  // ==========================================================================

  // Step 1 Elements
  var stepSubheading = document.getElementById('stepSubheading');
  var unitBtnMm = document.getElementById('unitBtnMm');
  var unitBtnInch = document.getElementById('unitBtnInch');
  var diaControlLabel = document.getElementById('diaControlLabel');
  var diaComboboxWrapper = document.getElementById('diaComboboxWrapper');
  var diaSearchInput = document.getElementById('diaSearchInput');
  var diaToggleDropdownBtn = document.getElementById('diaToggleDropdownBtn');
  var diaDropdownMenu = document.getElementById('diaDropdownMenu');
  var diaMenuScroll = document.getElementById('diaMenuScroll');
  var stepQtyInput = document.getElementById('stepQtyInput');
  var stepQtyMinus = document.getElementById('stepQtyMinus');
  var stepQtyPlus = document.getElementById('stepQtyPlus');
  var stepMoqBadge = document.getElementById('stepMoqBadge');
  var addToListBtn = document.getElementById('addToListBtn');
  var popularSizesList = document.getElementById('popularSizesList');

  // Step 2 Elements
  var clearAllSizesBtn = document.getElementById('clearAllSizesBtn');
  var colHeaderSize = document.getElementById('colHeaderSize');
  var quotationTable = document.getElementById('quotationTable');
  var quotationTableBody = document.getElementById('quotationTableBody');
  var quotationEmptyState = document.getElementById('quotationEmptyState');
  var heroRequestQuotationBtn = document.getElementById('heroRequestQuotationBtn');

  // Enquiry Section Elements
  var enquiryForm = document.getElementById('productEnquiryForm');
  var enquiryDiaInput = document.getElementById('enquiryDiaInput');
  var enquiryVariantInput = document.getElementById('enquiryVariantInput');
  var enquiryQuantityInput = document.getElementById('enquiryQuantityInput');
  var enquiryMoqNotice = document.getElementById('enquiryMoqNotice');
  var enquiryPriceBasisInput = document.getElementById('enquiryPriceBasisInput');
  var enquiryMessageInput = document.getElementById('enquiryMessageInput');
  var enquiryCartSummaryBox = document.getElementById('enquiryCartSummaryBox');
  var enquirySummaryCount = document.getElementById('enquirySummaryCount');
  var enquirySummaryItems = document.getElementById('enquirySummaryItems');
  var enquiryFeedback = document.getElementById('enquiryFeedback');
  var enquirySubmitBtn = document.getElementById('enquirySubmitBtn');

  // ==========================================================================
  // MOQ LOOKUP HELPER
  // ==========================================================================

  function getMoqForDiameter(diaStr) {
    if (!diaStr) return 100;
    var cleanStr = String(diaStr).replace(/mm|inch|"/gi, '').trim();
    var parsedFloat = parseFloat(cleanStr);

    // Search in loaded API catalogue sizes
    if (allSizesData && allSizesData.length > 0) {
      for (var i = 0; i < allSizesData.length; i++) {
        var row = allSizesData[i];
        if (row && row.mm && Math.abs(parseFloat(row.mm) - parsedFloat) < 0.001) {
          if (row.moq) return parseInt(row.moq, 10);
        }
        if (row && row.inch) {
          var rowInchClean = String(row.inch).replace(/"/g, '').trim();
          if (rowInchClean === cleanStr) {
            if (row.moq) return parseInt(row.moq, 10);
          }
        }
      }
    }

    // Standard April 2026 Price List packaging rules by diameter range
    if (!isNaN(parsedFloat)) {
      if (parsedFloat <= 5.0) return 200;
      if (parsedFloat <= 10.0) return 100;
      if (parsedFloat <= 13.0) return 50;
      if (parsedFloat <= 16.5) return 20;
      return 10;
    }
    return 100;
  }

  function updateStepMoqBadge(sizeStr) {
    if (!stepMoqBadge) return;
    var moq = getMoqForDiameter(sizeStr);
    stepMoqBadge.textContent = 'MOQ: ' + moq + ' pcs';
  }

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

  // Tabs Elements
  var tabButtons = document.querySelectorAll('.tab-btn');
  var tabPanels = document.querySelectorAll('.tab-content-panel');

  // ==========================================================================
  // 1. GALLERY & LIGHTBOX
  // ==========================================================================

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

  if (lightboxCloseBtn) lightboxCloseBtn.addEventListener('click', closeLightbox);
  if (lightboxBackdrop) lightboxBackdrop.addEventListener('click', closeLightbox);

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && galleryLightboxModal && galleryLightboxModal.classList.contains('is-open')) {
      closeLightbox();
    }
  });

  // ==========================================================================
  // 2. TAB NAVIGATION
  // ==========================================================================

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

  // ==========================================================================
  // 3. LOAD CATALOGUE DATA FROM API
  // ==========================================================================

  fetch('../api/get_product_data.php?action=all')
    .then(function (res) { return res.json(); })
    .then(function (json) {
      if (json && json.status === 'success') {
        allSizesData = json.sizes || [];
        allVariantsMap = json.variants || {};

        // Render Combobox dropdown once sizes are loaded
        renderDropdownSizes();
        var initialSize = diaSearchInput && diaSearchInput.value ? diaSearchInput.value : '3.00';
        updateStepMoqBadge(initialSize);
        renderQuotationTable();
        syncEnquiryForm();
      }
    })
    .catch(function (err) {
      console.warn('Could not fetch dynamic API data, using fallback sizes:', err);
    });

  // ==========================================================================
  // 4. METRIC / INCH UNIT TOGGLE
  // ==========================================================================

  var metricPopularSizes = ['2.00', '3.00', '4.00', '5.00', '6.00', '8.00', '10.00', '12.00'];
  var inchPopularSizes = ['1/16"', '1/8"', '3/16"', '1/4"', '5/16"', '3/8"', '7/16"', '1/2"'];

  function setUnit(unit) {
    currentUnit = unit;

    if (unit === 'mm') {
      if (unitBtnMm) unitBtnMm.classList.add('is-active');
      if (unitBtnInch) unitBtnInch.classList.remove('is-active');
      if (stepSubheading) stepSubheading.textContent = 'Enter the drill size (in mm) and quantity. You can add multiple sizes.';
      if (diaControlLabel) diaControlLabel.textContent = 'Drill Size (mm)';
      if (diaSearchInput) diaSearchInput.placeholder = 'Select or type size (e.g. 3.5)';
      if (colHeaderSize) colHeaderSize.textContent = 'Size (mm)';
      renderPopularPills(metricPopularSizes);
      updateStepMoqBadge('3.00');
    } else {
      if (unitBtnInch) unitBtnInch.classList.add('is-active');
      if (unitBtnMm) unitBtnMm.classList.remove('is-active');
      if (stepSubheading) stepSubheading.textContent = 'Enter the drill size (in inch) and quantity. You can add multiple sizes.';
      if (diaControlLabel) diaControlLabel.textContent = 'Drill Size (inch)';
      if (diaSearchInput) diaSearchInput.placeholder = 'Select or type size (e.g. 1/8)';
      if (colHeaderSize) colHeaderSize.textContent = 'Size (inch)';
      renderPopularPills(inchPopularSizes);
      updateStepMoqBadge('1/8"');
    }

    if (diaSearchInput) diaSearchInput.value = '';
    renderDropdownSizes();
  }

  if (unitBtnMm) {
    unitBtnMm.addEventListener('click', function () {
      setUnit('mm');
    });
  }

  if (unitBtnInch) {
    unitBtnInch.addEventListener('click', function () {
      setUnit('inch');
    });
  }

  // ==========================================================================
  // 5. POPULAR SIZES PILLS
  // ==========================================================================

  function renderPopularPills(sizesList) {
    if (!popularSizesList) return;
    popularSizesList.innerHTML = '';

    sizesList.forEach(function (sizeStr) {
      var btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'popular-size-pill';
      btn.textContent = sizeStr;
      btn.setAttribute('data-val', sizeStr);

      btn.addEventListener('click', function () {
        if (diaSearchInput) {
          diaSearchInput.value = sizeStr;
          diaSearchInput.focus();
        }
        updateStepMoqBadge(sizeStr);
        closeDropdown();

        // Highlight active pill briefly
        var allPills = popularSizesList.querySelectorAll('.popular-size-pill');
        allPills.forEach(function (p) { p.classList.remove('is-active'); });
        btn.classList.add('is-active');
      });

      popularSizesList.appendChild(btn);
    });
  }

  // ==========================================================================
  // 6. SEARCHABLE COMBOBOX DROPDOWN
  // ==========================================================================

  function renderDropdownSizes(query) {
    if (!diaMenuScroll) return;

    var filterText = (query || '').toLowerCase().trim();
    diaMenuScroll.innerHTML = '';

    var options = [];
    if (allSizesData && allSizesData.length > 0) {
      allSizesData.forEach(function (row) {
        if (!row) return;
        if (currentUnit === 'mm' && row.mm) {
          var val = parseFloat(row.mm).toFixed(2);
          if (!options.some(function (o) { return o.val === val; })) {
            options.push({ val: val, label: val + ' mm' });
          }
        } else if (currentUnit === 'inch' && row.inch) {
          var inchVal = row.inch.indexOf('"') === -1 ? (row.inch + '"') : row.inch;
          if (!options.some(function (o) { return o.val === inchVal; })) {
            options.push({ val: inchVal, label: inchVal + ' (' + row.mm + ' mm)' });
          }
        }
      });
    }

    // Fallback standard sizes if data fetch is delayed
    if (options.length === 0) {
      var defaultSizes = currentUnit === 'mm'
        ? ['1.00', '1.50', '2.00', '2.50', '3.00', '3.17', '3.50', '4.00', '4.50', '5.00', '5.50', '6.00', '6.35', '7.00', '8.00', '9.00', '10.00', '11.00', '12.00', '13.00']
        : ['1/16"', '3/32"', '1/8"', '5/32"', '3/16"', '7/32"', '1/4"', '9/32"', '5/16"', '3/8"', '7/16"', '1/2"'];
      options = defaultSizes.map(function (s) { return { val: s, label: s }; });
    }

    // Filter by query
    var filtered = options.filter(function (opt) {
      if (!filterText) return true;
      return opt.label.toLowerCase().indexOf(filterText) !== -1 || opt.val.toLowerCase().indexOf(filterText) !== -1;
    });

    if (filtered.length === 0) {
      var emptyMsg = document.createElement('div');
      emptyMsg.className = 'dia-menu-item';
      emptyMsg.style.color = '#888';
      emptyMsg.style.cursor = 'default';
      emptyMsg.textContent = 'No matching sizes found';
      diaMenuScroll.appendChild(emptyMsg);
      return;
    }

    filtered.forEach(function (opt) {
      var item = document.createElement('div');
      item.className = 'dia-menu-item';
      item.textContent = opt.label;

      item.addEventListener('click', function (e) {
        e.stopPropagation();
        if (diaSearchInput) {
          diaSearchInput.value = opt.val;
          diaSearchInput.focus();
        }
        updateStepMoqBadge(opt.val);
        closeDropdown();
      });

      diaMenuScroll.appendChild(item);
    });
  }

  function openDropdown() {
    if (diaComboboxWrapper && diaDropdownMenu) {
      diaComboboxWrapper.classList.add('is-open');
      diaDropdownMenu.classList.add('is-open');
      renderDropdownSizes(diaSearchInput ? diaSearchInput.value : '');
    }
  }

  function closeDropdown() {
    if (diaComboboxWrapper && diaDropdownMenu) {
      diaComboboxWrapper.classList.remove('is-open');
      diaDropdownMenu.classList.remove('is-open');
    }
  }

  if (diaSearchInput) {
    diaSearchInput.addEventListener('focus', function () {
      openDropdown();
    });

    diaSearchInput.addEventListener('input', function () {
      openDropdown();
      renderDropdownSizes(this.value);
      if (this.value.trim()) {
        updateStepMoqBadge(this.value.trim());
      }
    });

    diaSearchInput.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        closeDropdown();
        addCurrentSizeToList();
      }
    });
  }

  if (diaToggleDropdownBtn) {
    diaToggleDropdownBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      if (diaDropdownMenu && diaDropdownMenu.classList.contains('is-open')) {
        closeDropdown();
      } else {
        openDropdown();
        if (diaSearchInput) diaSearchInput.focus();
      }
    });
  }

  document.addEventListener('click', function (e) {
    if (diaComboboxWrapper && !diaComboboxWrapper.contains(e.target)) {
      closeDropdown();
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      closeDropdown();
    }
  });

  // ==========================================================================
  // 7. STEP 1 QUANTITY STEPPER
  // ==========================================================================

  if (stepQtyMinus && stepQtyInput) {
    stepQtyMinus.addEventListener('click', function () {
      var current = parseInt(stepQtyInput.value, 10) || 1;
      var next = current > 1 ? current - 1 : 1;
      stepQtyInput.value = next;
    });
  }

  if (stepQtyPlus && stepQtyInput) {
    stepQtyPlus.addEventListener('click', function () {
      var current = parseInt(stepQtyInput.value, 10) || 1;
      stepQtyInput.value = current + 1;
    });
  }

  if (stepQtyInput) {
    stepQtyInput.addEventListener('change', function () {
      var current = parseInt(this.value, 10);
      if (isNaN(current) || current < 1) {
        this.value = 1;
      }
    });
  }

  // ==========================================================================
  // 8. ADD TO LIST HANDLER
  // ==========================================================================

  function addCurrentSizeToList() {
    if (!diaSearchInput) return;

    var rawSize = diaSearchInput.value.trim();
    // Clean up input (e.g. remove "mm", extra spaces)
    var cleanedSize = rawSize.replace(/mm/i, '').replace(/inch/i, '').trim();

    if (!cleanedSize) {
      diaSearchInput.focus();
      diaSearchInput.style.borderColor = '#DC2626';
      setTimeout(function () {
        diaSearchInput.style.borderColor = '';
      }, 1000);
      return;
    }

    var qty = parseInt(stepQtyInput ? stepQtyInput.value : 1, 10) || 1;
    if (qty < 1) qty = 1;

    var itemMoq = getMoqForDiameter(cleanedSize);

    // Check if this size already exists in the quotation table
    var existingIndex = quotationItems.findIndex(function (it) {
      return it.size.toLowerCase() === cleanedSize.toLowerCase();
    });

    if (existingIndex !== -1) {
      // Increase existing item quantity
      quotationItems[existingIndex].qty += qty;
      quotationItems[existingIndex].moq = itemMoq;
    } else {
      // Add new item to table
      quotationItems.push({
        id: 'user-' + Date.now() + '-' + Math.random().toString(36).substr(2, 4),
        size: cleanedSize,
        unit: currentUnit,
        qty: qty,
        moq: itemMoq,
        availability: 'In Stock'
      });
    }

    // Reset input fields
    diaSearchInput.value = '';
    if (stepQtyInput) stepQtyInput.value = 1;

    // Remove active state on popular pills
    if (popularSizesList) {
      var allPills = popularSizesList.querySelectorAll('.popular-size-pill');
      allPills.forEach(function (p) { p.classList.remove('is-active'); });
    }

    renderQuotationTable();
    saveQuotationItems();
  }

  if (addToListBtn) {
    addToListBtn.addEventListener('click', function () {
      addCurrentSizeToList();
    });
  }

  // ==========================================================================
  // 9. RENDER QUOTATION TABLE (STEP 2)
  // ==========================================================================

  function renderQuotationTable() {
    if (!quotationTableBody) return;
    quotationTableBody.innerHTML = '';

    if (quotationItems.length === 0) {
      if (quotationEmptyState) quotationEmptyState.style.display = 'block';
      if (quotationTable) quotationTable.style.display = 'none';
      syncEnquiryForm();
      return;
    }

    if (quotationEmptyState) quotationEmptyState.style.display = 'none';
    if (quotationTable) quotationTable.style.display = 'table';

    quotationItems.forEach(function (item, index) {
      var itemMoq = item.moq || getMoqForDiameter(item.size);
      var tr = document.createElement('tr');
      tr.innerHTML =
        '<td class="td-sno">' + (index + 1) + '</td>' +
        '<td class="td-size">' + escapeHtml(item.size) + '</td>' +
        '<td class="td-qty">' +
          '<div class="table-qty-container">' +
            '<div class="table-stepper-box">' +
              '<button type="button" class="table-step-btn btn-table-minus" data-id="' + item.id + '" aria-label="Decrease quantity">&minus;</button>' +
              '<input type="number" class="table-step-input input-table-qty" data-id="' + item.id + '" value="' + item.qty + '" min="1">' +
              '<button type="button" class="table-step-btn btn-table-plus" data-id="' + item.id + '" aria-label="Increase quantity">&plus;</button>' +
            '</div>' +
            '<span class="table-row-moq">MOQ: ' + itemMoq + ' pcs</span>' +
          '</div>' +
        '</td>' +
        '<td class="td-avail">' +
          '<span class="stock-pill-badge">' +
            '<span class="stock-pill-dot"></span> In Stock' +
          '</span>' +
        '</td>' +
        '<td class="td-action">' +
          '<button type="button" class="row-delete-btn" data-id="' + item.id + '" title="Remove ' + escapeHtml(item.size) + '" aria-label="Remove ' + escapeHtml(item.size) + '">' +
            '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' +
              '<polyline points="3 6 5 6 21 6"></polyline>' +
              '<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>' +
            '</svg>' +
          '</button>' +
        '</td>';

      quotationTableBody.appendChild(tr);
    });

    // Wire up row stepper minus
    var minusBtns = quotationTableBody.querySelectorAll('.btn-table-minus');
    minusBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var id = this.getAttribute('data-id');
        var target = quotationItems.find(function (it) { return it.id === id; });
        if (target && target.qty > 1) {
          target.qty -= 1;
          var rowInput = quotationTableBody.querySelector('.input-table-qty[data-id="' + id + '"]');
          if (rowInput) rowInput.value = target.qty;
          saveQuotationItems();
          syncEnquiryForm();
        }
      });
    });

    // Wire up row stepper plus
    var plusBtns = quotationTableBody.querySelectorAll('.btn-table-plus');
    plusBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var id = this.getAttribute('data-id');
        var target = quotationItems.find(function (it) { return it.id === id; });
        if (target) {
          target.qty += 1;
          var rowInput = quotationTableBody.querySelector('.input-table-qty[data-id="' + id + '"]');
          if (rowInput) rowInput.value = target.qty;
          saveQuotationItems();
          syncEnquiryForm();
        }
      });
    });

    // Wire up row quantity input live direct change (input, change, blur)
    var qtyInputs = quotationTableBody.querySelectorAll('.input-table-qty');
    qtyInputs.forEach(function (inp) {
      function syncInputQty() {
        var id = inp.getAttribute('data-id');
        var val = parseInt(inp.value, 10);
        if (!isNaN(val) && val > 0) {
          var target = quotationItems.find(function (it) { return it.id === id; });
          if (target) {
            target.qty = val;
          }
        }
        try {
          localStorage.setItem('birla_quotation_items', JSON.stringify(quotationItems));
        } catch (e) {}
        syncEnquiryForm();
      }

      inp.addEventListener('input', syncInputQty);
      inp.addEventListener('change', function () {
        var val = parseInt(this.value, 10);
        if (isNaN(val) || val < 1) {
          this.value = 1;
        }
        syncInputQty();
      });
      inp.addEventListener('blur', syncInputQty);
    });

    // Wire up delete buttons
    var deleteBtns = quotationTableBody.querySelectorAll('.row-delete-btn');
    deleteBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var id = this.getAttribute('data-id');
        quotationItems = quotationItems.filter(function (it) { return it.id !== id; });
        renderQuotationTable();
        saveQuotationItems();
        syncEnquiryForm();
      });
    });

    syncEnquiryForm();
  }

  // ==========================================================================
  // REAL-TIME CART QUANTITY CALCULATION
  // ==========================================================================

  function calculateTotalCartQty() {
    var total = 0;

    // 1. Sync any visible input values from the table DOM first
    if (quotationTableBody) {
      var domInputs = quotationTableBody.querySelectorAll('.input-table-qty');
      if (domInputs.length > 0) {
        domInputs.forEach(function (inp) {
          var id = inp.getAttribute('data-id');
          var val = parseInt(inp.value, 10);
          if (!isNaN(val) && val > 0) {
            var target = quotationItems.find(function (it) { return it.id === id; });
            if (target) {
              target.qty = val;
            }
            total += val;
          }
        });
        if (total > 0) return total;
      }
    }

    // 2. Sum directly from quotationItems array
    if (Array.isArray(quotationItems) && quotationItems.length > 0) {
      quotationItems.forEach(function (it) {
        var q = parseInt(it.qty, 10);
        if (!isNaN(q) && q > 0) total += q;
      });
      if (total > 0) return total;
    }

    // 3. Fallback: check if global cart (birla_cart) has items
    try {
      var globalCart = JSON.parse(localStorage.getItem('birla_cart') || '[]');
      if (Array.isArray(globalCart) && globalCart.length > 0) {
        globalCart.forEach(function (g) {
          var gq = parseInt(g.qty, 10);
          if (!isNaN(gq) && gq > 0) total += gq;
        });
      }
    } catch (e) {}

    return total;
  }

  // ==========================================================================
  // 10. CLEAR ALL SIZES
  // ==========================================================================

  if (clearAllSizesBtn) {
    clearAllSizesBtn.addEventListener('click', function () {
      if (quotationItems.length === 0) return;
      quotationItems = [];
      renderQuotationTable();
      saveQuotationItems();
    });
  }

  // ==========================================================================
  // 11. NEXT STEP: REQUEST QUOTATION & ENQUIRY SYNC
  // ==========================================================================

  function syncEnquiryForm() {
    var itemsCount = quotationItems.length;
    var totalPieces = calculateTotalCartQty();

    // Ensure all items have moq assigned
    quotationItems.forEach(function (it) {
      if (!it.moq) {
        it.moq = getMoqForDiameter(it.size);
      }
    });

    // 1. Update Enquiry Summary Chip Box
    if (enquiryCartSummaryBox && enquirySummaryItems) {
      if (itemsCount === 0 && totalPieces === 0) {
        enquiryCartSummaryBox.style.display = 'none';
      } else {
        enquiryCartSummaryBox.style.display = 'block';
        if (enquirySummaryCount) {
          enquirySummaryCount.textContent = itemsCount + (itemsCount === 1 ? ' Size' : ' Sizes') + ' | ' + totalPieces + ' pcs';
        }
        enquirySummaryItems.innerHTML = '';
        quotationItems.forEach(function (it) {
          var itemMoq = it.moq || getMoqForDiameter(it.size);
          var chip = document.createElement('div');
          chip.className = 'enquiry-summary-chip';
          chip.innerHTML =
            '<div class="chip-main">' +
              '<strong class="chip-dia">' + escapeHtml(it.size) + (it.unit === 'mm' ? ' mm' : '') + '</strong>' +
              '<span class="chip-variant">HSS Jobber Series</span>' +
            '</div>' +
            '<div class="chip-qty-wrap">' +
              '<span class="chip-qty">' + it.qty + ' pcs</span>' +
              '<span class="chip-moq-tag">MOQ: ' + itemMoq + ' pcs</span>' +
            '</div>';
          enquirySummaryItems.appendChild(chip);
        });
      }
    }

    // 2. Update Form Input Values
    if (enquiryDiaInput) {
      if (itemsCount > 0) {
        var sizeStrings = quotationItems.map(function (it) {
          var itemMoq = it.moq || getMoqForDiameter(it.size);
          return it.size + (it.unit === 'mm' ? ' mm' : '') + ' (' + it.qty + ' pcs, MOQ: ' + itemMoq + ')';
        });
        enquiryDiaInput.value = 'HSS Jobber Series (IS:5101) — ' + sizeStrings.join(', ');
      } else {
        enquiryDiaInput.value = 'HSS Parallel Shank Twist Drills (Jobber Series) — Conforming to IS : 5101';
      }
    }

    // Strictly match cart total pieces
    if (enquiryQuantityInput) {
      enquiryQuantityInput.value = totalPieces;
    }

    if (enquiryMoqNotice) {
      if (itemsCount > 0 && totalPieces > 0) {
        var moqDetails = quotationItems.map(function (it) {
          return it.size + (it.unit === 'mm' ? 'mm' : '') + ' (MOQ ' + (it.moq || getMoqForDiameter(it.size)) + ' pcs)';
        }).join('; ');
        enquiryMoqNotice.textContent = 'Combined quantity in cart: ' + totalPieces + ' pcs. Standard MOQ: ' + moqDetails + '. Multiples of 10 pieces required.';
      } else {
        enquiryMoqNotice.textContent = 'Standard MOQ applies per diameter as noted (Multiples of 10 pieces required).';
      }
    }

    if (enquiryVariantInput) {
      enquiryVariantInput.value = 'ITM STD. (HSS M2 / Precision Ground Flutes — IS : 5101 | HSN: 8207)';
    }

    if (enquiryPriceBasisInput) {
      enquiryPriceBasisInput.value = 'Official April 2026 Price List — F.O.R. Destination (Direct ITM Plant Dispatch)';
    }

    // 3. Pre-fill Message Field with complete product and tooling details
    if (enquiryMessageInput) {
      var isDefaultOrAuto = !enquiryMessageInput.value ||
        enquiryMessageInput.value.indexOf('Selected Drill Sizes for Official Quotation:') !== -1 ||
        enquiryMessageInput.value.indexOf('PRODUCT DETAILS & TECHNICAL SPECIFICATIONS:') !== -1;

      if (isDefaultOrAuto && itemsCount > 0) {
        var msgLines = [
          'PRODUCT DETAILS & TECHNICAL SPECIFICATIONS:',
          '• Product Line: Birla Precision Technologies / Dagger Brand HSS Parallel Shank Twist Drills (Jobber Series)',
          '• Standard Specification: IS : 5101 (Conforming to ISO 235 / DIN 338 / BS 328)',
          '• Material & Metallurgy: Premium High-Speed Steel (M2 Grade Standard)',
          '• Flute Geometry: Precision CNC Ground Type \'N\' Right Hand Spiral Flutes',
          '• Point Angle: 118° Standard Conical Relief Point',
          '• HSN Code: 8207 (Tools, Interchangeable Tools for Hand/Machine Tools)',
          '• Pricing Unit: Price Per 10 Pieces (Official April 2026 Catalogue Edition)',
          '• Manufacturing Facilities: Aurangabad & Nashik Plants (ISO 9001 / IATF 16949 Certified)',
          '',
          'SELECTED TOOLING SIZES & REQUIRED QUANTITIES (WITH STANDARD MOQ):'
        ];

        quotationItems.forEach(function (it, i) {
          var itemMoq = it.moq || getMoqForDiameter(it.size);
          msgLines.push(
            (i + 1) + '. Diameter: ' + it.size + (it.unit === 'mm' ? ' mm' : '') +
            ' — Required Quantity: ' + it.qty + ' pcs' +
            ' (Standard MOQ: ' + itemMoq + ' pcs)' +
            ' — Availability: ' + (it.availability || 'In Stock')
          );
        });

        msgLines.push('');
        msgLines.push('COMMERCIAL & DISPATCH INSTRUCTIONS:');
        msgLines.push('• Total Required Quantity: ' + totalPieces + ' pieces across ' + itemsCount + (itemsCount === 1 ? ' size' : ' sizes') + '.');
        msgLines.push('• Supply Terms: Official B2B Quotation requested with applicable volume discount and GST breakdown.');
        msgLines.push('• Delivery Basis: F.O.R. Destination direct from plant dispatch in standard packaging (Multiples of 10).');
        msgLines.push('');
        msgLines.push('APPLICATION & MACHINING NOTES:');
        msgLines.push('[Please specify your workpiece material (e.g. Mild Steel, SS304, Cast Iron), hole depth, machine model, or coating requirements here]');

        enquiryMessageInput.value = msgLines.join('\n');
      }
    }
  }

  if (heroRequestQuotationBtn) {
    heroRequestQuotationBtn.addEventListener('click', function (e) {
      e.preventDefault();
      // Read any active inputs from the table DOM into quotationItems first
      if (quotationTableBody) {
        var domInputs = quotationTableBody.querySelectorAll('.input-table-qty');
        domInputs.forEach(function (inp) {
          var id = inp.getAttribute('data-id');
          var val = parseInt(inp.value, 10);
          if (!isNaN(val) && val > 0) {
            var target = quotationItems.find(function (it) { return it.id === id; });
            if (target) {
              target.qty = val;
            }
          }
        });
      }
      saveQuotationItems();
      syncEnquiryForm();

      var enquirySec = document.getElementById('enquiry');
      if (enquirySec) {
        enquirySec.scrollIntoView({ behavior: 'smooth' });
        var nameInput = document.getElementById('enquiryNameInput');
        if (nameInput) {
          setTimeout(function () {
            nameInput.focus();
          }, 600);
        }
      }
    });
  }

  // Expose global synchronization helper for site drawer cart
  window.syncCartToEnquiryForm = function (cart) {
    if (Array.isArray(cart) && cart.length > 0) {
      quotationItems = cart.map(function (cItem, idx) {
        var rawSize = String(cItem.dia || cItem.diaText || '3.00').replace(/mm|inch|"/gi, '').trim();
        return {
          id: 'cart-' + idx + '-' + Date.now(),
          size: rawSize || '3.00',
          unit: (cItem.diaText && cItem.diaText.indexOf('"') !== -1) ? 'inch' : 'mm',
          qty: parseInt(cItem.qty, 10) || 10,
          moq: parseInt(cItem.moq, 10) || getMoqForDiameter(rawSize),
          availability: 'In Stock'
        };
      });
      renderQuotationTable();
      saveQuotationItems();
      syncEnquiryForm();
    }
  };

  // ==========================================================================
  // 12. ENQUIRY FORM SUBMISSION (AJAX)
  // ==========================================================================

  if (enquiryForm) {
    enquiryForm.addEventListener('submit', function (e) {
      e.preventDefault();

      if (enquirySubmitBtn) {
        enquirySubmitBtn.disabled = true;
        enquirySubmitBtn.textContent = 'Submitting Request...';
      }

      if (enquiryFeedback) {
        enquiryFeedback.className = 'form-feedback-message';
        enquiryFeedback.textContent = '';
      }

      var formData = new FormData(enquiryForm);

      fetch(enquiryForm.action || '../enquiry_submit.php', {
        method: 'POST',
        body: formData
      })
        .then(function (res) { return res.json(); })
        .then(function (data) {
          if (enquirySubmitBtn) {
            enquirySubmitBtn.disabled = false;
            enquirySubmitBtn.textContent = 'Submit Official Enquiry';
          }

          if (data && data.status === 'success') {
            if (enquiryFeedback) {
              enquiryFeedback.className = 'form-feedback-message is-success';
              enquiryFeedback.innerHTML =
                '<strong>✓ Enquiry Submitted Successfully!</strong><br>' +
                'Reference ID: <strong>' + escapeHtml(data.reference_number) + '</strong><br>' +
                'A technical tooling sales specialist from Birla Precision Technologies will contact you shortly with an official quotation.';
            }

            // Update CSRF token if rotated
            if (data.details && data.details.new_csrf_token) {
              var csrfInput = enquiryForm.querySelector('input[name="csrf_token"]');
              if (csrfInput) csrfInput.value = data.details.new_csrf_token;
            }

            enquiryForm.reset();
            syncEnquiryForm();
          } else {
            var errorMsg = data && data.message ? data.message : 'Submission failed. Please check form inputs.';
            if (data && data.errors) {
              var errorList = Object.keys(data.errors).map(function (k) { return data.errors[k]; });
              errorMsg += '<br>&bull; ' + errorList.join('<br>&bull; ');
            }
            if (enquiryFeedback) {
              enquiryFeedback.className = 'form-feedback-message is-error';
              enquiryFeedback.innerHTML = errorMsg;
            }
          }
        })
        .catch(function (err) {
          if (enquirySubmitBtn) {
            enquirySubmitBtn.disabled = false;
            enquirySubmitBtn.textContent = 'Submit Official Enquiry';
          }
          if (enquiryFeedback) {
            enquiryFeedback.className = 'form-feedback-message is-error';
            enquiryFeedback.textContent = 'Network error while submitting enquiry. Please check your connection or contact sales directly.';
          }
          console.error('Enquiry submission error:', err);
        });
    });
  }

  // ==========================================================================
  // 13. UTILITY FUNCTIONS
  // ==========================================================================

  function escapeHtml(text) {
    if (text === null || text === undefined) return '';
    return String(text)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  // ==========================================================================
  // 14. INITIALIZE ON LOAD
  // ==========================================================================

  setUnit('mm');
  renderQuotationTable();
  syncEnquiryForm();

});
