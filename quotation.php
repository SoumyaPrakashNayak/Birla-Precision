<?php
/**
 * Birla Precision Technologies Limited / Dagger Brand
 * Dedicated Official Quotation Request & Bulk Tooling Enquiry Page
 * Displays ONLY the quotation workflow without product hero/configurator above it.
 */

require_once __DIR__ . '/includes/data.php';

$current_page = 'quotation';
$is_subfolder = false;
$page_title = 'Request Official Quotation | Birla Precision Technologies';
$page_description = 'Official quotation request and bulk tooling enquiry for Birla Precision Technologies and Dagger Brand cutting tools.';

include __DIR__ . '/includes/header.php';
?>

<!-- Breadcrumb & Navigation Bar -->
<nav class="breadcrumb-nav" aria-label="Breadcrumbs" style="background:#F8FAFC;border-bottom:1px solid #E2E8F0;padding:14px 0;">
  <div class="container" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
    <ol class="breadcrumb-list" style="margin:0;padding:0;list-style:none;display:flex;align-items:center;font-size:0.875rem;">
      <li><a href="index.php" style="color:#64748B;text-decoration:none;">Home</a></li>
      <li class="breadcrumb-separator" style="margin:0 8px;color:#94A3B8;">&rsaquo;</li>
      <li><a href="products/parallel-shank-twist-drills.php" style="color:#64748B;text-decoration:none;">Jobber Series Drills</a></li>
      <li class="breadcrumb-separator" style="margin:0 8px;color:#94A3B8;">&rsaquo;</li>
      <li class="breadcrumb-current" aria-current="page" style="color:#DC2626;font-weight:600;">Request Official Quotation</li>
    </ol>

    <div>
      <a href="products/parallel-shank-twist-drills.php" class="btn" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:#FFF;border:1px solid #CBD5E1;color:#1E293B;font-size:0.85rem;font-weight:600;border-radius:6px;text-decoration:none;transition:all 0.2s;">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="19" y1="12" x2="5" y2="12"></line>
          <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        <span>Back to Product Configurator</span>
      </a>
    </div>
  </div>
</nav>

<!-- ==========================================================================
     DEDICATED QUOTATION WORKFLOW SECTION
     ========================================================================== -->
