<?php $this->extend('layouts.main'); ?>

<?php $this->section('container_class'); ?>events-container<?php $this->endSection(); ?>

        <div class="events-content">
          <!-- Create Event Hero -->
          <section class="create-hero">
            <div class="create-hero-content">
              <span class="hero-tag">
                <i class="fa-solid fa-calendar-days"></i> Community Gathering
              </span>
              <h1>Create a New Event</h1>
              <p class="create-hero-subtitle">
                Bring your community together for meetups, markets, workshops, and more.
              </p>
            </div>
            <div class="create-hero-icon">
              <i class="fa-solid fa-calendar-plus"></i>
            </div>
          </section>

          <!-- Breadcrumbs -->
          <nav class="create-breadcrumbs" aria-label="Breadcrumb">
            <a href="/events">Events</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="#">Create Event</a>
          </nav>

          <!-- Create Event Form -->
          <div class="create-form-container">
            <form action="/events" method="POST" class="create-form" id="eventForm" enctype="multipart/form-data">
              <?= csrf_field() ?>

              <div class="form-section">
                <h3 class="section-title">Event Details</h3>

                <div class="form-row">
                  <div class="form-group">
                    <label for="eventTitle" class="field-label">Event Title *</label>
                    <div class="field-container">
                      <input type="text" id="eventTitle" name="title" value="<?= e(old('title')) ?>" placeholder="e.g., Surulere Street Food Festival" required />
                    </div>
                    <p class="field-hint">Catchy, descriptive title (max 80 characters)</p>
                  </div>
                  <div class="form-group">
                    <label for="eventCategory" class="field-label">Category *</label>
                    <div class="field-container">
                      <select id="eventCategory" name="category" required>
                        <option value="">Select category</option>
                        <option value="community">Community & Social</option>
                        <option value="sports">Sports & Fitness</option>
                        <option value="food">Food & Drink</option>
                        <option value="music">Music & Entertainment</option>
                        <option value="arts">Arts & Culture</option>
                        <option value="education">Education & Workshops</option>
                        <option value="business">Business & Networking</option>
                        <option value="health">Health & Wellness</option>
                        <option value="charity">Charity & Volunteering</option>
                        <option value="family">Family & Kids</option>
                        <option value="tech">Technology</option>
                        <option value="other">Other</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="eventDescription" class="field-label">Description *</label>
                  <div class="field-container textarea-container">
                    <textarea id="eventDescription" name="description" rows="4" placeholder="What's happening? Add details about activities, schedule, what to bring, etc." required><?= e(old('description')) ?></textarea>
                  </div>
                  <p class="field-hint">Describe the event so neighbors know what to expect (max 1000 characters)</p>
                </div>

                <div class="form-row">
                  <div class="form-group">
                    <label for="eventDate" class="field-label">Date *</label>
                    <div class="field-container">
                      <input type="date" id="eventDate" name="event_date" value="<?= e(old('event_date')) ?>" required />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="eventTime" class="field-label">Time *</label>
                    <div class="field-container">
                      <input type="time" id="eventTime" name="event_time" value="<?= e(old('event_time')) ?>" required />
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group">
                    <label for="eventEndDate" class="field-label">End Date (optional)</label>
                    <div class="field-container">
                      <input type="date" id="eventEndDate" name="end_date" value="<?= e(old('end_date')) ?>" />
                    </div>
                    <p class="field-hint">For multi-day events</p>
                  </div>
                  <div class="form-group">
                    <label for="eventEndTime" class="field-label">End Time (optional)</label>
                    <div class="field-container">
                      <input type="time" id="eventEndTime" name="end_time" value="<?= e(old('end_time')) ?>" />
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-section">
                <h3 class="section-title">Location & Venue</h3>

                <div class="form-group">
                  <label for="eventVenue" class="field-label">Venue Name *</label>
                  <div class="field-container">
                    <input type="text" id="eventVenue" name="venue" value="<?= e(old('venue')) ?>" placeholder="e.g., National Stadium Practice Pitch" required />
                  </div>
                </div>

                <div class="form-group">
                  <label for="eventAddress" class="field-label">Address *</label>
                  <div class="field-container">
                    <input type="text" id="eventAddress" name="location" value="<?= e(old('location')) ?>" placeholder="Street address, area, city" required />
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group">
                    <label for="eventIsOnline" class="field-label">Online Event</label>
                    <div class="field-container">
                      <select id="eventIsOnline" name="is_online">
                        <option value="no">In-person</option>
                        <option value="yes">Online / Virtual</option>
                        <option value="hybrid">Hybrid (both)</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="eventOnlineLink" class="field-label">Online Link</label>
                    <div class="field-container">
                      <input type="url" id="eventOnlineLink" name="online_link" value="<?= e(old('online_link')) ?>" placeholder="https://meet.example.com/..." />
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-section">
                <h3 class="section-title">Event Settings</h3>

                <div class="setting-group">
                  <div class="setting-info">
                    <h4>RSVP Required</h4>
                    <p>Let attendees confirm their attendance</p>
                  </div>
                  <div class="setting-control">
                    <label class="checkbox-option">
                      <input type="checkbox" name="rsvpRequired" value="1" checked />
                      <span class="checkbox-custom"></span>
                      <span>Require RSVP</span>
                    </label>
                  </div>
                </div>

                <div class="setting-group">
                  <div class="setting-info">
                    <h4>Max Attendees (optional)</h4>
                    <p>Limit capacity for the venue</p>
                  </div>
                  <div class="setting-control">
                    <div class="field-container" style="max-width: 200px;">
                      <input type="number" id="maxAttendees" name="max_attendees" value="<?= e(old('max_attendees')) ?>" placeholder="e.g., 100" min="1" />
                    </div>
                  </div>
                </div>

                <div class="setting-group">
                  <div class="setting-info">
                    <h4>Cost</h4>
                    <p>Is this a free or paid event?</p>
                  </div>
                  <div class="setting-control">
                    <label class="radio-option">
                      <input type="radio" name="eventCost" value="free" checked />
                      <span class="radio-custom"></span>
                      <span>Free</span>
                    </label>
                    <label class="radio-option">
                      <input type="radio" name="eventCost" value="paid" />
                      <span class="radio-custom"></span>
                      <span>Paid</span>
                    </label>
                    <label class="radio-option">
                      <input type="radio" name="eventCost" value="donation" />
                      <span class="radio-custom"></span>
                      <span>Donation-based</span>
                    </label>
                  </div>
                </div>

                <div class="setting-group" id="costAmountGroup" style="display: none;">
                  <div class="setting-info">
                    <h4>Amount (₦)</h4>
                    <p>Price per person</p>
                  </div>
                  <div class="setting-control">
                    <div class="field-container" style="max-width: 200px;">
                      <input type="number" id="costAmount" name="cost_amount" value="<?= e(old('cost_amount')) ?>" placeholder="e.g., 5000" min="0" step="100" />
                    </div>
                  </div>
                </div>

                <div class="setting-group">
                  <div class="setting-info">
                    <h4>Event Visibility</h4>
                    <p>Show in public listings and search</p>
                  </div>
                  <div class="setting-control">
                    <label class="checkbox-option">
                      <input type="checkbox" name="eventVisibility" value="1" checked />
                      <span class="checkbox-custom"></span>
                      <span>Make event discoverable</span>
                    </label>
                  </div>
                </div>

                <div class="setting-group">
                  <div class="setting-info">
                    <h4>Recurring Event</h4>
                    <p>Make this a repeating event</p>
                  </div>
                  <div class="setting-control">
                    <label class="checkbox-option">
                      <input type="checkbox" name="eventRecurring" value="1" />
                      <span class="checkbox-custom"></span>
                      <span>This is a recurring event</span>
                    </label>
                  </div>
                </div>
              </div>

              <div class="form-section">
                <h3 class="section-title">Event Cover Image</h3>
                <div class="cover-upload">
                  <div class="cover-preview" id="coverPreview">
                    <i class="fa-solid fa-image"></i>
                    <span>Drag & drop or click to upload</span>
                  </div>
                  <input type="file" id="coverImage" name="cover_image" accept="image/*" class="file-input" />
                  <input type="hidden" name="banner" id="bannerUrl" value="" />
                  <p class="field-hint">JPG, PNG, or GIF. Recommended: 1200x600px. Max 5MB.</p>
                </div>
              </div>

              <div class="form-actions">
                <a href="/events" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">
                  <i class="fa-solid fa-calendar-plus"></i> Create Event
                </button>
              </div>
            </form>
          </div>

          <!-- Preview Section -->
          <div class="preview-section" id="previewSection">
            <h2 class="preview-title">Event Preview</h2>
            <div class="event-card preview-card" id="previewCard">
              <div class="event-card-thumb" id="previewBanner">
                <span class="event-date-badge" id="previewDateBadge">
                  <span class="badge-day" id="previewDay">27</span>
                  <span class="badge-month" id="previewMonth">Sep</span>
                </span>
                <span class="event-category-badge" id="previewCategoryBadge">Community</span>
              </div>
              <div class="event-card-body">
                <h3 class="event-title" id="previewTitle">Event Title</h3>
                <div class="event-meta-row" id="previewMeta">
                  <span><i class="fa-regular fa-clock"></i> <span id="previewTime">Time</span></span>
                  <span><i class="fa-solid fa-location-dot"></i> <span id="previewVenue">Venue</span></span>
                </div>
                <p class="event-desc" id="previewDesc">
                  Event description will appear here...
                </p>
                <div class="preview-badges">
                  <span class="preview-badge free"><i class="fa-solid fa-tag"></i> Free</span>
                  <span class="preview-badge"><i class="fa-solid fa-user-check"></i> RSVP Required</span>
                </div>
              </div>
              <div class="event-footer" id="previewFooter">
                <div class="event-attendees">
                  <span class="attendee-count">0 going</span>
                </div>
                <button class="btn-attend" disabled>RSVP</button>
              </div>
            </div>
          </div>
        </div>

