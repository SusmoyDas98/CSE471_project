<style>
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
.navbar-brand i {
    color: var(--primary);
    font-size: 2rem;
}

.navbar-brand .brand-text {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
}

.navbar-brand .brand-main {
    font-size: 1.8rem;
}

.navbar-brand .brand-sub {
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: var(--primary);
    font-family: 'Inter', sans-serif;
    font-weight: 600;
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
</style>

<div class="nav-links">
                <a href="#">Dashboard</a>
                <a href="#">My Profile</a>
                <a href="#">Messages</a>
                <button class="btn-upgrade">
                    <i class="fas fa-crown me-2"></i>Upgrade Plan
                </button>
                <button class="btn btn-registered">
                    <i class="fas fa-list-ul me-2"></i>Browse Properties
                </button>                
</div>
