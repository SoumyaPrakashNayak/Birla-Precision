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

    var currentProductId = window.__BPTL_CURRENT_PRODUCT_ID || 1;
    var currentProductTitle = window.__BPTL_CURRENT_PRODUCT_TITLE || 'HSS Parallel Shank Twist Drills (Jobber Series)';
    var currentProductImg = window.__BPTL_CURRENT_PRODUCT_IMG || 'assets/images/products/gallery_thumb_1.jpg';
    var currentProductStandard = window.__BPTL_CURRENT_PRODUCT_STANDARD || 'IS : 5101';
    var currentProductHsn = window.__BPTL_CURRENT_PRODUCT_HSN || '8207';
    var quotationStorageKey = 'birla_quotation_items_' + String(currentProductId);

    var sizeTypesList = [];
    var sizesByTypeMap = {};
    var currentSizeType = {
      code: 'mm',
      label: 'Metric (mm)',
      unit_suffix: 'mm',
      placeholder: 'Select or type size (e.g. 3.5)',
      popular: ['2.00', '3.00', '4.00', '5.00', '6.00', '8.00', '10.00', '12.00']
    };
    var currentUnit = 'mm';
    var allSizesData = [];
    var allVariantsMap = {};

    // ==========================================================================
    // MOQ & PACKAGING HELPER
    // ==========================================================================

    function getMoqForDiameter(diaStr) {
      return 1;
    }

    // Quotation items state (scoped per product; starts empty on first visit)
    var quotationItems = [];
    try {
      var stored = localStorage.getItem(quotationStorageKey);
      if (stored) {
        var parsed = JSON.parse(stored);
        if (Array.isArray(parsed)) {
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
        localStorage.setItem(quotationStorageKey, JSON.stringify(quotationItems));
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
    // 3. LOAD CATALOGUE DATA FROM __BPTL_SIZE_CONFIG OR API FALLBACK
    // ==========================================================================

    var unitToggleSegmented = document.getElementById('unitToggleSegmented');

    function formatDisplaySize(rawVal, sizeTypeObj) {
      var v = String(rawVal || '').trim();
      if (!v) return '';
      var suffix = sizeTypeObj ? String(sizeTypeObj.unit_suffix || '').trim() : '';
      if (!suffix) return v;
      if (suffix === '"') {
        return v.indexOf('"') === -1 ? (v + '"') : v;
      }
      if (v.toLowerCase().indexOf(suffix.toLowerCase()) !== -1) {
        return v;
      }
      return v + ' ' + suffix;
    }

    function wireSizeTypeButtons() {
      if (!unitToggleSegmented) return;
      var btns = unitToggleSegmented.querySelectorAll('.unit-toggle-btn');
      btns.forEach(function (btn) {
        if (btn._bptlWired) return;
        btn._bptlWired = true;
        btn.addEventListener('click', function () {
          var unitCode = this.getAttribute('data-unit');
          setSizeType(unitCode, true);
        });
      });
    }

    function setSizeType(unitCode, shouldOpenDropdown) {
      var found = sizeTypesList.find(function (st) { return st.code === unitCode; }) || sizeTypesList[0];
      if (!found) {
        found = currentSizeType;
      }
      currentSizeType = found;
      currentUnit = found.code;

      if (unitToggleSegmented) {
        unitToggleSegmented.querySelectorAll('.unit-toggle-btn').forEach(function (btn) {
          if (btn.getAttribute('data-unit') === found.code) {
            btn.classList.add('is-active');
          } else {
            btn.classList.remove('is-active');
          }
        });
      }

      if (stepSubheading) {
        stepSubheading.textContent = 'Enter the size (' + found.label + ') and quantity. You can add multiple sizes.';
      }
      if (diaControlLabel) {
        diaControlLabel.textContent = 'Size (' + found.label + ')';
      }
      if (diaSearchInput) {
        diaSearchInput.placeholder = found.placeholder || ('Select or type ' + found.label);
        diaSearchInput.value = '';
      }
      if (colHeaderSize) {
        colHeaderSize.textContent = 'Size (' + (found.unit_suffix || found.label) + ')';
      }

      var popList = (found.popular && found.popular.length > 0)
        ? found.popular
        : ((sizesByTypeMap[found.code] || []).slice(0, 8).map(function (r) { return r.val; }));
      renderPopularPills(popList);
      updateStepMoqBadge(popList[0] || '');
      renderDropdownSizes();

      if (shouldOpenDropdown) {
        openDropdown();
      }
    }

    function initWithSizeConfig(cfg) {
      sizeTypesList = (cfg && Array.isArray(cfg.size_types) && cfg.size_types.length > 0)
        ? cfg.size_types
        : [
            { code: 'mm', label: 'Metric (mm)', unit_suffix: 'mm', placeholder: 'Select or type size (e.g. 3.5)', popular: ['2.00','3.00','4.00','5.00','6.00','8.00','10.00','12.00'] },
            { code: 'inch', label: 'Inch', unit_suffix: '"', placeholder: 'Select or type size (e.g. 1/8")', popular: ['1/16"','1/8"','3/16"','1/4"','5/16"','3/8"','7/16"','1/2"'] }
          ];
      sizesByTypeMap = (cfg && cfg.sizes_by_type) ? cfg.sizes_by_type : {};

      wireSizeTypeButtons();
      enforceMoqOnQuotationItems();
      setSizeType(sizeTypesList[0].code, true);
      renderQuotationTable();
      saveQuotationItems();
      syncEnquiryForm();
    }

    function initCatalogueSizes(sizes, variants) {
      allSizesData = sizes || [];
      allVariantsMap = variants || {};

      var mmList = [];
      var inchList = [];
      allSizesData.forEach(function (row) {
        if (!row) return;
        if (row.mm) {
          var mVal = String(row.mm).trim();
          if (mVal && !mmList.some(function (x) { return x.val === mVal; })) {
            mmList.push({ val: mVal, inch: row.inch ? String(row.inch).replace(/\uf0ab/g, '').trim() : null });
          }
        }
        if (row.inch) {
          var iVal = String(row.inch).replace(/\uf0ab/g, '').trim();
          if (iVal && !inchList.some(function (x) { return x.val === iVal; })) {
            inchList.push({ val: iVal, mm_equiv: row.mm });
          }
        }
      });

      var metricPop = (window.__BPTL_CURRENT_POPULAR_SIZES && window.__BPTL_CURRENT_POPULAR_SIZES.length > 0)
        ? window.__BPTL_CURRENT_POPULAR_SIZES
        : ['2.00', '3.00', '4.00', '5.00', '6.00', '8.00', '10.00', '12.00'];

      initWithSizeConfig({
        size_types: [
          { code: 'mm', label: 'Metric (mm)', unit_suffix: 'mm', placeholder: 'Select or type size (e.g. 3.5)', popular: metricPop },
          { code: 'inch', label: 'Inch', unit_suffix: '"', placeholder: 'Select or type size (e.g. 1/8")', popular: ['1/16"', '1/8"', '3/16"', '1/4"', '5/16"', '3/8"', '7/16"', '1/2"'] }
        ],
        sizes_by_type: { mm: mmList, inch: inchList }
      });
    }

    if (window.__BPTL_SIZE_CONFIG && Array.isArray(window.__BPTL_SIZE_CONFIG.size_types)) {
      initWithSizeConfig(window.__BPTL_SIZE_CONFIG);
    } else if (window.__BPTL_CURRENT_PRODUCT_SIZES && Array.isArray(window.__BPTL_CURRENT_PRODUCT_SIZES) && window.__BPTL_CURRENT_PRODUCT_SIZES.length > 0) {
      initCatalogueSizes(window.__BPTL_CURRENT_PRODUCT_SIZES, window.__BPTL_CURRENT_VARIANTS || {});
    } else {
      fetch('../api/get_product_data.php?action=all')
        .then(function (res) { return res.json(); })
        .then(function (json) {
          if (json && json.status === 'success') {
            initCatalogueSizes(json.sizes || [], json.variants || {});
          }
        })
        .catch(function (err) {
          console.warn('Could not fetch dynamic API data, using fallback sizes:', err);
        });
    }

    // ==========================================================================
    // 5. POPULAR SIZES PILLS
    // ==========================================================================

    function renderPopularPills(sizesList) {
      if (!popularSizesList) return;
      popularSizesList.innerHTML = '';

      var popRow = popularSizesList.closest('.popular-sizes-row');
      if (!sizesList || sizesList.length === 0) {
        if (popRow) popRow.style.display = 'none';
        return;
      }
      if (popRow) popRow.style.display = 'flex';

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
      var typeRows = sizesByTypeMap[currentUnit] || [];

      if (typeRows.length > 0) {
        typeRows.forEach(function (row) {
          if (!row) return;
          var rawVal = String(row.val || row.mm || '').trim();
          if (!rawVal) return;

          var val = rawVal;
          var label = formatDisplaySize(rawVal, currentSizeType);
          if (currentUnit === 'mm' && row.inch) {
            label = label + ' (' + row.inch + ')';
          } else if (currentUnit === 'inch' && row.mm_equiv) {
            label = label + ' (' + row.mm_equiv + ' mm)';
          }

          if (!options.some(function (o) { return o.val.toLowerCase() === val.toLowerCase(); })) {
            options.push({ val: val, label: label });
          }
        });
      }

      // Fallback sizes only for mm/inch if empty
      if (options.length === 0 && (currentUnit === 'mm' || currentUnit === 'inch')) {
        var defaultSizes = currentUnit === 'mm'
          ? ['0.30', '0.50', '1.00', '1.50', '2.00', '2.50', '3.00', '3.17', '3.50', '4.00', '4.50', '5.00', '5.50', '6.00', '6.35', '7.00', '8.00', '9.00', '10.00', '11.00', '12.00', '13.00']
          : ['1/16"', '3/32"', '1/8"', '5/32"', '3/16"', '7/32"', '1/4"', '9/32"', '5/16"', '3/8"', '7/16"', '1/2"'];
        options = defaultSizes.map(function (s) {
          return { val: s, label: formatDisplaySize(s, currentSizeType) };
        });
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
        emptyMsg.textContent = options.length === 0 ? 'Type any custom size above to add' : 'No matching sizes found';
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

    function cleanInputSize(rawVal, typeCode) {
      var v = String(rawVal || '').trim();
      if (typeCode === 'mm') {
        v = v.replace(/\s*mm$/i, '').trim();
      } else if (typeCode === 'inch') {
        v = v.replace(/\s*inch$/i, '').trim();
      }
      return v;
    }

    function addCurrentSizeToList() {
      if (!diaSearchInput) return;

      var rawSize = diaSearchInput.value.trim();
      var cleanedSize = cleanInputSize(rawSize, currentUnit);

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

      var displaySize = formatDisplaySize(cleanedSize, currentSizeType);

      // Check if this size + sizeType already exists in the quotation table
      var existingIndex = quotationItems.findIndex(function (it) {
        return it.size.toLowerCase() === cleanedSize.toLowerCase() && (it.unit || 'mm') === currentUnit;
      });

      if (existingIndex !== -1) {
        quotationItems[existingIndex].qty += qty;
        quotationItems[existingIndex].moq = 1;
      } else {
        quotationItems.push({
          id: 'user-' + Date.now() + '-' + Math.random().toString(36).substr(2, 4),
          productId: currentProductId,
          productTitle: currentProductTitle,
          size: cleanedSize,
          displaySize: displaySize,
          unit: currentUnit,
          sizeTypeLabel: currentSizeType.label || currentUnit,
          unitSuffix: currentSizeType.unit_suffix || '',
          qty: qty,
          moq: 1,
          availability: 'In Stock'
        });
      }

      // Reset input fields & close dropdown
      diaSearchInput.value = '';
      closeDropdown();
      if (stepQtyInput) {
        stepQtyInput.value = 10;
        stepQtyInput.min = 1;
      }
      updateStepMoqBadge(cleanedSize);

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

        var rawSize = sizeEl.getAttribute('data-size') || sizeEl.textContent.trim();
        var rowUnit = sizeEl.getAttribute('data-unit') || currentUnit || 'mm';
        if (!rawSize) return;

        var itemQty = qtyInp ? (parseInt(qtyInp.value, 10) || 1) : 1;
        if (itemQty < 1) itemQty = 1;
        if (qtyInp) qtyInp.value = itemQty;

        var rowId = (qtyInp && qtyInp.getAttribute('data-id')) ? qtyInp.getAttribute('data-id') : ('row-' + index + '-' + rawSize);

        var existing = quotationItems.find(function (it) {
          return it.id === rowId || (it.size.toLowerCase() === rawSize.toLowerCase() && (it.unit || 'mm') === rowUnit);
        });

        domList.push({
          id: existing ? existing.id : rowId,
          productId: existing ? existing.productId : currentProductId,
          productTitle: existing ? existing.productTitle : currentProductTitle,
          size: rawSize,
          displaySize: existing ? (existing.displaySize || rawSize) : rawSize,
          unit: existing ? existing.unit : rowUnit,
          sizeTypeLabel: existing ? (existing.sizeTypeLabel || rowUnit) : rowUnit,
          unitSuffix: existing ? (existing.unitSuffix || '') : '',
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
        var typeBadge = item.sizeTypeLabel ? '<span class="size-type-pill-tag">' + escapeHtml(item.sizeTypeLabel) + '</span>' : '';

        var tr = document.createElement('tr');
        tr.innerHTML =
          '<td class="td-sno">' + (index + 1) + '</td>' +
          '<td class="td-size" data-size="' + escapeHtml(item.size) + '" data-unit="' + escapeHtml(item.unit || 'mm') + '">' +
            escapeHtml(item.displaySize || item.size) + typeBadge +
          '</td>' +
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
          localStorage.removeItem(quotationStorageKey);
          localStorage.removeItem('birla_quotation_items');
          var curCart = JSON.parse(localStorage.getItem('birla_cart') || '[]');
          if (Array.isArray(curCart)) {
            var remaining = curCart.filter(function (c) {
              return String(c.productId || '') !== String(currentProductId) && c.title !== currentProductTitle;
            });
            if (window.BirlaCart && typeof window.BirlaCart.save === 'function') {
              window.BirlaCart.save(remaining);
            } else {
              localStorage.setItem('birla_cart', JSON.stringify(remaining));
            }
          }
        } catch (e) {}
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

    // Sync Cart Drawer edits/removals back into the current product's Step 2 list
    window.syncCartToProductList = function (cart) {
      if (!Array.isArray(cart)) return;
      var matching = cart.filter(function (c) {
        if (c.productId !== undefined && c.productId !== null && String(c.productId) !== '') {
          return String(c.productId) === String(currentProductId);
        }
        return c.title === currentProductTitle;
      });
      quotationItems = matching.map(function (c, idx) {
        var rawSize = String(c.dia || c.diaText || '').trim();
        var itemQty = parseInt(c.qty, 10) || 1;
        if (itemQty < 1) itemQty = 1;
        return {
          id: 'cart-sync-' + idx + '-' + Date.now(),
          productId: currentProductId,
          productTitle: currentProductTitle,
          size: rawSize,
          displaySize: c.diaText || rawSize,
          unit: c.unit || 'mm',
          sizeTypeLabel: c.sizeTypeLabel || c.unit || 'Metric (mm)',
          unitSuffix: c.unitSuffix || '',
          qty: itemQty,
          moq: 1,
          availability: 'In Stock'
        };
      });
      renderQuotationTable();
      saveQuotationItems();
      syncEnquiryForm();
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
                '<strong class="chip-dia">' + escapeHtml(it.displaySize || it.size) + '</strong>' +
                '<span class="chip-variant">' + escapeHtml(currentProductTitle) + (it.sizeTypeLabel ? ' (' + escapeHtml(it.sizeTypeLabel) + ')' : '') + '</span>' +
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
            return (it.displaySize || it.size) + ' [' + (it.sizeTypeLabel || it.unit || 'mm') + '] (' + it.qty + ' pcs)';
          });
          enquiryDiaInput.value = currentProductTitle + ' — ' + sizeStrings.join(', ');
        } else {
          var fallbackDia = (diaSearchInput && diaSearchInput.value.trim()) ? diaSearchInput.value.trim() : '';
          var cleanFallback = cleanInputSize(fallbackDia, currentUnit);
          var fallbackQty = parseInt(stepQtyInput ? stepQtyInput.value : 10, 10) || 10;
          enquiryDiaInput.value = currentProductTitle + (cleanFallback ? (' — ' + formatDisplaySize(cleanFallback, currentSizeType) + ' (' + fallbackQty + ' pcs)') : '');
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
        enquiryVariantInput.value = 'ITM STD. (' + currentProductStandard + ' | HSN: ' + currentProductHsn + ')';
      }

      if (enquiryPriceBasisInput) {
        enquiryPriceBasisInput.value = 'Official April 2026 Price List — F.O.R. Destination (Direct ITM Plant Dispatch)';
      }
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
            if (diaSearchInput) {
              diaSearchInput.focus();
              diaSearchInput.style.borderColor = '#DC2626';
              setTimeout(function () { diaSearchInput.style.borderColor = ''; }, 1200);
            }
            alert('Please select or enter a size in Step 1 first.');
            return;
          }

          var cleanSize = cleanInputSize(currentStepSize, currentUnit);
          var qty = parseInt(stepQtyInput ? stepQtyInput.value : 10, 10) || 10;
          if (qty < 1) qty = 1;

          quotationItems.push({
            id: 'user-' + Date.now() + '-' + Math.random().toString(36).substr(2, 4),
            productId: currentProductId,
            productTitle: currentProductTitle,
            size: cleanSize,
            displaySize: formatDisplaySize(cleanSize, currentSizeType),
            unit: currentUnit,
            sizeTypeLabel: currentSizeType.label || currentUnit,
            unitSuffix: currentSizeType.unit_suffix || '',
            qty: qty,
            moq: 1,
            availability: 'In Stock'
          });
          if (diaSearchInput) diaSearchInput.value = '';
          closeDropdown();
          renderQuotationTable();
        } else {
          // Table already has items. If user typed an active size in Step 1 that isn't added yet, add or update it
          var pendingDia = diaSearchInput ? diaSearchInput.value.trim() : '';
          if (pendingDia) {
            var cleanPending = cleanInputSize(pendingDia, currentUnit);
            if (cleanPending) {
              var pendingQty = parseInt(stepQtyInput ? stepQtyInput.value : 10, 10) || 10;
              if (pendingQty < 1) pendingQty = 1;

              var existingPending = quotationItems.find(function (it) {
                return it.size.toLowerCase() === cleanPending.toLowerCase() && (it.unit || 'mm') === currentUnit;
              });
              if (existingPending) {
                existingPending.qty = pendingQty;
              } else {
                quotationItems.push({
                  id: 'user-' + Date.now() + '-' + Math.random().toString(36).substr(2, 4),
                  productId: currentProductId,
                  productTitle: currentProductTitle,
                  size: cleanPending,
                  displaySize: formatDisplaySize(cleanPending, currentSizeType),
                  unit: currentUnit,
                  sizeTypeLabel: currentSizeType.label || currentUnit,
                  unitSuffix: currentSizeType.unit_suffix || '',
                  qty: pendingQty,
                  moq: 1,
                  availability: 'In Stock'
                });
              }
              if (diaSearchInput) diaSearchInput.value = '';
              closeDropdown();
              renderQuotationTable();
            }
          }
        }

        // 3. Final synchronization and saving of quotationItems
        syncQuotationItemsFromTableDOM();
        saveQuotationItems();
        syncEnquiryForm();

        // 4. Synchronize into global shopping cart (birla_cart) — uniquely keyed by productId + dia + unit
        var globalCart = [];
        try {
          globalCart = JSON.parse(localStorage.getItem('birla_cart') || '[]');
          if (!Array.isArray(globalCart)) globalCart = [];
        } catch (err) {
          globalCart = [];
        }

        quotationItems.forEach(function (qItem) {
          var diaClean = qItem.size;
          var itemUnit = qItem.unit || 'mm';
          var diaLabel = qItem.displaySize || diaClean;
          var existing = globalCart.find(function (c) {
            var sameProd = (c.productId !== undefined && c.productId !== null)
              ? (String(c.productId) === String(currentProductId))
              : (c.title === currentProductTitle);
            return sameProd && String(c.dia || '').toLowerCase() === diaClean.toLowerCase() && (c.unit || 'mm') === itemUnit;
          });
          if (existing) {
            existing.qty = qItem.qty;
            existing.diaText = diaLabel;
            existing.sizeTypeLabel = qItem.sizeTypeLabel || existing.sizeTypeLabel || itemUnit;
            existing.unitSuffix = qItem.unitSuffix || '';
            existing.standard = currentProductStandard;
            existing.hsn = currentProductHsn;
          } else {
            globalCart.push({
              id: 'cart-' + currentProductId + '-' + itemUnit + '-' + diaClean + '-' + Date.now(),
              productId: currentProductId,
              title: currentProductTitle,
              standard: currentProductStandard,
              hsn: currentProductHsn,
              variant: (window.__BPTL_CURRENT_PRODUCT_VARIANT || 'itm_std'),
              variantName: (window.__BPTL_CURRENT_PRODUCT_VARIANT_NAME || 'ITM STD.'),
              dia: diaClean,
              diaText: diaLabel,
              unit: itemUnit,
              sizeTypeLabel: qItem.sizeTypeLabel || itemUnit,
              unitSuffix: qItem.unitSuffix || '',
              qty: qItem.qty,
              moq: 1,
              img: currentProductImg,
              unitPrice: 0,
              total: 0
            });
          }
        });

        try {
          localStorage.setItem('birla_cart', JSON.stringify(globalCart));
        } catch (err) {}

        // 5. Update cart UI and open Cart Drawer
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
      if (Array.isArray(cart)) {
        window.syncCartToProductList(cart);
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

    renderQuotationTable();
    syncEnquiryForm();

    // Check if page loaded with #enquiry or quote redirect flag
    if (window.location.hash === '#enquiry' || localStorage.getItem('birla_sync_cart_to_quote') === '1') {
      try { localStorage.removeItem('birla_sync_cart_to_quote'); } catch (e) {}
      window.location.replace('../quotation.php');
    }

  });
}
