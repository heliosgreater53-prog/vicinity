<?php $this->extend('layouts.main'); ?>

<?php $this->section('container_class'); ?>community-container<?php $this->endSection(); ?>

<?php $this->section('sidebar'); ?>
<aside class="community-sidebar">
  <!-- Back to Main Feed link -->
  <a href="/" class="sidebar-back-link">
    <i class="fa-solid fa-arrow-left"></i> Back to Main Feed
  </a>

  <!-- Community Sidebar Title -->
  <div class="community-sidebar-brand">
    <div class="community-brand-icon">
      <i class="fa-solid fa-people-roof"></i>
    </div>
    <div class="community-brand-text">
      <h3>Communities</h3>
      <p>Surulere Hub</p>
    </div>
  </div>

  <!-- 4 Custom Navigation Items -->
  <a href="#feed" class="tab-nav current" data-tab="feed">
    <i class="fa-solid fa-square-rss"></i> Feed
  </a>
  <a href="#discover" class="tab-nav" data-tab="discover">
    <i class="fa-solid fa-compass"></i> Discover
  </a>
  <a href="#my-groups" class="tab-nav" data-tab="my-groups">
    <i class="fa-solid fa-users"></i> My Groups
    <span class="notif-count">3</span>
  </a>
  <a href="#invitations" class="tab-nav" data-tab="invitations">
    <i class="fa-solid fa-envelope-open-text"></i> Invitations
    <span class="notif-count">2</span>
  </a>

  <a href="/community/create" class="create-post" style="border: none; margin-top: 10px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
    <i class="fa-solid fa-plus"></i> Create Group
  </a>
</aside>
<?php $this->endSection(); ?>

