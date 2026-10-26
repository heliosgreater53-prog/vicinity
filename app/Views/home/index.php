<?php $this->extend('layouts.main'); ?>

        <div class="feed-content">
          <div class="composer">
            <div class="composer-upper">
              <div class="composer-profile">
                <p class="profile-initial"><?= e(strtoupper(substr(auth()->user()->name ?? 'JD', 0, 2))) ?></p>
              </div>
              <div class="composer-link">
                <a href="/posts/create"> What's happening in your community? </a>
              </div>
            </div>
            <div class="composer-lower">
              <button type="button" class="composer-button" onclick="window.location.href='/posts/create'">
                <i class="fa-solid fa-image"></i>
                <span>Image</span>
              </button>
              <button type="button" class="composer-button" onclick="window.location.href='/posts/create'">
                <i class="fa-solid fa-video"></i>
                <span>Video</span>
              </button>
              <button type="button" class="composer-button" onclick="window.location.href='/events/create'">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Event</span>
              </button>
            </div>
          </div>
          <div class="posts">
            <?php if (!empty($posts)): ?>
              <?php foreach ($posts as $post): ?>
                <article class="post">
                  <div class="post-header">
                    <div class="post-user-info">
                      <div class="post-profile">
                        <p class="profile-initials"><?= e(strtoupper(substr($post->user()->name ?? 'JD', 0, 2))) ?></p>
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
                      <div class="post-menu-dropdown">
                        <a href="#" class="post-menu-item">
                          <i class="fa-solid fa-thumbtack"></i>
                          <span>Pin post</span>
                        </a>
                        <a href="#" class="post-menu-item danger">
                          <i class="fa-solid fa-flag"></i>
                          <span>Report</span>
                        </a>
                      </div>
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
                      <span><?= (int) ($post->likes_count ?? 18) ?> Likes</span>
                    </button>
                    <button class="post-action-btn">
                      <i class="fa-regular fa-comment"></i>
                      <span><?= (int) ($post->comments_count ?? 6) ?> Comments</span>
                    </button>
                    <button class="post-action-btn">
                      <i class="fa-solid fa-share-nodes"></i>
                      <span>Share</span>
                    </button>
                  </div>
                </article>
              <?php endforeach; ?>
            <?php else: ?>
              <!-- Post 1: Notice / Announcement -->
              <article class="post">
                <div class="post-header">
                  <div class="post-user-info">
                    <div class="post-profile">
                      <p class="profile-initials">AC</p>
                    </div>
                    <div class="post-info">
                      <p class="name">Adekunle Charles</p>
                      <p class="post-meta">Surulere Central &bull; 2 hours ago</p>
                    </div>
                  </div>
                  <div class="post-menu">
                    <button class="post-menu-btn" aria-label="Post options">
                      <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <div class="post-menu-dropdown">
                      <a href="#" class="post-menu-item">
                        <i class="fa-solid fa-thumbtack"></i>
                        <span>Pin post</span>
                      </a>
                      <a href="#" class="post-menu-item danger">
                        <i class="fa-solid fa-flag"></i>
                        <span>Report</span>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="post-content">
                  <p class="post-text">
                    Community Announcement: There will be routine maintenance on
                    the main water supply pipeline along Ogunlana Drive tomorrow
                    between 9:00 AM and 2:00 PM. Please store adequate water for
                    your households beforehand!
                  </p>
                </div>
                <div class="post-actions">
                  <button class="post-action-btn">
                    <i class="fa-regular fa-thumbs-up"></i>
                    <span>18 Likes</span>
                  </button>
                  <button class="post-action-btn">
                    <i class="fa-regular fa-comment"></i>
                    <span>6 Comments</span>
                  </button>
                  <button class="post-action-btn">
                    <i class="fa-solid fa-share-nodes"></i>
                    <span>Share</span>
                  </button>
                </div>
              </article>

              <!-- Post 2: Local Business with Image -->
              <article class="post">
                <div class="post-header">
                  <div class="post-user-info">
                    <div class="post-profile" style="background-color: #2b7a78">
                      <p class="profile-initials">CO</p>
                    </div>
                    <div class="post-info">
                      <p class="name">Chidinma Okoro</p>
                      <p class="post-meta">
                        Adeniran Ogunsanya &bull; 4 hours ago
                      </p>
                    </div>
                  </div>
                  <div class="post-menu">
                    <button class="post-menu-btn" aria-label="Post options">
                      <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <div class="post-menu-dropdown">
                      <a href="#" class="post-menu-item">
                        <i class="fa-solid fa-thumbtack"></i>
                        <span>Pin post</span>
                      </a>
                      <a href="#" class="post-menu-item danger">
                        <i class="fa-solid fa-flag"></i>
                        <span>Report</span>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="post-content">
                  <p class="post-text">
                    Just stopped by the newly opened GreenBite Cafe on Adeniran
                    Ogunsanya! Warm ambiance, fast Wi-Fi, and their fresh pastries
                    are fantastic. Great new spot for remote work and quick
                    meetings in the neighborhood. ☕🥐
                  </p>
                  <div class="post-image">
                    <img
                      src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=1000&q=80"
                      alt="GreenBite Cafe Interior"
                    />
                  </div>
                </div>
                <div class="post-actions">
                  <button class="post-action-btn">
                    <i class="fa-regular fa-thumbs-up"></i>
                    <span>42 Likes</span>
                  </button>
                  <button class="post-action-btn">
                    <i class="fa-regular fa-comment"></i>
                    <span>14 Comments</span>
                  </button>
                  <button class="post-action-btn">
                    <i class="fa-solid fa-share-nodes"></i>
                    <span>Share</span>
                  </button>
                </div>
              </article>

              <!-- Post 3: Community Event -->
              <article class="post">
                <div class="post-header">
                  <div class="post-user-info">
                    <div class="post-profile" style="background-color: #e07a5f">
                      <p class="profile-initials">TB</p>
                    </div>
                    <div class="post-info">
                      <p class="name">Tunde Balogun</p>
                      <p class="post-meta">Stadium Road &bull; 6 hours ago</p>
                    </div>
                  </div>
                  <div class="post-menu">
                    <button class="post-menu-btn" aria-label="Post options">
                      <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <div class="post-menu-dropdown">
                      <a href="#" class="post-menu-item">
                        <i class="fa-solid fa-thumbtack"></i>
                        <span>Pin post</span>
                      </a>
                      <a href="#" class="post-menu-item danger">
                        <i class="fa-solid fa-flag"></i>
                        <span>Report</span>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="post-content">
                  <p class="post-text">
                    ⚽ Surulere Youth Football Tournament kicks off this Saturday
                    at the National Stadium Practice Pitch! Come out with family
                    and friends to cheer on our local street teams. Admission is
                    free for everyone. Let's support our local talents!
                  </p>
                </div>
                <div class="post-actions">
                  <button class="post-action-btn">
                    <i class="fa-regular fa-thumbs-up"></i>
                    <span>65 Likes</span>
                  </button>
                  <button class="post-action-btn">
                    <i class="fa-regular fa-comment"></i>
                    <span>21 Comments</span>
                  </button>
                  <button class="post-action-btn">
                    <i class="fa-solid fa-share-nodes"></i>
                    <span>Share</span>
                  </button>
                </div>
              </article>

              <!-- Post 4: Lost & Found -->
              <article class="post">
                <div class="post-header">
                  <div class="post-user-info">
                    <div class="post-profile" style="background-color: #6d597a">
                      <p class="profile-initials">FA</p>
                    </div>
                    <div class="post-info">
                      <p class="name">Fatima Al-Hassan</p>
                      <p class="post-meta">Bode Thomas &bull; Yesterday</p>
                    </div>
                  </div>
                  <div class="post-menu">
                    <button class="post-menu-btn" aria-label="Post options">
                      <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <div class="post-menu-dropdown">
                      <a href="#" class="post-menu-item">
                        <i class="fa-solid fa-thumbtack"></i>
                        <span>Pin post</span>
                      </a>
                      <a href="#" class="post-menu-item danger">
                        <i class="fa-solid fa-flag"></i>
                        <span>Report</span>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="post-content">
                  <p class="post-text">
                    Found a brown leather wallet with a student ID card near the
                    bus stop outside Leisure Mall earlier today. If you or someone
                    you know lost one, please leave a comment or message me with
                    the name on the ID to claim it.
                  </p>
                </div>
                <div class="post-actions">
                  <button class="post-action-btn">
                    <i class="fa-regular fa-thumbs-up"></i>
                    <span>29 Likes</span>
                  </button>
                  <button class="post-action-btn">
                    <i class="fa-regular fa-comment"></i>
                    <span>11 Comments</span>
                  </button>
                  <button class="post-action-btn">
                    <i class="fa-solid fa-share-nodes"></i>
                    <span>Share</span>
                  </button>
                </div>
              </article>
            <?php endif; ?>
          </div>
        </div>
