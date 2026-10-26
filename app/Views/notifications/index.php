<?php $this->extend('layouts.main'); ?>

<?php $this->section('container_class'); ?>notifications-container<?php $this->endSection(); ?>

        <div class="notifications-content">
          <div class="notifications-header">
            <div class="notifications-title-row">
              <h1>Notifications</h1>
              <div class="notifications-actions">
                <button class="btn-secondary mark-all-read" id="markAllRead">
                  <i class="fa-solid fa-check-double"></i> Mark All Read
                </button>
                <button class="btn-secondary" id="clearAll">
                  <i class="fa-solid fa-trash"></i> Clear All
                </button>
              </div>
            </div>
            <p class="notifications-subtitle">Stay updated with what's happening in your community</p>
          </div>

          <nav class="notifications-filter" aria-label="Notification filters">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="unread">Unread <span class="filter-count" id="unreadCount">8</span></button>
            <button class="filter-btn" data-filter="posts">Posts</button>
            <button class="filter-btn" data-filter="events">Events</button>
            <button class="filter-btn" data-filter="groups">Groups</button>
            <button class="filter-btn" data-filter="businesses">Businesses</button>
            <button class="filter-btn" data-filter="security">Security</button>
            <button class="filter-btn" data-filter="system">System</button>
          </nav>

          <div class="notifications-list" id="notificationsList">
            <!-- Notification items rendered by JS -->
          </div>

          <div class="notifications-empty" id="emptyState" style="display: none;">
            <i class="fa-regular fa-bell-slash"></i>
            <h3>No notifications</h3>
            <p>You're all caught up! New notifications will appear here.</p>
          </div>

          <div class="notifications-load-more" id="loadMoreContainer" style="display: none;">
            <button class="btn-secondary" id="loadMore">Load More</button>
          </div>
        </div>

