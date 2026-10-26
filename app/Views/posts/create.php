<?php $this->extend('layouts.main'); ?>

<?php $this->section('container_class'); ?>feed-container<?php $this->endSection(); ?>

        <div class="feed-content">
          <!-- Create Post Hero -->
          <section class="create-hero">
            <div class="create-hero-content">
              <h1>Create a Post</h1>
              <p class="create-hero-subtitle">
                Share updates, ask questions, or announce events to your
                neighbors
              </p>
            </div>
            <div class="create-hero-icon">
              <i class="fa-solid fa-pen-to-square"></i>
            </div>
          </section>

          <!-- Breadcrumbs -->
          <nav class="create-breadcrumbs" aria-label="Breadcrumb">
            <a href="/">Home</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="#">Create Post</a>
          </nav>

          <!-- Create Post Form -->
          <div class="create-form-container">
            <form action="/posts" method="POST" class="create-form" id="postForm" enctype="multipart/form-data">
              <?= csrf_field() ?>

              <div class="form-section">
                <h3 class="section-title">Post Content</h3>

                <div class="form-group">
                  <label for="postType" class="field-label">Post Type *</label>
                  <div class="field-container">
                    <select id="postType" name="type">
                      <option value="">Select post type</option>
                      <option value="general">General Discussion</option>
                      <option value="notice">Notice / Announcement</option>
                      <option value="event">Event</option>
                      <option value="business">Local Business</option>
                      <option value="lostfound">Lost & Found</option>
                      <option value="recommendation">Recommendation</option>
                      <option value="question">Question</option>
                      <option value="safety">Safety Alert</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="postTitle" class="field-label">Title</label>
                  <div class="field-container">
                    <input
                      type="text"
                      id="postTitle"
                      name="title"
                      value="<?= e(old('title')) ?>"
                      placeholder="What's happening in your community?"
                    />
                  </div>
                  <p class="field-hint">
                    Clear, engaging title (max 100 characters)
                  </p>
                </div>

                <div class="form-group">
                  <label for="postContent" class="field-label">Content *</label>
                  <div class="field-container textarea-container">
                    <textarea
                      id="postContent"
                      name="content"
                      rows="6"
                      placeholder="Write your post here..."
                      required
                    ><?= e(old('content')) ?></textarea>
                  </div>
                  <p class="field-hint">
                    Share details, ask questions, or start a discussion (max
                    2000 characters)
                  </p>
                </div>

                <div class="form-group">
                  <label class="field-label">Post To</label>
                  <div class="field-container">
                    <select id="postDestination" name="destination">
                      <option value="feed">Main Community Feed</option>
                      <optgroup label="Your Groups">
                        <option value="group-1">
                          Bode Thomas Security Watch
                        </option>
                        <option value="group-2">
                          Surulere Tech Enthusiasts
                        </option>
                        <option value="group-3">
                          Adeniran Market Traders & Buyers
                        </option>
                      </optgroup>
                      <option value="new-group">
                        Create New Group Instead
                      </option>
                    </select>
                  </div>
                  <p class="field-hint">Choose where this post will appear</p>
                </div>
              </div>

              <div class="form-section">
                <h3 class="section-title">Attachments</h3>

                <div class="attachment-options">
                  <label class="attachment-btn">
                    <input
                      type="file"
                      id="postImages"
                      name="media[]"
                      accept="image/*"
                      multiple
                      class="file-input"
                    />
                    <i class="fa-solid fa-image"></i>
                    <span>Add Photos</span>
                  </label>
                  <label class="attachment-btn">
                    <input
                      type="file"
                      id="postVideo"
                      name="video"
                      accept="video/*"
                      class="file-input"
                    />
                    <i class="fa-solid fa-video"></i>
                    <span>Add Video</span>
                  </label>
                  <label class="attachment-btn">
                    <input
                      type="file"
                      id="postDocument"
                      name="document"
                      accept=".pdf,.doc,.docx"
                      class="file-input"
                    />
                    <i class="fa-solid fa-file"></i>
                    <span>Add Document</span>
                  </label>
                </div>

                <div class="media-preview" id="mediaPreview"></div>

                <input type="hidden" name="media_url" id="postMediaUrl" value="" />

                <p class="field-hint">
                  Max 10 images, 1 video (50MB), 3 documents (10MB each)
                </p>
              </div>

              <div class="form-section">
                <h3 class="section-title">Post Settings</h3>

                <div class="setting-group">
                  <div class="setting-info">
                    <h4>Allow Comments</h4>
                    <p>Let neighbors reply to your post</p>
                  </div>
                  <div class="setting-control">
                    <label class="checkbox-option">
                      <input type="checkbox" name="allowComments" value="1" checked />
                      <span class="checkbox-custom"></span>
                      <span>Enable comments</span>
                    </label>
                  </div>
                </div>

                <div class="setting-group">
                  <div class="setting-info">
                    <h4>Anonymous Post</h4>
                    <p>Hide your name from the post (admins still see it)</p>
                  </div>
                  <div class="setting-control">
                    <label class="checkbox-option">
                      <input type="checkbox" name="anonymousPost" value="1" />
                      <span class="checkbox-custom"></span>
                      <span>Post anonymously</span>
                    </label>
                  </div>
                </div>

                <div class="setting-group">
                  <div class="setting-info">
                    <h4>Notify Group Members</h4>
                    <p>Send push notification to group members</p>
                  </div>
                  <div class="setting-control">
                    <label class="checkbox-option">
                      <input type="checkbox" name="notifyMembers" value="1" checked />
                      <span class="checkbox-custom"></span>
                      <span>Send notifications</span>
                    </label>
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <a href="/" class="btn-secondary">Cancel</a>
                <button type="button" class="btn-ghost" id="saveDraft">
                  <i class="fa-solid fa-floppy-disk"></i> Save Draft
                </button>
                <button type="submit" class="btn-primary">
                  <i class="fa-solid fa-paper-plane"></i> Publish Post
                </button>
              </div>
            </form>
          </div>

          <!-- Preview Section -->
          <div class="preview-section" id="previewSection">
            <h2 class="preview-title">Post Preview</h2>
            <article class="post preview-card" id="previewCard">
              <div class="post-header">
                <div class="post-user-info">
                  <div class="post-profile" id="previewProfile">
                    <p class="profile-initials">JD</p>
                  </div>
                  <div class="post-info">
                    <p class="name" id="previewAuthor"><?= e(auth()->user()->name ?? 'John Doe') ?></p>
                    <p class="post-meta" id="previewMeta">
                      Surulere Central &bull; Just now
                    </p>
                  </div>
                </div>
                <span class="post-tag" id="previewTag">General</span>
              </div>
              <div class="post-content">
                <p class="post-text" id="previewText">
                  Start writing to see a preview...
                </p>
                <div class="post-media" id="previewMedia"></div>
              </div>
              <div class="post-actions">
                <button type="button" class="post-action-btn">
                  <i class="fa-regular fa-thumbs-up"></i>
                  <span>0 Likes</span>
                </button>
                <button type="button" class="post-action-btn">
                  <i class="fa-regular fa-comment"></i>
                  <span>0 Comments</span>
                </button>
                <button type="button" class="post-action-btn">
                  <i class="fa-solid fa-share-nodes"></i>
                  <span>Share</span>
                </button>
              </div>
            </article>
          </div>
        </div>

