<?php $this->extend('layouts.main'); ?>

<?php $this->section('container_class'); ?>community-container<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<style>
/* ── Group Pane Overlay ──────────────────────────────────────────── */
.group-pane-overlay {
  position: fixed;
  inset: 0;
  background: var(--bg);
  z-index: 400;
  overflow-y: auto;
  animation: paneFadeIn .2s var(--ease-out);
}
@keyframes paneFadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to   { opacity: 1; transform: translateY(0); }
}
.group-pane {
  max-width: 1200px;
  margin: 0 auto;
  padding: 1.5rem 1.5rem 3rem;
}
.group-pane-close {
  display: inline-flex;
  align-items: center;
  gap: .5rem;
  background: none;
  border: none;
  color: var(--accent);
  font-size: .95rem;
  font-weight: 600;
  cursor: pointer;
  padding: .5rem .75rem;
  border-radius: var(--r-md);
  margin-bottom: 1.25rem;
  transition: background .15s;
}
.group-pane-close:hover { background: var(--accent-light); }
.group-pane-body {
  display: grid;
  grid-template-columns: 320px 1fr;
  gap: 1.25rem;
  align-items: start;
}
@media (max-width: 768px) {
  .group-pane-body { grid-template-columns: 1fr; }
}
.group-card-panel {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--r-xl);
  box-shadow: var(--shadow-sm);
  overflow: hidden;
  display: flex;
  flex-direction: column;
}
.group-panel-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  padding: 1.25rem 1.25rem .75rem;
  border-bottom: 1px solid var(--border-light);
  gap: .75rem;
}
.group-panel-title {
  font-size: 1.1rem;
  font-weight: 700;
  color: var(--text-1);
  margin: 0 0 .15rem;
}
.group-panel-sub {
  font-size: .78rem;
  color: var(--accent);
  font-weight: 600;
  margin: 0;
  text-transform: uppercase;
  letter-spacing: .05em;
}
.group-panel-desc {
  font-size: .85rem;
  color: var(--text-2);
  padding: .75rem 1.25rem .5rem;
  margin: 0;
  line-height: 1.5;
  border-bottom: 1px solid var(--border-light);
}
.group-member-count {
  font-size: .78rem;
  background: var(--accent-light);
  color: var(--accent);
  font-weight: 700;
  padding: .2rem .6rem;
  border-radius: var(--r-full);
  white-space: nowrap;
  flex-shrink: 0;
}
.chat-live-dot {
  font-size: .78rem;
  color: var(--text-2);
  display: flex;
  align-items: center;
  gap: .35rem;
}
/* Members */
.members-list {
  padding: .5rem .75rem;
  display: flex;
  flex-direction: column;
  gap: .2rem;
  max-height: calc(100vh - 320px);
  overflow-y: auto;
}
.members-loading {
  text-align: center;
  padding: 1.5rem;
  color: var(--text-3);
}
.member-row {
  display: flex;
  align-items: center;
  gap: .75rem;
  padding: .55rem .5rem;
  border-radius: var(--r-md);
  transition: background .12s;
}
.member-row:hover { background: var(--surface-2); }
.member-avatar {
  position: relative;
  width: 38px;
  height: 38px;
  flex-shrink: 0;
}
.member-initials {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  background: var(--accent-light);
  color: var(--accent-dark);
  font-size: .75rem;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
}
.member-online-dot {
  position: absolute;
  bottom: 1px;
  right: 1px;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  border: 2px solid var(--surface);
}
.member-online-dot.online  { background: #22c55e; }
.member-online-dot.offline { background: var(--border); }
.member-info { flex: 1; min-width: 0; }
.member-name {
  font-size: .88rem;
  font-weight: 600;
  color: var(--text-1);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.role-pill {
  font-size: .68rem;
  font-weight: 700;
  padding: .15rem .45rem;
  border-radius: var(--r-full);
  text-transform: uppercase;
  letter-spacing: .05em;
  flex-shrink: 0;
}
.role-pill.admin     { background: hsl(36,90%,93%); color: hsl(36,80%,35%); }
.role-pill.moderator { background: var(--info-light); color: var(--info); }
.role-pill.member    { background: var(--surface-3); color: var(--text-3); }
/* Chat */
.group-chat-panel {
  height: calc(100vh - 180px);
  min-height: 480px;
}
.chat-messages {
  flex: 1;
  overflow-y: auto;
  padding: 1rem 1.25rem;
  display: flex;
  flex-direction: column;
  gap: .75rem;
  scroll-behavior: smooth;
}
.chat-empty {
  text-align: center;
  color: var(--text-3);
  font-size: .88rem;
  padding: 2rem;
  margin: auto;
}
.chat-bubble-wrap {
  display: flex;
  align-items: flex-end;
  gap: .6rem;
}
.chat-bubble-wrap.mine { flex-direction: row-reverse; }
.chat-bubble-avatar {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background: var(--accent-light);
  color: var(--accent-dark);
  font-size: .68rem;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.chat-bubble-col { max-width: 70%; }
.chat-bubble-col.mine { align-items: flex-end; display: flex; flex-direction: column; }
.chat-name {
  font-size: .7rem;
  color: var(--text-3);
  margin-bottom: .2rem;
  padding: 0 .25rem;
}
.chat-bubble {
  background: var(--surface-2);
  color: var(--text-1);
  padding: .6rem .9rem;
  border-radius: 18px 18px 18px 4px;
  font-size: .88rem;
  line-height: 1.5;
  word-break: break-word;
  box-shadow: var(--shadow-xs);
}
.chat-bubble.mine {
  background: var(--accent);
  color: #fff;
  border-radius: 18px 18px 4px 18px;
}
.chat-bubble-time {
  font-size: .65rem;
  color: var(--text-3);
  margin-top: .2rem;
  padding: 0 .25rem;
}
.chat-composer {
  display: flex;
  gap: .5rem;
  padding: .75rem 1rem;
  border-top: 1px solid var(--border-light);
  background: var(--surface);
}
.chat-input {
  flex: 1;
  border: 1.5px solid var(--border);
  border-radius: var(--r-full);
  padding: .6rem 1rem;
  font-size: .9rem;
  background: var(--surface-2);
  color: var(--text-1);
  outline: none;
  transition: border-color .15s;
  font-family: inherit;
}
.chat-input:focus { border-color: var(--accent); background: var(--surface); }
.chat-send-btn {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: none;
  background: var(--accent);
  color: #fff;
  font-size: .95rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  transition: background .15s, transform .1s;
}
.chat-send-btn:hover  { background: var(--accent-dark); }
.chat-send-btn:active { transform: scale(.93); }
.chat-send-btn:disabled { opacity: .5; cursor: not-allowed; }
/* Dynamic my-groups items */
.my-group-item { cursor: pointer; transition: background .12s; }
.my-group-item:hover { background: var(--surface-2); border-radius: var(--r-md); }
.groups-loading { color: var(--text-3); font-size: .88rem; padding: 1rem .5rem; }
</style>
<?php $this->endSection(); ?>

<?php $this->section('sidebar'); ?>
<aside class="community-sidebar">
  <!-- Back to Main Feed link -->
  <a href="/home" class="sidebar-back-link">
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
          <?php $postAuthor = $post->user(); ?>
          <?php $postGroup  = $post->community(); ?>
          <article class="post">
            <div class="post-header">
              <div class="post-user-info">
                <div class="post-profile">
                  <p class="profile-initials"><?= strtoupper(substr($postAuthor->name ?? 'U', 0, 2)) ?></p>
                </div>
                <div class="post-info">
                  <p class="name">
                    <?= e($postAuthor->name ?? 'Community Member') ?>
                    <?php if ($postGroup): ?>
                      <span class="community-group-badge">
                        <i class="fa-solid fa-users"></i> <?= e($postGroup->name) ?>
                      </span>
                    <?php endif; ?>
                  </p>
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
              <?php if (!empty($post->media_url)): ?>
                <div class="post-image">
                  <img src="<?= e($post->media_url) ?>" alt="Post image" />
                </div>
              <?php endif; ?>
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

    <div class="my-groups-list" id="myGroupsList">
      <div class="groups-loading" id="groupsLoading">
        <i class="fa-solid fa-spinner fa-spin"></i> Loading your groups...
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

<!-- ── Group Page Pane (dynamic overlay, no reload) ──────────────── -->
<div class="group-pane-overlay" id="groupPaneOverlay" style="display:none;" aria-hidden="true">
  <div class="group-pane">
    <button class="group-pane-close" id="closePaneBtn" aria-label="Back to communities">
      <i class="fa-solid fa-arrow-left"></i> Back to Communities
    </button>

    <div class="group-pane-body">
      <!-- LEFT CARD: Group info + Members -->
      <div class="group-card-panel group-members-panel">
        <div class="group-panel-header">
          <div style="min-width:0;">
            <h2 class="group-panel-title" id="panelGroupName">Group</h2>
            <p class="group-panel-sub"  id="panelGroupCategory"></p>
          </div>
          <span class="group-member-count" id="panelMemberCount"></span>
        </div>
        <p class="group-panel-desc" id="panelGroupDesc"></p>
        <div class="members-list" id="panelMembersList">
          <div class="members-loading"><i class="fa-solid fa-spinner fa-spin"></i></div>
        </div>
      </div>

      <!-- RIGHT CARD: Chat -->
      <div class="group-card-panel group-chat-panel">
        <div class="group-panel-header">
          <h2 class="group-panel-title">Group Chat</h2>
          <span class="chat-live-dot">
            <i class="fa-solid fa-circle" style="color:var(--accent);font-size:.5rem;"></i> Live
          </span>
        </div>
        <div class="chat-messages" id="chatMessages">
          <div class="chat-empty">No messages yet. Be the first to say hello! 👋</div>
        </div>
        <div class="chat-composer">
          <input
            type="text"
            class="chat-input"
            id="chatInput"
            placeholder="Write a message..."
            autocomplete="off"
            maxlength="1000"
          />
          <button class="chat-send-btn" id="chatSendBtn" aria-label="Send">
            <i class="fa-solid fa-paper-plane"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
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

  // ── Group Pane / Chatroom ──────────────────────────────────────────
  (function () {
    const overlay      = document.getElementById('groupPaneOverlay');
    const closeBtn     = document.getElementById('closePaneBtn');
    const panelName    = document.getElementById('panelGroupName');
    const panelCat     = document.getElementById('panelGroupCategory');
    const panelDesc    = document.getElementById('panelGroupDesc');
    const panelCount   = document.getElementById('panelMemberCount');
    const membersList  = document.getElementById('panelMembersList');
    const chatMessages = document.getElementById('chatMessages');
    const chatInput    = document.getElementById('chatInput');
    const sendBtn      = document.getElementById('chatSendBtn');
    const myGroupsList = document.getElementById('myGroupsList');

    let currentGroupId  = null;
    let lastMessageId   = 0;
    let pollTimer       = null;
    let memberTimer     = null;
    let heartTimer      = null;
    const meId          = <?= (int)(auth()->id() ?? 0) ?>;
    const csrfToken     = '<?= csrf_token() ?>';

    // ── Utility ────────────────────────────────────────────────────────
    function esc(s) {
      return String(s).replace(/[&<>"']/g, c =>
        ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])
      );
    }
    function cap(s) { return s ? s.charAt(0).toUpperCase() + s.slice(1) : ''; }

    // ── Load My Groups ─────────────────────────────────────────────────
    async function loadMyGroups() {
      try {
        const res  = await fetch('/api/groups/mine', { credentials: 'same-origin' });
        const data = await res.json();
        if (!myGroupsList) return;

        if (!Array.isArray(data) || data.length === 0) {
          myGroupsList.innerHTML = '<p style="color:var(--text-3);font-size:.88rem;padding:.75rem .5rem;">No groups yet. <a href="/community/create" style="color:var(--accent);">Create one!</a></p>';
          return;
        }

        const colors = ['#2b7a78','#e07a5f','#36a036','#6d597a','#e27d60','#1a6b8a'];
        myGroupsList.innerHTML = data.map((g, i) => `
          <div class="my-group-item" style="display:flex;align-items:center;gap:.75rem;padding:.7rem .5rem;border-radius:var(--r-md);" data-gid="${g.id}">
            <div class="my-group-icon" style="background-color:${colors[i % colors.length]};width:42px;height:42px;border-radius:var(--r-md);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1rem;flex-shrink:0;">
              <i class="fa-solid fa-users"></i>
            </div>
            <div class="my-group-info" style="flex:1;min-width:0;">
              <h4 style="font-size:.9rem;font-weight:600;margin:0 0 .15rem;color:var(--text-1);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${esc(g.name)}</h4>
              <p style="font-size:.75rem;color:var(--text-3);margin:0;">
                <span class="role-pill ${g.role || 'member'}">${cap(g.role || 'member')}</span>
                &bull; ${parseInt(g.members_count) || 1} members
              </p>
            </div>
            <button class="btn-open-group" data-gid="${g.id}" style="font-size:.78rem;padding:.4rem .85rem;">Visit Group</button>
          </div>
        `).join('');

        myGroupsList.querySelectorAll('[data-gid]').forEach(el => {
          el.addEventListener('click', e => {
            const gid = e.currentTarget.dataset.gid || e.target.closest('[data-gid]')?.dataset.gid;
            if (gid) openGroup(gid);
          });
        });
      } catch (err) {
        console.warn('loadMyGroups error', err);
        if (myGroupsList) myGroupsList.innerHTML = '<p style="color:var(--text-3);font-size:.88rem;padding:.75rem .5rem;">Could not load groups.</p>';
      }
    }

    // ── Open Group Pane ────────────────────────────────────────────────
    async function openGroup(gid) {
      currentGroupId = gid;
      lastMessageId  = 0;

      overlay.style.display = 'block';
      overlay.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      overlay.scrollTop = 0;

      panelName.textContent  = 'Loading…';
      panelCat.textContent   = '';
      panelDesc.textContent  = '';
      panelCount.textContent = '';
      membersList.innerHTML  = '<div class="members-loading"><i class="fa-solid fa-spinner fa-spin"></i></div>';
      chatMessages.innerHTML = '<div class="chat-empty"><i class="fa-solid fa-spinner fa-spin"></i> Loading…</div>';

      // Group info
      try {
        const r = await fetch(`/api/groups/${gid}`, { credentials: 'same-origin' });
        const g = await r.json();
        panelName.textContent  = g.name        || 'Group';
        panelCat.textContent   = g.category    || '';
        panelDesc.textContent  = g.description || '';
        panelCount.textContent = (g.members_count || 0) + ' members';
      } catch(e) {}

      await loadMembers(gid);
      await loadMessages(gid, true);

      clearTimers();
      pollTimer  = setInterval(() => loadMessages(gid, false), 3000);
      memberTimer= setInterval(() => loadMembers(gid), 15000);
      heartTimer = setInterval(heartbeat, 25000);
      heartbeat();
    }

    function clearTimers() {
      clearInterval(pollTimer);
      clearInterval(memberTimer);
      clearInterval(heartTimer);
    }

    // ── Close pane ─────────────────────────────────────────────────────
    closeBtn.addEventListener('click', () => {
      overlay.style.display = 'none';
      overlay.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
      clearTimers();
      currentGroupId = null;
    });
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape' && overlay.style.display !== 'none') closeBtn.click();
    });

    // ── Members ────────────────────────────────────────────────────────
    async function loadMembers(gid) {
      try {
        const r    = await fetch(`/api/groups/${gid}/members`, { credentials: 'same-origin' });
        const data = await r.json();
        if (!Array.isArray(data)) return;

        membersList.innerHTML = data.length === 0
          ? '<p style="color:var(--text-3);font-size:.85rem;text-align:center;padding:1rem;">No members yet.</p>'
          : data.map(m => `
            <div class="member-row">
              <div class="member-avatar">
                <div class="member-initials">${esc(m.initials)}</div>
                <span class="member-online-dot ${m.is_online ? 'online' : 'offline'}" title="${m.is_online ? 'Online' : 'Offline'}"></span>
              </div>
              <div class="member-info">
                <div class="member-name">${esc(m.name)}</div>
              </div>
              <span class="role-pill ${m.role}">${cap(m.role)}</span>
            </div>
          `).join('');
      } catch(e) {}
    }

    // ── Messages ───────────────────────────────────────────────────────
    function isNearBottom() {
      const el = chatMessages;
      return el.scrollHeight - el.scrollTop - el.clientHeight < 80;
    }

    async function loadMessages(gid, full) {
      try {
        const url  = full
          ? `/api/groups/${gid}/messages`
          : `/api/groups/${gid}/messages?since=${lastMessageId}`;
        const r    = await fetch(url, { credentials: 'same-origin' });
        const data = await r.json();
        if (!Array.isArray(data) || data.length === 0) return;

        const bottom = isNearBottom();
        if (full) chatMessages.innerHTML = '';
        const empty = chatMessages.querySelector('.chat-empty');
        if (empty) empty.remove();

        data.forEach(msg => {
          if (msg.id > lastMessageId) lastMessageId = msg.id;
          const mine = msg.user_id == meId;
          const wrap = document.createElement('div');
          wrap.className = 'chat-bubble-wrap' + (mine ? ' mine' : '');
          wrap.innerHTML = `
            <div class="chat-bubble-avatar">${esc(msg.initials)}</div>
            <div class="chat-bubble-col${mine ? ' mine' : ''}">
              ${!mine ? `<div class="chat-name">${esc(msg.name)}</div>` : ''}
              <div class="chat-bubble${mine ? ' mine' : ''}">${esc(msg.message)}</div>
              <div class="chat-bubble-time">${esc(msg.time_ago)}</div>
            </div>
          `;
          chatMessages.appendChild(wrap);
        });

        if (full || bottom) chatMessages.scrollTop = chatMessages.scrollHeight;
      } catch(e) {}
    }

    // ── Send message ───────────────────────────────────────────────────
    async function doSend() {
      const text = chatInput.value.trim();
      if (!text || !currentGroupId) return;
      chatInput.value  = '';
      sendBtn.disabled = true;
      try {
        const r = await fetch(`/api/groups/${currentGroupId}/messages`, {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': csrfToken,
          },
          body: `message=${encodeURIComponent(text)}&_csrf_token=${encodeURIComponent(csrfToken)}`,
        });
        const msg = await r.json();
        if (msg.id) {
          if (msg.id > lastMessageId) lastMessageId = msg.id;
          const empty = chatMessages.querySelector('.chat-empty');
          if (empty) empty.remove();
          const wrap = document.createElement('div');
          wrap.className = 'chat-bubble-wrap mine';
          wrap.innerHTML = `
            <div class="chat-bubble-avatar">${esc(msg.initials)}</div>
            <div class="chat-bubble-col mine">
              <div class="chat-bubble mine">${esc(msg.message)}</div>
              <div class="chat-bubble-time">${esc(msg.time_ago)}</div>
            </div>
          `;
          chatMessages.appendChild(wrap);
          chatMessages.scrollTop = chatMessages.scrollHeight;
        }
      } catch(e) {}
      sendBtn.disabled = false;
      chatInput.focus();
    }

    sendBtn.addEventListener('click', doSend);
    chatInput.addEventListener('keydown', e => {
      if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); doSend(); }
    });

    // ── Heartbeat ──────────────────────────────────────────────────────
    async function heartbeat() {
      try {
        await fetch('/api/groups/heartbeat', {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': csrfToken,
          },
          body: `_csrf_token=${encodeURIComponent(csrfToken)}`,
        });
      } catch(e) {}
    }

    // ── Boot ───────────────────────────────────────────────────────────
    loadMyGroups();
  })();
</script>
<?php $this->endSection(); ?>
