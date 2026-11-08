<?php $this->extend('layouts.main'); ?>

<?php $this->section('container_class'); ?>business-container<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<style>
/* ── Business Detail: Cover & Logo ──────────────────────────────── */
.detail-thumb.biz-cover-wrap {
  position: relative;
  overflow: visible; /* allow logo badge to bleed out */
}
.biz-cover-img {
  width: 100%;
  height: 260px;
  object-fit: cover;
  border-radius: 16px;
  display: block;
}
.biz-cover-placeholder {
  object-fit: contain;
  background: #F0FDF4;
  padding: 1.5rem;
}
.biz-logo-badge {
  position: absolute;
  bottom: -1.5rem;
  left: 1.5rem;
  width: 72px;
  height: 72px;
  border-radius: 50%;
  border: 3px solid #fff;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, .18);
  background: #fff;
  z-index: 2;
}
.biz-logo-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}
.biz-logo-placeholder {
  object-fit: contain;
  padding: 4px;
}
</style>
<?php $this->endSection(); ?>

        <div class="business-content">

          <!-- ── Back Button & Hero ───────────────────────────────────── -->
          <section class="business-hero">
            <a href="/businesses" class="back-link">
              <i class="fa-solid fa-arrow-left"></i> Back to Directory
            </a>
            <span class="hero-tag">
              <i class="fa-solid fa-shop"></i> Local Marketplace
            </span>
            <h1><?= e($business->name) ?></h1>
          </section>

          <!-- ── Business Details ─────────────────────────────────────── -->
          <section class="business-details">

            <!-- Cover Image / Hero Thumbnail -->
            <?php $coverSrc = $business->cover_image ?: $business->image ?: null; ?>
            <?php $logoSrc  = $business->logo ?: null; ?>
            <div class="detail-hero">
              <div class="detail-thumb biz-cover-wrap">
                <!-- Cover: uploaded image or SVG placeholder — never Unsplash -->
                <img
                  src="<?= e($coverSrc ?: '/img/placeholder-cover.svg') ?>"
                  alt="<?= e($business->name) ?>"
                  class="biz-cover-img<?= $coverSrc ? '' : ' biz-cover-placeholder' ?>"
                />
                <span class="detail-badge"><?= e($business->category) ?></span>
                <span class="detail-status">
                  <i class="fa-solid fa-circle"></i> <?= e($business->status ?: 'Open Now') ?>
                </span>

                <!-- Logo: always rendered — uploaded image or SVG placeholder -->
                <div class="biz-logo-badge">
                  <img
                    src="<?= e($logoSrc ?: '/img/placeholder-logo.svg') ?>"
                    alt="<?= e($business->name) ?> logo"
                    class="biz-logo-img<?= $logoSrc ? '' : ' biz-logo-placeholder' ?>"
                  />
                </div>
              </div>

              <div class="detail-info" style="padding-top:1.75rem;">
                <div class="detail-rating">
                  <i class="fa-solid fa-star"></i>
                  <span>
                    <strong><?= number_format((float) ($business->rating ?? 5.0), 1) ?></strong>
                    (<?= (int) ($business->reviews_count ?? 0) ?> reviews)
                  </span>
                </div>
                <p class="detail-location">
                  <i class="fa-solid fa-location-dot"></i> <?= e($business->address) ?>
                </p>
                <?php if (!empty($business->price_range)): ?>
                  <p class="detail-location" style="margin-top:.4rem;">
                    <i class="fa-solid fa-tag"></i> <?= e($business->price_range) ?>
                  </p>
                <?php endif; ?>
                <?php if (!empty($business->opening_hours)): ?>
                  <p class="detail-location" style="margin-top:.4rem;">
                    <i class="fa-regular fa-clock"></i> <?= e($business->opening_hours) ?>
                  </p>
                <?php endif; ?>
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
              <?php if (!empty($business->website)): ?>
                <a href="<?= e($business->website) ?>" target="_blank" rel="noopener noreferrer" class="btn-message">
                  <i class="fa-solid fa-globe"></i> Website
                </a>
              <?php endif; ?>
            </div>

            <!-- About -->
            <?php if (!empty($business->description)): ?>
            <div class="detail-description">
              <h2>About <?= e($business->name) ?></h2>
              <p><?= nl2br(e($business->description)) ?></p>
            </div>
            <?php endif; ?>

            <!-- ── Products & Pricing (only shown when data exists) ──── -->
            <?php if (!empty($products)): ?>
            <div class="detail-section">
              <h2>Products &amp; Pricing</h2>
              <div class="menu-grid">
                <?php foreach ($products as $product): ?>
                  <div class="menu-item">
                    <div style="flex:1;min-width:0;">
                      <span class="menu-name"><?= e($product->name) ?></span>
                      <?php if (!empty($product->description)): ?>
                        <p style="font-size:.8rem;color:var(--text-secondary);margin:.2rem 0 0;line-height:1.4;">
                          <?= e($product->description) ?>
                        </p>
                      <?php endif; ?>
                    </div>
                    <?php if (!empty($product->price)): ?>
                      <span class="menu-price"><?= e($product->price) ?></span>
                    <?php endif; ?>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            <?php endif; ?>

            <!-- ── Services (only shown when data exists) ─────────────── -->
            <?php if (!empty($services)): ?>
            <div class="detail-section">
              <h2>Our Services</h2>
              <div class="services-list">
                <?php foreach ($services as $srv): ?>
                  <div class="service-item">
                    <i class="fa-solid <?= e($srv->icon ?: 'fa-circle-check') ?>"></i>
                    <div style="flex:1;min-width:0;">
                      <span><?= e($srv->name) ?></span>
                      <?php if (!empty($srv->description)): ?>
                        <p style="font-size:.78rem;color:var(--text-secondary);margin:.15rem 0 0;line-height:1.4;">
                          <?= e($srv->description) ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            <?php endif; ?>

            <!-- ── Opening Hours ───────────────────────────────────────── -->
            <?php $hoursSchedule = $business->getHoursSchedule(); ?>
            <?php if (!empty($hoursSchedule)): ?>
            <div class="detail-section">
              <h2>Opening Hours</h2>
              <div class="hours-grid">
                <?php foreach ($hoursSchedule as $sched): ?>
                  <div class="hour-item">
                    <span><?= e($sched['days']) ?></span>
                    <span><?= e($sched['hours']) ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            <?php endif; ?>

            <!-- ── Contact ────────────────────────────────────────────── -->
            <?php $hasContact = !empty($business->phone) || !empty($business->email) || !empty($business->website); ?>
            <?php if ($hasContact): ?>
            <div class="detail-section contact-section">
              <h2>Contact Us</h2>
              <div class="contact-info">
                <?php if (!empty($business->phone)): ?>
                  <div class="contact-item">
                    <i class="fa-solid fa-phone"></i>
                    <a href="tel:<?= e($business->phone) ?>"><?= e($business->phone) ?></a>
                  </div>
                <?php endif; ?>
                <?php if (!empty($business->email)): ?>
                  <div class="contact-item">
                    <i class="fa-solid fa-envelope"></i>
                    <a href="mailto:<?= e($business->email) ?>"><?= e($business->email) ?></a>
                  </div>
                <?php endif; ?>
                <?php if (!empty($business->website)): ?>
                  <div class="contact-item">
                    <i class="fa-solid fa-globe"></i>
                    <a href="<?= e($business->website) ?>" target="_blank" rel="noopener noreferrer">
                      <?= e(preg_replace('#^https?://#', '', $business->website)) ?>
                    </a>
                  </div>
                <?php endif; ?>
              </div>
            </div>
            <?php endif; ?>

          </section>
        </div>

<?php $this->section('scripts'); ?>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const backLink = document.querySelector('.back-link');
    if (backLink) {
      backLink.addEventListener('click', (e) => {
        if (window.history.length > 1) {
          e.preventDefault();
          window.history.back();
        }
      });
    }

    const followBtn = document.querySelector('.btn-follow');
    if (followBtn) {
      followBtn.addEventListener('click', (e) => {
        e.preventDefault();
        const isFollowing = followBtn.classList.toggle('following');
        followBtn.innerHTML = isFollowing
          ? '<i class="fa-solid fa-heart" style="color:#e74c3c;"></i> Following'
          : '<i class="fa-solid fa-heart"></i> Follow';
        followBtn.style.borderColor = isFollowing ? '#e74c3c' : '';
        followBtn.style.color       = isFollowing ? '#e74c3c' : '';
      });
    }

    const messageBtn = document.querySelector('.btn-message');
    if (messageBtn) {
      messageBtn.addEventListener('click', (e) => {
        if (messageBtn.href && messageBtn.href !== '#') return; // let website links pass
        e.preventDefault();
        const messengerToggle = document.getElementById('messengerToggle');
        if (messengerToggle) messengerToggle.click();
      });
    }
  });
</script>
<?php $this->endSection(); ?>
