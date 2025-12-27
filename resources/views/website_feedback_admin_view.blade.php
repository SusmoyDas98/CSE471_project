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
    <h1 class="hero-title">Overview The <span>User Experience</span></h1>
    <p class="hero-subtitle">As an Admin you can either Hide a User Review or Delete it!!</p>
</div>

<div class="container-main">
    <div class="feedback-container">
        @if (!empty($user_role) && $user_role == "Admin")
        
        <!-- FEEDBACK SUMMARY -->
        <div class="feedback-summary-section mb-5">
            <div class="summary-card">
                <h4 class="summary-title">
                    <i class="fas fa-chart-bar me-2"></i>Feedback Summary
                </h4>
            
                <div class="summary-grid">
                    <!-- Total Reviews -->
                    <div class="summary-item home">
                        <i class="fas fa-comments summary-icon"></i>
                        <h3 id="totalReviews">
                            @if(!empty($all_reviews))
                                {{ count($all_reviews) }}
                            @endif
                        </h3>
                        <p>Total Reviews</p>
                    </div>
                
                    <!-- Average Rating -->
                    <div class="summary-item">
                        <i class="fas fa-star summary-icon"></i>
                        <h3 id="averageRating">
                            @if(!empty($average_rating))
                                {{ $average_rating }}
                            @endif                            
                        </h3>
                        <p>Average Rating</p>
                    </div>
                
                    <!-- Hidden Reviews -->
                    <div class="summary-item summary-muted hide">
                        <i class="fas fa-eye-slash summary-icon"></i>
                        <h3 id="hiddenReviews">
                            @if(!empty($hidden_reviews))
                                {{ count($hidden_reviews) }}
                            @else
                            0
                            @endif                            
                        </h3>
                        <p>
                            Hidden <small>(By Admins)</small>
                        </p>
                    </div>
                
                    <!-- Deleted Reviews -->
                    <div class="summary-item summary-muted delete">
                        <i class="fas fa-trash summary-icon"></i>
                        <h3 id="deletedReviews">
                            @if(!empty($deleted_reviews))
                                {{ count($deleted_reviews ) }}
                            @else
                            0
                            @endif                            
                        </h3>
                        <p>
                            Deleted <small>(By Admins)</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ADMIN section - FEEDBACK SUMMARY --}}
        

        @endif


        <div class="reviews-section">

            <h3 class='title_all_reviews'>All Reviews</h3>

            <div id="reviewsList">
                @if ($all_reviews->isEmpty())
                    <p>No reviews yet. Be the first to write a review!</p>
                @else
                @foreach ($all_reviews as $review)
                @if (in_array($review->id , $hidden_reviews))
                    <div class="review-card" id="hidden_review-{{ $review->id }}"> 
                @elseif(in_array($review->id, $deleted_reviews))    
                    <div class="review-card" id="deleted_review-{{ $review->id }}"> 
                @else
                    <div class="review-card" id = "visible_review-{{ $review->id }}">
                @endif
                    <div class="review-header">
                        <div class="reviewer-info">
                            <div class="reviewer-avatar">S</div>
                            <div class="reviewer-details">
                                <h4>{{$review->user_name}}</h4>
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
                    @if (!empty($user_role) && $user_role == "Admin")
                        
                    <!-- ADMIN PANEL -->
                    <div class="admin-panel mb-4 p-3 border rounded bg-light">
                        <h5 class="mb-3">
                            <i class="fas fa-user-shield me-2"></i>Admin Controls
                        </h5>
                <div class="d-flex flex-wrap gap-2">

                @if (in_array($review->id , $hidden_reviews))

                            <button class="btn btn-outline-secondary btn-sm hide" id="hideSelected-{{ $review->id }}" data-message-id="{{ $review->id }}" data-state="hidden">
                                <i class='fas fa-eye-slash summary-icon'></i> Unhide
                            </button>
                @else 
                            <button class="btn btn-outline-secondary btn-sm hide" id="hideSelected-{{ $review->id }}" data-message-id="{{ $review->id }}" data-state="visible">
                               <i class='fas fa-eye summary-icon'></i> Hide Selected
                            </button>
                @endif
                @if(in_array($review->id, $deleted_reviews))    
                            <button class="btn btn-outline-danger btn-sm delete" id="deleteSelected-{{ $review->id }}" data-message-id="{{ $review->id }}" data-state="deleted">
                                <i class='fas fa-undo'></i> Restore
                            </button>
                @else                    
                        {{-- <div class="d-flex flex-wrap gap-2"> --}}
                            <button class="btn btn-outline-danger btn-sm delete" id="deleteSelected-{{ $review->id }}" data-message-id="{{ $review->id }}" data-state="visible">
                                <i class="fas fa-trash"></i> Delete Selected
                            </button>
                @endif        

                        </div>
                    </div>
                    {{-- end of admin part --}}      
                    @endif
                                  
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
