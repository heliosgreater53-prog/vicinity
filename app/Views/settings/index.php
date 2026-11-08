<?php $this->extend('layouts.main'); ?>

<?php $this->section('container_class'); ?>settings-container<?php $this->endSection(); ?>

<div class="settings-content">
  <div class="settings-header">
    <h1>Settings</h1>
    <p class="settings-subtitle">Manage your account, preferences, and community settings</p>
  </div>

  <nav class="settings-nav" aria-label="Settings categories">
    <a href="#account" class="settings-nav-item active" data-section="account">
      <i class="fa-solid fa-user"></i>
      <span>Account</span>
    </a>
    <a href="#notifications" class="settings-nav-item" data-section="notifications">
      <i class="fa-solid fa-bell"></i>
      <span>Notifications</span>
    </a>
    <a href="#privacy" class="settings-nav-item" data-section="privacy">
      <i class="fa-solid fa-shield-halved"></i>
      <span>Privacy</span>
    </a>
    <a href="#appearance" class="settings-nav-item" data-section="appearance">
      <i class="fa-solid fa-palette"></i>
      <span>Appearance</span>
    </a>
    <a href="#community" class="settings-nav-item" data-section="community">
      <i class="fa-solid fa-location-dot"></i>
      <span>Community</span>
    </a>
  </nav>

  <div class="settings-body">
    <!-- Account Section -->
    <section id="section-account" class="settings-section active">
      <div class="settings-card">
        <div class="settings-card-header">
          <h2>Profile Information</h2>
          <p>Update your personal information visible to your community</p>
        </div>
        <form action="/settings" method="POST" class="settings-form">
          <?= csrf_field() ?>
          <div class="form-row">
            <div class="form-group">
              <label for="display-name" class="field-label">Display Name</label>
              <div class="field-container">
                <input type="text" id="display-name" name="name" value="<?= e($user->name ?? 'John Doe') ?>" placeholder="Your name" required />
              </div>
            </div>
            <div class="form-group">
              <label for="username" class="field-label">Username</label>
              <div class="field-container">
                <span class="field-prefix">@</span>
                <input type="text" id="username" name="username" value="<?= e($user->username ?? 'johndoe') ?>" placeholder="username" />
              </div>
              <p class="field-hint">Your username is your unique identifier</p>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="email" class="field-label">Email Address</label>
              <div class="field-container">
                <input type="email" id="email" name="email" value="<?= e($user->email ?? 'john.doe@example.com') ?>" placeholder="email@example.com" required />
              </div>
            </div>
            <div class="form-group">
              <label for="phone" class="field-label">Phone Number</label>
              <div class="field-container">
                <input type="tel" id="phone" name="phone" value="<?= e($user->phone ?? '+234 801 234 5678') ?>" placeholder="+234 801 234 5678" />
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="bio" class="field-label">Bio</label>
            <div class="field-container textarea-container">
              <textarea id="bio" name="bio" rows="3" placeholder="Tell your neighbors about yourself..."><?= e($user->bio ?? 'Active community member in Surulere. Love local food and tech meetups!') ?></textarea>
            </div>
            <p class="field-hint">Max 160 characters</p>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn-primary">Save Changes</button>
          </div>
        </form>
      </div>

      <div class="settings-card">
        <div class="settings-card-header">
          <h2>Profile Photo</h2>
          <p>Upload a photo to help neighbors recognize you</p>
        </div>
        <div class="avatar-upload">
          <div class="avatar-preview">
            <div class="profile-initial large"><?= e(strtoupper(substr($user->name ?? 'JD', 0, 2))) ?></div>
          </div>
          <div class="avatar-actions">
            <label class="btn-secondary file-input-label">
              <i class="fa-solid fa-camera"></i> Choose Photo
              <input type="file" accept="image/*" class="file-input" />
            </label>
            <button type="button" class="btn-ghost">Remove Photo</button>
          </div>
          <p class="field-hint">JPG, PNG, or GIF. Max 5MB.</p>
        </div>
      </div>

      <div class="settings-card danger-zone">
        <div class="settings-card-header">
          <h2>Danger Zone</h2>
          <p>Irreversible actions</p>
        </div>
        <div class="danger-item">
          <div class="danger-info">
            <h3>Delete Account</h3>
            <p>Permanently delete your account and all associated data. This cannot be undone.</p>
          </div>
          <button type="button" class="btn-danger">Delete Account</button>
        </div>
      </div>
    </section>

    <!-- Notifications Section -->
    <section id="section-notifications" class="settings-section">
      <div class="settings-card">
        <div class="settings-card-header">
          <h2>Push Notifications</h2>
          <p>Choose what notifications you receive on your device</p>
        </div>
        <div class="notification-options">
          <label class="notification-toggle">
            <div class="toggle-info">
              <i class="fa-solid fa-newspaper"></i>
              <div>
                <h4>New Posts in My Groups</h4>
                <p>Get notified when someone posts in groups you've joined</p>
              </div>
            </div>
            <input type="checkbox" class="login-checkbox" checked />
            <span class="custom-checkbox"></span>
          </label>

          <label class="notification-toggle">
            <div class="toggle-info">
              <i class="fa-solid fa-calendar-days"></i>
              <div>
                <h4>Upcoming Events</h4>
                <p>Reminders for events you've RSVP'd to</p>
              </div>
            </div>
            <input type="checkbox" class="login-checkbox" checked />
            <span class="custom-checkbox"></span>
          </label>

          <label class="notification-toggle">
            <div class="toggle-info">
              <i class="fa-solid fa-comment"></i>
              <div>
                <h4>Comments & Replies</h4>
                <p>When someone replies to your posts or comments</p>
              </div>
            </div>
            <input type="checkbox" class="login-checkbox" checked />
            <span class="custom-checkbox"></span>
          </label>

          <label class="notification-toggle">
            <div class="toggle-info">
              <i class="fa-solid fa-thumbs-up"></i>
              <div>
                <h4>Likes & Reactions</h4>
                <p>When someone reacts to your posts</p>
              </div>
            </div>
            <input type="checkbox" class="login-checkbox" />
            <span class="custom-checkbox"></span>
          </label>

          <label class="notification-toggle">
            <div class="toggle-info">
              <i class="fa-solid fa-user-plus"></i>
              <div>
                <h4>Group Invitations</h4>
                <p>When someone invites you to join a group</p>
              </div>
            </div>
            <input type="checkbox" class="login-checkbox" checked />
            <span class="custom-checkbox"></span>
          </label>

          <label class="notification-toggle">
            <div class="toggle-info">
              <i class="fa-solid fa-store"></i>
              <div>
                <h4>New Business Listings</h4>
                <p>When new businesses open in your area</p>
              </div>
            </div>
            <input type="checkbox" class="login-checkbox" />
            <span class="custom-checkbox"></span>
          </label>

          <label class="notification-toggle">
            <div class="toggle-info">
              <i class="fa-solid fa-shield-halved"></i>
              <div>
                <h4>Security Alerts</h4>
                <p>Important safety notices from your community</p>
              </div>
            </div>
            <input type="checkbox" class="login-checkbox" checked />
            <span class="custom-checkbox"></span>
          </label>

          <label class="notification-toggle">
            <div class="toggle-info">
              <i class="fa-solid fa-bullhorn"></i>
              <div>
                <h4>Announcements from Vicinity</h4>
                <p>Product updates, feature announcements, and tips</p>
              </div>
            </div>
            <input type="checkbox" class="login-checkbox" />
            <span class="custom-checkbox"></span>
          </label>
        </div>
      </div>

      <div class="settings-card">
        <div class="settings-card-header">
          <h2>Email Notifications</h2>
          <p>Receive email summaries and important updates</p>
        </div>
        <div class="notification-options">
          <label class="notification-toggle">
            <div class="toggle-info">
              <i class="fa-solid fa-envelope"></i>
              <div>
                <h4>Weekly Digest</h4>
                <p>Summary of community activity every Monday</p>
              </div>
            </div>
            <input type="checkbox" class="login-checkbox" checked />
            <span class="custom-checkbox"></span>
          </label>

          <label class="notification-toggle">
            <div class="toggle-info">
              <i class="fa-solid fa-bell"></i>
              <div>
                <h4>Security & Account Alerts</h4>
                <p>Login alerts, password changes, security notices</p>
              </div>
            </div>
            <input type="checkbox" class="login-checkbox" checked />
            <span class="custom-checkbox"></span>
          </label>

          <label class="notification-toggle">
            <div class="toggle-info">
              <i class="fa-solid fa-star"></i>
              <div>
                <h4>Featured Content</h4>
                <p>Hand-picked posts, events, and businesses you might like</p>
              </div>
            </div>
            <input type="checkbox" class="login-checkbox" />
            <span class="custom-checkbox"></span>
          </label>
        </div>
      </div>
    </section>

    <!-- Privacy Section -->
    <section id="section-privacy" class="settings-section">
      <div class="settings-card">
        <div class="settings-card-header">
          <h2>Profile Visibility</h2>
          <p>Control who can see your profile information</p>
        </div>
        <div class="privacy-options">
          <div class="privacy-option">
            <div class="privacy-info">
              <h4>Profile Photo & Name</h4>
              <p>Visible to everyone on Vicinity</p>
            </div>
            <select class="privacy-select">
              <option value="everyone" selected>Everyone</option>
              <option value="neighbors">Verified Neighbors Only</option>
              <option value="groups">Group Members Only</option>
            </select>
          </div>

          <div class="privacy-option">
            <div class="privacy-info">
              <h4>Email Address</h4>
              <p>Used for account recovery and notifications</p>
            </div>
            <select class="privacy-select">
              <option value="private" selected>Private</option>
              <option value="neighbors">Verified Neighbors Only</option>
              <option value="groups">Group Members Only</option>
            </select>
          </div>

          <div class="privacy-option">
            <div class="privacy-info">
              <h4>Phone Number</h4>
              <p>For direct contact with neighbors</p>
            </div>
            <select class="privacy-select">
              <option value="private" selected>Private</option>
              <option value="neighbors">Verified Neighbors Only</option>
              <option value="groups">Group Members Only</option>
            </select>
          </div>

          <div class="privacy-option">
            <div class="privacy-info">
              <h4>Groups You've Joined</h4>
              <p>List of communities you participate in</p>
            </div>
            <select class="privacy-select">
              <option value="neighbors" selected>Verified Neighbors Only</option>
              <option value="everyone">Everyone</option>
              <option value="private">Private</option>
            </select>
          </div>

          <div class="privacy-option">
            <div class="privacy-info">
              <h4>Events You're Attending</h4>
              <p>Your RSVP'd events visible to others</p>
            </div>
            <select class="privacy-select">
              <option value="everyone" selected>Everyone</option>
              <option value="neighbors">Verified Neighbors Only</option>
              <option value="private">Private</option>
            </select>
          </div>

          <div class="privacy-option">
            <div class="privacy-info">
              <h4>Saved Items</h4>
              <p>Posts, businesses, and events you've bookmarked</p>
            </div>
            <select class="privacy-select">
              <option value="private" selected>Private</option>
              <option value="neighbors">Verified Neighbors Only</option>
              <option value="everyone">Everyone</option>
            </select>
          </div>
        </div>
      </div>

      <div class="settings-card">
        <div class="settings-card-header">
          <h2>Data & Activity</h2>
          <p>Manage your data and activity history</p>
        </div>
        <div class="data-actions">
          <div class="data-action">
            <div class="data-info">
              <h4>Download Your Data</h4>
              <p>Get a copy of your profile, posts, groups, and activity</p>
            </div>
            <button type="button" class="btn-secondary">Request Download</button>
          </div>

          <div class="data-action">
            <div class="data-info">
              <h4>Clear Search History</h4>
              <p>Remove all your past search queries</p>
            </div>
            <button type="button" class="btn-secondary">Clear History</button>
          </div>

          <div class="data-action">
            <div class="data-info">
              <h4>Manage Connected Apps</h4>
              <p>View and revoke third-party app access</p>
            </div>
            <button type="button" class="btn-secondary">Manage Apps</button>
          </div>
        </div>
      </div>

      <div class="settings-card">
        <div class="settings-card-header">
          <h2>Blocking & Reporting</h2>
          <p>Manage blocked users and content preferences</p>
        </div>
        <div class="data-actions">
          <div class="data-action">
            <div class="data-info">
              <h4>Blocked Users</h4>
              <p>View and manage users you've blocked (3 blocked)</p>
            </div>
            <button type="button" class="btn-secondary">Manage</button>
          </div>

          <div class="data-action">
            <div class="data-info">
              <h4>Content Preferences</h4>
              <p>Hide posts containing specific keywords</p>
            </div>
            <button type="button" class="btn-secondary">Set Keywords</button>
          </div>
        </div>
      </div>
    </section>

    <!-- Appearance Section -->
    <section id="section-appearance" class="settings-section">
      <div class="settings-card">
        <div class="settings-card-header">
          <h2>Theme</h2>
          <p>Choose how Vicinity looks on your device</p>
        </div>
        <div class="theme-options">
          <label class="theme-option">
            <input type="radio" name="theme" value="light" checked />
            <div class="theme-preview light">
              <div class="theme-header"></div>
              <div class="theme-sidebar"></div>
              <div class="theme-feed"></div>
            </div>
            <span>Light</span>
          </label>

          <label class="theme-option">
            <input type="radio" name="theme" value="dark" />
            <div class="theme-preview dark">
              <div class="theme-header"></div>
              <div class="theme-sidebar"></div>
              <div class="theme-feed"></div>
            </div>
            <span>Dark</span>
          </label>

          <label class="theme-option">
            <input type="radio" name="theme" value="system" />
            <div class="theme-preview system">
              <div class="theme-header"></div>
              <div class="theme-sidebar"></div>
              <div class="theme-feed"></div>
            </div>
            <span>System</span>
          </label>
        </div>
      </div>

      <div class="settings-card">
        <div class="settings-card-header">
          <h2>Display Density</h2>
          <p>Adjust spacing and content density</p>
        </div>
        <div class="density-options">
          <label class="density-option">
            <input type="radio" name="density" value="comfortable" checked />
            <div class="density-preview comfortable">
              <div class="density-line"></div>
              <div class="density-line"></div>
              <div class="density-line short"></div>
            </div>
            <span>Comfortable</span>
          </label>

          <label class="density-option">
            <input type="radio" name="density" value="compact" />
            <div class="density-preview compact">
              <div class="density-line"></div>
              <div class="density-line"></div>
              <div class="density-line short"></div>
            </div>
            <span>Compact</span>
          </label>
        </div>
      </div>

      <div class="settings-card">
        <div class="settings-card-header">
          <h2>Language & Region</h2>
          <p>Customize your language and regional settings</p>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="language" class="field-label">Language</label>
            <div class="field-container select-container">
              <select id="language">
                <option value="en" selected>English</option>
                <option value="yo">Yoruba</option>
                <option value="ig">Igbo</option>
                <option value="ha">Hausa</option>
                <option value="pidgin">Nigerian Pidgin</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="region" class="field-label">Region</label>
            <div class="field-container select-container">
              <select id="region" disabled>
                <option value="ng" selected>Nigeria</option>
                <option value="gh">Ghana</option>
                <option value="ke">Kenya</option>
                <option value="za">South Africa</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Community Section -->
    <section id="section-community" class="settings-section">
      <div class="settings-card">
        <div class="settings-card-header">
          <h2>Your Community (LGA)</h2>
          <p>Set your primary neighborhood for localized content</p>
        </div>
        <div class="community-setting">
          <div class="community-current">
            <div class="community-icon">
              <i class="fa-solid fa-location-dot"></i>
            </div>
            <div class="community-details">
              <h4><?= e($user->location ?? 'Surulere LGA, Lagos State') ?></h4>
              <p>Your primary community for posts, events, and businesses</p>
            </div>
          </div>
          <button type="button" class="btn-secondary">Change Community</button>
        </div>
      </div>

      <div class="settings-card">
        <div class="settings-card-header">
          <h2>Additional Areas</h2>
          <p>Follow nearby communities for broader content</p>
        </div>
        <div class="additional-areas">
          <label class="area-toggle">
            <div class="area-info">
              <h4>Yaba LGA</h4>
              <p>Tech hub, universities, vibrant nightlife</p>
            </div>
            <input type="checkbox" class="login-checkbox" />
            <span class="custom-checkbox"></span>
          </label>

          <label class="area-toggle">
            <div class="area-info">
              <h4>Mushin LGA</h4>
              <p>Markets, residential areas, local commerce</p>
            </div>
            <input type="checkbox" class="login-checkbox" checked />
            <span class="custom-checkbox"></span>
          </label>

          <label class="area-toggle">
            <div class="area-info">
              <h4>Mainland LGA</h4>
              <p>Ebute Metta, Sabo, Iddo business districts</p>
            </div>
            <input type="checkbox" class="login-checkbox" />
            <span class="custom-checkbox"></span>
          </label>

          <label class="area-toggle">
            <div class="area-info">
              <h4>Apapa LGA</h4>
              <p>Ports, logistics, industrial areas</p>
            </div>
            <input type="checkbox" class="login-checkbox" />
            <span class="custom-checkbox"></span>
          </label>
        </div>
      </div>

      <div class="settings-card">
        <div class="settings-card-header">
          <h2>Community Preferences</h2>
          <p>Customize your community experience</p>
        </div>
        <div class="notification-options">
          <label class="notification-toggle">
            <div class="toggle-info">
              <i class="fa-solid fa-map-marker-alt"></i>
              <div>
                <h4>Show Distance</h4>
                <p>Display distance from your location on posts and businesses</p>
              </div>
            </div>
            <input type="checkbox" class="login-checkbox" checked />
            <span class="custom-checkbox"></span>
          </label>

          <label class="notification-toggle">
            <div class="toggle-info">
              <i class="fa-solid fa-globe"></i>
              <div>
                <h4>Auto-translate Posts</h4>
                <p>Translate posts in other languages to your preferred language</p>
              </div>
            </div>
            <input type="checkbox" class="login-checkbox" />
            <span class="custom-checkbox"></span>
          </label>

          <label class="notification-toggle">
            <div class="toggle-info">
              <i class="fa-solid fa-users-gear"></i>
              <div>
                <h4>Suggest Groups</h4>
                <p>Get recommendations for groups based on your activity</p>
              </div>
            </div>
            <input type="checkbox" class="login-checkbox" checked />
            <span class="custom-checkbox"></span>
          </label>
        </div>
      </div>
    </section>
  </div>
