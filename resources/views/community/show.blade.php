<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $dorm->name }} Community</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --primary-light: #38bdf8;
            --secondary: #06b6d4;
            --accent: #3b82f6;
            --gold: #fbbf24;
            --success: #10b981;
            --bg-main: #f0f9ff;
            --bg-secondary: #e0f2fe;
            --card-bg: #ffffff;
            --text-primary: #0c4a6e;
            --text-secondary: #075985;
            --border-color: #bae6fd;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at 20% 50%, rgba(14, 165, 233, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
                        linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: var(--text-primary);
            min-height: 100vh;
        }
        
        .navbar {
            background: #ffffff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #1a1a1a;
        }
        
        .navbar-brand .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #0ea5e9, #3b82f6);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        
        .navbar-brand .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        
        .navbar-brand .brand-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0284c7;
            font-family: 'Playfair Display', serif;
        }
        
        .navbar-brand .brand-tagline {
            font-size: 0.65rem;
            font-weight: 500;
            color: #0ea5e9;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-family: 'Inter', sans-serif;
        }
        
        .navbar-text {
            color: var(--text-secondary) !important;
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        .hero-section {
            padding: 60px 0 40px;
            text-align: center;
        }
        
        .hero-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 8px 24px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 24px;
        }
        
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 10px;
        }
        
        .post-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            border: 2px solid rgba(14, 165, 233, 0.1);
            margin-bottom: 20px;
            transition: all 0.3s;
        }
        
        .post-card:hover {
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.1);
            border-color: var(--primary);
        }
        
        .post-form-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            border: 2px solid rgba(14, 165, 233, 0.1);
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
        }
        
        .btn-post {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-post:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(14, 165, 233, 0.3);
        }
        
        .btn-leave {
            background: white;
            color: #dc3545;
            border: 2px solid #dc3545;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-leave:hover {
            background: rgba(220, 53, 69, 0.05);
        }
        
        .btn-back {
            background: white;
            color: var(--text-secondary);
            border: 2px solid rgba(14, 165, 233, 0.2);
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-back:hover {
            border-color: var(--primary);
            background: rgba(14, 165, 233, 0.05);
            color: var(--primary);
        }
        
        .reply-card {
            background: rgba(14, 165, 233, 0.03);
            border-left: 4px solid var(--primary);
            border-radius: 12px;
            padding: 20px;
            margin-left: 50px;
            margin-top: 15px;
            transition: all 0.3s;
        }
        
        .reply-card:hover {
            background: rgba(14, 165, 233, 0.06);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.1);
        }
        
        .reply-form {
            display: none;
            margin-top: 15px;
            padding: 15px;
            background: rgba(14, 165, 233, 0.05);
            border-radius: 12px;
            border: 2px solid rgba(14, 165, 233, 0.2);
        }
        
        .reply-form.active {
            display: block;
        }
        
        .btn-reply {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .btn-reply:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }
        
        .thread-indicator {
            color: var(--primary);
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 10px;
        }
        
        .replies-count {
            background: rgba(14, 165, 233, 0.1);
            color: var(--primary);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('community.index') }}">
            <div class="logo-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="brand-text">
                <div class="brand-title">DormMate</div>
                <div class="brand-tagline">HOUSING SIMPLIFIED</div>
            </div>
        </a>
        <span class="navbar-text ms-auto">
            <i class="fas fa-building me-2"></i>{{ $dorm->name }}
        </span>
    </div>
</nav>

<div class="hero-section">
    <div class="container">
        <span class="hero-badge"><i class="fas fa-comments me-2"></i>Community Chat</span>
        <h1 class="hero-title">{{ $dorm->name }} Community</h1>
        <p class="text-muted">{{ $dorm->city ?? '—' }} • {{ $dorm->description ?? 'No description' }}</p>
    </div>
</div>

