<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Website Feedback - DormLuxe</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href='/css/website_feedback.css'>
</head>
<body>

<x-page-header>
        <x-slot name="nav_links">
            <x-nav-buttons />
        </x-slot>
</x-page-header>
<div style="height: 90px;"></div>

<div class="hero-section">
    <span class="hero-badge"><i class="fas fa-comments me-2"></i>Community Feedback</span>
    <h1 class="hero-title">Share Your <span>Experience</span></h1>
    <p class="hero-subtitle">Your feedback helps us improve and helps others make better decisions. Share your thoughts and read what our community has to say!</p>
</div>

<div class="container-main">
    <div class="feedback-container">
<<<<<<< HEAD
            <div class="write-review-section">
                @if ( !empty($already_have) )
                    {{-- <div class="alert alert-success"> --}}
                    <div class="already_have">
                        {{ $already_have }}
=======

        <div class="write-review-section">
            @if (  session('success') )
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                
            @else 
            <h3>Write a Review</h3>
            <p>Share your experience with DormLuxe</p>
            <form id="reviewForm" action="/website_reviews" method="POST">
                @csrf
                <div class="form-group">
                    <label>Your Rating *</label>
                    <div class="star-rating" id="starRating">
                        <i class="fas fa-star star" data-rating="1" tabindex="0"></i>
                        <i class="fas fa-star star" data-rating="2" tabindex="0"></i>
                        <i class="fas fa-star star" data-rating="3" tabindex="0"></i>
                        <i class="fas fa-star star" data-rating="4" tabindex="0"></i>
                        <i class="fas fa-star star" data-rating="5" tabindex="0"></i>
>>>>>>> afia-branch
                    </div>

<<<<<<< HEAD
                @else 
                <h3>Write a Review</h3>
                <p>Share your experience with DormLuxe</p>
                {{-- <form id="reviewForm" action="/website_reviews" method="POST"> --}}
                <form id="reviewForm" >
                    @csrf
                    <div class="form-group">
                        <label>Your Rating *</label>
                        <div class="star-rating" id="starRating">
                            <i class="fas fa-star star" data-rating="1" tabindex="0"></i>
                            <i class="fas fa-star star" data-rating="2" tabindex="0"></i>
                            <i class="fas fa-star star" data-rating="3" tabindex="0"></i>
                            <i class="fas fa-star star" data-rating="4" tabindex="0"></i>
                            <i class="fas fa-star star" data-rating="5" tabindex="0"></i>
                        </div>
                        <input type="hidden" id="ratingValue" name="rating" value="0">
                    </div>

                    <div class="form-group">
                        <label for="reviewText">Your Review *</label>
                        <textarea name = "review_text" class="form-control" id="reviewText" maxlength="500" required placeholder="Tell us about your experience..."></textarea>
                        <div class="char-count"><span id="charCount">0</span>/500 characters</div>
                    </div>

                    {{-- <button type="submit" class="btn-submit-review"><i class="fas fa-paper-plane me-2"></i>Submit Review</button> --}}
                    <button type="submit" id = "submit_button" class="btn-submit-review"><i class="fas fa-paper-plane me-2"></i>Submit Review</button>                
                </form>
                @endif
            </div>
=======
                <div class="form-group">
                    <label for="reviewText">Your Review *</label>
                    <textarea name = "review_text" class="form-control" id="reviewText" maxlength="500" required placeholder="Tell us about your experience..."></textarea>
                    <div class="char-count"><span id="charCount">0</span>/500 characters</div>
                </div>

                <button type="submit" class="btn-submit-review"><i class="fas fa-paper-plane me-2"></i>Submit Review</button>
            </form>
            @endif
        </div>

        <div class="reviews-section">
            <h3 class='title_all_reviews'>All Reviews</h3>
>>>>>>> afia-branch


        <div class="reviews-section">

            <h3 class='title_all_reviews'>All Reviews</h3>

            <div id="reviewsList">
                @if ($all_reviews->isEmpty())
                    <p>No reviews yet. Be the first to write a review!</p>
                @else
                @foreach ($all_reviews as $review)
<<<<<<< HEAD
                    <div class="review-card" id = "visible_review-{{ $review->id }}">
                
=======
                    <div class="review-card" data-rating="5">
>>>>>>> afia-branch
                    <div class="review-header">
                        <div class="reviewer-info">
                            <div class="reviewer-avatar">S</div>
                            <div class="reviewer-details">
<<<<<<< HEAD
                                <h4>{{ $user_map[(int)$review->user_id] ?? 'Unknown' }}</h4>

=======
                                <h4>{{$review->user_name}}</h4>
>>>>>>> afia-branch
                            </div>
                        </div>
                        <div class="review-rating">
                            @for ( $i = 1; $i<=$review->rating; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                            
                        </div>
                    </div>

                    <p class="review-content">
                        {{$review->message}}
                    </p>
<<<<<<< HEAD
                                  
=======
>>>>>>> afia-branch
                </div>                         
                    @endforeach
                    
                
                    
                @endif
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/website_feedback.js"></script>
</body>
</html>