</div>

<?php $this->section('scripts'); ?>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    // Settings navigation
    const navItems = document.querySelectorAll(".settings-nav-item");
    const sections = document.querySelectorAll(".settings-section");

    navItems.forEach((item) => {
      item.addEventListener("click", (e) => {
        e.preventDefault();
        const target = item.getAttribute("data-section");

        navItems.forEach((n) => n.classList.remove("active"));
        item.classList.add("active");

        sections.forEach((s) => {
          s.classList.toggle("active", s.id === `section-${target}`);
        });

        history.replaceState(null, null, `#${target}`);
      });
    });

    // Handle initial hash
    const currentHash = window.location.hash.replace("#", "");
    if (currentHash) {
      const matchingItem = document.querySelector(`.settings-nav-item[data-section="${currentHash}"]`);
      if (matchingItem) matchingItem.click();
    }

    // Theme switching and persistence
    const savedTheme = localStorage.getItem("vicinity_theme") || "light";
    const currentThemeRadio = document.querySelector(`input[name="theme"][value="${savedTheme}"]`);
    if (currentThemeRadio) currentThemeRadio.checked = true;
    applyTheme(savedTheme);

    function applyTheme(theme) {
      if (theme === "dark") {
        document.documentElement.setAttribute("data-theme", "dark");
      } else if (theme === "system") {
        const prefersDark = window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches;
        if (prefersDark) {
          document.documentElement.setAttribute("data-theme", "dark");
        } else {
          document.documentElement.removeAttribute("data-theme");
        }
      } else {
        document.documentElement.removeAttribute("data-theme");
      }
    }

    document.querySelectorAll('input[name="theme"]').forEach((radio) => {
      radio.addEventListener("change", () => {
        const val = radio.value;
        localStorage.setItem("vicinity_theme", val);
        applyTheme(val);
      });
    });

    // File input for avatar
    const fileInput = document.querySelector(".file-input");
    const avatarPreview = document.querySelector(".avatar-preview");
    if (fileInput && avatarPreview) {
      fileInput.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = (event) => {
            avatarPreview.innerHTML = `<img src="${event.target.result}" alt="Profile" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">`;
          };
          reader.readAsDataURL(file);
        }
      });
    }

    // Remove photo button
    const removePhotoBtn = document.querySelector(".avatar-actions .btn-ghost");
    if (removePhotoBtn && avatarPreview) {
      removePhotoBtn.addEventListener("click", () => {
        avatarPreview.innerHTML = '<div class="profile-initial large">JD</div>';
        if (fileInput) fileInput.value = "";
      });
    }

    // Danger zone Delete Account
    const deleteAccountBtn = document.querySelector(".danger-item .btn-danger");
    if (deleteAccountBtn) {
      deleteAccountBtn.addEventListener("click", () => {
        if (confirm("Are you sure you want to permanently delete your account? This action cannot be undone.")) {
          alert("Your account deletion request has been submitted. A verification email has been sent.");
        }
      });
    }

    // Data & Activity buttons
    document.querySelectorAll(".data-action .btn-secondary").forEach((btn) => {
      btn.addEventListener("click", () => {
        const title = btn.closest(".data-action")?.querySelector("h4")?.textContent || "Action";
        alert(`${title} completed successfully!`);
      });
    });
  });
</script>
<?php $this->endSection(); ?>