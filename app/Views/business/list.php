<?php $this->extend('layouts.main'); ?>

<?php $this->section('container_class'); ?>business-container<?php $this->endSection(); ?>

        <div class="business-content">
          <!-- List Business Hero -->
          <section class="list-hero">
            <div class="list-hero-content">
              <span class="hero-tag">
                <i class="fa-solid fa-store"></i> Merchant Registration
              </span>
              <h1>List Your Business</h1>
              <p class="list-hero-subtitle">
                Reach neighbors in Surulere, share your services, and grow your customer base with a verified listing.
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

          <!-- Listing Form -->
          <div class="list-form-container">
            <div class="list-form-section">
              <div class="section-header">
                <h2>Business Information</h2>
                <p>Basic details about your business</p>
              </div>

              <form action="/businesses" method="POST" class="list-form" id="businessForm">
                <?= csrf_field() ?>

                <div class="form-row">
                  <div class="form-group">
                    <label for="businessName" class="field-label">Business Name *</label>
                    <div class="field-container">
                      <input type="text" id="businessName" name="name" value="<?= e(old('name')) ?>" placeholder="e.g., GreenBite Cafe" required />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="businessType" class="field-label">Business Type *</label>
                    <div class="field-container">
                      <select id="businessType" name="category" required>
                        <option value="">Select category</option>
                        <option value="Cafes & Dining">Cafes & Dining</option>
                        <option value="Auto Services">Auto Services</option>
                        <option value="Beauty & Wellness">Beauty & Wellness</option>
                        <option value="Clothing & Fashion">Clothing & Fashion</option>
                        <option value="Electronics & Tech">Electronics & Tech</option>
                        <option value="Food Delivery">Food Delivery</option>
                        <option value="Health & Pharmacy">Health & Pharmacy</option>
                        <option value="Home & Garden">Home & Garden</option>
                        <option value="Markets & Grocery">Markets & Grocery</option>
                        <option value="Repairs & Services">Repairs & Services</option>
                        <option value="Other">Other</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="description" class="field-label">Business Description *</label>
                  <div class="field-container textarea-container">
                    <textarea id="description" name="description" rows="4" placeholder="Tell your neighbors about your business..." required><?= e(old('description')) ?></textarea>
                  </div>
                  <p class="field-hint">Describe what makes your business special (max 300 characters)</p>
                </div>

                <div class="form-row">
                  <div class="form-group">
                    <label for="address" class="field-label">Address *</label>
                    <div class="field-container">
                      <input type="text" id="address" name="address" value="<?= e(old('address')) ?>" placeholder="Street address, area" required />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="hours" class="field-label">Hours</label>
                    <div class="field-container">
                      <input type="text" id="hours" name="opening_hours" value="<?= e(old('opening_hours')) ?>" placeholder="e.g., 8AM - 8PM" />
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group">
                    <label for="phone" class="field-label">Phone Number</label>
                    <div class="field-container">
                      <input type="tel" id="phone" name="phone" value="<?= e(old('phone')) ?>" placeholder="+234 80x xxx xxxx" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email" class="field-label">Email</label>
                    <div class="field-container">
                      <input type="email" id="email" name="email" value="<?= e(old('email')) ?>" placeholder="info@you.com" />
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="website" class="field-label">Website / Social Media</label>
                  <div class="field-container">
                    <input type="url" id="website" name="website" value="<?= e(old('website')) ?>" placeholder="https://..." />
                  </div>
                </div>

                <div class="form-group">
                  <label for="priceRange" class="field-label">Price Range</label>
                  <div class="field-container price-selector">
                    <select id="priceRange" name="price_range">
                      <option value="">Select range</option>
                      <option value="₦">₦ - Budget</option>
                      <option value="₦₦">₦₦ - Moderate</option>
                      <option value="₦₦₦">₦₦₦ - Premium</option>
                      <option value="₦₦₦₦">₦₦₦₦ - Luxury</option>
                    </select>
                  </div>
                </div>

                <div class="form-actions">
                  <a href="/businesses" class="btn-secondary">Cancel</a>
                  <button type="submit" class="btn-primary">Publish Listing</button>
                </div>
              </form>
            </div>
          </div>

          <!-- Preview Section (live preview synced with form) -->
          <div class="preview-section" id="previewSection">
            <h2 class="preview-title">Preview</h2>
            <div class="business-card preview-card" id="previewCard">
              <div class="cardThumb">
                <img id="previewImage" src="https://images.unsplash.com/photo-1504674900247-0877f964ce7d?auto=format&fit=crop&w=800&q=80" alt="Business preview" />
                <span class="cardBadge" id="previewBadge">Cafe &amp; Dining</span>
                <span class="cardStatus"><i class="fa-solid fa-circle"></i> Open Now</span>
              </div>
              <div class="cardBody">
                <h3 class="cardTitle" id="previewTitle">Your Business Name</h3>
                <div class="cardRating">
                  <i class="fa-solid fa-star"></i>
                  <span><strong id="previewRating">4.8</strong> (0 reviews)</span>
                </div>
                <p class="cardLocation">
                  <i class="fa-solid fa-location-dot"></i> <span id="previewLocation">Your Address</span>
                </p>
                <p class="cardDesc" id="previewDesc">
                  Your business description will appear here.
                </p>
              </div>
              <div class="cardFooter">
                <span class="cardPriceRange" id="previewPrice">₦₦ • Moderate</span>
                <a href="#" class="btnView">View Listing</a>
              </div>
            </div>
          </div>
        </div>

<?php $this->section('scripts'); ?>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("businessForm");
    const previewSection = document.getElementById("previewSection");

    form.addEventListener("input", updatePreview);
    form.addEventListener("change", updatePreview);

    function updatePreview() {
      const name = document.getElementById("businessName").value || "Your Business Name";
      const type = document.getElementById("businessType").value;
      const address = document.getElementById("address").value || "Your Address";
      const price = document.getElementById("priceRange").value;
      const desc = document.getElementById("description").value || "Your business description will appear here.";

      document.getElementById("previewTitle").textContent = name;
      document.getElementById("previewBadge").textContent = type || "Business";
      document.getElementById("previewLocation").textContent = address;
      document.getElementById("previewDesc").textContent = desc.length > 80 ? desc.substring(0, 80) + "..." : desc;
      document.getElementById("previewPrice").textContent = price ? (price + " • Active") : "₦₦ • Moderate";
    }

    // Initialize preview
    updatePreview();
  });
</script>
<?php $this->endSection(); ?>
