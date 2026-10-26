<?php $this->extend('layouts.main'); ?>

<?php $this->section('container_class'); ?>events-container<?php $this->endSection(); ?>

        <div class="events-content">

          <!-- Hero Section -->
          <section class="events-hero">
            <div class="events-hero-left">
              <span class="hero-tag">
                <i class="fa-solid fa-calendar-star"></i> Community Events
              </span>
              <h1>What's Happening Around You</h1>
              <p>
                Discover local meetups, markets, sports days, and neighbourhood
                gatherings happening right here in Surulere.
              </p>
              <a href="/events/create" class="hero-btn">
                <i class="fa-solid fa-plus"></i> Create an Event
              </a>
            </div>
            <div class="events-hero-right">
              <div class="events-hero-stat">
                <span class="stat-num"><?= !empty($events) ? count($events) : '24' ?></span>
                <span class="stat-label">Upcoming Events</span>
              </div>
              <div class="events-hero-divider"></div>
              <div class="events-hero-stat">
                <span class="stat-num">8</span>
                <span class="stat-label">This Weekend</span>
              </div>
              <div class="events-hero-divider"></div>
              <div class="events-hero-stat">
                <span class="stat-num">142</span>
                <span class="stat-label">Community Members Going</span>
              </div>
            </div>
          </section>

          <!-- Tab Navigation -->
          <div class="events-tabs">
            <button class="events-tab-btn active" data-tab="upcoming">
              <i class="fa-solid fa-clock"></i> Upcoming Events
            </button>
            <button class="events-tab-btn" data-tab="all">
              <i class="fa-solid fa-calendar-days"></i> All Events
            </button>
          </div>

          <!-- ─── TAB 1: UPCOMING EVENTS ─── -->
          <section id="tab-upcoming" class="events-pane active">

            <!-- This Weekend highlight -->
            <div class="events-section-label">
              <i class="fa-solid fa-fire"></i> This Weekend
            </div>
            <div class="events-featured-grid">

              <?php if (!empty($events)): ?>
                <?php foreach ($events as $index => $e): ?>
                  <div class="event-card featured">
                    <div class="event-card-thumb">
                      <img
                        src="<?= e($e->banner ?: ($index % 2 === 0 ? 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=800&q=80' : 'https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&w=800&q=80')) ?>"
                        alt="<?= e($e->title) ?>"
                      />
                      <span class="event-date-badge">
                        <span class="badge-day"><?= !empty($e->event_date) ? date('d', strtotime($e->event_date)) : '27' ?></span>
                        <span class="badge-month"><?= !empty($e->event_date) ? date('M', strtotime($e->event_date)) : 'Sep' ?></span>
                      </span>
                      <span class="event-category-badge"><?= e($e->category ?? 'Sports') ?></span>
                    </div>
                    <div class="event-card-body">
                      <h3 class="event-title"><?= e($e->title) ?></h3>
                      <div class="event-meta-row">
                        <span><i class="fa-regular fa-clock"></i> <?= e($e->event_time ?? '9:00 AM') ?></span>
                        <span><i class="fa-solid fa-location-dot"></i> <?= e($e->location ?? 'Surulere, Lagos') ?></span>
                      </div>
                      <p class="event-desc">
                        <?= e($e->description ?? 'Join your neighbors for this community event.') ?>
                      </p>
                      <div class="event-footer">
                        <div class="event-attendees">
                          <div class="attendee-avatars">
                            <span class="attendee-dot" style="background:#36a036;"></span>
                            <span class="attendee-dot" style="background:#2b7a78;"></span>
                            <span class="attendee-dot" style="background:#e07a5f;"></span>
                          </div>
                          <span class="attendee-count">+<?= (int) ($e->attendees_count ?? 38) ?> going</span>
                        </div>
                        <button class="btn-attend">RSVP <i class="fa-solid fa-arrow-right"></i></button>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <!-- Featured Card 1 -->
                <div class="event-card featured">
                  <div class="event-card-thumb">
                    <img
                      src="https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=800&q=80"
                      alt="Youth Football Tournament"
                    />
                    <span class="event-date-badge">
                      <span class="badge-day">27</span>
                      <span class="badge-month">Sep</span>
                    </span>
                    <span class="event-category-badge">Sports</span>
                  </div>
                  <div class="event-card-body">
                    <h3 class="event-title">Surulere Youth Football Tournament</h3>
                    <div class="event-meta-row">
                      <span><i class="fa-regular fa-clock"></i> Sat, 9:00 AM</span>
                      <span><i class="fa-solid fa-location-dot"></i> National Stadium Practice Pitch</span>
                    </div>
                    <p class="event-desc">
                      Local street teams battle it out in a day-long friendly tournament.
                      Free entry, refreshments available, all ages welcome!
                    </p>
                    <div class="event-footer">
                      <div class="event-attendees">
                        <div class="attendee-avatars">
                          <span class="attendee-dot" style="background:#36a036;"></span>
                          <span class="attendee-dot" style="background:#2b7a78;"></span>
                          <span class="attendee-dot" style="background:#e07a5f;"></span>
                        </div>
                        <span class="attendee-count">+38 going</span>
                      </div>
                      <button class="btn-attend">RSVP <i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                  </div>
                </div>

                <!-- Featured Card 2 -->
                <div class="event-card featured">
                  <div class="event-card-thumb">
                    <img
                      src="https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&w=800&q=80"
                      alt="Surulere Food Festival"
                    />
                    <span class="event-date-badge">
                      <span class="badge-day">28</span>
                      <span class="badge-month">Sep</span>
                    </span>
                    <span class="event-category-badge">Food & Culture</span>
                  </div>
                  <div class="event-card-body">
                    <h3 class="event-title">Surulere Street Food Festival</h3>
                    <div class="event-meta-row">
                      <span><i class="fa-regular fa-clock"></i> Sun, 11:00 AM – 7:00 PM</span>
                      <span><i class="fa-solid fa-location-dot"></i> Adeniran Ogunsanya St.</span>
                    </div>
                    <p class="event-desc">
                      Sample jollof rice, suya, puff-puff, and dozens of local dishes from
                      over 30 neighbourhood vendors. Live Afrobeats music all day.
                    </p>
                    <div class="event-footer">
                      <div class="event-attendees">
                        <div class="attendee-avatars">
                          <span class="attendee-dot" style="background:#6d597a;"></span>
                          <span class="attendee-dot" style="background:#36a036;"></span>
                          <span class="attendee-dot" style="background:#e27d60;"></span>
                        </div>
                        <span class="attendee-count">+91 going</span>
                      </div>
                      <button class="btn-attend">RSVP <i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                  </div>
                </div>
              <?php endif; ?>

            </div>

            <!-- Next 7 Days -->
            <div class="events-section-label" style="margin-top:25px;">
              <i class="fa-solid fa-calendar-week"></i> Next 7 Days
            </div>
            <div class="events-list">

              <!-- Compact Event 1 -->
              <div class="event-list-item">
                <div class="event-list-date">
                  <span class="list-day">30</span>
                  <span class="list-month">Sep</span>
                </div>
                <div class="event-list-info">
                  <h4>Community Tree Planting Drive</h4>
                  <div class="event-list-meta">
                    <span><i class="fa-regular fa-clock"></i> Mon, 7:00 AM – 10:00 AM</span>
                    <span><i class="fa-solid fa-location-dot"></i> Alaka Estate Open Ground</span>
                  </div>
                  <span class="event-list-tag">Environment</span>
                </div>
                <div class="event-list-action">
                  <span class="event-list-going">12 going</span>
                  <button class="btn-attend-sm">RSVP</button>
                </div>
              </div>

              <!-- Compact Event 2 -->
              <div class="event-list-item">
                <div class="event-list-date">
                  <span class="list-day">01</span>
                  <span class="list-month">Oct</span>
                </div>
                <div class="event-list-info">
                  <h4>Nigeria Independence Day Block Party</h4>
                  <div class="event-list-meta">
                    <span><i class="fa-regular fa-clock"></i> Tue, 4:00 PM – 10:00 PM</span>
                    <span><i class="fa-solid fa-location-dot"></i> Bode Thomas Street Junction</span>
                  </div>
                  <span class="event-list-tag">Community</span>
                </div>
                <div class="event-list-action">
                  <span class="event-list-going">54 going</span>
                  <button class="btn-attend-sm">RSVP</button>
                </div>
              </div>

              <!-- Compact Event 3 -->
              <div class="event-list-item">
                <div class="event-list-date">
                  <span class="list-day">02</span>
                  <span class="list-month">Oct</span>
                </div>
                <div class="event-list-info">
                  <h4>Tech Skills Workshop for Youth</h4>
                  <div class="event-list-meta">
                    <span><i class="fa-regular fa-clock"></i> Wed, 10:00 AM – 2:00 PM</span>
                    <span><i class="fa-solid fa-location-dot"></i> GreenBite Cafe, Adeniran Ogunsanya</span>
                  </div>
                  <span class="event-list-tag">Education</span>
                </div>
                <div class="event-list-action">
                  <span class="event-list-going">31 going</span>
                  <button class="btn-attend-sm">RSVP</button>
                </div>
              </div>

            </div>
          </section>

          <!-- ─── TAB 2: ALL EVENTS (grouped by date) ─── -->
          <section id="tab-all" class="events-pane">

            <!-- Date Group: September 27 -->
            <div class="date-group">
              <div class="date-group-label">
                <span class="dg-day">Saturday, 27 September 2026</span>
              </div>
              <div class="events-list">
                <div class="event-list-item">
                  <div class="event-list-date">
                    <span class="list-day">27</span>
                    <span class="list-month">Sep</span>
                  </div>
                  <div class="event-list-info">
                    <h4>Surulere Youth Football Tournament</h4>
                    <div class="event-list-meta">
                      <span><i class="fa-regular fa-clock"></i> 9:00 AM – 6:00 PM</span>
                      <span><i class="fa-solid fa-location-dot"></i> National Stadium Practice Pitch</span>
                    </div>
                    <span class="event-list-tag">Sports</span>
                  </div>
                  <div class="event-list-action">
                    <span class="event-list-going">38 going</span>
                    <button class="btn-attend-sm">RSVP</button>
                  </div>
                </div>
                <div class="event-list-item">
                  <div class="event-list-date">
                    <span class="list-day">27</span>
                    <span class="list-month">Sep</span>
                  </div>
                  <div class="event-list-info">
                    <h4>Neighbourhood Watch Briefing</h4>
                    <div class="event-list-meta">
                      <span><i class="fa-regular fa-clock"></i> 5:00 PM – 6:30 PM</span>
                      <span><i class="fa-solid fa-location-dot"></i> Surulere Town Hall</span>
                    </div>
                    <span class="event-list-tag">Security</span>
                  </div>
                  <div class="event-list-action">
                    <span class="event-list-going">19 going</span>
                    <button class="btn-attend-sm">RSVP</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Date Group: September 28 -->
            <div class="date-group">
              <div class="date-group-label">
                <span class="dg-day">Sunday, 28 September 2026</span>
              </div>
              <div class="events-list">
                <div class="event-list-item">
                  <div class="event-list-date">
                    <span class="list-day">28</span>
                    <span class="list-month">Sep</span>
                  </div>
                  <div class="event-list-info">
                    <h4>Surulere Street Food Festival</h4>
                    <div class="event-list-meta">
                      <span><i class="fa-regular fa-clock"></i> 11:00 AM – 7:00 PM</span>
                      <span><i class="fa-solid fa-location-dot"></i> Adeniran Ogunsanya St.</span>
                    </div>
                    <span class="event-list-tag">Food & Culture</span>
                  </div>
                  <div class="event-list-action">
                    <span class="event-list-going">91 going</span>
                    <button class="btn-attend-sm">RSVP</button>
                  </div>
                </div>
                <div class="event-list-item">
                  <div class="event-list-date">
                    <span class="list-day">28</span>
                    <span class="list-month">Sep</span>
                  </div>
                  <div class="event-list-info">
                    <h4>Sunday Morning Yoga in the Park</h4>
                    <div class="event-list-meta">
                      <span><i class="fa-regular fa-clock"></i> 7:00 AM – 8:30 AM</span>
                      <span><i class="fa-solid fa-location-dot"></i> Randle Avenue Park</span>
                    </div>
                    <span class="event-list-tag">Health & Fitness</span>
                  </div>
                  <div class="event-list-action">
                    <span class="event-list-going">22 going</span>
                    <button class="btn-attend-sm">RSVP</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Date Group: September 30 -->
            <div class="date-group">
              <div class="date-group-label">
                <span class="dg-day">Monday, 30 September 2026</span>
              </div>
              <div class="events-list">
                <div class="event-list-item">
                  <div class="event-list-date">
                    <span class="list-day">30</span>
                    <span class="list-month">Sep</span>
                  </div>
                  <div class="event-list-info">
                    <h4>Community Tree Planting Drive</h4>
                    <div class="event-list-meta">
                      <span><i class="fa-regular fa-clock"></i> 7:00 AM – 10:00 AM</span>
                      <span><i class="fa-solid fa-location-dot"></i> Alaka Estate Open Ground</span>
                    </div>
                    <span class="event-list-tag">Environment</span>
                  </div>
                  <div class="event-list-action">
                    <span class="event-list-going">12 going</span>
                    <button class="btn-attend-sm">RSVP</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Date Group: October 1 -->
            <div class="date-group">
              <div class="date-group-label">
                <span class="dg-day">Tuesday, 1 October 2026</span>
                <span class="dg-badge">Independence Day 🇳🇬</span>
              </div>
              <div class="events-list">
                <div class="event-list-item">
                  <div class="event-list-date">
                    <span class="list-day">01</span>
                    <span class="list-month">Oct</span>
                  </div>
                  <div class="event-list-info">
                    <h4>Nigeria Independence Day Block Party</h4>
                    <div class="event-list-meta">
                      <span><i class="fa-regular fa-clock"></i> 4:00 PM – 10:00 PM</span>
                      <span><i class="fa-solid fa-location-dot"></i> Bode Thomas Street Junction</span>
                    </div>
                    <span class="event-list-tag">Community</span>
                  </div>
                  <div class="event-list-action">
                    <span class="event-list-going">54 going</span>
                    <button class="btn-attend-sm">RSVP</button>
                  </div>
                </div>
                <div class="event-list-item">
                  <div class="event-list-date">
                    <span class="list-day">01</span>
                    <span class="list-month">Oct</span>
                  </div>
                  <div class="event-list-info">
                    <h4>Independence Day 5K Fun Run</h4>
                    <div class="event-list-meta">
                      <span><i class="fa-regular fa-clock"></i> 6:30 AM – 9:00 AM</span>
                      <span><i class="fa-solid fa-location-dot"></i> National Stadium, Surulere</span>
                    </div>
                    <span class="event-list-tag">Sports</span>
                  </div>
                  <div class="event-list-action">
                    <span class="event-list-going">47 going</span>
                    <button class="btn-attend-sm">RSVP</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Date Group: October 2 -->
            <div class="date-group">
              <div class="date-group-label">
                <span class="dg-day">Wednesday, 2 October 2026</span>
              </div>
              <div class="events-list">
                <div class="event-list-item">
                  <div class="event-list-date">
                    <span class="list-day">02</span>
                    <span class="list-month">Oct</span>
                  </div>
                  <div class="event-list-info">
                    <h4>Tech Skills Workshop for Youth</h4>
                    <div class="event-list-meta">
                      <span><i class="fa-regular fa-clock"></i> 10:00 AM – 2:00 PM</span>
                      <span><i class="fa-solid fa-location-dot"></i> GreenBite Cafe, Adeniran Ogunsanya</span>
                    </div>
                    <span class="event-list-tag">Education</span>
                  </div>
                  <div class="event-list-action">
                    <span class="event-list-going">31 going</span>
                    <button class="btn-attend-sm">RSVP</button>
                  </div>
                </div>
              </div>
            </div>

          </section>

        </div>

