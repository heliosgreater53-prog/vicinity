<?php $this->extend('layouts.main'); ?>

<?php $this->section('container_class'); ?>business-container<?php $this->endSection(); ?>

        <div class="business-content">
          <!-- Back Button & Hero -->
          <section class="business-hero">
            <a href="/businesses" class="back-link">
              <i class="fa-solid fa-arrow-left"></i> Back to Directory
            </a>
            <span class="hero-tag">
              <i class="fa-solid fa-shop"></i> Local Marketplace
            </span>
            <h1><?= e($business->name) ?></h1>
          </section>

          <!-- Business Details -->
          <section class="business-details">
            <div class="detail-hero">
              <div class="detail-thumb">
                <img
                  src="<?= e($business->image ?: 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=800&q=80') ?>"
                  alt="<?= e($business->name) ?>"
                />
                <span class="detail-badge"><?= e($business->category) ?></span>
                <span class="detail-status"><i class="fa-solid fa-circle"></i> <?= e($business->status ?: 'Open Now') ?></span>
              </div>
              <div class="detail-info">
                <div class="detail-rating">
                  <i class="fa-solid fa-star"></i>
                  <span><strong><?= number_format((float) ($business->rating ?? 5.0), 1) ?></strong> (<?= (int) ($business->reviews_count ?? 0) ?> reviews)</span>
                </div>
                <p class="detail-location">
                  <i class="fa-solid fa-location-dot"></i> <?= e($business->address) ?>
                </p>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="detail-actions">
              <a href="#" class="btn-follow">
                <i class="fa-solid fa-heart"></i> Follow
              </a>
              <a href="#" class="btn-message">
                <i class="fa-solid fa-message"></i> Message
              </a>
            </div>

            <!-- Business Description -->
            <div class="detail-description">
              <h2>About <?= e($business->name) ?></h2>
              <p>
                <?= nl2br(e($business->description ?: 'Welcome to ' . $business->name . ', proudly serving our local community.')) ?>
              </p>
            </div>

            <!-- Menu / Offerings Section -->
            <div class="detail-section">
              <h2><?= in_array($business->category, ['Cafes & Dining', 'Food Delivery']) ? 'Our Menu' : (in_array($business->category, ['Beauty & Wellness', 'Sports & Fitness', 'Tech & Repairs']) ? 'Services & Pricing' : 'Products & Pricing') ?></h2>
              <div class="menu-grid">
                <?php foreach ($business->getMenuItems() as $item): ?>
                  <div class="menu-item">
                    <span class="menu-name"><?= e($item['name']) ?></span>
                    <span class="menu-price"><?= e($item['price']) ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Services Section -->
            <div class="detail-section">
              <h2>Our Services</h2>
              <div class="services-list">
                <?php foreach ($business->getServicesList() as $srv): ?>
                  <div class="service-item">
                    <i class="fa-solid <?= e($srv['icon']) ?>"></i>
                    <span><?= e($srv['name']) ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Hours Section -->
            <div class="detail-section">
              <h2>Opening Hours</h2>
              <div class="hours-grid">
                <?php foreach ($business->getHoursSchedule() as $sched): ?>
                  <div class="hour-item">
                    <span><?= e($sched['days']) ?></span>
                    <span><?= e($sched['hours']) ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Contact Section -->
            <div class="detail-section contact-section">
              <h2>Contact Us</h2>
              <div class="contact-info">
                <?php if (!empty($business->phone)): ?>
                  <div class="contact-item">
                    <i class="fa-solid fa-phone"></i>
                    <span><?= e($business->phone) ?></span>
                  </div>
                <?php endif; ?>
                <?php if (!empty($business->email)): ?>
                  <div class="contact-item">
                    <i class="fa-solid fa-envelope"></i>
                    <span><?= e($business->email) ?></span>
                  </div>
                <?php endif; ?>
                <?php if (!empty($business->website)): ?>
                  <div class="contact-item">
                    <i class="fa-solid fa-globe"></i>
                    <span><?= e(preg_replace('#^https?://#', '', $business->website)) ?></span>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </section>
        </div>

<?php $this->section('scripts'); ?>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const backLink = document.querySelector(".back-link");
    if (backLink) {
      backLink.addEventListener("click", (e) => {
        if (window.history.length > 1) {
          e.preventDefault();
          window.history.back();
        }
      });
    }

    const followBtn = document.querySelector(".btn-follow");
    if (followBtn) {
      followBtn.addEventListener("click", (e) => {
        e.preventDefault();
        const isFollowing = followBtn.classList.toggle("following");
        if (isFollowing) {
          followBtn.innerHTML = '<i class="fa-solid fa-heart" style="color:#e74c3c;"></i> Following';
          followBtn.style.borderColor = "#e74c3c";
          followBtn.style.color = "#e74c3c";
        } else {
          followBtn.innerHTML = '<i class="fa-solid fa-heart"></i> Follow';
          followBtn.style.borderColor = "";
          followBtn.style.color = "";
        }
      });
    }

    const messageBtn = document.querySelector(".btn-message");
    if (messageBtn) {
      messageBtn.addEventListener("click", (e) => {
        e.preventDefault();
        const messengerToggle = document.getElementById("messengerToggle");
        if (messengerToggle) {
          messengerToggle.click();
        } else {
          alert("Opening direct message with <?= addslashes(e($business->name)) ?>...");
        }
      });
    }
  });
</script>
<?php $this->endSection(); ?>