<section class="enquiry-section" id="quotationPageSection" style="padding:48px 0 80px;background:#FAFAFA;">
  <div class="container">
    
    <!-- Empty Cart Notice (displayed when no items are in cart) -->
    <div id="quoteEmptyNotice" class="enquiry-card" style="display:none;text-align:center;padding:56px 24px;">
      <div style="width:72px;height:72px;margin:0 auto 20px;border-radius:50%;background:#FEE2E2;display:flex;align-items:center;justify-content:center;color:#DC2626;">
        <svg viewBox="0 0 24 24" width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="9" cy="21" r="1"></circle>
          <circle cx="20" cy="21" r="1"></circle>
          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
      </div>
      <h3 style="font-family:var(--font-heading);font-size:1.5rem;color:#0F172A;margin-bottom:8px;">Your Quotation Cart is Empty</h3>
      <p style="color:#64748B;max-width:520px;margin:0 auto 24px;font-size:0.95rem;line-height:1.6;">
        You have not added any tooling sizes to your cart yet. Please explore our Jobber Series Drills configurator to select diameters and quantities before requesting a quotation.
      </p>
      <a href="products/parallel-shank-twist-drills.php" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:8px;padding:12px 28px;font-size:0.95rem;border-radius:6px;">
        <span>Configure Jobber Drills</span>
        <span>&rarr;</span>
      </a>
    </div>

    <!-- Active Quotation Card -->
    <div class="enquiry-card" id="quoteMainCard">
      
      <div style="text-align:center;margin-bottom:28px;">
        <span class="section-eyebrow" style="color:#DC2626;font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:6px;">
          Official Quotation Workflow
        </span>
        <h1 style="font-family:var(--font-heading);font-size:2rem;color:#111;margin-bottom:8px;font-weight:700;">
          Request Official Quotation / Bulk Tooling Enquiry
        </h1>
        <p style="font-size:0.95rem;color:#64748B;max-width:680px;margin:0 auto;">
          Review your selected tooling specifications below. Your request will be routed directly to the Birla Precision cutting tools technical sales desk.
        </p>
      </div>

      <!-- Live Feedback Banner -->
      <div id="enquiryFeedback" class="form-feedback-message"></div>

      <!-- Selected Tooling Specifications to be Quoted: Contains ONLY user added cart items -->
      <div class="enquiry-cart-summary-box" id="enquiryCartSummaryBox" style="margin-bottom:28px;">
        <div class="enquiry-summary-header" style="display:flex;align-items:center;justify-content:space-between;padding-bottom:12px;border-bottom:1px solid #E2E8F0;margin-bottom:14px;">
          <div class="enquiry-summary-title-wrap" style="display:flex;align-items:center;gap:8px;color:#0F172A;font-weight:700;font-size:0.95rem;">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#DC2626" stroke-width="2">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
              <polyline points="14 2 14 8 20 8"></polyline>
              <line x1="16" y1="13" x2="8" y2="13"></line>
              <line x1="16" y1="17" x2="8" y2="17"></line>
            </svg>
            <span class="enquiry-summary-title">Selected Tooling Specifications to be Quoted:</span>
          </div>
          <span class="enquiry-summary-count-badge" id="enquirySummaryCount" style="background:#DC2626;color:#FFF;font-size:0.75rem;font-weight:700;padding:4px 10px;border-radius:20px;">
            0 Sizes | 0 pcs
          </span>
        </div>

        <div class="enquiry-summary-items" id="enquirySummaryItems" style="display:flex;flex-wrap:wrap;gap:10px;">
          <!-- Populated dynamically via JS: contains ONLY user added cart items -->
        </div>
      </div>

      <!-- Form -->
      <form id="productEnquiryForm" method="POST" action="enquiry_submit.php">
        
        <!-- CSRF Token -->
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">

        <div class="enquiry-form-grid">
          
          <!-- Selected Diameter & Product Line (Pre-filled from cart) -->
          <div class="form-group form-group-full">
            <label class="form-label" for="enquiryDiaInput">Product Specification &amp; Selected Diameters</label>
            <input 
              type="text" 
              name="metric_dia" id="enquiryDiaInput" class="form-control form-readonly" value="HSS Parallel Shank Twist Drills (Jobber Series) — Conforming to IS : 5101"
              readonly
            >
          </div>

          <!-- Selected Variant (Pre-filled) -->
          <div class="form-group">
            <label class="form-label" for="enquiryVariantInput">Selected Variant &amp; Metallurgy</label>
            <input 
              type="text" 
              name="variant_name" 
              id="enquiryVariantInput" 
              class="form-control form-readonly" 
              value="ITM STD. (HSS M2 / Precision Ground Flutes — IS : 5101 | HSN: 8207)"
              readonly
            >
          </div>

          <!-- Quantity -->
          <div class="form-group">
            <label class="form-label" for="enquiryQuantityInput">Total Required Quantity (Pieces)</label>
            <input 
              type="number" 
              name="quantity" id="enquiryQuantityInput" class="form-control" value="" placeholder="Combined pieces in cart" min="1" required
            >
            <small id="enquiryMoqNotice" style="display:block;font-size:0.75rem;color:#78909C;margin-top:4px;">
              Combined quantity for selected sizes.
            </small>
          </div>

          <!-- Procurement Basis Reference -->
          <div class="form-group form-group-full">
            <label class="form-label" for="enquiryPriceBasisInput">Procurement Basis &amp; Supply Terms</label>
            <input 
              type="text" 
              name="price_basis" 
              id="enquiryPriceBasisInput" 
              class="form-control form-readonly" 
              value="Official April 2026 Price List — F.O.R. Destination (Direct ITM Plant Dispatch)"
              readonly
            >
          </div>

          <!-- Customer Name -->
          <div class="form-group">
            <label class="form-label" for="enquiryNameInput">Full Name *</label>
            <input 
              type="text" 
              name="customer_name" 
              id="enquiryNameInput" 
              class="form-control" 
              placeholder="e.g. Rajesh Kumar" 
              required
            >
          </div>

          <!-- Company Name -->
          <div class="form-group">
            <label class="form-label" for="enquiryCompanyInput">Company / Organization</label>
            <input 
              type="text" 
              name="company_name" 
              id="enquiryCompanyInput" 
              class="form-control" 
              placeholder="e.g. Apex Precision Engineering Ltd." 
              required
            >
          </div>

          <!-- Email -->
          <div class="form-group">
            <label class="form-label" for="enquiryEmailInput">Mail *</label>
            <input 
              type="email" 
              name="email" 
              id="enquiryEmailInput" 
              class="form-control" 
              placeholder="e.g. procurement@apex-eng.com" 
              required
            >
          </div>

          <!-- Phone -->
          <div class="form-group">
            <label class="form-label" for="enquiryPhoneInput">Phone / Mobile Number *</label>
            <input 
              type="tel" 
              name="phone" 
              id="enquiryPhoneInput" 
              class="form-control" 
              placeholder="e.g. +91 98200 12345" 
              required
            >
          </div>

          <!-- Address -->
          <div class="form-group form-group-full">
            <label class="form-label" for="enquiryAddressInput">Address</label>
            <textarea 
              name="address" 
              id="enquiryAddressInput" 
              class="form-control" 
              rows="2" 
              placeholder="Enter delivery or company address (Plant address, City, Pincode)..."
            ></textarea>
          </div>

          <!-- Any remark -->
          <div class="form-group form-group-full">
            <label class="form-label" for="enquiryMessageInput">Any remark</label>
            <textarea 
              name="message" 
              id="enquiryMessageInput" 
              class="form-control" 
              placeholder="Enter any remarks, special instructions, or requirements..."
            ></textarea>
          </div>

          <!-- Submit Button -->
          <div class="form-group form-group-full" style="text-align:center;margin-top:16px;">
            <button type="submit" class="btn btn-primary" id="enquirySubmitBtn" style="min-width:280px;padding:14px 32px;font-size:1rem;font-weight:700;">
              Submit Official Enquiry
            </button>
            <p style="font-size:0.75rem;color:#888;margin-top:10px;">
              By submitting, your request is routed directly to the Birla Precision cutting tools technical sales desk.
            </p>
          </div>

        </div>

      </form>

    </div>

  </div>
