<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= e($title ?? 'Vicinity – Your Community Connected') ?></title>
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
    <?= $this->yield('styles') ?>
  </head>
  <body>
    <?php $currentUri = request()->uri(); ?>
    <!-- Flash Messages -->
    <?php if ($success = session()->getFlash('success')): ?>
      <div style="position:fixed;top:1rem;right:1rem;z-index:9999;background:hsl(140,62%,35%);color:#fff;padding:.85rem 1.4rem;border-radius:10px;font-weight:600;box-shadow:0 8px 24px rgba(0,0,0,0.2);display:flex;align-items:center;gap:.75rem;animation:fadeIn 0.3s ease;">
        <i class="fa-solid fa-circle-check"></i>
        <span><?= e($success) ?></span>
      </div>
    <?php endif; ?>

    <?php if ($error = session()->getFlash('error')): ?>
      <div style="position:fixed;top:1rem;right:1rem;z-index:9999;background:hsl(0,72%,45%);color:#fff;padding:.85rem 1.4rem;border-radius:10px;font-weight:600;box-shadow:0 8px 24px rgba(0,0,0,0.2);display:flex;align-items:center;gap:.75rem;animation:fadeIn 0.3s ease;">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <span><?= e($error) ?></span>
      </div>
    <?php endif; ?>

    <header>
      <div class="header-top">
        <div class="logo">
          <button class="mobile-menu-btn" id="mobileMenuToggle" aria-label="Open menu" style="display:none;background:none;border:none;color:inherit;font-size:1.25rem;cursor:pointer;margin-right:0.5rem;">
            <i class="fa-solid fa-bars"></i>
          </button>
          <div class="logo-img">
            <i class="fa-solid fa-users"></i>
          </div>
          <div class="logo-text">
            <h2><a href="/">Vicinity</a></h2>
          </div>
        </div>
        <div class="header-right">
          <div class="create-wrapper">
            <button
              class="create-btn"
              id="createToggle"
              aria-label="Create"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <i class="fa-solid fa-plus plus-icon"></i>
              <span>Create</span>
              <i class="fa-solid fa-chevron-down chevron"></i>
            </button>
            <div class="create-dropdown" id="createDropdown" role="menu">
              <span class="create-section-label">Create</span>
              <a href="/posts/create" class="create-item" role="menuitem">
                <i class="fa-solid fa-pen"></i>
                <span>Post</span>
              </a>
              <a href="/events/create" class="create-item" role="menuitem">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Event</span>
              </a>
              <a href="/businesses/create" class="create-item" role="menuitem">
                <i class="fa-solid fa-store"></i>
                <span>Business</span>
              </a>
              <div class="create-divider"></div>
              <a href="/community/create" class="create-item" role="menuitem">
                <i class="fa-solid fa-people-roof"></i>
                <span>Community</span>
              </a>
            </div>
          </div>
          <button
            class="messenger-btn"
            id="messengerToggle"
            aria-label="Messenger"
            title="Messenger"
          >
            <i class="fa-solid fa-comment-dots"></i>
            <span class="msg-badge"></span>
          </button>
          <a href="/notifications" class="notification-btn" aria-label="Notifications" style="text-decoration:none;">
            <i class="fa-regular fa-bell"><span class="notification-dot"></span></i>
          </a>
          <div class="account-wrapper">
            <button
              class="account-profile"
              id="accountToggle"
              aria-label="Account menu"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <?php $currentUser = user(); ?>
              <p class="profile-initial"><?= strtoupper(substr($currentUser->name ?? 'John Doe', 0, 2)) ?></p>
              <p class="profile-name"><?= e($currentUser->name ?? 'John Doe') ?></p>
              <i class="fa-solid fa-chevron-down acc-chevron"></i>
            </button>
            <div class="account-dropdown" id="accountDropdown" role="menu">
              <div class="acc-user">
                <div class="acc-avatar"><?= strtoupper(substr($currentUser->name ?? 'John Doe', 0, 2)) ?></div>
                <div>
                  <div class="acc-name"><?= e($currentUser->name ?? 'John Doe') ?></div>
                  <div class="acc-email"><?= e($currentUser->email ?? 'john.doe@example.com') ?></div>
                </div>
              </div>
              <a
                href="/notifications"
                class="acc-item notifications"
                role="menuitem"
              >
                <i class="fa-solid fa-bell"></i>
                <span>Notifications</span>
                <span class="notif-count">2</span>
              </a>
              <a href="/settings" class="acc-item" role="menuitem">
                <i class="fa-solid fa-gear"></i>
                <span>Settings</span>
              </a>
              <div class="acc-divider"></div>
              <?php if (auth()->check()): ?>
                <a href="/logout" class="acc-item danger" role="menuitem">
                  <i class="fa-solid fa-arrow-right-from-bracket"></i>
                  <span>Logout</span>
                </a>
              <?php else: ?>
                <a href="/login" class="acc-item" role="menuitem">
                  <i class="fa-solid fa-arrow-right-to-bracket"></i>
                  <span>Sign In</span>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="header-bottom">
        <form action="/businesses" method="GET" class="header-search">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" name="q" placeholder="Search businesses, events, posts..." value="<?= e(request('q', '')) ?>" />
          <p class="kbd-shortcut">/</p>
        </form>
      </div>
    </header>

    <main>
      <?php if ($this->yield('sidebar')): ?>
        <?= $this->yield('sidebar') ?>
      <?php else: ?>
      <aside>
        <div class="LGA">
          <div class="LGA-icon">
            <i class="fa-solid fa-location-dot"></i>
          </div>
          <div class="LGA-info">
            <p class="LGA-title">My Community</p>
            <p class="LGA-name">Surulere LGA, Lagos State</p>
          </div>
        </div>
        <?php $currentUri = request()->uri(); ?>
        <a href="/" class="<?= $currentUri === '/' ? 'current' : '' ?>">
          <i class="fa-solid fa-home"></i>Home
        </a>
        <a href="/businesses" class="<?= str_starts_with($currentUri, '/businesses') ? 'current' : '' ?>">
          <i class="fa-solid fa-store"></i>Business
        </a>
        <a href="/community" class="<?= str_starts_with($currentUri, '/community') ? 'current' : '' ?>">
          <i class="fa-solid fa-people-roof"></i>Communities
        </a>
        <a href="/events" class="<?= str_starts_with($currentUri, '/events') ? 'current' : '' ?>">
          <i class="fa-solid fa-calendar-days"></i>Events
        </a>
        <a href="/saved" class="<?= $currentUri === '/saved' ? 'current' : '' ?>">
          <i class="fa-solid fa-bookmark"></i>Saved
        </a>
        <a href="/settings" class="<?= $currentUri === '/settings' ? 'current' : '' ?>">
          <i class="fa-solid fa-gear"></i>Settings
        </a>
        <a href="/notifications" class="<?= $currentUri === '/notifications' ? 'current' : '' ?>">
          <i class="fa-solid fa-bell"></i>Notifications
          <span class="notif-count">2</span>
        </a>
        <a href="/about" class="<?= $currentUri === '/about' ? 'current' : '' ?>">
          <i class="fa-solid fa-info-circle"></i>About Vicinity
        </a>
        <a href="/posts/create" class="create-post">
          <i class="fa-solid fa-leaf"></i>Create Post
        </a>
      </aside>
      <?php endif; ?>

      <!-- Main Page Content Injected Here -->
      <div class="main-container<?= $this->yield('container_class') ? ' ' . $this->yield('container_class') : '' ?>">
        <?= $this->yield('content') ?>
      </div>

      <!-- Floating Bottom Nav for Mobile -->
      <nav class="floating-nav">
        <a href="/" class="nav-item <?= $currentUri === '/' ? 'active' : '' ?>">
          <i class="fa-solid fa-home"></i>
          <span>Home</span>
        </a>
        <a href="/businesses" class="nav-item <?= str_starts_with($currentUri, '/businesses') ? 'active' : '' ?>">
          <i class="fa-solid fa-store"></i>
          <span>Business</span>
        </a>
        <a href="/community" class="nav-item <?= str_starts_with($currentUri, '/community') ? 'active' : '' ?>">
          <i class="fa-solid fa-people-roof"></i>
          <span>Community</span>
        </a>
        <a href="/events" class="nav-item <?= str_starts_with($currentUri, '/events') ? 'active' : '' ?>">
          <i class="fa-solid fa-calendar-days"></i>
          <span>Event</span>
        </a>
        <a href="/saved" class="nav-item <?= $currentUri === '/saved' ? 'active' : '' ?>">
          <i class="fa-solid fa-bookmark"></i>
          <span>Saved</span>
        </a>
      </nav>
    </main>

    <!-- Mobile Sidebar -->
    <aside class="mobile-sidebar">
      <div class="sidebar-overlay"></div>
      <div class="sidebar-header">
        <div class="logo">
          <div class="logo-img">
            <i class="fa-solid fa-users"></i>
          </div>
          <div class="logo-text">
            <h2>Vicinity</h2>
          </div>
        </div>
        <button class="sidebar-close" id="sidebarClose">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <div class="sidebar-content">
        <div class="LGA">
          <div class="LGA-icon">
            <i class="fa-solid fa-location-dot"></i>
          </div>
          <div class="LGA-info">
            <p class="LGA-title">My Community</p>
            <p class="LGA-name">Surulere LGA, Lagos State</p>
          </div>
        </div>

        <div class="sidebar-nav">
          <a href="/" class="<?= $currentUri === '/' ? 'current' : '' ?>">
            <i class="fa-solid fa-home"></i>Home
          </a>
          <a href="/businesses" class="<?= str_starts_with($currentUri, '/businesses') ? 'current' : '' ?>">
            <i class="fa-solid fa-store"></i>Business
          </a>
          <a href="/community" class="<?= str_starts_with($currentUri, '/community') ? 'current' : '' ?>">
            <i class="fa-solid fa-people-roof"></i>Communities
          </a>
          <a href="/events" class="<?= str_starts_with($currentUri, '/events') ? 'current' : '' ?>">
            <i class="fa-solid fa-calendar-days"></i>Events
          </a>
          <a href="/saved" class="<?= $currentUri === '/saved' ? 'current' : '' ?>">
            <i class="fa-solid fa-bookmark"></i>Saved
          </a>
          <a href="/settings" class="<?= $currentUri === '/settings' ? 'current' : '' ?>">
            <i class="fa-solid fa-gear"></i>Settings
          </a>
          <a href="/notifications" class="<?= $currentUri === '/notifications' ? 'current' : '' ?>">
            <i class="fa-solid fa-bell"></i>Notifications
            <span class="notif-count">2</span>
          </a>
          <a href="/about" class="<?= $currentUri === '/about' ? 'current' : '' ?>">
            <i class="fa-solid fa-info-circle"></i>About Vicinity
          </a>
        </div>
      </div>

      <div class="sidebar-actions">
        <a href="/posts/create" class="create-post">
          <i class="fa-solid fa-leaf"></i>Create Post
        </a>
        <div class="sidebar-links">
          <a href="/settings"><i class="fa-solid fa-gear"></i>Settings</a>
          <?php if (auth()->check()): ?>
            <a href="/logout" class="sidebar-logout"><i class="fa-solid fa-arrow-right-from-bracket"></i>Logout</a>
          <?php else: ?>
            <a href="/login"><i class="fa-solid fa-arrow-right-to-bracket"></i>Sign In</a>
          <?php endif; ?>
        </div>
      </div>
    </aside>

    <!-- Messenger Popup Window -->
    <div class="msg-window" id="msgWindow">
      <div class="msg-header">
        <div class="msg-title">
          <i class="fa-solid fa-comments"></i>
          <span>Messenger</span>
        </div>
        <button class="msg-close" id="msgClose">&times;</button>
      </div>
      <div class="msg-content">
        <div class="msg-contacts" id="msgContacts"></div>
        <div class="msg-chat">
          <div class="msg-messages" id="msgMessages">
            <div class="message received">
              <div class="msg-bubble">Hey! How's your community project going?</div>
              <span class="msg-time">10:24 AM</span>
            </div>
          </div>
          <div class="msg-input-area">
            <input type="text" id="msgInput" placeholder="Type a message..." />
            <button id="msgSend" aria-label="Send message">
              <i class="fa-solid fa-paper-plane"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- UI Scripts -->
    <script>
      // Create dropdown toggle
      (function () {
        const wrapper = document.querySelector(".create-wrapper");
        if (!wrapper) return;
        const btn = document.getElementById("createToggle");
        function toggle() { wrapper.classList.toggle("open"); }
        btn.addEventListener("click", function (e) { e.stopPropagation(); toggle(); });
        document.addEventListener("click", function (e) { if (!wrapper.contains(e.target)) wrapper.classList.remove("open"); });
        document.addEventListener("keydown", function (e) { if (e.key === "Escape") wrapper.classList.remove("open"); });
      })();

      // Account dropdown toggle
      (function () {
        const wrapper = document.querySelector(".account-wrapper");
        if (!wrapper) return;
        const btn = document.getElementById("accountToggle");
        function toggle() { wrapper.classList.toggle("open"); }
        btn.addEventListener("click", function (e) { e.stopPropagation(); toggle(); });
        document.addEventListener("click", function (e) { if (!wrapper.contains(e.target)) wrapper.classList.remove("open"); });
        document.addEventListener("keydown", function (e) { if (e.key === "Escape") wrapper.classList.remove("open"); });
      })();

      // Messenger popup logic
      (function () {
        var toggleBtn = document.getElementById("messengerToggle");
        var msgWindow = document.getElementById("msgWindow");
        var closeBtn = document.getElementById("msgClose");
        var contactsEl = document.getElementById("msgContacts");
        var messagesEl = document.getElementById("msgMessages");
        var inputEl = document.getElementById("msgInput");
        var sendBtn = document.getElementById("msgSend");

        if (!toggleBtn || !msgWindow) return;

        var contacts = [
          { id: "sarah", name: "Sarah M.", initial: "S", lastMsg: "See you at the event tomorrow!", messages: [{ text: "Hey! How's your community project going?", time: "10:24 AM", sent: false }, { text: "Going well, thanks! Just finished the new group.", time: "10:25 AM", sent: true }] },
          { id: "michael", name: "Michael R.", initial: "M", lastMsg: "The event is confirmed for Saturday.", messages: [{ text: "Did you finalize the event details?", time: "9:10 AM", sent: false }, { text: "Yes, it's confirmed for Saturday at 2pm.", time: "9:12 AM", sent: true }] },
          { id: "aisha", name: "Aisha K.", initial: "A", lastMsg: "The market is open every Thursday now.", messages: [{ text: "Have you seen the new market schedule?", time: "8:30 AM", sent: false }, { text: "Yes, it's every Thursday starting next week.", time: "8:35 AM", sent: true }] }
        ];

        var currentContact = "sarah";

        function renderContacts() {
          if (!contactsEl) return;
          contactsEl.innerHTML = contacts.map(function (c) {
            return '<div class="contact-item' + (c.id === currentContact ? ' active' : '') + '" data-id="' + c.id + '">' +
                   '<div class="contact-avatar">' + c.initial + '</div>' +
                   '<div class="contact-info"><div class="contact-name">' + c.name + '</div><div class="contact-last-msg">' + c.lastMsg + '</div></div>' +
                   '</div>';
          }).join('');
          contactsEl.querySelectorAll('.contact-item').forEach(function (el) {
            el.addEventListener('click', function () { selectContact(this.getAttribute('data-id')); });
          });
        }

        function selectContact(id) {
          currentContact = id;
          renderContacts();
          var contact = contacts.find(function (c) { return c.id === id; });
          if (!contact || !messagesEl) return;
          messagesEl.innerHTML = contact.messages.map(function (m) {
            return '<div class="message ' + (m.sent ? 'sent' : 'received') + '"><div class="msg-bubble">' + m.text + '</div><span class="msg-time">' + m.time + '</span></div>';
          }).join('');
          messagesEl.scrollTop = messagesEl.scrollHeight;
        }

        function sendMessage() {
          var text = inputEl.value.trim();
          if (!text || !currentContact) return;
          var contact = contacts.find(function (c) { return c.id === currentContact; });
          if (!contact) return;
          var now = new Date();
          var time = now.getHours() + ':' + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes();
          contact.messages.push({ text: text, time: time, sent: true });
          contact.lastMsg = text;
          inputEl.value = '';
          selectContact(currentContact);
          renderContacts();
        }

        toggleBtn.addEventListener('click', function () { msgWindow.classList.add('open'); toggleBtn.style.display = 'none'; });
        closeBtn.addEventListener('click', function () { msgWindow.classList.remove('open'); toggleBtn.style.display = ''; });
        if (sendBtn) sendBtn.addEventListener('click', sendMessage);
        if (inputEl) inputEl.addEventListener('keydown', function (e) { if (e.key === 'Enter') sendMessage(); });

        renderContacts();
      })();

      // Mobile sidebar toggle
      (function () {
        var mobileMenuBtn = document.getElementById("mobileMenuToggle");
        var sidebar = document.querySelector(".mobile-sidebar");
        var sidebarClose = document.getElementById("sidebarClose");
        var sidebarOverlay = document.querySelector(".sidebar-overlay");

        if (!mobileMenuBtn || !sidebar) return;

        function openSidebar() { sidebar.classList.add("open"); }
        function closeSidebar() { sidebar.classList.remove("open"); }

        mobileMenuBtn.addEventListener("click", openSidebar);
        if (sidebarClose) sidebarClose.addEventListener("click", closeSidebar);
        if (sidebarOverlay) sidebarOverlay.addEventListener("click", closeSidebar);
        document.addEventListener("keydown", function (e) { if (e.key === "Escape") closeSidebar(); });
      })();
    </script>
    <?= $this->yield('scripts') ?>
  </body>
</html>