<?php $this->section('scripts'); ?>
<script>
  // Sample notification data from THEME
  const defaultNotificationsData = [
    {
      id: 1,
      type: "post",
      category: "posts",
      title: "New post in Bode Thomas Security Watch",
      message: "Babatunde Adeleke posted: \"The new solar streetlights on Alaka-Bode Thomas connector road are now fully operational...\"",
      time: "5 min ago",
      timestamp: Date.now() - 5 * 60 * 1000,
      read: false,
      avatar: "BT",
      avatarColor: "#2b7a78",
      icon: "fa-solid fa-newspaper",
      iconColor: "#36a036",
      link: "/community"
    },
    {
      id: 2,
      type: "event",
      category: "events",
      title: "Event reminder: Surulere Youth Football Tournament",
      message: "Starting tomorrow at 9:00 AM at National Stadium Practice Pitch",
      time: "15 min ago",
      timestamp: Date.now() - 15 * 60 * 1000,
      read: false,
      avatar: null,
      avatarColor: null,
      icon: "fa-solid fa-futbol",
      iconColor: "#e07a5f",
      link: "/events"
    },
    {
      id: 3,
      type: "group",
      category: "groups",
      title: "Invitation to join Surulere Football Fanatics",
      message: "Tunde Balogun invited you to join this group",
      time: "1 hour ago",
      timestamp: Date.now() - 60 * 60 * 1000,
      read: false,
      avatar: "TB",
      avatarColor: "#e07a5f",
      icon: "fa-solid fa-users",
      iconColor: "#36a036",
      link: "/community"
    },
    {
      id: 4,
      type: "security",
      category: "security",
      title: "Security Alert: Neighbourhood Watch Briefing",
      message: "Scheduled for today at 5:00 PM at Surulere Town Hall",
      time: "2 hours ago",
      timestamp: Date.now() - 2 * 60 * 60 * 1000,
      read: true,
      avatar: null,
      avatarColor: null,
      icon: "fa-solid fa-shield-halved",
      iconColor: "#c0392b",
      link: "/events"
    },
    {
      id: 5,
      type: "business",
      category: "businesses",
      title: "New business: Royal Touch Spa & Salon",
      message: "Just opened at 22 Akerele Street, Surulere - Beauty & Wellness",
      time: "4 hours ago",
      timestamp: Date.now() - 4 * 60 * 60 * 1000,
      read: true,
      avatar: null,
      avatarColor: null,
      icon: "fa-solid fa-store",
      iconColor: "#6d597a",
      link: "/businesses"
    },
    {
      id: 6,
      type: "post",
      category: "posts",
      title: "Comment on your post in Surulere Tech Enthusiasts",
      message: "Kehinde Osoba replied: \"Great workshop recap! Looking forward to the next one in two weeks.\"",
      time: "5 hours ago",
      timestamp: Date.now() - 5 * 60 * 60 * 1000,
      read: true,
      avatar: "KO",
      avatarColor: "#e07a5f",
      icon: "fa-solid fa-comment",
      iconColor: "#2b7a78",
      link: "/community"
    },
    {
      id: 7,
      type: "event",
      category: "events",
      title: "You're going to Surulere Street Food Festival",
      message: "Confirmed for Sunday, 11:00 AM at Adeniran Ogunsanya St.",
      time: "6 hours ago",
      timestamp: Date.now() - 6 * 60 * 60 * 1000,
      read: true,
      avatar: null,
      avatarColor: null,
      icon: "fa-solid fa-calendar-check",
      iconColor: "#e07a5f",
      link: "/events"
    },
    {
      id: 8,
      type: "group",
      category: "groups",
      title: "New member in Adeniran Market Traders & Buyers",
      message: "Fatima Al-Hassan joined the group",
      time: "8 hours ago",
      timestamp: Date.now() - 8 * 60 * 60 * 1000,
      read: true,
      avatar: "FA",
      avatarColor: "#6d597a",
      icon: "fa-solid fa-user-plus",
      iconColor: "#36a036",
      link: "/community"
    },
    {
      id: 9,
      type: "system",
      category: "system",
      title: "Welcome to Vicinity!",
      message: "Thanks for joining. Explore groups, events, and businesses in your community.",
      time: "1 day ago",
      timestamp: Date.now() - 24 * 60 * 60 * 1000,
      read: true,
      avatar: null,
      avatarColor: null,
      icon: "fa-solid fa-circle-info",
      iconColor: "#888",
      link: "/"
    },
    {
      id: 10,
      type: "post",
      category: "posts",
      title: "Like on your post in Clean & Green Surulere",
      message: "Adekunle Charles liked your post about the tree planting drive",
      time: "1 day ago",
      timestamp: Date.now() - 26 * 60 * 60 * 1000,
      read: true,
      avatar: "AC",
      avatarColor: "#36a036",
      icon: "fa-solid fa-thumbs-up",
      iconColor: "#36a036",
      link: "/community"
    },
    {
      id: 11,
      type: "security",
      category: "security",
      title: "Security Update: Patrol schedule updated",
      message: "New patrol routes for Bode Thomas area posted in group files",
      time: "2 days ago",
      timestamp: Date.now() - 48 * 60 * 60 * 1000,
      read: true,
      avatar: null,
      avatarColor: null,
      icon: "fa-solid fa-route",
      iconColor: "#c0392b",
      link: "/community"
    },
    {
      id: 12,
      type: "business",
      category: "businesses",
      title: "GreenBite Cafe updated their hours",
      message: "Now open 7:00 AM - 10:00 PM daily at 14 Adeniran Ogunsanya",
      time: "2 days ago",
      timestamp: Date.now() - 50 * 60 * 60 * 1000,
      read: true,
      avatar: null,
      avatarColor: null,
      icon: "fa-solid fa-clock",
      iconColor: "#2b7a78",
      link: "/businesses"
    },
    {
      id: 13,
      type: "event",
      category: "events",
      title: "Tech Skills Workshop for Youth",
      message: "New event added: Wednesday, 10:00 AM at GreenBite Cafe",
      time: "3 days ago",
      timestamp: Date.now() - 72 * 60 * 60 * 1000,
      read: true,
      avatar: null,
      avatarColor: null,
      icon: "fa-solid fa-laptop-code",
      iconColor: "#e07a5f",
      link: "/events"
    },
    {
      id: 14,
      type: "group",
      category: "groups",
      title: "Surulere Book & Literature Club",
      message: "Monthly book review: \"Things Fall Apart\" discussion this Friday",
      time: "3 days ago",
      timestamp: Date.now() - 75 * 60 * 60 * 1000,
      read: true,
      avatar: null,
      avatarColor: null,
      icon: "fa-solid fa-book",
      iconColor: "#6d597a",
      link: "/community"
    },
    {
      id: 15,
      type: "system",
      category: "system",
      title: "App updated to v2.4.0",
      message: "New features: Dark mode, improved search, and faster loading",
      time: "4 days ago",
      timestamp: Date.now() - 96 * 60 * 60 * 1000,
      read: true,
      avatar: null,
      avatarColor: null,
      icon: "fa-solid fa-cog",
      iconColor: "#888",
      link: "/settings"
    }
  ];

  let notificationsData = defaultNotificationsData;

  <?php if (!empty($notifications)): ?>
    try {
      const serverNotifs = <?= json_encode(array_map(function($n) {
        return [
          'id' => (int) $n->id,
          'type' => $n->type ?? 'system',
          'category' => $n->category ?? 'system',
          'title' => $n->title,
          'message' => $n->message,
          'time' => date('M j, g:i a', strtotime($n->created_at)),
          'timestamp' => strtotime($n->created_at) * 1000,
          'read' => (bool) $n->is_read,
          'avatar' => null,
          'avatarColor' => null,
          'icon' => 'fa-solid fa-bell',
          'iconColor' => '#36a036',
          'link' => $n->link ?? '/'
        ];
      }, $notifications)) ?>;
      if (serverNotifs && serverNotifs.length > 0) {
        notificationsData = serverNotifs;
      }
    } catch(e) {}
  <?php endif; ?>

  let currentFilter = "all";
  let displayedCount = 10;
  const batchSize = 10;

  function renderNotifications() {
    const list = document.getElementById("notificationsList");
    const emptyState = document.getElementById("emptyState");
    const loadMoreContainer = document.getElementById("loadMoreContainer");
    const unreadCountEl = document.getElementById("unreadCount");

    // Filter notifications
    let filtered = notificationsData;
    if (currentFilter === "unread") {
      filtered = notificationsData.filter(n => !n.read);
    } else if (currentFilter !== "all") {
      filtered = notificationsData.filter(n => n.category === currentFilter);
    }

    // Count unread
    const unreadCount = notificationsData.filter(n => !n.read).length;
    if (unreadCountEl) unreadCountEl.textContent = unreadCount;
    document.querySelectorAll(".notif-count").forEach(el => {
      el.textContent = unreadCount;
      el.style.display = unreadCount > 0 ? "" : "none";
    });
    const notifDot = document.querySelector(".notification-dot");
    if (notifDot) notifDot.style.display = unreadCount > 0 ? "" : "none";

    // Get display slice
    const displayItems = filtered.slice(0, displayedCount);

    if (displayItems.length === 0) {
      list.innerHTML = "";
      emptyState.style.display = "flex";
      loadMoreContainer.style.display = "none";
      return;
    }

    emptyState.style.display = "none";

    list.innerHTML = displayItems.map(n => `
      <article class="notification-item ${!n.read ? "unread" : ""}" data-id="${n.id}" data-category="${n.category}">
        <div class="notification-icon" style="background: ${n.iconColor}15;">
          <i class="${n.icon}" style="color: ${n.iconColor};"></i>
        </div>
        <div class="notification-content">
          <div class="notification-header">
            <h4 class="notification-title">${n.title}</h4>
            <span class="notification-time">${n.time}</span>
            ${!n.read ? '<span class="unread-dot" aria-label="Unread"></span>' : ''}
          </div>
          <p class="notification-message">${n.message}</p>
          ${n.avatar ? `
            <div class="notification-meta">
              <div class="notification-avatar" style="background: ${n.avatarColor};">
                ${n.avatar}
              </div>
              <span class="notification-type">${getCategoryLabel(n.category)}</span>
            </div>
          ` : `
            <div class="notification-meta">
              <span class="notification-type">${getCategoryLabel(n.category)}</span>
            </div>
          `}
        </div>
        <button class="notification-action" aria-label="Mark as ${n.read ? 'unread' : 'read'}">
          <i class="fa-solid ${n.read ? 'fa-circle' : 'fa-circle-check'}"></i>
        </button>
      </article>
    `).join("");

    // Show/hide load more
    if (displayedCount < filtered.length) {
      loadMoreContainer.style.display = "block";
    } else {
      loadMoreContainer.style.display = "none";
    }

    // Add click handlers
    document.querySelectorAll(".notification-item").forEach(item => {
      item.addEventListener("click", (e) => {
        if (e.target.closest(".notification-action")) return;
        const id = parseInt(item.dataset.id);
        const notification = notificationsData.find(n => n.id === id);
        if (notification && !notification.read) {
          markAsRead(id);
        }
      });

      item.querySelector(".notification-action")?.addEventListener("click", (e) => {
        e.stopPropagation();
        const id = parseInt(item.dataset.id);
        toggleRead(id);
      });
    });
  }

  function getCategoryLabel(category) {
    const labels = {
      posts: "Post",
      events: "Event",
      groups: "Group",
      businesses: "Business",
      security: "Security",
      system: "System"
    };
    return labels[category] || category;
  }

  function markAsRead(id) {
    const notification = notificationsData.find(n => n.id === id);
    if (notification) {
      notification.read = true;
      renderNotifications();
    }
  }

  function toggleRead(id) {
    const notification = notificationsData.find(n => n.id === id);
    if (notification) {
      notification.read = !notification.read;
      renderNotifications();
    }
  }

  function markAllRead() {
    notificationsData.forEach(n => n.read = true);
    renderNotifications();
  }

  function clearAll() {
    notificationsData.forEach(n => n.read = true);
    displayedCount = 10;
    renderNotifications();
  }

  function filterNotifications(filter) {
    currentFilter = filter;
    displayedCount = 10;
    document.querySelectorAll(".filter-btn").forEach(btn => {
      btn.classList.toggle("active", btn.dataset.filter === filter);
    });
    renderNotifications();
  }

  function loadMore() {
    displayedCount += batchSize;
    renderNotifications();
  }

  document.addEventListener("DOMContentLoaded", () => {
    renderNotifications();

    document.querySelectorAll(".filter-btn").forEach(btn => {
      btn.addEventListener("click", () => filterNotifications(btn.dataset.filter));
    });

    document.getElementById("markAllRead")?.addEventListener("click", markAllRead);
    document.getElementById("clearAll")?.addEventListener("click", clearAll);
    document.getElementById("loadMore")?.addEventListener("click", loadMore);
  });
</script>
<?php $this->endSection(); ?>
