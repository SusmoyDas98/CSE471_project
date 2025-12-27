<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - DormMate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary: #0ea5e9;
            --accent: #3b82f6;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.1);
        }
        
        .notification-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 4px 16px rgba(14, 165, 233, 0.1);
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        
        .notification-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(14, 165, 233, 0.15);
        }
        
        .notification-card.unread {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.05), rgba(59, 130, 246, 0.05));
            border-left-color: var(--primary);
        }
        
        .notification-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .notification-icon.application {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }
        
        .notification-icon.dorm_registration {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }
        
        .notification-icon.update {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
        }
        
        .notification-icon.deadline {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

    {{-- Page Header + Nav (ADDED, same as show.blade.php) --}}
    <x-page-header>
        <x-slot name="nav_links">
            <x-nav-buttons />
        </x-slot>
    </x-page-header>

    {{-- Spacer for fixed header --}}
    <div style="height: 120px;"></div>

    <div class="container py-5">
        <div class="text-center mb-4">
            <h1 style="font-family: 'Playfair Display', serif; font-weight: 700; color: var(--primary);">
                <i class="fas fa-bell me-2"></i>Notifications
            </h1>
            <p class="text-secondary">Stay updated with your DormMate activity</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($unreadCount > 0)
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <span class="badge bg-primary">{{ $unreadCount }} unread</span>
                </div>
                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-check-double me-2"></i>Mark all as read
                    </button>
                </form>
            </div>
        @endif

        @if($notifications->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-bell-slash" style="font-size: 4rem; color: #cbd5e1;"></i>
                <h3 class="mt-3 text-secondary">No notifications yet</h3>
                <p class="text-secondary">We'll notify you when something important happens</p>
            </div>
        @else
            @foreach($notifications as $notification)
                <div class="notification-card {{ $notification->is_read ? '' : 'unread' }}">
                    <div class="d-flex gap-3">
                        <div class="notification-icon {{ $notification->type }}">
                            @if($notification->type == 'application')
                                <i class="fas fa-user-check"></i>
                            @elseif($notification->type == 'dorm_registration')
                                <i class="fas fa-building"></i>
                            @elseif($notification->type == 'update')
                                <i class="fas fa-info-circle"></i>
                            @elseif($notification->type == 'deadline')
                                <i class="fas fa-clock"></i>
                            @else
                                <i class="fas fa-bell"></i>
                            @endif
                        </div>
                        
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="mb-1">{{ $notification->title }}</h5>
                                    <p class="mb-2 text-secondary">{{ $notification->message }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    @if(!$notification->is_read)
                                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary" title="Mark as read">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form method="POST" action="{{ route('notifications.delete', $notification->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
