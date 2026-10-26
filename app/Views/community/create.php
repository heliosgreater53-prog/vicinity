<?php $this->extend('layouts.main'); ?>

<?php $this->section('container_class'); ?>community-container<?php $this->endSection(); ?>

        <div class="community-content">
          <!-- Create Group Hero -->
          <section class="create-hero">
            <div class="create-hero-content">
              <span class="hero-tag">
                <i class="fa-solid fa-people-roof"></i> Neighborhood Groups
              </span>
              <h1>Create a New Group</h1>
              <p class="create-hero-subtitle">
                Bring neighbors together around shared interests, causes, or activities.
              </p>
            </div>
            <div class="create-hero-icon">
              <i class="fa-solid fa-people-roof"></i>
            </div>
          </section>

          <!-- Breadcrumbs -->
          <nav class="create-breadcrumbs" aria-label="Breadcrumb">
            <a href="/community">Communities</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="#">Create Group</a>
          </nav>

          <!-- Create Group Form -->
          <div class="create-form-container">
            <form action="/community" method="POST" class="create-form" id="groupForm" enctype="multipart/form-data">
              <?= csrf_field() ?>

              <div class="form-section">
                <h3 class="section-title">Basic Information</h3>

                <div class="form-row">
                  <div class="form-group">
                    <label for="groupName" class="field-label">Group Name *</label>
                    <div class="field-container">
                      <input type="text" id="groupName" name="name" value="<?= e(old('name')) ?>" placeholder="e.g., Surulere Runners Club" required />
                    </div>
                    <p class="field-hint">Choose a clear, descriptive name (max 50 characters)</p>
                  </div>
                  <div class="form-group">
                    <label for="groupCategory" class="field-label">Category *</label>
                    <div class="field-container">
                      <select id="groupCategory" name="category" required>
                        <option value="">Select category</option>
                        <option value="sports">Sports & Fitness</option>
                        <option value="business">Business & Trade</option>
                        <option value="environment">Environment & Sustainability</option>
                        <option value="arts">Arts & Culture</option>
                        <option value="food">Food & Cooking</option>
                        <option value="tech">Technology</option>
                        <option value="education">Education & Learning</option>
                        <option value="health">Health & Wellness</option>
                        <option value="security">Security & Safety</option>
                        <option value="faith">Faith & Spirituality</option>
                        <option value="hobby">Hobbies & Interests</option>
                        <option value="other">Other</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="groupDescription" class="field-label">Description *</label>
                  <div class="field-container textarea-container">
                    <textarea id="groupDescription" name="description" rows="4" placeholder="What is this group about? What will members do together?" required><?= e(old('description')) ?></textarea>
                  </div>
                  <p class="field-hint">Describe the group's purpose and activities (max 500 characters)</p>
                </div>

                <div class="form-row">
                  <div class="form-group">
                    <label for="groupLocation" class="field-label">Location / Area</label>
                    <div class="field-container">
                      <input type="text" id="groupLocation" name="location" value="<?= e(old('location')) ?>" placeholder="e.g., Surulere, Lagos" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="groupMeetingFrequency" class="field-label">Meeting Frequency</label>
                    <div class="field-container">
                      <select id="groupMeetingFrequency" name="frequency">
                        <option value="">Select frequency</option>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="biweekly">Bi-weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="occasionally">Occasionally</option>
                        <option value="online">Online only</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-section">
                <h3 class="section-title">Group Settings</h3>

                <div class="setting-group">
                  <div class="setting-info">
                    <h4>Privacy</h4>
                    <p>Who can see and join this group</p>
                  </div>
                  <div class="setting-control">
                    <label class="radio-option">
                      <input type="radio" name="privacy" value="public" checked />
                      <span class="radio-custom"></span>
                      <span>Public - Anyone can see and join</span>
                    </label>
                    <label class="radio-option">
                      <input type="radio" name="privacy" value="private" />
                      <span class="radio-custom"></span>
                      <span>Private - Request to join, admin approval required</span>
                    </label>
                  </div>
                </div>

                <div class="setting-group">
                  <div class="setting-info">
                    <h4>Post Permissions</h4>
                    <p>Who can post in this group</p>
                  </div>
                  <div class="setting-control">
                    <label class="radio-option">
                      <input type="radio" name="postPermission" value="all" checked />
                      <span class="radio-custom"></span>
                      <span>All members can post</span>
                    </label>
                    <label class="radio-option">
                      <input type="radio" name="postPermission" value="admins" />
                      <span class="radio-custom"></span>
                      <span>Only admins and moderators can post</span>
                    </label>
                  </div>
                </div>

                <div class="setting-group">
                  <div class="setting-info">
                    <h4>Group Visibility</h4>
                    <p>Show group in Discover and search results</p>
                  </div>
                  <div class="setting-control">
                    <label class="checkbox-option">
                      <input type="checkbox" name="visibility" value="1" checked />
                      <span class="checkbox-custom"></span>
                      <span>Make group discoverable</span>
                    </label>
                  </div>
                </div>

                <div class="setting-group">
                  <div class="setting-info">
                    <h4>Member Invites</h4>
                    <p>Allow members to invite others</p>
                  </div>
                  <div class="setting-control">
                    <label class="checkbox-option">
                      <input type="checkbox" name="invites" value="1" checked />
                      <span class="checkbox-custom"></span>
                      <span>Enable member invitations</span>
                    </label>
                  </div>
                </div>
              </div>

              <div class="form-section">
                <h3 class="section-title">Group Cover Image</h3>
                <div class="cover-upload">
                  <div class="cover-preview" id="coverPreview">
                    <i class="fa-solid fa-image"></i>
                    <span>Drag & drop or click to upload</span>
                  </div>
                  <input type="file" id="coverImage" name="cover_image" accept="image/*" class="file-input" />
                  <input type="hidden" name="banner" id="bannerUrl" value="" />
                  <p class="field-hint">JPG, PNG, or GIF. Recommended: 1200x400px. Max 5MB.</p>
                </div>
              </div>

              <div class="form-actions">
                <a href="/community" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">
                  <i class="fa-solid fa-people-roof"></i> Create Group
                </button>
              </div>
            </form>
          </div>

          <!-- Preview Section -->
          <div class="preview-section" id="previewSection">
            <h2 class="preview-title">Group Preview</h2>
            <div class="group-card preview-card" id="previewCard">
              <div class="group-banner" id="previewBanner">
                <span class="group-category" id="previewCategory">Category</span>
              </div>
              <div class="group-card-body">
                <h3 class="group-title" id="previewTitle">Group Name</h3>
                <p class="group-meta" id="previewMeta">
                  <i class="fa-solid fa-map-marker-alt"></i> Location &bull; <span id="previewFrequency">Weekly meetings</span>
                </p>
                <p class="group-desc" id="previewDesc">
                  Group description will appear here...
                </p>
                <div class="preview-badges">
                  <span class="preview-badge public"><i class="fa-solid fa-globe"></i> Public</span>
                  <span class="preview-badge"><i class="fa-solid fa-users"></i> All members can post</span>
                </div>
              </div>
            </div>
          </div>
        </div>

