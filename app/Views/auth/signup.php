<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vicinity – Join Your Community</title>
    <link rel="stylesheet" href="<?= asset('modern.css') ?>" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  </head>
  <body>
    <div class="signup-main">
      <div class="signup-content">
        <div class="signup-inner">
          <div class="signup-brand">
            <div class="brand-logo">
              <i class="fa-solid fa-users"></i>
            </div>
            <h1>Vicinity</h1>
          </div>

          <?php if ($error = session()->getFlash('error')): ?>
            <div style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);color:#fca5a5;padding:.85rem 1rem;border-radius:8px;margin-bottom:1.25rem;font-size:.9rem;display:flex;align-items:center;gap:.5rem;">
              <i class="fa-solid fa-circle-exclamation"></i>
              <span><?= e($error) ?></span>
            </div>
          <?php endif; ?>

          <!-- Signup Form Card -->
          <div class="signup-card">
            <div class="signup-header">
              <h2>Create Your Account</h2>
              <p>Fill in the details below to get started</p>
            </div>

            <form class="signup-form" id="signupForm" action="/signup" method="POST">
              <?= csrf_field() ?>

              <!-- Profile Picture -->
              <div class="profile-upload">
                <div class="profile-preview" id="profilePreview">
                  <i class="fa-solid fa-user"></i>
                </div>
                <div class="profile-actions">
                  <label class="file-input-label">
                    <i class="fa-solid fa-camera"></i> Upload Photo
                    <input
                      type="file"
                      class="file-input"
                      id="profileImage"
                      name="avatar"
                      accept="image/*"
                    />
                  </label>
                  <button type="button" class="btn-ghost" id="removePhoto">
                    <i class="fa-solid fa-trash"></i> Remove
                  </button>
                </div>
              </div>

              <!-- Handle and Name Row -->
              <div class="form-row">
                <div class="form-group">
                  <label for="handle" class="field-label">Handle *</label>
                  <div class="field-container">
                    <i class="fa-solid fa-at field-icon"></i>
                    <input
                      type="text"
                      id="handle"
                      name="handle"
                      value="<?= e(old('handle')) ?>"
                      placeholder="@yourhandle"
                      class="field-input"
                      required
                    />
                  </div>
                  <p class="field-hint">Your unique community identifier</p>
                </div>
                <div class="form-group">
                  <label for="fullName" class="field-label">Full Name *</label>
                  <div class="field-container">
                    <i class="fa-solid fa-user field-icon"></i>
                    <input
                      type="text"
                      id="fullName"
                      name="name"
                      value="<?= e(old('name')) ?>"
                      placeholder="Enter your full name"
                      class="field-input"
                      required
                    />
                  </div>
                </div>
              </div>

              <!-- Bio -->
              <div class="form-group">
                <label for="bio" class="field-label">Bio</label>
                <div class="field-container textarea-container">
                  <textarea
                    id="bio"
                    name="bio"
                    rows="3"
                    placeholder="Tell your neighbors a bit about yourself..."
                    class="field-input"
                  ><?= e(old('bio')) ?></textarea>
                </div>
                <p class="field-hint">
                  Brief description visible to your community (max 160 characters)
                </p>
              </div>

              <!-- Email and Phone -->
              <div class="form-row">
                <div class="form-group">
                  <label for="email" class="field-label">Email *</label>
                  <div class="field-container">
                    <i class="fa-solid fa-envelope field-icon"></i>
                    <input
                      type="email"
                      id="email"
                      name="email"
                      value="<?= e(old('email')) ?>"
                      placeholder="you@example.com"
                      class="field-input"
                      required
                    />
                  </div>
                </div>
                <div class="form-group">
                  <label for="phone" class="field-label">Phone Number</label>
                  <div class="field-container">
                    <i class="fa-solid fa-phone field-icon"></i>
                    <input
                      type="tel"
                      id="phone"
                      name="phone"
                      value="<?= e(old('phone')) ?>"
                      placeholder="+234 80x xxx xxxx"
                      class="field-input"
                    />
                  </div>
                </div>
              </div>

              <!-- Location and LGA -->
              <div class="form-row">
                <div class="form-group">
                  <label for="location" class="field-label">Location</label>
                  <div class="field-container">
                    <i class="fa-solid fa-location-dot field-icon"></i>
                    <input
                      type="text"
                      id="location"
                      name="location"
                      value="<?= e(old('location')) ?>"
                      placeholder="Your neighborhood"
                      class="field-input"
                    />
                  </div>
                </div>
                <div class="form-group">
                  <label for="lga" class="field-label">LGA</label>
                  <div class="field-container">
                    <i class="fa-solid fa-map field-icon"></i>
                    <select id="lga" name="lga" class="field-input">
                      <option value="">Select LGA</option>
                      <option value="surulere" <?= old('lga') === 'surulere' ? 'selected' : '' ?>>Surulere</option>
                      <option value="lagos-island" <?= old('lga') === 'lagos-island' ? 'selected' : '' ?>>Lagos Island</option>
                      <option value="ikeja" <?= old('lga') === 'ikeja' ? 'selected' : '' ?>>Ikeja</option>
                      <option value="yaba" <?= old('lga') === 'yaba' ? 'selected' : '' ?>>Yaba</option>
                      <option value="lekki" <?= old('lga') === 'lekki' ? 'selected' : '' ?>>Lekki</option>
                      <option value="victoria-island" <?= old('lga') === 'victoria-island' ? 'selected' : '' ?>>Victoria Island</option>
                      <option value="other" <?= old('lga') === 'other' ? 'selected' : '' ?>>Other</option>
                    </select>
                  </div>
                </div>
              </div>

              <!-- Password Fields -->
              <div class="form-row">
                <div class="form-group">
                  <label for="password" class="field-label">Password *</label>
                  <div class="field-container">
                    <i class="fa-solid fa-lock field-icon"></i>
                    <input
                      type="password"
                      id="password"
                      name="password"
                      placeholder="Create a password"
                      class="field-input"
                      required
                    />
                  </div>
                  <p class="field-hint">At least 8 characters with one number</p>
                </div>
                <div class="form-group">
                  <label for="confirmPassword" class="field-label">Confirm Password *</label>
                  <div class="field-container">
                    <i class="fa-solid fa-lock field-icon"></i>
                    <input
                      type="password"
                      id="confirmPassword"
                      name="password_confirmation"
                      placeholder="Confirm your password"
                      class="field-input"
                      required
                    />
                  </div>
                </div>
              </div>

              <!-- Password Strength -->
              <div class="password-strength" id="passwordStrength">
                <div class="strength-bar">
                  <div class="strength-fill" id="strengthFill"></div>
                </div>
                <span class="strength-text" id="strengthText">Password strength</span>
              </div>

              <!-- Terms -->
              <div class="login-options">
                <label class="checkbox-container">
                  <input
                    type="checkbox"
                    id="termsCheckbox"
                    name="terms"
                    class="login-checkbox"
                    required
                  />
                  <span class="custom-checkbox"></span>
                  I agree to the
                  <a href="#" class="terms-link">Terms of Service</a> and
                  <a href="#" class="terms-link">Privacy Policy</a>
                </label>
              </div>

              <!-- Submit -->
              <button type="submit" class="login-button">
                <i class="fa-solid fa-leaf"></i> Join Vicinity
              </button>
              <div class="signup-footer">
                Already have an account? <a href="/login">Log in</a>
              </div>
            </form>
          </div>

          <!-- Preview Section -->
          <div class="preview-section" id="previewSection">
            <h2 class="preview-title">Your Profile Preview</h2>
            <div class="profile-preview-card" id="profilePreviewCard">
              <div class="preview-avatar" id="previewAvatar">
                <i class="fa-solid fa-user"></i>
              </div>
              <div class="preview-info">
                <h3 id="previewHandle">@yourhandle</h3>
                <p id="previewName">Full Name</p>
                <p id="previewBio" class="preview-bio-text">
                  Your bio will appear here...
                </p>
              </div>
              <div class="preview-details">
                <span class="preview-detail">
                  <i class="fa-solid fa-envelope"></i>
                  <span id="previewEmail">Email</span>
                </span>
                <span class="preview-detail">
                  <i class="fa-solid fa-location-dot"></i>
                  <span id="previewLocation">Location</span>
                </span>
                <span class="preview-detail">
                  <i class="fa-solid fa-map"></i>
                  <span id="previewLGA">LGA</span>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("signupForm");
        const profileImage = document.getElementById("profileImage");
        const profilePreview = document.getElementById("profilePreview");
        const removePhoto = document.getElementById("removePhoto");
        const password = document.getElementById("password");
        const strengthFill = document.getElementById("strengthFill");
        const strengthText = document.getElementById("strengthText");

        // Profile image upload
        profileImage.addEventListener("change", (e) => {
          const file = e.target.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = (ev) => {
              profilePreview.innerHTML = `<img src="${ev.target.result}" alt="Profile preview" />`;
              profilePreview.style.borderColor = "var(--accent-color)";
            };
            reader.readAsDataURL(file);
          }
        });

        removePhoto.addEventListener("click", () => {
          profilePreview.innerHTML = '<i class="fa-solid fa-user"></i>';
          profilePreview.style.borderColor = "";
          profileImage.value = "";
        });

        // Password strength checker
        password.addEventListener("input", () => {
          const val = password.value;
          let strength = 0;
          if (val.length >= 8) strength++;
          if (/[A-Z]/.test(val)) strength++;
          if (/[0-9]/.test(val)) strength++;
          if (/[^A-Za-z0-9]/.test(val)) strength++;

          const levels = [
            { width: "0%", color: "#ccc", text: "Weak" },
            { width: "25%", color: "#e74c3c", text: "Weak" },
            { width: "50%", color: "#e67e22", text: "Medium" },
            { width: "75%", color: "#36a036", text: "Strong" },
            { width: "100%", color: "#2ecc71", text: "Very Strong" },
          ];

          const level = levels[Math.min(strength, 4)];
          strengthFill.style.width = level.width;
          strengthFill.style.backgroundColor = level.color;
          strengthText.textContent = level.text;
          strengthText.style.color = level.color;
        });

        // Live preview update
        const updatePreview = () => {
          const handle = document.getElementById("handle").value || "@yourhandle";
          const name = document.getElementById("fullName").value || "Full Name";
          const bio = document.getElementById("bio").value || "Your bio will appear here...";
          const email = document.getElementById("email").value || "Email";
          const location = document.getElementById("location").value || "Location";
          const lga = document.getElementById("lga").selectedOptions[0]?.text || "LGA";

          document.getElementById("previewHandle").textContent = handle;
          document.getElementById("previewName").textContent = name;
          document.getElementById("previewBio").textContent = bio;
          document.getElementById("previewEmail").textContent = email;
          document.getElementById("previewLocation").textContent = location;
          document.getElementById("previewLGA").textContent = lga;
        };

        form.addEventListener("input", updatePreview);
        form.addEventListener("change", updatePreview);
        updatePreview();
      });
    </script>
  </body>
</html>