<?php $this->section('scripts'); ?>
<script>
  (function () {
    const postForm = document.getElementById("postForm");
    const postType = document.getElementById("postType");
    const postTitle = document.getElementById("postTitle");
    const postContent = document.getElementById("postContent");
    const anonCheckbox = document.querySelector('input[name="anonymousPost"]');
    const postImages = document.getElementById("postImages");
    const mediaPreview = document.getElementById("mediaPreview");
    const previewTag = document.getElementById("previewTag");
    const previewText = document.getElementById("previewText");
    const previewAuthor = document.getElementById("previewAuthor");
    const previewProfile = document.getElementById("previewProfile");
    const previewMedia = document.getElementById("previewMedia");
    const defaultAuthor = "<?= e(auth()->user()->name ?? 'John Doe') ?>";
    const defaultInitial = "<?= e(strtoupper(substr(auth()->user()->name ?? 'JD', 0, 2))) ?>";

    const typeLabels = {
      "": "General",
      general: "General Discussion",
      notice: "Notice / Announcement",
      event: "Event",
      business: "Local Business",
      lostfound: "Lost & Found",
      recommendation: "Recommendation",
      question: "Question",
      safety: "Safety Alert"
    };

    function escapeHTML(str) {
      return str.replace(/[&<>'"]/g, 
        tag => ({
          '&': '&amp;',
          '<': '&lt;',
          '>': '&gt;',
          "'": '&#39;',
          '"': '&quot;'
        }[tag] || tag)
      );
    }

    function updatePreview() {
      if (!previewTag || !previewText) return;

      // Type
      const selectedType = postType ? postType.value : "";
      previewTag.textContent = typeLabels[selectedType] || "General";

      // Author
      const isAnon = anonCheckbox && anonCheckbox.checked;
      if (previewAuthor) {
        previewAuthor.textContent = isAnon ? "Anonymous Neighbor" : defaultAuthor;
      }
      if (previewProfile) {
        previewProfile.innerHTML = `<p class="profile-initials">${isAnon ? '?' : defaultInitial}</p>`;
      }

      // Text / Content
      const titleVal = postTitle ? postTitle.value.trim() : "";
      const contentVal = postContent ? postContent.value.trim() : "";

      if (titleVal || contentVal) {
        let html = "";
        if (titleVal) {
          html += `<strong style="display:block;font-size:1.05rem;margin-bottom:0.4rem;color:var(--text-primary);">${escapeHTML(titleVal)}</strong>`;
        }
        if (contentVal) {
          html += `<span style="white-space:pre-wrap;color:var(--text-secondary);">${escapeHTML(contentVal)}</span>`;
        }
        previewText.innerHTML = html;
      } else {
        previewText.innerHTML = "Start writing to see a preview...";
      }
    }

    if (postForm) {
      postForm.addEventListener("input", updatePreview);
      postForm.addEventListener("change", updatePreview);
    }

    if (postImages) {
      postImages.addEventListener("change", function () {
        if (!mediaPreview) return;
        mediaPreview.innerHTML = "";
        if (previewMedia) previewMedia.innerHTML = "";

        const files = Array.from(this.files);
        files.slice(0, 4).forEach((file) => {
          const reader = new FileReader();
          reader.onload = function (e) {
            const imgThumb = document.createElement("div");
            imgThumb.className = "media-thumb";
            imgThumb.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width:100%; height:100%; object-fit:cover; border-radius:8px;" />`;
            mediaPreview.appendChild(imgThumb);

            if (previewMedia) {
              const previewImg = document.createElement("img");
              previewImg.src = e.target.result;
              previewImg.style.maxHeight = "240px";
              previewImg.style.borderRadius = "8px";
              previewImg.style.marginTop = "0.5rem";
              previewMedia.appendChild(previewImg);
            }
          };
          reader.readAsDataURL(file);
        });
      });
    }

    updatePreview();
  })();
</script>
<?php $this->endSection(); ?>
