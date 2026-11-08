<?php $this->extend('layouts.main'); ?>

<?php $this->section('container_class'); ?>business-container<?php $this->endSection(); ?>

        <div class="business-content">
          <!-- Hero Section -->
          <section class="business-hero">
            <span class="hero-tag">
              <i class="fa-solid fa-shop"></i> Local Marketplace
            </span>
            <h1>Discover & Support Local Businesses in Surulere</h1>
            <p>
              Connect with verified neighborhood cafes, trusted artisans, retail
              shops, and essential services right in your vicinity.
            </p>
            <div class="hero-actions">
              <a href="#directory" class="hero-btn">
                <i class="fa-solid fa-compass"></i> Browse Business Directory
              </a>
              <a href="/businesses/create" class="hero-btn hero-btn-secondary">
                <i class="fa-solid fa-plus"></i> List Your Business
              </a>
            </div>
          </section>

          <!-- Directory Section -->
          <section class="business-directory" id="directory">
            <?php if (!empty($dbError)): ?>
              <div style="background:hsl(0,72%,95%);border:1px solid hsl(0,72%,75%);border-radius:10px;padding:1rem 1.25rem;margin-bottom:1.5rem;">
                <p style="color:hsl(0,72%,40%);font-weight:600;margin:0;"><i class="fa-solid fa-triangle-exclamation"></i> Database error: <?= e($dbError) ?></p>
              </div>
            <?php endif; ?>
            <div class="directory-header">
              <div class="directory-title-row">
                <h2>Featured Directory</h2>
                <span class="directory-count"><?= count($businesses) ?> Business<?= count($businesses) !== 1 ? 'es' : '' ?> Found</span>
              </div>
              <div class="directory-filters">
                <button class="filter-pill active">All</button>
                <button class="filter-pill">Cafes & Dining</button>
                <button class="filter-pill">Tech & Repairs</button>
                <button class="filter-pill">Groceries & Retail</button>
                <button class="filter-pill">Beauty & Wellness</button>
                <button class="filter-pill">Fashion & Tailoring</button>
                <button class="filter-pill">Sports & Fitness</button>
              </div>
            </div>

            <!-- Business Cards Grid -->
            <div class="business-grid">
              <?php if (!empty($businesses)): ?>
                <?php foreach ($businesses as $b): ?>
                  <div class="business-card">
                    <div class="card-thumb">
                      <img
                        src="<?= e($b->image ?: '/img/placeholder-cover.svg') ?>"
                        alt="<?= e($b->name) ?>"
                      />
                      <?php
                        $catIcons = [
                          'Cafes & Dining'     => 'fa-utensils',
                          'Tech & Repairs'     => 'fa-laptop-code',
                          'Groceries & Retail' => 'fa-basket-shopping',
                          'Beauty & Wellness'  => 'fa-spa',
                          'Fashion & Tailoring'=> 'fa-scissors',
                          'Sports & Fitness'   => 'fa-dumbbell',
                          'Electronics & Tech' => 'fa-laptop-code',
                          'Food Delivery'      => 'fa-bag-shopping',
                          'Health & Pharmacy'  => 'fa-kit-medical',
                          'Markets & Grocery'  => 'fa-basket-shopping',
                          'Auto Services'      => 'fa-car',
                          'Home & Garden'      => 'fa-house',
                          'Repairs & Services' => 'fa-screwdriver-wrench',
                          'Clothing & Fashion' => 'fa-shirt',
                        ];
                        $catIcon = $catIcons[$b->category] ?? 'fa-shop';
                      ?>
                      <span class="card-badge"><i class="fa-solid <?= $catIcon ?>"></i> <?= e($b->category) ?></span>
                      <span class="card-status"><i class="fa-solid fa-circle"></i> <?= e($b->status ?? 'Open Now') ?></span>
                      <button class="card-save-btn" title="Save Business" aria-label="Save Business">
                        <i class="fa-regular fa-bookmark"></i>
                      </button>
                    </div>
                    <div class="card-body">
                      <h3 class="card-title">
                        <span><?= e($b->name) ?></span>
                        <i class="fa-solid fa-circle-check verified-badge" title="Verified Local Business"></i>
                      </h3>
                      <div class="card-rating">
                        <i class="fa-solid fa-star"></i>
                        <span><strong><?= number_format((float) ($b->rating ?? 5.0), 1) ?></strong> (<?= (int) ($b->reviews_count ?? 0) ?> reviews)</span>
                      </div>
                      <p class="card-location">
                        <i class="fa-solid fa-location-dot"></i>
                        <span><?= e($b->address) ?></span>
                      </p>
                      <p class="card-desc">
                        <?= e($b->description ?? 'Connect with verified local businesses and services right here in your neighborhood.') ?>
                      </p>
                    </div>
                    <div class="card-footer">
                      <span class="card-price-range"><?= e($b->price_range ?? '₦₦ • Moderate') ?></span>
                      <a href="/businesses/<?= (int) $b->id ?>" class="btn-view">
                        View Business <i class="fa-solid fa-arrow-right"></i>
                      </a>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <!-- Empty State -->
                <div style="grid-column:1/-1;text-align:center;padding:4rem 2rem;color:var(--text-muted,#6b7280);">
                  <i class="fa-solid fa-store" style="font-size:3rem;margin-bottom:1rem;opacity:0.4;display:block;"></i>
                  <?php if (!empty($search) || !empty($category)): ?>
                    <h3 style="margin:0 0 .5rem;">No businesses found</h3>
                    <p style="margin:0 0 1.5rem;">Try a different search term or category.</p>
                    <a href="/businesses" style="display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.5rem;background:var(--primary,#16a34a);color:#fff;border-radius:8px;text-decoration:none;font-weight:600;">
                      <i class="fa-solid fa-arrow-left"></i> Clear Filters
                    </a>
                  <?php else: ?>
                    <h3 style="margin:0 0 .5rem;">No businesses listed yet</h3>
                    <p style="margin:0 0 1.5rem;">Be the first to register your local business!</p>
                    <a href="/businesses/create" style="display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.5rem;background:var(--primary,#16a34a);color:#fff;border-radius:8px;text-decoration:none;font-weight:600;">
                      <i class="fa-solid fa-plus"></i> List Your Business
                    </a>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </div>
          </section>
        </div>

