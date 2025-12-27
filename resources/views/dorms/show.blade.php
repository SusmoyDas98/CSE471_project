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

    {{-- Page Header + Nav --}}
    <x-page-header>
        <x-slot name="nav_links">
            <x-nav-buttons />
        </x-slot>
    </x-page-header>

    <div style="height: 120px;"></div>

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

        {{-- Apply Button (NEW) --}}
        @if(Auth::check() && Auth::user()->role === 'Dorm Seeker')
            <div class="dorm-details text-center">
                <a href="{{ route('dorms.apply', $dorm->id) }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-paper-plane me-2"></i>Apply to This Dorm
                </a>
            </div>
        @endif
        {{-- Reviews --}}
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
                                <div class="d-flex gap-2">
                                    {{-- Edit Button --}}
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editReviewModal{{ $review->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    {{-- Delete Button --}}
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteReviewModal{{ $review->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                {{-- Delete Modal --}}
                                <div class="modal fade" id="deleteReviewModal{{ $review->id }}" tabindex="-1" aria-labelledby="deleteReviewLabel{{ $review->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteReviewLabel{{ $review->id }}">Delete Review</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete your review?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                                                <form method="POST" action="{{ route('reviews.delete', $review->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger rounded-pill">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Edit Modal --}}
                                <div class="modal fade" id="editReviewModal{{ $review->id }}" tabindex="-1" aria-labelledby="editReviewLabel{{ $review->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editReviewLabel{{ $review->id }}">Edit Review</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="POST" action="{{ route('dorms.review', $dorm->id) }}">
                                                @csrf
                                                <input type="hidden" name="edit_review_id" value="{{ $review->id }}">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Rating</label>
                                                        <div class="star-rating">
                                                            @for($i = 5; $i >= 1; $i--)
                                                                <input type="radio" id="edit-star{{ $i }}-{{ $review->id }}" name="rating" value="{{ $i }}" @if($review->rating == $i) checked @endif />
                                                                <label for="edit-star{{ $i }}-{{ $review->id }}"><i class="fas fa-star"></i></label>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Review</label>
                                                        <textarea class="form-control" name="comment_text" rows="3" required>{{ $review->comment_text }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary rounded-pill">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            @endif
                        @endauth
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{-- Review Form --}}
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
                        <input type="radio" id="star5" name="rating" value="5" required /><label for="star5"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star4" name="rating" value="4" /><label for="star4"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star3" name="rating" value="3" /><label for="star3"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star2" name="rating" value="2" /><label for="star2"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star1" name="rating" value="1" /><label for="star1"><i class="fas fa-star"></i></label>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>