<?php $this->section('scripts'); ?>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("groupForm");
    const coverInput = document.getElementById("coverImage");
    const coverPreview = document.getElementById("coverPreview");

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

    function updatePreview() {
      const name = document.getElementById("groupName").value || "Group Name";
      const category = document.getElementById("groupCategory").value;
      const location = document.getElementById("groupLocation").value;
      const frequency = document.getElementById("groupMeetingFrequency").value;
      const desc = document.getElementById("groupDescription").value || "Group description will appear here...";
      const privacyChecked = document.querySelector('input[name="privacy"]:checked');
      const privacy = privacyChecked ? privacyChecked.value : 'public';
      const postPermChecked = document.querySelector('input[name="postPermission"]:checked');
      const postPerm = postPermChecked ? postPermChecked.value : 'all';

      const categories = {
        sports: "Sports & Fitness",
        business: "Business & Trade",
        environment: "Environment & Sustainability",
        arts: "Arts & Culture",
        food: "Food & Cooking",
        tech: "Technology",
        education: "Education & Learning",
        health: "Health & Wellness",
        security: "Security & Safety",
        faith: "Faith & Spirituality",
        hobby: "Hobbies & Interests",
        other: "Other"
      };

      const freqLabels = {
        daily: "Daily meetings",
        weekly: "Weekly meetings",
        biweekly: "Bi-weekly meetings",
        monthly: "Monthly meetings",
        occasionally: "Occasional meetings",
        online: "Online only"
      };

      document.getElementById("previewTitle").textContent = name;
      document.getElementById("previewCategory").textContent = categories[category] || "Category";
      document.getElementById("previewMeta").innerHTML = `
        <i class="fa-solid fa-map-marker-alt"></i> ${location || "Location"} &bull; 
        <span>${freqLabels[frequency] || "Meeting frequency"}</span>
      `;
      document.getElementById("previewDesc").textContent = desc.length > 100 ? desc.substring(0, 100) + "..." : desc;

      const badges = document.querySelector(".preview-badges");
      if (badges) {
        badges.innerHTML = `
          <span class="preview-badge ${privacy === 'public' ? 'public' : 'private'}">
            <i class="fa-solid ${privacy === 'public' ? 'fa-globe' : 'fa-lock'}"></i> 
            ${privacy === 'public' ? 'Public' : 'Private'}
          </span>
          <span class="preview-badge">
            <i class="fa-solid fa-users"></i> 
            ${postPerm === 'all' ? 'All members can post' : 'Admins only can post'}
          </span>
        `;
      }
    }

    updatePreview();
  });
</script>
<?php $this->endSection(); ?>