<?php $this->section('scripts'); ?>
<script>
  // Directory Category Filter Pills & Search
  document.addEventListener("DOMContentLoaded", function () {
    const pills = document.querySelectorAll(".directory-filters .filter-pill");
    const cards = document.querySelectorAll(".business-grid .business-card");
    const countBadge = document.querySelector(".directory-count");
    const searchInput = document.querySelector(".header-search input");

    function filterDirectory() {
      const activePill = document.querySelector(".directory-filters .filter-pill.active");
      const selectedCategory = activePill ? activePill.textContent.trim().toLowerCase() : "all";
      const query = searchInput ? searchInput.value.trim().toLowerCase() : "";

      let visibleCount = 0;

      cards.forEach((card) => {
        const badge = card.querySelector(".card-badge");
        const title = card.querySelector(".card-title");
        const desc = card.querySelector(".card-desc");
        const location = card.querySelector(".card-location");

        const cardCategory = badge ? badge.textContent.trim().toLowerCase() : "";
        const textContent = `${title?.textContent || ""} ${desc?.textContent || ""} ${location?.textContent || ""}`.toLowerCase();

        const matchesCategory = selectedCategory === "all" || cardCategory.includes(selectedCategory) || selectedCategory.includes(cardCategory);
        const matchesQuery = !query || textContent.includes(query);

        if (matchesCategory && matchesQuery) {
          card.style.display = "";
          visibleCount++;
        } else {
          card.style.display = "none";
        }
      });

      if (countBadge) {
        countBadge.textContent = `${visibleCount} Business${visibleCount === 1 ? "" : "es"} Found`;
      }
    }

    pills.forEach((pill) => {
      pill.addEventListener("click", function () {
        pills.forEach((p) => p.classList.remove("active"));
        pill.classList.add("active");
        filterDirectory();
      });
    });

    if (searchInput) {
      searchInput.addEventListener("input", filterDirectory);
    }
  });
</script>
<?php $this->endSection(); ?>