<div class="container mb-5">
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-end gap-2 mb-3">
        <a href="{{ route('community.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Community Forum
        </a>
        <a href="{{ route('community.leave', $dorm) }}" class="btn-leave" onclick="return confirm('Are you sure you want to leave this community?')">
            <i class="fas fa-sign-out-alt me-2"></i>Leave Community
        </a>
    </div>

    <div class="post-form-card">
        <h5 class="mb-3" style="font-family: 'Playfair Display', serif; color: var(--text-primary);">
            <i class="fas fa-edit me-2"></i>Share an Update
        </h5>
        <form method="POST" action="{{ route('community.posts.store', $dorm) }}">
            @csrf
            <div class="mb-3">
                <textarea name="body" class="form-control @error('body') is-invalid @enderror" rows="4" 
                          placeholder="Share info with your dorm community..." 
                          style="border-radius: 12px; border: 2px solid rgba(14, 165, 233, 0.2); padding: 15px;">{{ old('body') }}</textarea>
                @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button class="btn-post" type="submit">
                <i class="fas fa-paper-plane me-2"></i>Post Message
            </button>
            <p class="small text-muted mt-3 mb-0">
                <i class="fas fa-info-circle me-1"></i>
                Non-subscribed users see only the last 3 months. Subscribers see all history.
            </p>
        </form>
    </div>

    <div class="post-form-card">
        <h5 class="mb-4" style="font-family: 'Playfair Display', serif; color: var(--text-primary);">
            <i class="fas fa-comments me-2"></i>Recent Messages
        </h5>
        @forelse($posts as $post)
            <div class="post-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                             style="width: 40px; height: 40px; font-weight: 700; margin-right: 12px;">
                            {{ strtoupper(substr($post->author->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2">
                                <div class="fw-bold">{{ $post->author->name ?? 'User '.$post->user_id }}</div>
                                @if($post->replies->count() > 0)
                                    <span class="replies-count">
                                        <i class="fas fa-comments me-1"></i>{{ $post->replies->count() }} {{ $post->replies->count() == 1 ? 'Reply' : 'Replies' }}
                                    </span>
                                @endif
                            </div>
                            <small class="text-muted">{{ $post->created_at->format('M d, Y • h:i A') }}</small>
                        </div>
                    </div>
                    <button class="btn-reply" onclick="toggleReplyForm({{ $post->id }})">
                        <i class="fas fa-reply me-1"></i>Reply
                    </button>
                </div>
                <div class="text-body" style="line-height: 1.6; color: var(--text-secondary); margin-bottom: 15px;">
                    {{ $post->body }}
                </div>
                
                <!-- Reply Form -->
                <div class="reply-form" id="reply-form-{{ $post->id }}">
                    <form method="POST" action="{{ route('community.posts.store', $dorm) }}">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $post->id }}">
                        <div class="mb-2">
                            <textarea name="body" class="form-control" rows="3" 
                                      placeholder="Write your reply..." 
                                      required
                                      style="border-radius: 10px; border: 2px solid rgba(14, 165, 233, 0.2); padding: 12px; resize: vertical;"></textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-post" style="padding: 8px 20px; font-size: 0.9rem;">
                                <i class="fas fa-paper-plane me-1"></i>Post Reply
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="toggleReplyForm({{ $post->id }})" style="padding: 8px 20px; font-size: 0.9rem; border-radius: 10px;">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Replies Thread -->
                @if($post->replies->count() > 0)
                    <div class="mt-3">
                        @foreach($post->replies as $reply)
                            <div class="reply-card">
                                <div class="d-flex align-items-start mb-2">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                                         style="width: 35px; height: 35px; font-weight: 700; margin-right: 10px; font-size: 0.9rem;">
                                        {{ strtoupper(substr($reply->author->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <div class="fw-bold" style="font-size: 0.95rem;">{{ $reply->author->name ?? 'User '.$reply->user_id }}</div>
                                            @if($reply->user_id == $post->user_id)
                                                <span class="badge bg-info" style="font-size: 0.75rem;">Original Poster</span>
                                            @endif
                                        </div>
                                        <small class="text-muted">{{ $reply->created_at->format('M d, Y • h:i A') }}</small>
                                    </div>
                                </div>
                                <div style="line-height: 1.6; color: var(--text-secondary); font-size: 0.95rem;">
                                    {{ $reply->body }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="alert alert-info text-center" style="border-radius: 20px; padding: 40px;">
                <i class="fas fa-comment-slash fa-2x mb-3 text-muted"></i>
                <h5>No messages yet</h5>
                <p class="mb-0">Be the first to share something with the community!</p>
            </div>
        @endforelse

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleReplyForm(postId) {
        const form = document.getElementById('reply-form-' + postId);
        if (form) {
            form.classList.toggle('active');
            if (form.classList.contains('active')) {
                const textarea = form.querySelector('textarea');
                if (textarea) {
                    textarea.focus();
                }
            }
        }
    }
    
    // Auto-scroll to reply form if parent_id is in URL
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const replyTo = urlParams.get('reply_to');
        if (replyTo) {
            setTimeout(() => {
                toggleReplyForm(replyTo);
                const form = document.getElementById('reply-form-' + replyTo);
                if (form) {
                    form.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }, 500);
        }
    });
</script>
</body>
</html>
