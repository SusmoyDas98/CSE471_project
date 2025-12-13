<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $dorm->name }} - DormMate</title>
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
        
        .dorm-details {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin: 30px 0;
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.1);
        }
        
        .rating {
            color: #fbbf24;
            font-size: 1.5rem;
        }
        
        .review-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            border-left: 4px solid var(--primary);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
        }
        
        .star-rating input[type="radio"] {
            display: none;
        }
        
        .star-rating label {
            font-size: 2rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
        }
        
        .star-rating input[type="radio"]:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #fbbf24;
        }
        
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 4px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">DormMate</a>
            <div class="d-flex gap-2">
                <a href="{{ route('dorms.index') }}" class="btn btn-outline-primary">Back to Dorms</a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    
    <div class="container py-5">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <div class="dorm-details">
            <h1 style="font-family: 'Playfair Display', serif; font-weight: 700; color: var(--primary);">{{ $dorm->name }}</h1>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <p><i class="fas fa-map-marker-alt me-2 text-primary"></i><strong>Location:</strong> {{ $dorm->location }}</p>
                    <p><i class="fas fa-door-open me-2 text-primary"></i><strong>Available Rooms:</strong> {{ $dorm->room_count }}</p>
                    <p><i class="fas fa-bed me-2 text-primary"></i><strong>Room Types:</strong> {{ $dorm->room_types }}</p>
                    <p><i class="fas fa-info-circle me-2 text-primary"></i><strong>Status:</strong> <span class="badge bg-success">{{ ucfirst($dorm->status) }}</span></p>
                </div>
                <div class="col-md-6 text-end">
                    <div class="rating">
                        @if($avgRating)
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($avgRating))
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                            <div class="mt-2">
                                <h3 class="mb-0" style="color: var(--primary);">{{ number_format($avgRating, 1) }}/5</h3>
                                <small class="text-secondary">Based on {{ $reviewCount }} reviews</small>
                            </div>
                        @else
                            <p class="text-secondary">No ratings yet</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Reviews List -->
        <div class="dorm-details">
            <h3 class="mb-4"><i class="fas fa-comments me-2 text-primary"></i> Reviews ({{ $reviewCount }})</h3>
            
            @if($reviews->isEmpty())
                <p class="text-secondary text-center">No reviews yet. Be the first to review!</p>
            @else
                @foreach($reviews as $review)
                    <div class="review-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1">{{ $review->user_name }}</h5>
                                <div class="rating mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star" style="font-size: 1rem;"></i>
                                        @else
                                            <i class="far fa-star" style="font-size: 1rem;"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p class="mb-1">{{ $review->comment_text }}</p>
                                <small class="text-secondary">{{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</small>
                            </div>
                            
                            @auth
                                @if($review->user_id == Auth::id())
                                    <form method="POST" action="{{ route('reviews.delete', $review->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this review?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

                <!-- Review Form -->
        @auth
            <div class="dorm-details">
                <h3 class="mb-4"><i class="fas fa-pen me-2 text-primary"></i>Leave a Review</h3>
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('dorms.review', $dorm->id) }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Your Rating</label>
                        <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5" required />
                            <label for="star5"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star4" name="rating" value="4" />
                            <label for="star4"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star3" name="rating" value="3" />
                            <label for="star3"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star2" name="rating" value="2" />
                            <label for="star2"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star1" name="rating" value="1" />
                            <label for="star1"><i class="fas fa-star"></i></label>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="comment_text" class="form-label fw-bold">Your Review</label>
                        <textarea class="form-control" id="comment_text" name="comment_text" rows="4" placeholder="Share your experience..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Submit Review
                    </button>
                </form>
            </div>
        @else
            <div class="dorm-details">
                <p class="text-center mb-0">
                    <a href="{{ route('login') }}" class="btn btn-primary">Login to leave a review</a>
                </p>
            </div>
        @endauth
    </div>
</body>
</html>