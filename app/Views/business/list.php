<?php $this->extend('layouts.main'); ?>

<?php $this->section('container_class'); ?>business-container<?php $this->endSection(); ?>

        <div class="business-content">
          <!-- Hero -->
          <section class="list-hero">
            <div class="list-hero-content">
              <span class="hero-tag">
                <i class="fa-solid fa-store"></i> Merchant Registration
              </span>
              <h1>List Your Business</h1>
              <p class="list-hero-subtitle">
                Reach neighbors in your area, share your services, and grow your customer base with a verified listing.
              </p>
              <div class="list-stats">
                <div class="stat-item">
                  <span class="stat-number"><i class="fa-solid fa-users stat-icon"></i> 12,400+</span>
                  <span class="stat-label">Active Neighbors</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number"><i class="fa-solid fa-shop stat-icon"></i> 890+</span>
                  <span class="stat-label">Local Businesses</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number"><i class="fa-solid fa-bolt stat-icon"></i> 100% Free</span>
                  <span class="stat-label">Instant Listing</span>
                </div>
              </div>
            </div>
            <div class="list-hero-icon">
              <i class="fa-solid fa-store"></i>
            </div>
          </section>

          <!-- Breadcrumbs -->
          <nav class="list-breadcrumbs" aria-label="Breadcrumb">
            <a href="/businesses">Business Directory</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="#">List Your Business</a>
          </nav>

          <!-- Form -->
          <div class="list-form-container">
            <div class="list-form-section">

              <?php
                $formErrors    = session()->getFlash('errors', []);
                $oldCategory   = old('category');
                $oldPriceRange = old('price_range');
              ?>

              <?php if (!empty($formErrors)): ?>
                <div class="form-error-banner">
                  <p><i class="fa-solid fa-triangle-exclamation"></i> Please fix the following errors:</p>
                  <ul>
                    <?php foreach ($formErrors as $errs): ?>
                      <?php foreach ((array) $errs as $err): ?>
                        <li><?= e($err) ?></li>
                      <?php endforeach; ?>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php endif; ?>

              <form action="/businesses" method="POST" class="list-form" id="businessForm"
                    enctype="multipart/form-data">
                <?= csrf_field() ?>

                <!-- ======================================================
                     SECTION 1 — General Information
                     ====================================================== -->
                <div class="form-section">
                  <h3 class="section-title">
                    <span class="sec-num">1</span> General Information
                  </h3>
                  <p class="section-desc">Core details about your business.</p>

                  <div class="form-row">
                    <div class="form-group">
                      <label for="businessName" class="field-label">Business Name *</label>
                      <div class="field-container">
                        <input type="text" id="businessName" name="name"
                               value="<?= e(old('name')) ?>"
                               placeholder="e.g., GreenBite Cafe" required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="businessType" class="field-label">Business Category *</label>
                      <div class="field-container">
                        <select id="businessType" name="category" required>
                          <option value="">Select category</option>
                          <?php
                            $categories = [
                              'Cafes & Dining','Auto Services','Beauty & Wellness',
                              'Clothing & Fashion','Electronics & Tech','Food Delivery',
                              'Health & Pharmacy','Home & Garden','Markets & Grocery',
                              'Repairs & Services','Sports & Fitness','Education & Tutoring',
                              'Financial Services','Real Estate','Other',
                            ];
                            foreach ($categories as $cat):
                          ?>
                            <option value="<?= e($cat) ?>"<?= $oldCategory === $cat ? ' selected' : '' ?>><?= e($cat) ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="description" class="field-label">Business Description</label>
                    <div class="field-container textarea-container">
                      <textarea id="description" name="description" rows="4"
                                placeholder="Tell your neighbors what makes your business special..."><?= e(old('description')) ?></textarea>
                    </div>
                    <p class="field-hint">What do you offer? What makes you stand out?</p>
                  </div>

                  <div class="form-row">
                    <div class="form-group">
                      <label for="address" class="field-label">Address *</label>
                      <div class="field-container">
                        <input type="text" id="address" name="address"
                               value="<?= e(old('address')) ?>"
                               placeholder="Street address, area" required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="hours" class="field-label">Opening Hours</label>
                      <div class="field-container">
                        <input type="text" id="hours" name="opening_hours"
                               value="<?= e(old('opening_hours')) ?>"
                               placeholder="e.g., 8AM – 8PM" />
                      </div>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group">
                      <label for="phone" class="field-label">Phone Number</label>
                      <div class="field-container">
                        <input type="tel" id="phone" name="phone"
                               value="<?= e(old('phone')) ?>"
                               placeholder="+234 80x xxx xxxx" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="bizEmail" class="field-label">Business Email</label>
                      <div class="field-container">
                        <input type="email" id="bizEmail" name="email"
                               value="<?= e(old('email')) ?>"
                               placeholder="info@yourbusiness.com" />
                      </div>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group">
                      <label for="website" class="field-label">Website / Social Media</label>
                      <div class="field-container">
                        <input type="url" id="website" name="website"
                               value="<?= e(old('website')) ?>"
                               placeholder="https://..." />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="priceRange" class="field-label">Price Range</label>
                      <div class="field-container">
                        <select id="priceRange" name="price_range">
                          <option value="">Select range</option>
                          <?php
                            $priceOptions = [
                              '₦'    => '₦ – Budget',
                              '₦₦'   => '₦₦ – Moderate',
                              '₦₦₦'  => '₦₦₦ – Premium',
                              '₦₦₦₦' => '₦₦₦₦ – Luxury',
                            ];
                            foreach ($priceOptions as $val => $label):
                          ?>
                            <option value="<?= e($val) ?>"<?= $oldPriceRange === $val ? ' selected' : '' ?>><?= e($label) ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- ======================================================
                     SECTION 2 — Branding
                     ====================================================== -->
                <div class="form-section">
                  <h3 class="section-title">
                    <span class="sec-num">2</span> Branding
                  </h3>
                  <p class="section-desc">Upload your business logo and a cover image to make your listing stand out.</p>

                  <div class="branding-upload-row">

                    <!-- Logo uploader -->
                    <div class="upload-zone upload-zone--logo">
                      <label class="field-label" for="logoInput">Business Logo</label>
                      <div class="upload-trigger upload-trigger--logo" id="logoTrigger" role="button" tabindex="0"
                           aria-label="Upload business logo">
                        <div class="upload-preview upload-preview--logo" id="logoPreview">
                          <img src="/img/placeholder-logo.svg"
                               alt="Logo placeholder"
                               class="upload-placeholder-img"
                               id="logoPreviewImg" />
                        </div>
                        <div class="upload-overlay">
                          <i class="fa-solid fa-camera"></i>
                          <span>Upload Logo</span>
                        </div>
                      </div>
                      <input type="file" id="logoInput" name="logo"
                             accept="image/jpeg,image/png,image/gif,image/webp"
                             class="upload-file-input" aria-label="Upload logo" />
                      <p class="field-hint" style="text-align:center;">
                        Square image recommended · JPG, PNG or WebP · Max 2 MB
                      </p>
                      <button type="button" class="upload-clear-btn" id="logoClearBtn"
                              style="display:none;" aria-label="Remove logo">
                        <i class="fa-solid fa-xmark"></i> Remove
                      </button>
                    </div>

                    <!-- Cover image uploader -->
                    <div class="upload-zone upload-zone--cover">
                      <label class="field-label" for="coverInput">Cover Image</label>
                      <div class="upload-trigger upload-trigger--cover" id="coverTrigger" role="button" tabindex="0"
                           aria-label="Upload cover image">
                        <div class="upload-preview upload-preview--cover" id="coverPreview">
                          <img src="/img/placeholder-cover.svg"
                               alt="Cover placeholder"
                               class="upload-placeholder-img"
                               id="coverPreviewImg" />
                        </div>
                        <div class="upload-overlay">
                          <i class="fa-solid fa-image"></i>
                          <span>Upload Cover</span>
                        </div>
                      </div>
                      <input type="file" id="coverInput" name="cover_image"
                             accept="image/jpeg,image/png,image/gif,image/webp"
                             class="upload-file-input" aria-label="Upload cover image" />
                      <p class="field-hint">
                        Landscape image recommended (1200×480 px) · JPG, PNG or WebP · Max 2 MB
                      </p>
                      <button type="button" class="upload-clear-btn" id="coverClearBtn"
                              style="display:none;" aria-label="Remove cover image">
                        <i class="fa-solid fa-xmark"></i> Remove
                      </button>
                    </div>

                  </div>
                </div>

                <!-- ======================================================
                     SECTION 3 — Products & Pricing (optional)
                     ====================================================== -->
                <div class="form-section">
                  <h3 class="section-title">
                    <span class="sec-num">3</span> Products &amp; Pricing
                    <span class="sec-badge-optional">Optional</span>
                  </h3>
                  <p class="section-desc">
                    Add the products you sell and their prices. Leave this section empty if your business doesn't sell products.
                  </p>

                  <div id="productsContainer"></div>

                  <button type="button" class="btn-add-row" id="addProductBtn">
                    <i class="fa-solid fa-plus"></i> Add a Product
                  </button>
                </div>

                <!-- ======================================================
                     SECTION 4 — Services (optional)
                     ====================================================== -->
                <div class="form-section">
                  <h3 class="section-title">
                    <span class="sec-num">4</span> Services
                    <span class="sec-badge-optional">Optional</span>
                  </h3>
                  <p class="section-desc">
                    List the services you offer. Leave this section empty if your business doesn't offer specific services.
                  </p>

                  <div id="servicesContainer"></div>

                  <button type="button" class="btn-add-row" id="addServiceBtn">
                    <i class="fa-solid fa-plus"></i> Add a Service
                  </button>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                  <a href="/businesses" class="btn-secondary">Cancel</a>
                  <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-store"></i> Publish Listing
                  </button>
                </div>
              </form>
            </div>
          </div>

          <!-- Live Preview Card -->
          <div class="preview-section" id="previewSection">
            <h2 class="preview-title">Preview</h2>
            <div class="business-card preview-card" id="previewCard">
              <div class="cardThumb">
                <img id="previewImage" src="/img/placeholder-cover.svg" alt="Business preview" />
                <span class="cardBadge" id="previewBadge">Category</span>
                <span class="cardStatus"><i class="fa-solid fa-circle"></i> Open Now</span>
              </div>
              <div class="cardBody">
                <h3 class="cardTitle" id="previewTitle">Your Business Name</h3>
                <div class="cardRating">
                  <i class="fa-solid fa-star"></i>
                  <span><strong>5.0</strong> (0 reviews)</span>
                </div>
                <p class="cardLocation">
                  <i class="fa-solid fa-location-dot"></i>
                  <span id="previewLocation">Your Address</span>
                </p>
                <p class="cardDesc" id="previewDesc">Your business description will appear here.</p>
              </div>
              <div class="cardFooter">
                <span class="cardPriceRange" id="previewPrice">₦₦ • Moderate</span>
                <a href="#" class="btnView">View Listing</a>
              </div>
            </div>
          </div>
        </div>