<?php $this->section('scripts'); ?>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("eventForm");
    const coverInput = document.getElementById("coverImage");
    const coverPreview = document.getElementById("coverPreview");
    const costRadio = document.querySelectorAll('input[name="eventCost"]');
    const costAmountGroup = document.getElementById("costAmountGroup");

    form.addEventListener("input", updatePreview);
    form.addEventListener("change", updatePreview);

    coverPreview.addEventListener("click", () => coverInput.click());
    coverPreview.addEventListener("dragover", (e) => {
      e.preventDefault();
      coverPreview.classList.add("dragover");
    });
    coverPreview.addEventListener("dragleave", () => {
      coverPreview.classList.remove("dragover");
    });
    coverPreview.addEventListener("drop", (e) => {
      e.preventDefault();
      coverPreview.classList.remove("dragover");
      if (e.dataTransfer.files && e.dataTransfer.files[0]) {
        coverInput.files = e.dataTransfer.files;
        const event = new Event("change");
        coverInput.dispatchEvent(event);
      }
    });

    coverInput.addEventListener("change", (e) => {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (event) => {
          coverPreview.innerHTML = `<img src="${event.target.result}" alt="Cover preview" style="width:100%; height:100%; object-fit:cover; border-radius:12px;">`;
          const previewBanner = document.getElementById("previewBanner");
          if (previewBanner) {
            previewBanner.style.backgroundImage = `url(${event.target.result})`;
            previewBanner.style.backgroundSize = "cover";
            previewBanner.style.backgroundPosition = "center";
          }
        };
        reader.readAsDataURL(file);
      }
    });

    // Toggle cost amount field
    costRadio.forEach(radio => {
      radio.addEventListener("change", () => {
        costAmountGroup.style.display = radio.value === "paid" ? "block" : "none";
      });
    });

    function updatePreview() {
      const title = document.getElementById("eventTitle").value || "Event Title";
      const category = document.getElementById("eventCategory").value;
      const date = document.getElementById("eventDate").value;
      const time = document.getElementById("eventTime").value;
      const venue = document.getElementById("eventVenue").value || "Venue";
      const desc = document.getElementById("eventDescription").value || "Event description will appear here...";
      const costRadioChecked = document.querySelector('input[name="eventCost"]:checked');
      const cost = costRadioChecked ? costRadioChecked.value : 'free';
      const rsvp = document.querySelector('input[name="rsvpRequired"]') ? document.querySelector('input[name="rsvpRequired"]').checked : true;

      const categories = {
        community: "Community",
        sports: "Sports",
        food: "Food & Drink",
        music: "Music & Entertainment",
        arts: "Arts & Culture",
        education: "Education",
        business: "Business",
        health: "Health & Wellness",
        charity: "Charity",
        family: "Family & Kids",
        tech: "Technology",
        other: "Other"
      };

      // Parse date for badge
      let day = "27", month = "Sep";
      if (date) {
        const d = new Date(date);
        day = d.getDate().toString();
        month = d.toLocaleString("en-US", { month: "short" });
      }

      // Format time
      let timeStr = "Time";
      if (time) {
        const [h, m] = time.split(":");
        const hour = parseInt(h);
        const ampm = hour >= 12 ? "PM" : "AM";
        const hour12 = hour % 12 || 12;
        timeStr = `${hour12}:${m} ${ampm}`;
      }

      document.getElementById("previewTitle").textContent = title;
      document.getElementById("previewDay").textContent = day;
      document.getElementById("previewMonth").textContent = month;
      document.getElementById("previewCategoryBadge").textContent = categories[category] || "Category";
      document.getElementById("previewTime").textContent = timeStr;
      document.getElementById("previewVenue").textContent = venue;
      document.getElementById("previewDesc").textContent = desc.length > 100 ? desc.substring(0, 100) + "..." : desc;

      const badges = document.querySelector(".preview-badges");
      if (badges) {
        const costLabels = { free: "Free", paid: "Paid", donation: "Donation" };
        const costClasses = { free: "free", paid: "paid", donation: "donation" };
        badges.innerHTML = `
          <span class="preview-badge ${costClasses[cost]}">
            <i class="fa-solid fa-tag"></i> ${costLabels[cost]}
          </span>
          <span class="preview-badge ${rsvp ? '' : 'hidden'}">
            <i class="fa-solid fa-user-check"></i> ${rsvp ? 'RSVP Required' : 'No RSVP'}
          </span>
        `;
      }
    }

    updatePreview();
  });
</script>
<?php $this->endSection(); ?>
