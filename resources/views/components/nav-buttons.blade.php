<style>
:root {
    --primary: #0ea5e9;
    --secondary: #3b82f6;
    --text-secondary: #6b7280;
}

.navbar {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(15px);
    border-bottom: 1px solid rgba(14,165,233,0.1);
    padding: 1rem 0;
}

.navbar-brand {
  background: url("/images/DormMate_edited.png") no-repeat center / contain;
  width: 160px;
  height: 48px;
  text-indent: -9999px;
  overflow: hidden;
  display: block;
}

.nav-links {
    display: flex;
    gap: 30px;
    align-items: center;
}

.nav-links a {
    color: var(--text-secondary);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}

.nav-links a:hover {
    color: var(--primary);
}

.btn-upgrade {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    box-shadow: 0 4px 16px rgba(251, 191, 36, 0.3);
}        

.btn-registered {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
    border: none;
    padding: 12px 32px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 16px rgba(14, 165, 233, 0.25);
}

.btn-registered:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 24px rgba(14, 165, 233, 0.35);
}

/* 🔴 Logout styling (NEW) */
.logout-btn {
    background: none;
    border: none;
    color: #ef4444;
    font-weight: 500;
    padding: 0;
    cursor: pointer;
    transition: color 0.2s, text-shadow 0.2s;
}

.logout-btn:hover {
    color: #dc2626;
    text-shadow: 0 0 0.5px currentColor;
}

/* Notification Bell */
.notification-bell {
    position: relative;
    color: var(--text-secondary);
    font-size: 1.3rem;
    transition: color 0.2s;
    text-decoration: none;
}

.notification-bell:hover {
    color: var(--primary);
}

.notification-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: 700;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
}

.notification-badge.hidden {
    display: none;
}

</style>

<div class="nav-links">
    <a href="#">Dashboard</a>
    <a href="{{ route('dorms.search') }}">Search Dorms</a>
    <a href="{{ route('dashboard') }}">My Profile</a>
    <a href="#">Messages</a>

      @auth
        <a href="{{ route('notifications.index') }}" class="notification-bell">
            <i class="fas fa-bell"></i>
            <span class="notification-badge hidden" id="notificationBadge">0</span>
        </a>
    @endauth
      
    <button class="btn-upgrade">
        <i class="fas fa-crown me-2"></i>Upgrade Plan
    </button>

    <button class="btn btn-registered">
        <i class="fas fa-list-ul me-2"></i>Browse Properties
    </button>

    <!-- 🔴 Logout (NEW) -->
    @auth
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">
            Logout
        </button>
    </form>
    @endauth
</div>

@auth
<script>
    // Update notification count
    function updateNotificationCount() {
        fetch('{{ route('notifications.unreadCount') }}')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('notificationBadge');
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            })
            .catch(error => console.error('Error fetching notification count:', error));
    }

    // Update count on page load
    updateNotificationCount();

    // Update count every 30 seconds
    setInterval(updateNotificationCount, 30000);
</script>
@endauth