</section>

<!-- Quotation Page Client Interactions -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  var quoteEmptyNotice = document.getElementById('quoteEmptyNotice');
  var quoteMainCard = document.getElementById('quoteMainCard');
  var enquiryCartSummaryBox = document.getElementById('enquiryCartSummaryBox');
  var enquirySummaryCount = document.getElementById('enquirySummaryCount');
  var enquirySummaryItems = document.getElementById('enquirySummaryItems');
  var enquiryDiaInput = document.getElementById('enquiryDiaInput');
  var enquiryQuantityInput = document.getElementById('enquiryQuantityInput');
  var enquiryMoqNotice = document.getElementById('enquiryMoqNotice');
  var enquiryNameInput = document.getElementById('enquiryNameInput');
  var enquiryCompanyInput = document.getElementById('enquiryCompanyInput');
  var enquiryEmailInput = document.getElementById('enquiryEmailInput');
  var enquiryPhoneInput = document.getElementById('enquiryPhoneInput');
  var enquiryAddressInput = document.getElementById('enquiryAddressInput');
  var enquiryMessageInput = document.getElementById('enquiryMessageInput');
  var enquiryForm = document.getElementById('productEnquiryForm');
  var enquirySubmitBtn = document.getElementById('enquirySubmitBtn');
  var enquiryFeedback = document.getElementById('enquiryFeedback');

  function escapeHtml(text) {
    if (text === null || text === undefined) return '';
    return String(text).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  }

  function getCartData() {
    try {
      var data = localStorage.getItem('birla_cart');
      return data ? JSON.parse(data) : [];
    } catch (e) {
      return [];
    }
  }

  function renderQuotationView() {
    var cart = getCartData();

    if (!Array.isArray(cart) || cart.length === 0) {
      if (quoteEmptyNotice) quoteEmptyNotice.style.display = 'block';
      if (quoteMainCard) quoteMainCard.style.display = 'none';
      return;
    }

    if (quoteEmptyNotice) quoteEmptyNotice.style.display = 'none';
    if (quoteMainCard) quoteMainCard.style.display = 'block';

    var totalPieces = 0;
    cart.forEach(function (it) {
      totalPieces += (parseInt(it.qty, 10) || 0);
    });

    // 1. Render Summary Header & Chips
    if (enquirySummaryCount) {
      enquirySummaryCount.textContent = cart.length + (cart.length === 1 ? ' Size' : ' Sizes') + ' | ' + totalPieces + ' pcs';
    }

    if (enquirySummaryItems) {
      enquirySummaryItems.innerHTML = '';
      cart.forEach(function (it) {
        var diaLabel = it.diaText || (it.dia ? (it.dia + (it.unit === 'inch' ? '' : ' mm')) : 'Drill');
        var chip = document.createElement('div');
        chip.className = 'enquiry-summary-chip';
        chip.innerHTML =
          '<div class="chip-main">' +
            '<strong class="chip-dia">' + escapeHtml(diaLabel) + '</strong>' +
            '<span class="chip-variant">HSS Jobber Series</span>' +
          '</div>' +
          '<div class="chip-qty-wrap">' +
            '<span class="chip-qty">' + (it.qty || 1) + ' pcs</span>' +
          '</div>';
        enquirySummaryItems.appendChild(chip);
      });
    }

    // 2. Pre-fill Diameters and Total Quantity
    if (enquiryDiaInput) {
      var diaList = cart.map(function (it) {
        var label = it.diaText || (it.dia ? (it.dia + (it.unit === 'inch' ? '' : ' mm')) : 'Drill');
        return label + ' (' + (it.qty || 1) + ' pcs)';
      });
      enquiryDiaInput.value = 'HSS Jobber Series (IS:5101) — ' + diaList.join(', ');
    }

    if (enquiryQuantityInput) {
      enquiryQuantityInput.value = totalPieces > 0 ? totalPieces : 1;
    }

    if (enquiryMoqNotice) {
      enquiryMoqNotice.textContent = 'Combined quantity in cart: ' + totalPieces + ' pcs across ' + cart.length + (cart.length === 1 ? ' size' : ' sizes') + '.';
    }

    // 3. Pre-fill User Data if already signed in
    try {
      var savedUser = localStorage.getItem('birla_user');
      if (savedUser) {
        var u = JSON.parse(savedUser);
        if (enquiryNameInput && !enquiryNameInput.value && u.fullName) enquiryNameInput.value = u.fullName;
        if (enquiryCompanyInput && !enquiryCompanyInput.value && u.company) enquiryCompanyInput.value = u.company;
        if (enquiryEmailInput && !enquiryEmailInput.value && u.email) enquiryEmailInput.value = u.email;
        if (enquiryPhoneInput && !enquiryPhoneInput.value && u.phone) enquiryPhoneInput.value = u.phone;
      }
    } catch (e) {}
  }

  // Initial render
  renderQuotationView();

  // Handle AJAX Form Submission
  if (enquiryForm) {
    enquiryForm.addEventListener('submit', function (e) {
      e.preventDefault();

      if (enquirySubmitBtn) {
        enquirySubmitBtn.disabled = true;
        enquirySubmitBtn.textContent = 'Submitting Official Quotation Request...';
      }
      if (enquiryFeedback) {
        enquiryFeedback.className = 'form-feedback-message';
        enquiryFeedback.style.display = 'none';
        enquiryFeedback.innerHTML = '';
      }

      var formData = new FormData(enquiryForm);

      fetch(enquiryForm.action || 'enquiry_submit.php', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        if (enquirySubmitBtn) {
          enquirySubmitBtn.disabled = false;
          enquirySubmitBtn.textContent = 'Submit Official Enquiry';
        }

        if (data && data.status === 'success') {
          // Clear cart on successful quotation submission
          try {
            localStorage.removeItem('birla_cart');
            localStorage.removeItem('birla_quotation_items');
          } catch (e) {}
          if (window.BirlaCart && typeof window.BirlaCart.save === 'function') {
            window.BirlaCart.save([]);
          }

          if (quoteMainCard) {
            quoteMainCard.innerHTML =
              '<div style="text-align:center;padding:48px 16px;">' +
                '<div style="width:72px;height:72px;margin:0 auto 20px;border-radius:50%;background:#DCFCE7;display:flex;align-items:center;justify-content:center;color:#16A34A;">' +
                  '<svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">' +
                    '<polyline points="20 6 9 17 4 12"></polyline>' +
                  '</svg>' +
                '</div>' +
                '<h2 style="font-family:var(--font-heading);font-size:1.8rem;color:#0F172A;margin-bottom:8px;font-weight:700;">' +
                  'Quotation Request Successfully Submitted!' +
                '</h2>' +
                '<p style="color:#475569;font-size:1rem;margin-bottom:12px;">' +
                  (escapeHtml(data.message) || 'Your official quotation request has been received by our technical desk.') +
                '</p>' +
                '<div style="display:inline-block;background:#F1F5F9;border:1px dashed #CBD5E1;padding:10px 24px;border-radius:8px;margin:16px auto 28px;">' +
                  '<span style="font-size:0.8rem;color:#64748B;display:block;">Official Reference Code</span>' +
                  '<strong style="font-size:1.15rem;color:#DC2626;letter-spacing:1px;">' + escapeHtml(data.reference_id || 'BPTL-QUOTE-REC') + '</strong>' +
                '</div>' +
                '<div style="margin-top:8px;">' +
                  '<a href="products/parallel-shank-twist-drills.php" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:8px;padding:12px 28px;font-size:0.95rem;border-radius:6px;">' +
                    '<span>Return to Catalogue & Configurator</span>' +
                    '<span>&rarr;</span>' +
                  '</a>' +
                '</div>' +
              '</div>';
          }
        } else {
          var errorMsg = data && data.message ? data.message : 'Submission failed. Please check form inputs.';
          if (data && data.errors) {
            var errorList = Object.keys(data.errors).map(function (k) { return data.errors[k]; });
            errorMsg += '<br>&bull; ' + errorList.join('<br>&bull; ');
          }
          if (enquiryFeedback) {
            enquiryFeedback.className = 'form-feedback-message is-error';
            enquiryFeedback.style.display = 'block';
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
          enquiryFeedback.style.display = 'block';
          enquiryFeedback.textContent = 'Network error while submitting enquiry. Please check your connection or contact sales directly.';
        }
        console.error('Enquiry submission error:', err);
      });
    });
  }

});
</script>

<?php
include __DIR__ . '/includes/footer.php';
?>
