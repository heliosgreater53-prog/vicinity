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
            <div class="directory-header">
              <div class="directory-title-row">
                <h2>Featured Directory</h2>
                <span class="directory-count"><?= !empty($businesses) ? count($businesses) : 6 ?> Businesses Found</span>
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
                        src="<?= e($b->image ?: 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=800&q=80') ?>"
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
                        <span><strong><?= number_format((float) ($b->rating ?? 4.8), 1) ?></strong> (<?= (int) ($b->reviews_count ?? 25) ?> reviews)</span>
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
                <!-- Business Card 1 -->
                <div class="business-card">
                  <div class="card-thumb">
                    <img
                      src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=800&q=80"
                      alt="GreenBite Cafe & Bakery"
                    />
                    <span class="card-badge"><i class="fa-solid fa-utensils"></i> Cafes & Dining</span>
                    <span class="card-status"><i class="fa-solid fa-circle"></i> Open Now</span>
                    <button class="card-save-btn" title="Save Business" aria-label="Save Business">
                      <i class="fa-regular fa-bookmark"></i>
                    </button>
                  </div>
                  <div class="card-body">
                    <h3 class="card-title">
                      <span>GreenBite Cafe & Bakery</span>
                      <i class="fa-solid fa-circle-check verified-badge" title="Verified Local Business"></i>
                    </h3>
                    <div class="card-rating">
                      <i class="fa-solid fa-star"></i>
                      <span><strong>4.9</strong> (64 reviews)</span>
                    </div>
                    <p class="card-location">
                      <i class="fa-solid fa-location-dot"></i>
                      <span>14 Adeniran Ogunsanya, Surulere</span>
                    </p>
                    <p class="card-desc">
                      Artisanal coffees, fresh sourdough bread, healthy pastries,
                      and a peaceful co-working vibe with fast Wi-Fi.
                    </p>
                  </div>
                  <div class="card-footer">
                    <span class="card-price-range">₦₦ • Moderate</span>
                    <a href="/businesses/1" class="btn-view">
                      View Business <i class="fa-solid fa-arrow-right"></i>
                    </a>
                  </div>
                </div>

                <!-- Business Card 2 -->
                <div class="business-card">
                  <div class="card-thumb">
                    <img
                      src="https://images.unsplash.com/photo-1588508065123-287b28e013da?auto=format&fit=crop&w=800&q=80"
                      alt="Surulere TechFix & Gadgets"
                    />
                    <span class="card-badge"><i class="fa-solid fa-laptop-code"></i> Tech & Repairs</span>
                    <span class="card-status"><i class="fa-solid fa-circle"></i> Open Now</span>
                    <button class="card-save-btn" title="Save Business" aria-label="Save Business">
                      <i class="fa-regular fa-bookmark"></i>
                    </button>
                  </div>
                  <div class="card-body">
                    <h3 class="card-title">
                      <span>Surulere TechFix & Gadgets</span>
                      <i class="fa-solid fa-circle-check verified-badge" title="Verified Local Business"></i>
                    </h3>
                    <div class="card-rating">
                      <i class="fa-solid fa-star"></i>
                      <span><strong>4.8</strong> (92 reviews)</span>
                    </div>
                    <p class="card-location">
                      <i class="fa-solid fa-location-dot"></i>
                      <span>52 Bode Thomas Street, Surulere</span>
                    </p>
                    <p class="card-desc">
                      Specialized laptop and smartphone repairs, screen
                      replacements, diagnostic fixes, and certified electronics
                      accessories.
                    </p>
                  </div>
                  <div class="card-footer">
                    <span class="card-price-range">₦₦ • Affordable</span>
                    <a href="/businesses/2" class="btn-view">
                      View Business <i class="fa-solid fa-arrow-right"></i>
                    </a>
                  </div>
                </div>

                <!-- Business Card 3 -->
                <div class="business-card">
                  <div class="card-thumb">
                    <img
                      src="https://images.unsplash.com/photo-1578916171728-46686eac8d58?auto=format&fit=crop&w=800&q=80"
                      alt="Apex Fresh Supermarket"
                    />
                    <span class="card-badge"><i class="fa-solid fa-basket-shopping"></i> Groceries & Retail</span>
                    <span class="card-status"><i class="fa-solid fa-circle"></i> Open Now</span>
                    <button class="card-save-btn" title="Save Business" aria-label="Save Business">
                      <i class="fa-regular fa-bookmark"></i>
                    </button>
                  </div>
                  <div class="card-body">
                    <h3 class="card-title">
                      <span>Apex Fresh Supermarket</span>
                      <i class="fa-solid fa-circle-check verified-badge" title="Verified Local Business"></i>
                    </h3>
                    <div class="card-rating">
                      <i class="fa-solid fa-star"></i>
                      <span><strong>4.7</strong> (110 reviews)</span>
                    </div>
                    <p class="card-location">
                      <i class="fa-solid fa-location-dot"></i>
                      <span>88 Ogunlana Drive, Surulere</span>
                    </p>
                    <p class="card-desc">
                      Farm-fresh local produce, organic food staples, household
                      provisions, and convenient same-day neighborhood deliveries.
                    </p>
                  </div>
                  <div class="card-footer">
                    <span class="card-price-range">₦ • Budget-Friendly</span>
                    <a href="/businesses/3" class="btn-view">
                      View Business <i class="fa-solid fa-arrow-right"></i>
                    </a>
                  </div>
                </div>

                <!-- Business Card 4 -->
                <div class="business-card">
                  <div class="card-thumb">
                    <img
                      src="https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=800&q=80"
                      alt="Royal Touch Spa & Unisex Salon"
                    />
                    <span class="card-badge"><i class="fa-solid fa-spa"></i> Beauty & Wellness</span>
                    <span class="card-status"><i class="fa-solid fa-circle"></i> Open Now</span>
                    <button class="card-save-btn" title="Save Business" aria-label="Save Business">
                      <i class="fa-regular fa-bookmark"></i>
                    </button>
                  </div>
                  <div class="card-body">
                    <h3 class="card-title">
                      <span>Royal Touch Spa & Salon</span>
                      <i class="fa-solid fa-circle-check verified-badge" title="Verified Local Business"></i>
                    </h3>
                    <div class="card-rating">
                      <i class="fa-solid fa-star"></i>
                      <span><strong>4.9</strong> (45 reviews)</span>
                    </div>
                    <p class="card-location">
                      <i class="fa-solid fa-location-dot"></i>
                      <span>22 Akerele Street, Surulere</span>
                    </p>
                    <p class="card-desc">
                      Modern hairstyling, executive beard grooming, revitalizing
                      skin treatments, and deep relaxation massage therapy.
                    </p>
                  </div>
                  <div class="card-footer">
                    <span class="card-price-range">₦₦₦ • Premium</span>
                    <a href="/businesses/4" class="btn-view">
                      View Business <i class="fa-solid fa-arrow-right"></i>
                    </a>
                  </div>
                </div>

                <!-- Business Card 5 -->
                <div class="business-card">
                  <div class="card-thumb">
                    <img
                      src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?auto=format&fit=crop&w=800&q=80"
                      alt="Urban Thread Bespoke Tailors"
                    />
                    <span class="card-badge"><i class="fa-solid fa-shirt"></i> Fashion & Tailoring</span>
                    <span class="card-status"><i class="fa-solid fa-circle"></i> Open Now</span>
                    <button class="card-save-btn" title="Save Business" aria-label="Save Business">
                      <i class="fa-regular fa-bookmark"></i>
                    </button>
                  </div>
                  <div class="card-body">
                    <h3 class="card-title">
                      <span>Urban Thread Bespoke</span>
                      <i class="fa-solid fa-circle-check verified-badge" title="Verified Local Business"></i>
                    </h3>
                    <div class="card-rating">
                      <i class="fa-solid fa-star"></i>
                      <span><strong>4.8</strong> (38 reviews)</span>
                    </div>
                    <p class="card-location">
                      <i class="fa-solid fa-location-dot"></i>
                      <span>19 Shitta Road, Surulere</span>
                    </p>
                    <p class="card-desc">
                      Custom-fit Nigerian traditional outfits, sharp formal suits,
                      premium fabric sourcing, and swift alterations.
                    </p>
                  </div>
                  <div class="card-footer">
                    <span class="card-price-range">₦₦ • Moderate</span>
                    <a href="/businesses/5" class="btn-view">
                      View Business <i class="fa-solid fa-arrow-right"></i>
                    </a>
                  </div>
                </div>

                <!-- Business Card 6 -->
                <div class="business-card">
                  <div class="card-thumb">
                    <img
                      src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=800&q=80"
                      alt="Zenith Fitness & Wellness Hub"
                    />
                    <span class="card-badge"><i class="fa-solid fa-dumbbell"></i> Sports & Fitness</span>
                    <span class="card-status"><i class="fa-solid fa-circle"></i> Open Now</span>
                    <button class="card-save-btn" title="Save Business" aria-label="Save Business">
                      <i class="fa-regular fa-bookmark"></i>
                    </button>
                  </div>
                  <div class="card-body">
                    <h3 class="card-title">
                      <span>Zenith Fitness Hub</span>
                      <i class="fa-solid fa-circle-check verified-badge" title="Verified Local Business"></i>
                    </h3>
                    <div class="card-rating">
                      <i class="fa-solid fa-star"></i>
                      <span><strong>4.6</strong> (53 reviews)</span>
                    </div>
                    <p class="card-location">
                      <i class="fa-solid fa-location-dot"></i>
                      <span>Near National Stadium, Surulere</span>
                    </p>
                    <p class="card-desc">
                      State-of-the-art gym equipment, group spin and HIIT classes,
                      certified personal coaching, and organic smoothie bar.
                    </p>
                  </div>
                  <div class="card-footer">
                    <span class="card-price-range">₦₦ • Subscription</span>
                    <a href="/businesses/6" class="btn-view">
                      View Business <i class="fa-solid fa-arrow-right"></i>
                    </a>
                  </div>
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