<div class="community-content">
  <!-- 1. FEED TAB -->
  <section id="tab-feed" class="community-tab-pane active">
    <!-- Composer for Community Posts -->
    <div class="composer">
      <div class="composer-upper">
        <div class="composer-profile">
          <p class="profile-initial"><?= strtoupper(substr(user()->name ?? 'JD', 0, 2)) ?></p>
        </div>
        <div class="composer-link">
          <a href="/posts/create">Post an update to your groups...</a>
        </div>
      </div>
      <div class="composer-lower">
        <button class="composer-button">
          <i class="fa-solid fa-image"></i>
          <span>Photo</span>
        </button>
        <button class="composer-button">
          <i class="fa-solid fa-calendar-days"></i>
          <span>Event</span>
        </button>
        <button class="composer-button">
          <i class="fa-solid fa-poll"></i>
          <span>Poll</span>
        </button>
      </div>
    </div>

    <!-- Feed Posts -->
    <div class="posts">
      <?php if (!empty($communityPosts)): ?>
        <?php foreach ($communityPosts as $post): ?>
          <article class="post">
            <div class="post-header">
              <div class="post-user-info">
                <div class="post-profile">
                  <p class="profile-initials"><?= strtoupper(substr($post->user()->name ?? 'U', 0, 2)) ?></p>
                </div>
                <div class="post-info">
                  <p class="name"><?= e($post->user()->name ?? 'Community Member') ?></p>
                  <p class="post-meta"><?= date('M j, Y', strtotime($post->created_at)) ?></p>
                </div>
              </div>
              <div class="post-menu">
                <button class="post-menu-btn" aria-label="Post options">
                  <i class="fa-solid fa-ellipsis"></i>
                </button>
              </div>
            </div>
            <div class="post-content">
              <p class="post-text"><?= nl2br(e($post->content)) ?></p>
            </div>
            <div class="post-actions">
              <button class="post-action-btn">
                <i class="fa-regular fa-thumbs-up"></i>
                <span><?= (int)($post->likes_count ?? 0) ?> Likes</span>
              </button>
              <button class="post-action-btn">
                <i class="fa-regular fa-comment"></i>
                <span><?= (int)($post->comments_count ?? 0) ?> Comments</span>
              </button>
              <button class="post-action-btn">
                <i class="fa-solid fa-share-nodes"></i>
                <span>Share</span>
              </button>
            </div>
          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Post 1 -->
        <article class="post">
          <div class="post-header">
            <div class="post-user-info">
              <div class="post-profile" style="background-color: #2b7a78">
                <p class="profile-initials">BT</p>
              </div>
              <div class="post-info">
                <p class="name">
                  Babatunde Adeleke
                  <span class="community-group-badge">
                    <i class="fa-solid fa-users"></i> Bode Thomas Security Watch
                  </span>
                </p>
                <p class="post-meta">Surulere Central &bull; 1 hour ago</p>
              </div>
            </div>
            <span class="post-tag">Security Update</span>
          </div>
          <div class="post-content">
            <p class="post-text">
              Good evening members. The new solar streetlights on
              Alaka-Bode Thomas connector road are now fully operational.
              Patrol schedules for this week have been posted in the group
              files section. Stay alert and stay safe!
            </p>
          </div>
          <div class="post-actions">
            <button class="post-action-btn">
              <i class="fa-regular fa-thumbs-up"></i>
              <span>34 Likes</span>
            </button>
            <button class="post-action-btn">
              <i class="fa-regular fa-comment"></i>
              <span>12 Comments</span>
            </button>
            <button class="post-action-btn">
              <i class="fa-solid fa-share-nodes"></i>
              <span>Share</span>
            </button>
          </div>
        </article>

        <!-- Post 2 with Image -->
        <article class="post">
          <div class="post-header">
            <div class="post-user-info">
              <div class="post-profile" style="background-color: #e07a5f">
                <p class="profile-initials">KO</p>
              </div>
              <div class="post-info">
                <p class="name">
                  Kehinde Osoba
                  <span class="community-group-badge">
                    <i class="fa-solid fa-users"></i> Surulere Tech Enthusiasts
                  </span>
                </p>
                <p class="post-meta">Adeniran Ogunsanya &bull; 3 hours ago</p>
              </div>
            </div>
            <span class="post-tag">Meetup</span>
          </div>
          <div class="post-content">
            <p class="post-text">
              Recap from our Saturday frontend pair-programming session at
              GreenBite Cafe! We covered modern CSS Grid and state
              management. Huge shoutout to everyone who made it. Next
              workshop is in two weeks! 💻🚀
            </p>
            <div class="post-image">
              <img
                src="https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=1000&q=80"
                alt="Tech Workshop"
              />
            </div>
          </div>
          <div class="post-actions">
            <button class="post-action-btn">
              <i class="fa-regular fa-thumbs-up"></i>
              <span>58 Likes</span>
            </button>
            <button class="post-action-btn">
              <i class="fa-regular fa-comment"></i>
              <span>19 Comments</span>
            </button>
            <button class="post-action-btn">
              <i class="fa-solid fa-share-nodes"></i>
              <span>Share</span>
            </button>
          </div>
        </article>
      <?php endif; ?>
    </div>
  </section>

  <!-- 2. DISCOVER TAB -->
  <section id="tab-discover" class="community-tab-pane">
    <div class="pane-header">
      <h2>Discover Groups</h2>
      <p class="pane-subtitle">
        Find and join active communities tailored to your interests in Surulere
      </p>
    </div>

    <div class="pane-actions">
      <a href="/community/create" class="btn-create-group">
        <i class="fa-solid fa-plus"></i> Create Group
      </a>
    </div>

    <div class="group-grid">
      <?php if (!empty($communities)): ?>
        <?php foreach ($communities as $c): ?>
          <div class="group-card">
            <div class="group-banner">
              <img
                src="<?= e($c->banner ?: 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80') ?>"
                alt="<?= e($c->name) ?>"
              />
              <span class="group-category"><?= e($c->category) ?></span>
            </div>
            <div class="group-card-body">
              <h3 class="group-title"><?= e($c->name) ?></h3>
              <p class="group-meta">
                <i class="fa-solid fa-users"></i> <?= (int)($c->members_count ?? 1) ?> members &bull; <?= e(ucfirst($c->privacy ?? 'public')) ?>
              </p>
              <p class="group-desc">
                <?= e($c->description ?? 'A welcoming neighborhood circle in Surulere.') ?>
              </p>
              <button class="btn-join">
                <i class="fa-solid fa-user-plus"></i> Join Group
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Group 1 -->
        <div class="group-card">
          <div class="group-banner">
            <img
              src="https://images.unsplash.com/photo-1517649763962-0c623266ddc0?auto=format&fit=crop&w=800&q=80"
              alt="Sports"
            />
            <span class="group-category">Sports &amp; Fitness</span>
          </div>
          <div class="group-card-body">
            <h3 class="group-title">Surulere Runners &amp; Fitness Club</h3>
            <p class="group-meta">
              <i class="fa-solid fa-users"></i> 340 members &bull; 15 posts/week
            </p>
            <p class="group-desc">
              Weekend 5K and 10K morning jogs around National Stadium,
              nutrition tips, and fitness challenges.
            </p>
            <button class="btn-join">
              <i class="fa-solid fa-user-plus"></i> Join Group
            </button>
          </div>
        </div>

        <!-- Group 2 -->
        <div class="group-card">
          <div class="group-banner">
            <img
              src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&w=800&q=80"
              alt="Small Business"
            />
            <span class="group-category">Business &amp; Trade</span>
          </div>
          <div class="group-card-body">
            <h3 class="group-title">Surulere Entrepreneurs Network</h3>
            <p class="group-meta">
              <i class="fa-solid fa-users"></i> 512 members &bull; 28 posts/week
            </p>
            <p class="group-desc">
              Collaboration, networking, cross-promotions, and business
              resources for local shop owners and freelancers.
            </p>
            <button class="btn-join">
              <i class="fa-solid fa-user-plus"></i> Join Group
            </button>
          </div>
        </div>

        <!-- Group 3 -->
        <div class="group-card">
          <div class="group-banner">
            <img
              src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?auto=format&fit=crop&w=800&q=80"
              alt="Gardening"
            />
            <span class="group-category">Environment</span>
          </div>
          <div class="group-card-body">
            <h3 class="group-title">Clean &amp; Green Surulere Initiative</h3>
            <p class="group-meta">
              <i class="fa-solid fa-users"></i> 210 members &bull; 8 posts/week
            </p>
            <p class="group-desc">
              Neighborhood tree planting, community drainage clearing
              drives, and urban gardening enthusiasts.
            </p>
            <button class="btn-join">
              <i class="fa-solid fa-user-plus"></i> Join Group
            </button>
          </div>
        </div>

        <!-- Group 4 -->
        <div class="group-card">
          <div class="group-banner">
            <img
              src="https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=800&q=80"
              alt="Book Club"
            />
            <span class="group-category">Arts &amp; Culture</span>
          </div>
          <div class="group-card-body">
            <h3 class="group-title">Surulere Book &amp; Literature Club</h3>
            <p class="group-meta">
              <i class="fa-solid fa-users"></i> 185 members &bull; 6 posts/week
            </p>
            <p class="group-desc">
              Monthly book reviews, African contemporary fiction
              discussions, and creative writing exchange.
            </p>
            <button class="btn-join">
              <i class="fa-solid fa-user-plus"></i> Join Group
            </button>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- 3. MY GROUPS TAB -->
  <section id="tab-my-groups" class="community-tab-pane">
    <div class="pane-header">
      <h2>My Groups</h2>
      <p class="pane-subtitle">Groups you are actively participating in</p>
    </div>

    <div class="pane-actions">
      <a href="/community/create" class="btn-create-group">
        <i class="fa-solid fa-plus"></i> Create Group
      </a>
    </div>

    <div class="my-groups-list">
      <!-- Item 1 -->
      <div class="my-group-item">
        <div class="my-group-icon" style="background-color: #2b7a78">
          <i class="fa-solid fa-shield-halved"></i>
        </div>
        <div class="my-group-info">
          <h4>Bode Thomas Security Watch</h4>
          <p class="my-group-meta">
            <span class="role-badge admin">Admin</span> &bull; 248 Members &bull; Active today
          </p>
          <p class="my-group-preview">
            Last post: "The new solar streetlights are operational..."
          </p>
        </div>
        <button class="btn-open-group">Visit Group</button>
      </div>

      <!-- Item 2 -->
      <div class="my-group-item">
        <div class="my-group-icon" style="background-color: #e07a5f">
          <i class="fa-solid fa-laptop-code"></i>
        </div>
        <div class="my-group-info">
          <h4>Surulere Tech Enthusiasts</h4>
          <p class="my-group-meta">
            <span class="role-badge member">Member</span> &bull; 410 Members &bull; 3 new posts
          </p>
          <p class="my-group-preview">
            Last post: "Recap from our Saturday frontend workshop..."
          </p>
        </div>
        <button class="btn-open-group">Visit Group</button>
      </div>

      <!-- Item 3 -->
      <div class="my-group-item">
        <div class="my-group-icon" style="background-color: #36a036">
          <i class="fa-solid fa-basket-shopping"></i>
        </div>
        <div class="my-group-info">
          <h4>Adeniran Market Traders &amp; Buyers</h4>
          <p class="my-group-meta">
            <span class="role-badge member">Member</span> &bull; 630 Members &bull; Active 2h ago
          </p>
          <p class="my-group-preview">
            Last post: "Fresh organic tomatoes batch arrived this morning..."
          </p>
        </div>
        <button class="btn-open-group">Visit Group</button>
      </div>
    </div>
  </section>

  <!-- 4. INVITATIONS TAB -->
  <section id="tab-invitations" class="community-tab-pane">
    <div class="pane-header">
      <h2>Group Invitations</h2>
      <p class="pane-subtitle">
        Invitations you have received from neighbors and friends
      </p>
    </div>

    <div class="invitations-list">
      <!-- Invitation 1 -->
      <div class="invitation-card">
        <div class="invitation-avatar" style="background-color: #6d597a">
          <i class="fa-solid fa-futbol"></i>
        </div>
        <div class="invitation-body">
          <div class="invitation-header">
            <h4>Surulere Football Fanatics</h4>
            <span class="invitation-time">2 days ago</span>
          </div>
          <p class="invitation-text">
            <strong>Tunde Balogun</strong> invited you to join this group.
          </p>
          <p class="invitation-desc">
            Weekly matches, stadium meetups, Premier League banter, and local tournaments.
          </p>
          <p class="invitation-members">
            <i class="fa-solid fa-user-group"></i> 194 members &bull; 8 mutual connections
          </p>
          <div class="invitation-actions">
            <button class="btn-accept">
              <i class="fa-solid fa-check"></i> Accept Invitation
            </button>
            <button class="btn-decline">Decline</button>
          </div>
        </div>
      </div>

      <!-- Invitation 2 -->
      <div class="invitation-card">
        <div class="invitation-avatar" style="background-color: #e27d60">
          <i class="fa-solid fa-utensils"></i>
        </div>
        <div class="invitation-body">
          <div class="invitation-header">
            <h4>Surulere Foodies &amp; Home Chefs</h4>
            <span class="invitation-time">Yesterday</span>
          </div>
          <p class="invitation-text">
            <strong>Chidinma Okoro</strong> invited you to join this group.
          </p>
          <p class="invitation-desc">
            Sharing secret local recipes, honest restaurant reviews, and
            weekend potlucks across Surulere.
          </p>
          <p class="invitation-members">
            <i class="fa-solid fa-user-group"></i> 325 members &bull; 14 mutual connections
          </p>
          <div class="invitation-actions">
            <button class="btn-accept">
              <i class="fa-solid fa-check"></i> Accept Invitation
            </button>
            <button class="btn-decline">Decline</button>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php $this->section('scripts'); ?>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const tabLinks = document.querySelectorAll(".community-sidebar .tab-nav");
    const tabPanes = document.querySelectorAll(".community-tab-pane");

    tabLinks.forEach((link) => {
      link.addEventListener("click", (e) => {
        e.preventDefault();
        const targetTab = link.getAttribute("data-tab");

        tabLinks.forEach((l) => l.classList.remove("current"));
        link.classList.add("current");

        tabPanes.forEach((pane) => {
          if (pane.id === `tab-${targetTab}`) {
            pane.classList.add("active");
          } else {
            pane.classList.remove("active");
          }
        });

        history.replaceState(null, null, `#${targetTab}`);
      });
    });

    const currentHash = window.location.hash.replace("#", "");
    if (currentHash) {
      const matchingLink = document.querySelector(
        `.community-sidebar .tab-nav[data-tab="${currentHash}"]`
      );
      if (matchingLink) matchingLink.click();
    }
  });
</script>
<?php $this->endSection(); ?>
