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

        <div class="write-review-section">
            <h3>Write a Review</h3>
            <p>Share your experience with DormLuxe</p>
            <form id="reviewForm">
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
                    <label for="reviewTitle">Review Title *</label>
                    <input type="text" class="form-control" id="reviewTitle" required placeholder="Sum up your experience">
                </div>

                <div class="form-group">
                    <label for="reviewText">Your Review *</label>
                    <textarea class="form-control" id="reviewText" maxlength="500" required placeholder="Tell us about your experience..."></textarea>
                    <div class="char-count"><span id="charCount">0</span>/500 characters</div>
                </div>

                <button type="submit" class="btn-submit-review"><i class="fas fa-paper-plane me-2"></i>Submit Review</button>
            </form>
        </div>

        <div class="reviews-section">
            <h3>Community Reviews</h3>
            <div class="filter-tabs">
                <button class="filter-tab active" data-filter="all">All</button>
                <button class="filter-tab" data-filter="5">5 Stars</button>
                <button class="filter-tab" data-filter="4">4 Stars</button>
            </div>

            <div id="reviewsList">
                <div class="review-card" data-rating="5">
                    <div class="review-header">
                        <div class="reviewer-info">
                            <div class="reviewer-avatar">S</div>
                            <div class="reviewer-details">
                                <h4>Sarah J</h4>
                            </div>
                        </div>
                        <div class="review-rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                    </div>
                    <h5 style="margin-bottom:10px;font-weight:700;">Great website!</h5>
                    <p class="review-content">Found a perfect dorm quickly. User interface is clean and easy to navigate.</p>
                </div>
            </div>

            <div class="load-more">
                <button id="btnLoadMore" class="btn-load-more"><i class="fas fa-chevron-down me-2"></i>Load More</button>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/website_feedback.js"></script>
</body>
</html>
