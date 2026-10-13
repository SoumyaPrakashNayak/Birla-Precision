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

// Global guard to guarantee product.js only initializes once
if (window.__bptl_product_js_initialized) {
  console.log('Birla Precision product.js already initialized, skipping duplicate execution.');
} else {
  window.__bptl_product_js_initialized = true;

  document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    // ==========================================================================
    // STATE MANAGEMENT
    // ==========================================================================

    var currentUnit = 'mm'; // 'mm' or 'inch'
    var allSizesData = [];
    var allVariantsMap = {};

    // ==========================================================================
    // MOQ & PACKAGING HELPER
    // ==========================================================================

    function getMoqForDiameter(diaStr) {
      return 1;
    }

    // Quotation items state (starts empty on first visit; user adds sizes using Step 1)
    var quotationItems = [];
    try {
      var stored = localStorage.getItem('birla_quotation_items');
      if (stored) {
        var parsed = JSON.parse(stored);
        if (Array.isArray(parsed)) {
          // Exclude any legacy seed items so clean empty state is respected
          quotationItems = parsed.filter(function (it) {
            return it && it.id && String(it.id).indexOf('seed-') !== 0;
          });
        }
      }
    } catch (e) {
      quotationItems = [];
    }

    // Enforce positive quantity on quotation items
    function enforceMoqOnQuotationItems() {
      var changed = false;
      quotationItems.forEach(function (it) {
        it.moq = 1;
        var curQty = parseInt(it.qty, 10);
        if (isNaN(curQty) || curQty < 1) {
          it.qty = 1;
          changed = true;
        }
      });
      return changed;
    }
    enforceMoqOnQuotationItems();

    function saveQuotationItems() {
      enforceMoqOnQuotationItems();
      try {
        localStorage.setItem('birla_quotation_items', JSON.stringify(quotationItems));
      } catch (e) {
        // storage unavailable
      }
    }

    // ==========================================================================
    // DOM ELEMENTS
    // ==========================================================================

    // Step 1 Elements
    var stepSubheading = document.getElementById('stepSubheading');
    var unitBtnMm = document.getElementById('unitBtnMm');
    var unitBtnInch = document.getElementById('unitBtnInch');
    var diaControlLabel = document.getElementById('diaControlLabel');
    var diaSearchInput = document.getElementById('diaSearchInput');
    var diaComboboxWrapper = document.getElementById('diaComboboxWrapper');
    var diaDropdownMenu = document.getElementById('diaDropdownMenu');
    var diaMenuScroll = document.getElementById('diaMenuScroll');
    var diaToggleDropdownBtn = document.getElementById('diaToggleDropdownBtn');
    var popularSizesList = document.getElementById('popularSizesList');
    var stepQtyMinus = document.getElementById('stepQtyMinus');
    var stepQtyPlus = document.getElementById('stepQtyPlus');
    var stepQtyInput = document.getElementById('stepQtyInput');
    var addToListBtn = document.getElementById('addToListBtn');
    var stepMoqBadge = document.getElementById('stepMoqBadge');

    // Step 2 Quotation Table Elements
    var colHeaderSize = document.getElementById('colHeaderSize');
    var quotationTable = document.getElementById('quotationTable');
    var quotationTableBody = document.getElementById('quotationTableBody');
    var quotationEmptyState = document.getElementById('quotationEmptyState');
    var clearAllSizesBtn = document.getElementById('clearAllSizesBtn');
    var heroAddToCartBtn = document.getElementById('heroAddToCartBtn') || document.getElementById('heroRequestQuotationBtn');
    var heroRequestQuotationBtn = heroAddToCartBtn;

    // Enquiry Section Elements
    var enquirySection = document.getElementById('enquiry');
    var enquiryForm = document.getElementById('productEnquiryForm');
    var enquiryDiaInput = document.getElementById('enquiryDiaInput');
    var enquiryVariantInput = document.getElementById('enquiryVariantInput');
    var enquiryQuantityInput = document.getElementById('enquiryQuantityInput');
    var enquiryMoqNotice = document.getElementById('enquiryMoqNotice');
    var enquiryPriceBasisInput = document.getElementById('enquiryPriceBasisInput');
    var enquiryAddressInput = document.getElementById('enquiryAddressInput');
    var enquiryMessageInput = document.getElementById('enquiryMessageInput');
    var enquiryCartSummaryBox = document.getElementById('enquiryCartSummaryBox');
    var enquirySummaryCount = document.getElementById('enquirySummaryCount');
    var enquirySummaryItems = document.getElementById('enquirySummaryItems');
    var enquirySubmitBtn = document.getElementById('enquirySubmitBtn');
    var enquiryFeedback = document.getElementById('enquiryFeedback');

    // Gallery Elements
    var galleryStage = document.getElementById('galleryStage');
    var galleryMainImage = document.getElementById('galleryMainImage');
    var galleryZoomBtn = document.getElementById('galleryZoomBtn');
    var galleryThumbs = document.querySelectorAll('.gallery-thumb-btn');
    var galleryLightboxModal = document.getElementById('galleryLightboxModal');
    var lightboxImage = document.getElementById('lightboxImage');
    var lightboxCaption = document.getElementById('lightboxCaption');
    var lightboxCloseBtn = document.getElementById('lightboxCloseBtn');
    var lightboxBackdrop = document.getElementById('lightboxBackdrop');

    // Tabs
    var tabButtons = document.querySelectorAll('.spec-tab-btn');
    var tabPanels = document.querySelectorAll('.spec-tab-panel');

    // State for gallery lightbox
    var currentFullImgUrl = galleryMainImage ? galleryMainImage.src : '';
    var currentCaption = 'HSS Parallel Shank Jobber Series';

    // Hide MOQ badge in Step 1 and maintain valid stepper constraints
    function updateStepMoqBadge(sizeStr) {
      if (stepMoqBadge) {
        stepMoqBadge.style.display = 'none';
      }
      if (stepQtyInput) {
        var currentQty = parseInt(stepQtyInput.value, 10);
        if (isNaN(currentQty) || currentQty < 1) {
          stepQtyInput.value = 10;
        }
        stepQtyInput.min = 1;
      }
      if (stepQtyMinus && stepQtyInput) {
        var cur = parseInt(stepQtyInput.value, 10);
        stepQtyMinus.disabled = (cur <= 1);
        stepQtyMinus.setAttribute('aria-disabled', cur <= 1 ? 'true' : 'false');
      }
    }

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

          // Re-enforce MOQ constraints with dynamic catalogue sizes
          enforceMoqOnQuotationItems();
          renderDropdownSizes();
          var initialSize = diaSearchInput && diaSearchInput.value ? diaSearchInput.value : (currentUnit === 'mm' ? '3.00' : '1/8"');
          updateStepMoqBadge(initialSize);
          renderQuotationTable();
          saveQuotationItems();
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

      // Fallback sizes if API did not provide any
      if (options.length === 0) {
        var defaultSizes = currentUnit === 'mm'
          ? ['0.30', '0.50', '1.00', '1.50', '2.00', '2.50', '3.00', '3.17', '3.50', '4.00', '4.50', '5.00', '5.50', '6.00', '6.35', '7.00', '8.00', '9.00', '10.00', '11.00', '12.00', '13.00']
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
        if (current > 1) {
          var step = current > 10 ? 10 : 1;
          var next = Math.max(1, current - step);
          stepQtyInput.value = next;
          stepQtyMinus.disabled = (next <= 1);
          stepQtyMinus.setAttribute('aria-disabled', next <= 1 ? 'true' : 'false');
        } else {
          stepQtyInput.value = 1;
          stepQtyMinus.disabled = true;
          stepQtyMinus.setAttribute('aria-disabled', 'true');
        }
      });
    }

    if (stepQtyPlus && stepQtyInput) {
      stepQtyPlus.addEventListener('click', function () {
        var current = parseInt(stepQtyInput.value, 10) || 0;
        stepQtyInput.value = current + (current < 10 ? 1 : 10);
        if (stepQtyMinus) {
          stepQtyMinus.disabled = false;
          stepQtyMinus.setAttribute('aria-disabled', 'false');
        }
      });
    }

    if (stepQtyInput) {
      function sanitizeStepQty() {
        var current = parseInt(stepQtyInput.value, 10);
        if (isNaN(current) || current < 1) {
          stepQtyInput.value = 1;
        }
        if (stepQtyMinus) {
          var valNow = parseInt(stepQtyInput.value, 10);
          stepQtyMinus.disabled = (valNow <= 1);
          stepQtyMinus.setAttribute('aria-disabled', valNow <= 1 ? 'true' : 'false');
        }
      }

      stepQtyInput.addEventListener('change', sanitizeStepQty);
      stepQtyInput.addEventListener('blur', sanitizeStepQty);
      stepQtyInput.addEventListener('input', function() {
        if (quotationItems.length === 0) syncEnquiryForm();
      });
    }

    // ==========================================================================
    // 8. ADD TO LIST HANDLER
    // ==========================================================================

    function addCurrentSizeToList() {
      if (!diaSearchInput) return;

      var rawSize = diaSearchInput.value.trim();
      var cleanedSize = rawSize.replace(/mm/i, '').replace(/inch/i, '').trim();

      if (!cleanedSize) {
        diaSearchInput.focus();
        diaSearchInput.style.borderColor = '#DC2626';
        setTimeout(function () {
          diaSearchInput.style.borderColor = '';
        }, 1000);
        return;
      }

      var qty = parseInt(stepQtyInput ? stepQtyInput.value : 10, 10) || 10;
      if (qty < 1) qty = 1;

      // Check if this size already exists in the quotation table
      var existingIndex = quotationItems.findIndex(function (it) {
        return it.size.toLowerCase() === cleanedSize.toLowerCase();
      });

      if (existingIndex !== -1) {
        quotationItems[existingIndex].qty += qty;
        quotationItems[existingIndex].moq = 1;
      } else {
        quotationItems.push({
          id: 'user-' + Date.now() + '-' + Math.random().toString(36).substr(2, 4),
          size: cleanedSize,
          unit: currentUnit,
          qty: qty,
          moq: 1,
          availability: 'In Stock'
        });
      }

      // Reset input fields
      diaSearchInput.value = '';
      if (stepQtyInput) {
        stepQtyInput.value = 10;
        stepQtyInput.min = 1;
      }
      updateStepMoqBadge(currentUnit === 'mm' ? '3.00' : '1/8"');

      // Remove active state on popular pills
      if (popularSizesList) {
        var allPills = popularSizesList.querySelectorAll('.popular-size-pill');
        allPills.forEach(function (p) { p.classList.remove('is-active'); });
      }

      renderQuotationTable();
      saveQuotationItems();
      syncEnquiryForm();
    }

    if (addToListBtn) {
      addToListBtn.addEventListener('click', function () {
        addCurrentSizeToList();
      });
    }

    // ==========================================================================
    // 9. RENDER QUOTATION TABLE (STEP 2)
    // ==========================================================================

    // Helper: synchronize quotationItems array directly from DOM table rows
    function syncQuotationItemsFromTableDOM() {
      if (!quotationTableBody) return;
      var rows = quotationTableBody.querySelectorAll('tr');
      if (rows.length === 0) return;

      var domList = [];
      rows.forEach(function (tr, index) {
        var sizeEl = tr.querySelector('.td-size');
        var qtyInp = tr.querySelector('.input-table-qty');
        if (!sizeEl) return;

        var rawSize = sizeEl.textContent.trim().replace(/mm|inch/gi, '').trim();
        if (!rawSize) return;

        var itemQty = qtyInp ? (parseInt(qtyInp.value, 10) || 1) : 1;
        if (itemQty < 1) itemQty = 1;
        if (qtyInp) qtyInp.value = itemQty;

        var rowId = (qtyInp && qtyInp.getAttribute('data-id')) ? qtyInp.getAttribute('data-id') : ('row-' + index + '-' + rawSize);

        var existing = quotationItems.find(function (it) {
          return it.id === rowId || it.size.toLowerCase() === rawSize.toLowerCase();
        });

        domList.push({
          id: existing ? existing.id : rowId,
          size: rawSize,
          unit: existing ? existing.unit : (currentUnit || 'mm'),
          qty: itemQty,
          moq: 1,
          availability: existing ? existing.availability : 'In Stock'
        });
      });

      if (domList.length > 0) {
        quotationItems = domList;
      }
    }

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
        item.moq = 1;
        if (!item.qty || item.qty < 1) {
          item.qty = 1;
        }
        var isAtMin = item.qty <= 1;

        var tr = document.createElement('tr');
        tr.innerHTML =
          '<td class="td-sno">' + (index + 1) + '</td>' +
          '<td class="td-size">' + escapeHtml(item.size) + '</td>' +
          '<td class="td-qty">' +
            '<div class="table-qty-container">' +
              '<div class="table-stepper-box">' +
                '<button type="button" class="table-step-btn btn-table-minus" data-id="' + item.id + '" aria-label="Decrease quantity"' + (isAtMin ? ' disabled aria-disabled="true"' : '') + '>&minus;</button>' +
                '<input type="number" class="table-step-input input-table-qty" data-id="' + item.id + '" value="' + item.qty + '" min="1" step="1">' +
                '<button type="button" class="table-step-btn btn-table-plus" data-id="' + item.id + '" aria-label="Increase quantity">&plus;</button>' +
              '</div>' +
            '</div>' +
          '</td>' +
          '<td class="td-avail">' +
            '<span class="stock-pill-badge">' +
              '<span class="stock-pill-dot"></span> ' + (item.availability || 'In Stock') +
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
          if (target) {
            if (target.qty > 1) {
              target.qty = Math.max(1, target.qty - (target.qty > 10 ? 10 : 1));
              var rowInput = quotationTableBody.querySelector('.input-table-qty[data-id="' + id + '"]');
              if (rowInput) rowInput.value = target.qty;
              this.disabled = (target.qty <= 1);
              this.setAttribute('aria-disabled', target.qty <= 1 ? 'true' : 'false');
              saveQuotationItems();
              syncEnquiryForm();
            }
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
            target.qty += (target.qty < 10 ? 1 : 10);
            var rowInput = quotationTableBody.querySelector('.input-table-qty[data-id="' + id + '"]');
            if (rowInput) rowInput.value = target.qty;
            var rowMinusBtn = quotationTableBody.querySelector('.btn-table-minus[data-id="' + id + '"]');
            if (rowMinusBtn) {
              rowMinusBtn.disabled = false;
              rowMinusBtn.setAttribute('aria-disabled', 'false');
            }
            saveQuotationItems();
            syncEnquiryForm();
          }
        });
      });

      // Wire up row quantity input live direct change (input, change, blur)
      var qtyInputs = quotationTableBody.querySelectorAll('.input-table-qty');
      qtyInputs.forEach(function (inp) {
        var id = inp.getAttribute('data-id');
        var target = quotationItems.find(function (it) { return it.id === id; });

        inp.addEventListener('input', function () {
          var val = parseInt(this.value, 10);
          if (!isNaN(val) && val >= 1) {
            if (target) {
              target.qty = val;
            }
            var rowMinusBtn = quotationTableBody.querySelector('.btn-table-minus[data-id="' + id + '"]');
            if (rowMinusBtn) {
              rowMinusBtn.disabled = (val <= 1);
              rowMinusBtn.setAttribute('aria-disabled', val <= 1 ? 'true' : 'false');
            }
            syncEnquiryForm();
          }
        });

        function commitRowQty() {
          var val = parseInt(inp.value, 10);
          if (isNaN(val) || val < 1) {
            val = 1;
          }
          inp.value = val;
          if (target) {
            target.qty = val;
          }
          var rowMinusBtn = quotationTableBody.querySelector('.btn-table-minus[data-id="' + id + '"]');
          if (rowMinusBtn) {
            rowMinusBtn.disabled = (val <= 1);
            rowMinusBtn.setAttribute('aria-disabled', val <= 1 ? 'true' : 'false');
          }
          saveQuotationItems();
          syncEnquiryForm();
        }

        inp.addEventListener('change', commitRowQty);
        inp.addEventListener('blur', commitRowQty);
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

      // 1. Calculate from visible input values in table DOM first
      if (quotationTableBody) {
        var domInputs = quotationTableBody.querySelectorAll('.input-table-qty');
        if (domInputs.length > 0) {
          domInputs.forEach(function (inp) {
            var val = parseInt(inp.value, 10);
            if (!isNaN(val) && val > 0) {
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
        try {
          localStorage.removeItem('birla_cart');
          localStorage.removeItem('birla_quotation_items');
        } catch (e) {}
        if (window.BirlaCart && typeof window.BirlaCart.save === 'function') {
          window.BirlaCart.save([]);
        }
        if (typeof syncEnquiryForm === 'function') {
          syncEnquiryForm();
        }
      });
    }

    window.syncQuotationOnCartClear = function () {
      quotationItems = [];
      renderQuotationTable();
      saveQuotationItems();
      if (typeof syncEnquiryForm === 'function') {
        syncEnquiryForm();
      }
    };

    // ==========================================================================
    // 11. NEXT STEP: REQUEST QUOTATION & ENQUIRY SYNC
    // ==========================================================================

    function syncEnquiryForm() {
      // 1. Sync any existing table rows from DOM first
      if (quotationTableBody && quotationTableBody.querySelectorAll('tr').length > 0) {
        syncQuotationItemsFromTableDOM();
      }

      var itemsCount = quotationItems.length;
      var totalPieces = calculateTotalCartQty();

      // Ensure all items have moq assigned and qty is valid
      quotationItems.forEach(function (it) {
        it.moq = 1;
        if (!it.qty || it.qty < 1) {
          it.qty = 1;
        }
      });

      // 1. Update Enquiry Summary Chip Box (Contains ONLY what user added to cart)
      if (enquiryCartSummaryBox && enquirySummaryItems) {
        if (itemsCount === 0 && totalPieces === 0) {
          enquiryCartSummaryBox.style.display = 'none';
          if (enquirySummaryCount) {
            enquirySummaryCount.textContent = '0 Sizes | 0 pcs';
          }
          enquirySummaryItems.innerHTML = '';
        } else {
          enquiryCartSummaryBox.style.display = 'block';
          if (enquirySummaryCount) {
            enquirySummaryCount.textContent = itemsCount + (itemsCount === 1 ? ' Size' : ' Sizes') + ' | ' + totalPieces + ' pcs';
          }
          enquirySummaryItems.innerHTML = '';
          quotationItems.forEach(function (it) {
            var chip = document.createElement('div');
            chip.className = 'enquiry-summary-chip';
            chip.innerHTML =
              '<div class="chip-main">' +
                '<strong class="chip-dia">' + escapeHtml(it.size) + (it.unit === 'mm' ? ' mm' : '') + '</strong>' +
                '<span class="chip-variant">HSS Jobber Series</span>' +
              '</div>' +
              '<div class="chip-qty-wrap">' +
                '<span class="chip-qty">' + it.qty + ' pcs</span>' +
              '</div>';
            enquirySummaryItems.appendChild(chip);
          });
        }
      }

      // 2. Update Form Input Values - Selected diameters without MOQ text
      if (enquiryDiaInput) {
        if (itemsCount > 0) {
          var sizeStrings = quotationItems.map(function (it) {
            return it.size + (it.unit === 'mm' ? ' mm' : '') + ' (' + it.qty + ' pcs)';
          });
          enquiryDiaInput.value = 'HSS Jobber Series (IS:5101) — ' + sizeStrings.join(', ');
        } else {
          var fallbackDia = (diaSearchInput && diaSearchInput.value.trim()) ? diaSearchInput.value.trim() : (currentUnit === 'mm' ? '3.00' : '1/8"');
          var cleanFallback = fallbackDia.replace(/mm/i, '').replace(/inch/i, '').trim();
          var fallbackQty = parseInt(stepQtyInput ? stepQtyInput.value : 10, 10) || 10;
          enquiryDiaInput.value = 'HSS Jobber Series (IS:5101) — ' + cleanFallback + (currentUnit === 'mm' ? ' mm' : '') + ' (' + fallbackQty + ' pcs)';
        }
      }

      // Strictly match cart total pieces
      if (enquiryQuantityInput) {
        if (itemsCount > 0) {
          enquiryQuantityInput.value = totalPieces;
        } else {
          var qtyVal = parseInt(stepQtyInput ? stepQtyInput.value : 10, 10) || 10;
          enquiryQuantityInput.value = qtyVal;
        }
      }

      // Update notice below quantity field
      if (enquiryMoqNotice) {
        if (itemsCount > 0 && totalPieces > 0) {
          enquiryMoqNotice.textContent = 'Combined quantity in cart: ' + totalPieces + ' pcs across ' + itemsCount + (itemsCount === 1 ? ' size' : ' sizes') + '.';
        } else {
          enquiryMoqNotice.textContent = 'Combined quantity for selected sizes.';
        }
      }

      if (enquiryVariantInput) {
        enquiryVariantInput.value = 'ITM STD. (HSS M2 / Precision Ground Flutes — IS : 5101 | HSN: 8207)';
      }

      if (enquiryPriceBasisInput) {
        enquiryPriceBasisInput.value = 'Official April 2026 Price List — F.O.R. Destination (Direct ITM Plant Dispatch)';
      }

      // 3. Keep Any remark textarea clean with placeholder - do NOT pre-fill with specs text
      // User requested to keep the text box empty with placeholder
    }

    // Next Step Button: Add to Cart & Open Cart Drawer
    if (heroAddToCartBtn) {
      heroAddToCartBtn.addEventListener('click', function (e) {
        e.preventDefault();

        // 1. Sync any visible rows currently in the table DOM into quotationItems
        syncQuotationItemsFromTableDOM();

        // 2. If table is completely empty, check if user entered a size in Step 1
        if (quotationItems.length === 0) {
          var currentStepSize = diaSearchInput ? diaSearchInput.value.trim() : '';
          if (!currentStepSize) {
            // STRICTLY do not auto-add any default items!
            if (diaSearchInput) {
              diaSearchInput.focus();
              diaSearchInput.style.borderColor = '#DC2626';
              setTimeout(function () { diaSearchInput.style.borderColor = ''; }, 1200);
            }
            alert('Please select or enter a drill size in Step 1 first.');
            return;
          }

          var cleanSize = currentStepSize.replace(/mm/i, '').replace(/inch/i, '').trim();
          var qty = parseInt(stepQtyInput ? stepQtyInput.value : 10, 10) || 10;
          if (qty < 1) qty = 1;

          quotationItems.push({
            id: 'user-' + Date.now() + '-' + Math.random().toString(36).substr(2, 4),
            size: cleanSize,
            unit: currentUnit,
            qty: qty,
            moq: 1,
            availability: 'In Stock'
          });
          if (diaSearchInput) diaSearchInput.value = '';
          renderQuotationTable();
        } else {
          // Table already has items. If user typed an active size in Step 1 that isn't added yet, add or update it
          var pendingDia = diaSearchInput ? diaSearchInput.value.trim() : '';
          if (pendingDia) {
            var cleanPending = pendingDia.replace(/mm/i, '').replace(/inch/i, '').trim();
            if (cleanPending) {
              var pendingQty = parseInt(stepQtyInput ? stepQtyInput.value : 10, 10) || 10;
              if (pendingQty < 1) pendingQty = 1;

              var existingPending = quotationItems.find(function (it) {
                return it.size.toLowerCase() === cleanPending.toLowerCase();
              });
              if (existingPending) {
                existingPending.qty = pendingQty;
              } else {
                quotationItems.push({
                  id: 'user-' + Date.now() + '-' + Math.random().toString(36).substr(2, 4),
                  size: cleanPending,
                  unit: currentUnit,
                  qty: pendingQty,
                  moq: 1,
                  availability: 'In Stock'
                });
              }
              if (diaSearchInput) diaSearchInput.value = '';
              renderQuotationTable();
            }
          }
        }

        // 3. Final synchronization and saving of quotationItems
        syncQuotationItemsFromTableDOM();
        saveQuotationItems();
        syncEnquiryForm();

        // 4. Synchronize into global shopping cart (birla_cart)
        var globalCart = [];
        try {
          globalCart = JSON.parse(localStorage.getItem('birla_cart') || '[]');
        } catch (err) {
          globalCart = [];
        }

        quotationItems.forEach(function (qItem) {
          var diaClean = qItem.size;
          var diaLabel = diaClean + (qItem.unit === 'mm' ? ' mm' : '');
          var existing = globalCart.find(function (c) {
            return c.dia === diaClean;
          });
          if (existing) {
            existing.qty = qItem.qty;
          } else {
            globalCart.push({
              id: 'cart-' + diaClean + '-' + Date.now(),
              title: 'HSS Parallel Shank Twist Drills (Jobber Series)',
              variant: 'itm_std',
              variantName: 'ITM STD.',
              dia: diaClean,
              diaText: diaLabel,
              unit: qItem.unit || 'mm',
              qty: qItem.qty,
              img: 'assets/images/products/gallery_thumb_1.jpg',
              unitPrice: 0,
              total: 0
            });
          }
        });

        try {
          localStorage.setItem('birla_cart', JSON.stringify(globalCart));
        } catch (err) {}

        // 5. Update cart UI and open Cart Drawer so user can see "Request Quotation" option in cart
        if (window.BirlaCart && typeof window.BirlaCart.save === 'function') {
          window.BirlaCart.save(globalCart);
          if (typeof window.BirlaCart.open === 'function') {
            window.BirlaCart.open();
          }
        } else {
          var navCartBtn = document.getElementById('navCartBtn');
          if (navCartBtn) navCartBtn.click();
        }

        // 6. Visual feedback on button
        var originalHtml = heroAddToCartBtn.innerHTML;
        heroAddToCartBtn.innerHTML = '<span>✓ Added to Cart!</span>';
        setTimeout(function () {
          heroAddToCartBtn.innerHTML = originalHtml;
        }, 1500);
      });
    }

    // Expose global synchronization helper for site drawer cart
    window.syncCartToEnquiryForm = function (cart) {
      if (Array.isArray(cart) && cart.length > 0) {
        quotationItems = cart.map(function (cItem, idx) {
          var rawSize = String(cItem.dia || cItem.diaText || '3.00').replace(/mm|inch|"/gi, '').trim();
          var itemQty = parseInt(cItem.qty, 10) || 1;
          if (itemQty < 1) itemQty = 1;
          return {
            id: 'cart-' + idx + '-' + Date.now(),
            size: rawSize || '3.00',
            unit: (cItem.diaText && cItem.diaText.indexOf('"') !== -1) ? 'inch' : 'mm',
            qty: itemQty,
            moq: 1,
            availability: 'In Stock'
          };
        });
        renderQuotationTable();
        saveQuotationItems();
        syncEnquiryForm();
      }

      // Unhide quotation form after user presses Request Quotation in cart
      var enquirySec = document.getElementById('enquiry');
      if (enquirySec) {
        enquirySec.style.display = 'block';
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

    // Check if page loaded with #enquiry or quote redirect flag
    if (window.location.hash === '#enquiry' || localStorage.getItem('birla_sync_cart_to_quote') === '1') {
      try { localStorage.removeItem('birla_sync_cart_to_quote'); } catch (e) {}
      window.location.replace('../quotation.php');
    }

  });
}
