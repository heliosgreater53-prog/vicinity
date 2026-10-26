<?php $this->extend('layouts.main'); ?>

<?php $this->section('container_class'); ?>saved-container<?php $this->endSection(); ?>

        <div class="saved-content">

          <!-- Page Header -->
          <div class="saved-page-header">
            <div class="saved-page-title">
              <h1><i class="fa-solid fa-bookmark"></i> Saved Items</h1>
              <p>All your bookmarked posts, businesses, and events in one place.</p>
            </div>
            <span class="saved-total-badge">12 items</span>
          </div>

          <!-- Filter Tabs -->
          <div class="saved-tabs">
            <button class="saved-tab-btn active" data-tab="all" id="tab-btn-all">
              All <span class="saved-tab-count">12</span>
            </button>
            <button class="saved-tab-btn" data-tab="posts" id="tab-btn-posts">
              <i class="fa-solid fa-newspaper"></i> Posts
              <span class="saved-tab-count">5</span>
            </button>
            <button class="saved-tab-btn" data-tab="businesses" id="tab-btn-businesses">
              <i class="fa-solid fa-store"></i> Businesses
              <span class="saved-tab-count">4</span>
            </button>
            <button class="saved-tab-btn" data-tab="events" id="tab-btn-events">
              <i class="fa-solid fa-calendar-days"></i> Events
              <span class="saved-tab-count">3</span>
            </button>
          </div>

          <!-- ─── ALL TAB ─── -->
          <section id="tab-all" class="saved-pane active">

            <!-- Saved Posts -->
            <div class="saved-section-label">
              <i class="fa-solid fa-newspaper"></i> Posts
            </div>

            <div class="saved-list">
              <!-- Saved Post 1 -->
              <div class="saved-item">
                <div class="saved-item-icon post-icon">
                  <i class="fa-solid fa-newspaper"></i>
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <div class="saved-item-author">
                      <div class="saved-mini-avatar" style="background:#36a036;">AC</div>
                      <span class="saved-author-name">Adekunle Charles</span>
                      <span class="saved-item-type-pill notice">Notice</span>
                    </div>
                    <span class="saved-item-time">2 hours ago</span>
                  </div>
                  <p class="saved-item-preview">
                    Community Announcement: There will be routine maintenance on the main water supply pipeline along Ogunlana Drive tomorrow...
                  </p>
                </div>
                <div class="saved-item-actions">
                  <a href="/" class="btn-saved-view">View</a>
                  <button class="btn-unsave" title="Remove bookmark">
                    <i class="fa-solid fa-bookmark"></i>
                  </button>
                </div>
              </div>

              <!-- Saved Post 2 -->
              <div class="saved-item">
                <div class="saved-item-icon post-icon">
                  <i class="fa-solid fa-newspaper"></i>
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <div class="saved-item-author">
                      <div class="saved-mini-avatar" style="background:#2b7a78;">CO</div>
                      <span class="saved-author-name">Chidinma Okoro</span>
                      <span class="saved-item-type-pill business">Local Business</span>
                    </div>
                    <span class="saved-item-time">4 hours ago</span>
                  </div>
                  <p class="saved-item-preview">
                    Just stopped by the newly opened GreenBite Cafe on Adeniran Ogunsanya! Warm ambiance, fast Wi-Fi, and their fresh pastries...
                  </p>
                </div>
                <div class="saved-item-actions">
                  <a href="/" class="btn-saved-view">View</a>
                  <button class="btn-unsave" title="Remove bookmark">
                    <i class="fa-solid fa-bookmark"></i>
                  </button>
                </div>
              </div>

              <!-- Saved Post 3 -->
              <div class="saved-item">
                <div class="saved-item-icon post-icon">
                  <i class="fa-solid fa-newspaper"></i>
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <div class="saved-item-author">
                      <div class="saved-mini-avatar" style="background:#e07a5f;">TB</div>
                      <span class="saved-author-name">Tunde Balogun</span>
                      <span class="saved-item-type-pill event">Event</span>
                    </div>
                    <span class="saved-item-time">6 hours ago</span>
                  </div>
                  <p class="saved-item-preview">
                    ⚽ Surulere Youth Football Tournament kicks off this Saturday at the National Stadium Practice Pitch! Come out...
                  </p>
                </div>
                <div class="saved-item-actions">
                  <a href="/" class="btn-saved-view">View</a>
                  <button class="btn-unsave" title="Remove bookmark">
                    <i class="fa-solid fa-bookmark"></i>
                  </button>
                </div>
              </div>
            </div>

            <!-- Saved Businesses -->
            <div class="saved-section-label" style="margin-top:22px;">
              <i class="fa-solid fa-store"></i> Businesses
            </div>

            <div class="saved-list">
              <!-- Saved Business 1 -->
              <div class="saved-item">
                <div class="saved-item-thumb">
                  <img
                    src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=200&q=80"
                    alt="GreenBite Cafe"
                  />
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <h4 class="saved-item-title">GreenBite Cafe & Bakery</h4>
                    <span class="saved-item-time">Saved 2 days ago</span>
                  </div>
                  <p class="saved-item-preview">14 Adeniran Ogunsanya, Surulere &bull; Cafes & Dining</p>
                  <div class="saved-item-rating">
                    <i class="fa-solid fa-star"></i>
                    <span><strong>4.9</strong> &bull; Open Now</span>
                  </div>
                </div>
                <div class="saved-item-actions">
                  <a href="/businesses/1" class="btn-saved-view">View</a>
                  <button class="btn-unsave" title="Remove bookmark">
                    <i class="fa-solid fa-bookmark"></i>
                  </button>
                </div>
              </div>

              <!-- Saved Business 2 -->
              <div class="saved-item">
                <div class="saved-item-thumb">
                  <img
                    src="https://images.unsplash.com/photo-1588508065123-287b28e013da?auto=format&fit=crop&w=200&q=80"
                    alt="TechFix"
                  />
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <h4 class="saved-item-title">Surulere TechFix & Gadgets</h4>
                    <span class="saved-item-time">Saved 3 days ago</span>
                  </div>
                  <p class="saved-item-preview">52 Bode Thomas Street, Surulere &bull; Tech & Repairs</p>
                  <div class="saved-item-rating">
                    <i class="fa-solid fa-star"></i>
                    <span><strong>4.8</strong> &bull; Open Now</span>
                  </div>
                </div>
                <div class="saved-item-actions">
                  <a href="/businesses/2" class="btn-saved-view">View</a>
                  <button class="btn-unsave" title="Remove bookmark">
                    <i class="fa-solid fa-bookmark"></i>
                  </button>
                </div>
              </div>
            </div>

            <!-- Saved Events -->
            <div class="saved-section-label" style="margin-top:22px;">
              <i class="fa-solid fa-calendar-days"></i> Events
            </div>

            <div class="saved-list">
              <!-- Saved Event 1 -->
              <div class="saved-item">
                <div class="saved-event-date">
                  <span class="sed-day">27</span>
                  <span class="sed-month">Sep</span>
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <h4 class="saved-item-title">Surulere Youth Football Tournament</h4>
                    <span class="saved-item-time">Saved yesterday</span>
                  </div>
                  <p class="saved-item-preview">
                    <i class="fa-regular fa-clock"></i> Sat, 9:00 AM &nbsp;&bull;&nbsp;
                    <i class="fa-solid fa-location-dot"></i> National Stadium Practice Pitch
                  </p>
                  <span class="saved-item-type-pill sports">Sports</span>
                </div>
                <div class="saved-item-actions">
                  <a href="/events" class="btn-saved-view">View</a>
                  <button class="btn-unsave" title="Remove bookmark">
                    <i class="fa-solid fa-bookmark"></i>
                  </button>
                </div>
              </div>

              <!-- Saved Event 2 -->
              <div class="saved-item">
                <div class="saved-event-date">
                  <span class="sed-day">01</span>
                  <span class="sed-month">Oct</span>
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <h4 class="saved-item-title">Nigeria Independence Day Block Party</h4>
                    <span class="saved-item-time">Saved 2 days ago</span>
                  </div>
                  <p class="saved-item-preview">
                    <i class="fa-regular fa-clock"></i> Tue, 4:00 PM &nbsp;&bull;&nbsp;
                    <i class="fa-solid fa-location-dot"></i> Bode Thomas Street Junction
                  </p>
                  <span class="saved-item-type-pill event">Community</span>
                </div>
                <div class="saved-item-actions">
                  <a href="/events" class="btn-saved-view">View</a>
                  <button class="btn-unsave" title="Remove bookmark">
                    <i class="fa-solid fa-bookmark"></i>
                  </button>
                </div>
              </div>
            </div>

          </section>

          <!-- ─── POSTS TAB ─── -->
          <section id="tab-posts" class="saved-pane">
            <div class="saved-list">
              <div class="saved-item">
                <div class="saved-item-icon post-icon">
                  <i class="fa-solid fa-newspaper"></i>
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <div class="saved-item-author">
                      <div class="saved-mini-avatar" style="background:#36a036;">AC</div>
                      <span class="saved-author-name">Adekunle Charles</span>
                      <span class="saved-item-type-pill notice">Notice</span>
                    </div>
                    <span class="saved-item-time">2 hours ago</span>
                  </div>
                  <p class="saved-item-preview">
                    Community Announcement: There will be routine maintenance on the main water supply pipeline along Ogunlana Drive tomorrow...
                  </p>
                </div>
                <div class="saved-item-actions">
                  <a href="/" class="btn-saved-view">View</a>
                  <button class="btn-unsave"><i class="fa-solid fa-bookmark"></i></button>
                </div>
              </div>
              <div class="saved-item">
                <div class="saved-item-icon post-icon">
                  <i class="fa-solid fa-newspaper"></i>
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <div class="saved-item-author">
                      <div class="saved-mini-avatar" style="background:#2b7a78;">CO</div>
                      <span class="saved-author-name">Chidinma Okoro</span>
                      <span class="saved-item-type-pill business">Local Business</span>
                    </div>
                    <span class="saved-item-time">4 hours ago</span>
                  </div>
                  <p class="saved-item-preview">
                    Just stopped by the newly opened GreenBite Cafe on Adeniran Ogunsanya! Warm ambiance, fast Wi-Fi...
                  </p>
                </div>
                <div class="saved-item-actions">
                  <a href="/" class="btn-saved-view">View</a>
                  <button class="btn-unsave"><i class="fa-solid fa-bookmark"></i></button>
                </div>
              </div>
              <div class="saved-item">
                <div class="saved-item-icon post-icon">
                  <i class="fa-solid fa-newspaper"></i>
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <div class="saved-item-author">
                      <div class="saved-mini-avatar" style="background:#e07a5f;">TB</div>
                      <span class="saved-author-name">Tunde Balogun</span>
                      <span class="saved-item-type-pill event">Event</span>
                    </div>
                    <span class="saved-item-time">6 hours ago</span>
                  </div>
                  <p class="saved-item-preview">
                    ⚽ Surulere Youth Football Tournament kicks off this Saturday at the National Stadium Practice Pitch...
                  </p>
                </div>
                <div class="saved-item-actions">
                  <a href="/" class="btn-saved-view">View</a>
                  <button class="btn-unsave"><i class="fa-solid fa-bookmark"></i></button>
                </div>
              </div>
              <div class="saved-item">
                <div class="saved-item-icon post-icon">
                  <i class="fa-solid fa-newspaper"></i>
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <div class="saved-item-author">
                      <div class="saved-mini-avatar" style="background:#6d597a;">FA</div>
                      <span class="saved-author-name">Fatima Al-Hassan</span>
                      <span class="saved-item-type-pill notice">Lost &amp; Found</span>
                    </div>
                    <span class="saved-item-time">Yesterday</span>
                  </div>
                  <p class="saved-item-preview">
                    Found a brown leather wallet with a student ID card near the bus stop outside Leisure Mall...
                  </p>
                </div>
                <div class="saved-item-actions">
                  <a href="/" class="btn-saved-view">View</a>
                  <button class="btn-unsave"><i class="fa-solid fa-bookmark"></i></button>
                </div>
              </div>
              <div class="saved-item">
                <div class="saved-item-icon post-icon">
                  <i class="fa-solid fa-newspaper"></i>
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <div class="saved-item-author">
                      <div class="saved-mini-avatar" style="background:#2b7a78;">BT</div>
                      <span class="saved-author-name">Babatunde Adeleke</span>
                      <span class="saved-item-type-pill business">Security Update</span>
                    </div>
                    <span class="saved-item-time">1 hour ago</span>
                  </div>
                  <p class="saved-item-preview">
                    The new solar streetlights on Alaka-Bode Thomas connector road are now fully operational...
                  </p>
                </div>
                <div class="saved-item-actions">
                  <a href="/community" class="btn-saved-view">View</a>
                  <button class="btn-unsave"><i class="fa-solid fa-bookmark"></i></button>
                </div>
              </div>
            </div>
          </section>

          <!-- ─── BUSINESSES TAB ─── -->
          <section id="tab-businesses" class="saved-pane">
            <div class="saved-list">
              <div class="saved-item">
                <div class="saved-item-thumb">
                  <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=200&q=80" alt="GreenBite" />
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <h4 class="saved-item-title">GreenBite Cafe & Bakery</h4>
                    <span class="saved-item-time">Saved 2 days ago</span>
                  </div>
                  <p class="saved-item-preview">14 Adeniran Ogunsanya, Surulere &bull; Cafes & Dining</p>
                  <div class="saved-item-rating"><i class="fa-solid fa-star"></i><span><strong>4.9</strong> &bull; Open Now</span></div>
                </div>
                <div class="saved-item-actions">
                  <a href="/businesses/1" class="btn-saved-view">View</a>
                  <button class="btn-unsave"><i class="fa-solid fa-bookmark"></i></button>
                </div>
              </div>
              <div class="saved-item">
                <div class="saved-item-thumb">
                  <img src="https://images.unsplash.com/photo-1588508065123-287b28e013da?auto=format&fit=crop&w=200&q=80" alt="TechFix" />
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <h4 class="saved-item-title">Surulere TechFix & Gadgets</h4>
                    <span class="saved-item-time">Saved 3 days ago</span>
                  </div>
                  <p class="saved-item-preview">52 Bode Thomas Street, Surulere &bull; Tech & Repairs</p>
                  <div class="saved-item-rating"><i class="fa-solid fa-star"></i><span><strong>4.8</strong> &bull; Open Now</span></div>
                </div>
                <div class="saved-item-actions">
                  <a href="/businesses/2" class="btn-saved-view">View</a>
                  <button class="btn-unsave"><i class="fa-solid fa-bookmark"></i></button>
                </div>
              </div>
              <div class="saved-item">
                <div class="saved-item-thumb">
                  <img src="https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=200&q=80" alt="Royal Touch" />
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <h4 class="saved-item-title">Royal Touch Spa & Salon</h4>
                    <span class="saved-item-time">Saved 4 days ago</span>
                  </div>
                  <p class="saved-item-preview">22 Akerele Street, Surulere &bull; Beauty & Wellness</p>
                  <div class="saved-item-rating"><i class="fa-solid fa-star"></i><span><strong>4.9</strong> &bull; Open Now</span></div>
                </div>
                <div class="saved-item-actions">
                  <a href="/businesses/4" class="btn-saved-view">View</a>
                  <button class="btn-unsave"><i class="fa-solid fa-bookmark"></i></button>
                </div>
              </div>
              <div class="saved-item">
                <div class="saved-item-thumb">
                  <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=200&q=80" alt="Zenith Fitness" />
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <h4 class="saved-item-title">Zenith Fitness Hub</h4>
                    <span class="saved-item-time">Saved 5 days ago</span>
                  </div>
                  <p class="saved-item-preview">Near National Stadium, Surulere &bull; Sports & Fitness</p>
                  <div class="saved-item-rating"><i class="fa-solid fa-star"></i><span><strong>4.6</strong> &bull; Open Now</span></div>
                </div>
                <div class="saved-item-actions">
                  <a href="/businesses/6" class="btn-saved-view">View</a>
                  <button class="btn-unsave"><i class="fa-solid fa-bookmark"></i></button>
                </div>
              </div>
            </div>
          </section>

          <!-- ─── EVENTS TAB ─── -->
          <section id="tab-events" class="saved-pane">
            <div class="saved-list">
              <div class="saved-item">
                <div class="saved-event-date">
                  <span class="sed-day">27</span>
                  <span class="sed-month">Sep</span>
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <h4 class="saved-item-title">Surulere Youth Football Tournament</h4>
                    <span class="saved-item-time">Saved yesterday</span>
                  </div>
                  <p class="saved-item-preview"><i class="fa-regular fa-clock"></i> Sat, 9:00 AM &nbsp;&bull;&nbsp; <i class="fa-solid fa-location-dot"></i> National Stadium Practice Pitch</p>
                  <span class="saved-item-type-pill sports">Sports</span>
                </div>
                <div class="saved-item-actions">
                  <a href="/events" class="btn-saved-view">View</a>
                  <button class="btn-unsave"><i class="fa-solid fa-bookmark"></i></button>
                </div>
              </div>
              <div class="saved-item">
                <div class="saved-event-date">
                  <span class="sed-day">28</span>
                  <span class="sed-month">Sep</span>
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <h4 class="saved-item-title">Surulere Street Food Festival</h4>
                    <span class="saved-item-time">Saved 2 days ago</span>
                  </div>
                  <p class="saved-item-preview"><i class="fa-regular fa-clock"></i> Sun, 11:00 AM &nbsp;&bull;&nbsp; <i class="fa-solid fa-location-dot"></i> Adeniran Ogunsanya St.</p>
                  <span class="saved-item-type-pill event">Food & Culture</span>
                </div>
                <div class="saved-item-actions">
                  <a href="/events" class="btn-saved-view">View</a>
                  <button class="btn-unsave"><i class="fa-solid fa-bookmark"></i></button>
                </div>
              </div>
              <div class="saved-item">
                <div class="saved-event-date">
                  <span class="sed-day">01</span>
                  <span class="sed-month">Oct</span>
                </div>
                <div class="saved-item-body">
                  <div class="saved-item-top">
                    <h4 class="saved-item-title">Nigeria Independence Day Block Party</h4>
                    <span class="saved-item-time">Saved 2 days ago</span>
                  </div>
                  <p class="saved-item-preview"><i class="fa-regular fa-clock"></i> Tue, 4:00 PM &nbsp;&bull;&nbsp; <i class="fa-solid fa-location-dot"></i> Bode Thomas Street Junction</p>
                  <span class="saved-item-type-pill event">Community</span>
                </div>
                <div class="saved-item-actions">
                  <a href="/events" class="btn-saved-view">View</a>
                  <button class="btn-unsave"><i class="fa-solid fa-bookmark"></i></button>
                </div>
              </div>
            </div>
          </section>

        </div>

<?php $this->section('scripts'); ?>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const tabBtns = document.querySelectorAll(".saved-tab-btn");
    const panes = document.querySelectorAll(".saved-pane");

    tabBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        const target = btn.getAttribute("data-tab");

        tabBtns.forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");

        panes.forEach((p) => {
          p.classList.toggle("active", p.id === `tab-${target}`);
        });
      });
    });

    // Unsave button interaction
    document.querySelectorAll(".btn-unsave").forEach((btn) => {
      btn.addEventListener("click", () => {
        const item = btn.closest(".saved-item");
        if (!item) return;
        item.style.opacity = "0";
        item.style.transform = "translateX(20px)";
        item.style.transition = "0.3s ease";
        setTimeout(() => {
          item.remove();
          const remaining = document.querySelectorAll("#tab-all .saved-item").length;
          const totalBadge = document.querySelector(".saved-total-badge");
          if (totalBadge) totalBadge.textContent = `${remaining} item${remaining === 1 ? "" : "s"}`;
          const allCount = document.querySelector("#tab-btn-all .saved-tab-count");
          if (allCount) allCount.textContent = remaining;
        }, 280);
      });
    });
  });
</script>
<?php $this->endSection(); ?>