<?php $this->section('scripts'); ?>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const tabBtns = document.querySelectorAll(".events-tab-btn");
    const panes = document.querySelectorAll(".events-pane");

    tabBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        const target = btn.getAttribute("data-tab");

        tabBtns.forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");

        panes.forEach((p) => {
          if (p.id === `tab-${target}`) {
            p.classList.add("active");
          } else {
            p.classList.remove("active");
          }
        });
      });
    });

    // RSVP Buttons toggle
    document.querySelectorAll(".btn-attend, .btn-attend-sm").forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.preventDefault();
        const isAttending = btn.classList.toggle("attending");
        const parent = btn.closest(".event-card, .event-list-item");
        const countEl = parent ? parent.querySelector(".attendee-count, .event-list-going") : null;

        if (isAttending) {
          btn.innerHTML = '<i class="fa-solid fa-check"></i> Going';
          btn.style.background = "var(--accent)";
          btn.style.color = "#fff";
          if (countEl) {
            const match = countEl.textContent.match(/\d+/);
            if (match) {
              const num = parseInt(match[0]) + 1;
              countEl.textContent = `${num} going`;
            }
          }
        } else {
          btn.innerHTML = 'RSVP';
          btn.style.background = "";
          btn.style.color = "";
          if (countEl) {
            const match = countEl.textContent.match(/\d+/);
            if (match) {
              const num = Math.max(0, parseInt(match[0]) - 1);
              countEl.textContent = `${num} going`;
            }
          }
        }
      });
    });
  });
</script>
<?php $this->endSection(); ?>