<?php $this->section('styles'); ?>
<style>
/* ── Section header chrome ──────────────────────────────────── */
.form-section .section-title::before { display: none; }

.sec-num {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 1.75rem;
  height: 1.75rem;
  border-radius: 50%;
  background: var(--accent, #16a34a);
  color: #fff;
  font-size: .78rem;
  font-weight: 700;
  margin-right: .45rem;
  flex-shrink: 0;
  line-height: 1;
}
.sec-badge-optional {
  display: inline-block;
  font-size: .68rem;
  font-weight: 600;
  padding: .15rem .5rem;
  border-radius: 999px;
  background: hsl(210,20%,92%);
  color: hsl(210,20%,42%);
  margin-left: .6rem;
  vertical-align: middle;
  letter-spacing: .03em;
  text-transform: uppercase;
}
.section-desc {
  margin: -.25rem 0 1.25rem;
  font-size: .875rem;
  color: var(--text-3, #6b7280);
  line-height: 1.5;
}
.form-error-banner {
  background: hsl(0,72%,95%);
  border: 1px solid hsl(0,72%,78%);
  border-radius: 10px;
  padding: 1rem 1.25rem;
  margin-bottom: 1.5rem;
}
.form-error-banner p {
  color: hsl(0,72%,40%);
  font-weight: 600;
  margin: 0 0 .4rem;
}
.form-error-banner ul {
  margin: 0;
  padding-left: 1.25rem;
  color: hsl(0,72%,42%);
  font-size: .875rem;
}

/* ── Branding upload layout ─────────────────────────────────── */
.branding-upload-row {
  display: grid;
  grid-template-columns: 180px 1fr;
  gap: 1.5rem;
  align-items: start;
}
@media (max-width: 600px) {
  .branding-upload-row { grid-template-columns: 1fr; }
}

/* ── Upload zone (wrapper) ──────────────────────────────────── */
.upload-zone {
  display: flex;
  flex-direction: column;
  gap: .5rem;
}

/* Hidden native input */
.upload-file-input {
  position: absolute;
  width: 1px;
  height: 1px;
  opacity: 0;
  pointer-events: none;
  overflow: hidden;
}

/* ── Trigger / clickable area ───────────────────────────────── */
.upload-trigger {
  position: relative;
  cursor: pointer;
  border-radius: 12px;
  overflow: hidden;
  border: 2px dashed var(--border, #e5e7eb);
  transition: border-color .2s, box-shadow .2s;
  background: var(--bg-secondary, #f9fafb);
}
.upload-trigger:hover,
.upload-trigger:focus-within,
.upload-trigger.dragover {
  border-color: var(--accent, #16a34a);
  box-shadow: 0 0 0 3px rgba(22,163,74,.12);
  outline: none;
}

/* Logo trigger — square */
.upload-trigger--logo {
  width: 160px;
  height: 160px;
  border-radius: 50%;
}
.upload-preview--logo {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Cover trigger — wide */
.upload-trigger--cover {
  width: 100%;
  height: 180px;
  border-radius: 12px;
}
.upload-preview--cover {
  width: 100%;
  height: 100%;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Placeholder / preview images */
.upload-placeholder-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: opacity .2s;
}

/* Hover overlay */
.upload-overlay {
  position: absolute;
  inset: 0;
  background: rgba(22, 163, 74, .72);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: .4rem;
  color: #fff;
  font-size: .85rem;
  font-weight: 600;
  opacity: 0;
  transition: opacity .2s;
  border-radius: inherit;
}
.upload-overlay i { font-size: 1.4rem; }
.upload-trigger:hover .upload-overlay,
.upload-trigger:focus .upload-overlay,
.upload-trigger.dragover .upload-overlay {
  opacity: 1;
}

/* Clear button */
.upload-clear-btn {
  display: inline-flex;
  align-items: center;
  gap: .35rem;
  padding: .3rem .75rem;
  border: 1px solid hsl(0,72%,75%);
  border-radius: 6px;
  background: hsl(0,72%,96%);
  color: hsl(0,72%,45%);
  font-size: .78rem;
  font-weight: 600;
  cursor: pointer;
  align-self: flex-start;
  transition: background .15s;
}
.upload-clear-btn:hover { background: hsl(0,72%,90%); }

/* ── Dynamic product/service rows ───────────────────────────── */
.dynamic-row {
  padding: 1rem;
  background: var(--bg-secondary, #f9fafb);
  border: 1px solid var(--border, #e5e7eb);
  border-radius: 10px;
  margin-bottom: .75rem;
  position: relative;
}
.dynamic-row .row-grid { display: grid; gap: .75rem; }
.dynamic-row .row-grid-2 { grid-template-columns: 1fr 1fr; }
.dynamic-row label {
  font-size: .78rem;
  font-weight: 600;
  color: var(--text-3, #6b7280);
  display: block;
  margin-bottom: .3rem;
}
.dynamic-row input,
.dynamic-row select,
.dynamic-row textarea {
  width: 100%;
  padding: .55rem .75rem;
  border: 1.5px solid var(--border, #e5e7eb);
  border-radius: 8px;
  font-size: .875rem;
  background: #fff;
  color: var(--text-1, #111827);
  box-sizing: border-box;
  font-family: inherit;
  transition: border-color .15s, box-shadow .15s;
}
.dynamic-row input:focus,
.dynamic-row select:focus,
.dynamic-row textarea:focus {
  outline: none;
  border-color: var(--accent, #16a34a);
  box-shadow: 0 0 0 3px rgba(22,163,74,.12);
}
.dynamic-row textarea { resize: vertical; min-height: 60px; }
.btn-remove-row {
  position: absolute;
  top: .75rem;
  right: .75rem;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 2rem;
  height: 2rem;
  border: none;
  border-radius: 6px;
  background: hsl(0,72%,94%);
  color: hsl(0,72%,45%);
  cursor: pointer;
  transition: background .15s;
}
.btn-remove-row:hover { background: hsl(0,72%,88%); }
.btn-add-row {
  display: inline-flex;
  align-items: center;
  gap: .4rem;
  padding: .6rem 1.1rem;
  border: 1.5px dashed var(--accent, #16a34a);
  border-radius: 8px;
  background: transparent;
  color: var(--accent, #16a34a);
  font-size: .875rem;
  font-weight: 600;
  cursor: pointer;
  margin-top: .25rem;
  transition: background .15s;
  font-family: inherit;
}
.btn-add-row:hover { background: hsl(140,62%,96%); }

/* Icon select row */
.icon-select-wrap { display: flex; align-items: center; gap: .5rem; }
.icon-select-preview { font-size: 1.1rem; color: var(--accent, #16a34a); width: 1.25rem; }
</style>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
(function () {
  /* ── Utility ──────────────────────────────────────────────── */
  function escHtml(str) {
    return String(str)
      .replace(/&/g,'&amp;').replace(/</g,'&lt;')
      .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

  /* ── Live Preview sync ────────────────────────────────────── */
  const form = document.getElementById('businessForm');
  if (form) {
    form.addEventListener('input',  updatePreview);
    form.addEventListener('change', updatePreview);
  }
  function updatePreview() {
    const name    = document.getElementById('businessName')?.value  || 'Your Business Name';
    const type    = document.getElementById('businessType')?.value  || '';
    const address = document.getElementById('address')?.value       || 'Your Address';
    const price   = document.getElementById('priceRange')?.value    || '';
    const desc    = document.getElementById('description')?.value   || 'Your business description will appear here.';

    document.getElementById('previewTitle').textContent    = name;
    document.getElementById('previewBadge').textContent    = type || 'Category';
    document.getElementById('previewLocation').textContent = address;
    document.getElementById('previewDesc').textContent     = desc.length > 80 ? desc.substring(0, 80) + '...' : desc;
    document.getElementById('previewPrice').textContent    = price ? (price + ' • Active') : '₦₦ • Moderate';
  }
  updatePreview();

  /* ── File Upload UI helper ────────────────────────────────── */
  function setupFileUpload({ triggerId, inputId, previewImgId, clearBtnId, placeholder, circular }) {
    const trigger    = document.getElementById(triggerId);
    const input      = document.getElementById(inputId);
    const previewImg = document.getElementById(previewImgId);
    const clearBtn   = document.getElementById(clearBtnId);
    const previewCard = document.getElementById('previewImage');

    if (!trigger || !input || !previewImg) return;

    // Click trigger → open file dialog
    trigger.addEventListener('click', () => input.click());
    trigger.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); input.click(); }
    });

    // Drag & drop
    trigger.addEventListener('dragover',  (e) => { e.preventDefault(); trigger.classList.add('dragover'); });
    trigger.addEventListener('dragleave', ()  => trigger.classList.remove('dragover'));
    trigger.addEventListener('drop', (e) => {
      e.preventDefault();
      trigger.classList.remove('dragover');
      const files = e.dataTransfer?.files;
      if (files && files[0]) {
        // Transfer files to the real input via DataTransfer trick
        const dt = new DataTransfer();
        dt.items.add(files[0]);
        input.files = dt.files;
        showPreview(files[0]);
      }
    });

    // File selected
    input.addEventListener('change', () => {
      if (input.files && input.files[0]) showPreview(input.files[0]);
    });

    function showPreview(file) {
      // Basic client-side type guard
      if (!file.type.startsWith('image/')) {
        alert('Please select an image file (JPG, PNG, GIF, or WebP).');
        return;
      }
      if (file.size > 2 * 1024 * 1024) {
        alert('Image is too large. Please choose a file under 2 MB.');
        return;
      }

      const reader = new FileReader();
      reader.onload = (ev) => {
        previewImg.src = ev.target.result;
        previewImg.classList.remove('upload-placeholder-img');
        previewImg.style.objectFit = 'cover';

        // Also update the preview card with cover image
        if (!circular && previewCard) previewCard.src = ev.target.result;

        if (clearBtn) clearBtn.style.display = 'inline-flex';
      };
      reader.readAsDataURL(file);
    }

    // Clear button
    if (clearBtn) {
      clearBtn.addEventListener('click', () => {
        input.value = '';
        previewImg.src = placeholder;
        previewImg.classList.add('upload-placeholder-img');
        previewImg.style.objectFit = 'cover';
        clearBtn.style.display = 'none';

        // Reset preview card if this was the cover
        if (!circular && previewCard) previewCard.src = '/img/placeholder-cover.svg';
      });
    }
  }

  setupFileUpload({
    triggerId:   'logoTrigger',
    inputId:     'logoInput',
    previewImgId:'logoPreviewImg',
    clearBtnId:  'logoClearBtn',
    placeholder: '/img/placeholder-logo.svg',
    circular:    true,
  });

  setupFileUpload({
    triggerId:   'coverTrigger',
    inputId:     'coverInput',
    previewImgId:'coverPreviewImg',
    clearBtnId:  'coverClearBtn',
    placeholder: '/img/placeholder-cover.svg',
    circular:    false,
  });

  /* ── Service icon options ─────────────────────────────────── */
  const iconOptions = [
    { value: 'fa-circle-check',      label: 'Verified / Check' },
    { value: 'fa-wifi',              label: 'Wi-Fi' },
    { value: 'fa-credit-card',       label: 'Card Payment' },
    { value: 'fa-truck-fast',        label: 'Delivery' },
    { value: 'fa-headset',           label: 'Customer Support' },
    { value: 'fa-shield-halved',     label: 'Warranty / Guarantee' },
    { value: 'fa-bolt',              label: 'Express / Fast' },
    { value: 'fa-calendar-check',    label: 'Booking / Appointment' },
    { value: 'fa-chair',             label: 'Seating' },
    { value: 'fa-snowflake',         label: 'Air Conditioning' },
    { value: 'fa-square-parking',    label: 'Parking' },
    { value: 'fa-mug-hot',           label: 'Refreshments' },
    { value: 'fa-door-closed',       label: 'Private Room' },
    { value: 'fa-certificate',       label: 'Certified' },
    { value: 'fa-spray-can-sparkles',label: 'Aromatherapy / Spa' },
    { value: 'fa-bag-shopping',      label: 'Takeaway / Shopping' },
    { value: 'fa-tablet-button',     label: 'Power Outlets' },
    { value: 'fa-globe',             label: 'Online / Web' },
    { value: 'fa-phone',             label: 'Phone Support' },
    { value: 'fa-star',              label: 'Premium' },
  ];

  function buildIconSelect(name, value) {
    const wrap = document.createElement('div');
    wrap.className = 'icon-select-wrap';

    const preview = document.createElement('i');
    preview.className = `fa-solid ${value || 'fa-circle-check'} icon-select-preview`;

    const sel = document.createElement('select');
    sel.name = name;
    iconOptions.forEach(opt => {
      const o = document.createElement('option');
      o.value       = opt.value;
      o.textContent = opt.label;
      if (opt.value === (value || 'fa-circle-check')) o.selected = true;
      sel.appendChild(o);
    });
    sel.addEventListener('change', () => {
      preview.className = `fa-solid ${sel.value} icon-select-preview`;
    });

    wrap.appendChild(preview);
    wrap.appendChild(sel);
    return wrap;
  }

  /* ── Products ─────────────────────────────────────────────── */
  let productIndex = 0;

  function addProductRow(data) {
    data = data || {};
    const idx = productIndex++;
    const row = document.createElement('div');
    row.className = 'dynamic-row';

    const grid = document.createElement('div');
    grid.className = 'row-grid row-grid-2';
    grid.innerHTML = `
      <div>
        <label>Product Name *</label>
        <input type="text" name="products[${idx}][name]"
               value="${escHtml(data.name || '')}"
               placeholder="e.g., Signature Pasta" />
      </div>
      <div>
        <label>Price</label>
        <input type="text" name="products[${idx}][price]"
               value="${escHtml(data.price || '')}"
               placeholder="e.g., ₦2,500" />
      </div>
    `;
    row.appendChild(grid);

    const descWrap = document.createElement('div');
    descWrap.style.marginTop = '.6rem';
    descWrap.innerHTML = `
      <label>Description <span style="font-weight:400;">(optional)</span></label>
      <textarea name="products[${idx}][description]"
                placeholder="Briefly describe this product...">${escHtml(data.description || '')}</textarea>
    `;
    row.appendChild(descWrap);

    const rm = document.createElement('button');
    rm.type = 'button'; rm.className = 'btn-remove-row'; rm.title = 'Remove';
    rm.innerHTML = '<i class="fa-solid fa-xmark"></i>';
    rm.addEventListener('click', () => row.remove());
    row.appendChild(rm);

    document.getElementById('productsContainer').appendChild(row);
  }
  document.getElementById('addProductBtn')?.addEventListener('click', () => addProductRow());

  /* ── Services ─────────────────────────────────────────────── */
  let serviceIndex = 0;

  function addServiceRow(data) {
    data = data || {};
    const idx = serviceIndex++;
    const row = document.createElement('div');
    row.className = 'dynamic-row';

    const grid = document.createElement('div');
    grid.className = 'row-grid row-grid-2';

    const nameDiv = document.createElement('div');
    nameDiv.innerHTML = `
      <label>Service Name *</label>
      <input type="text" name="services[${idx}][name]"
             value="${escHtml(data.name || '')}"
             placeholder="e.g., Free Wi-Fi" />
    `;
    grid.appendChild(nameDiv);

    const iconDiv = document.createElement('div');
    const iconLbl = document.createElement('label');
    iconLbl.textContent = 'Icon';
    iconDiv.appendChild(iconLbl);
    iconDiv.appendChild(buildIconSelect(`services[${idx}][icon]`, data.icon || ''));
    grid.appendChild(iconDiv);

    row.appendChild(grid);

    const descWrap = document.createElement('div');
    descWrap.style.marginTop = '.6rem';
    descWrap.innerHTML = `
      <label>Description <span style="font-weight:400;">(optional)</span></label>
      <textarea name="services[${idx}][description]"
                placeholder="Briefly describe this service...">${escHtml(data.description || '')}</textarea>
    `;
    row.appendChild(descWrap);

    const rm = document.createElement('button');
    rm.type = 'button'; rm.className = 'btn-remove-row'; rm.title = 'Remove';
    rm.innerHTML = '<i class="fa-solid fa-xmark"></i>';
    rm.addEventListener('click', () => row.remove());
    row.appendChild(rm);

    document.getElementById('servicesContainer').appendChild(row);
  }
  document.getElementById('addServiceBtn')?.addEventListener('click', () => addServiceRow());

})();
</script>
<?php $this->endSection(); ?>
