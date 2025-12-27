<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DormReviewController extends Controller
{
    // Show all dorms for review
    public function index()
    {
        $dorms = DB::table('dorm')
            ->select('dorm.*', DB::raw('COALESCE(AVG(dorm_reviews.rating), 0) as avg_rating'), DB::raw('COUNT(dorm_reviews.id) as review_count'))
            ->leftJoin('dorm_reviews', 'dorm.id', '=', 'dorm_reviews.dorm_id')
            ->groupBy('dorm.id', 'dorm.owner_id', 'dorm.name', 'dorm.location', 'dorm.dorm_review', 'dorm.room_count', 'dorm.room_types', 'dorm.status', 'dorm.created_at', 'dorm.updated_at')
            ->get();

        return view('dorms.index', compact('dorms'));
    }

    // Show single dorm with reviews
    public function show($id)
    {
        $dorm = DB::table('dorm')->where('id', $id)->first();
        
        if (!$dorm) {
            return redirect()->route('dorms.index')->with('error', 'Dorm not found!');
        }

        $reviews = DB::table('dorm_reviews')
            ->join('users', 'dorm_reviews.user_id', '=', 'users.id')
            ->where('dorm_reviews.dorm_id', $id)
            ->select('dorm_reviews.*', 'users.name as user_name')
            ->orderBy('dorm_reviews.created_at', 'desc')
            ->get();

        $avgRating = DB::table('dorm_reviews')
            ->where('dorm_id', $id)
            ->avg('rating');

        $reviewCount = $reviews->count();

        return view('dorms.show', compact('dorm', 'reviews', 'avgRating', 'reviewCount'));
    }

// Store or update review
public function storeReview(Request $request, $dormId)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please login to leave a review!');
    }

    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment_text' => 'required|string|max:1000',
    ]);

    // Check if this is an edit
    $editReviewId = $request->input('edit_review_id');

    if ($editReviewId) {
        $review = DB::table('dorm_reviews')->where('id', $editReviewId)->first();

        if (!$review) {
            return back()->with('error', 'Review not found!');
        }

        if ($review->user_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action!');
        }

        DB::table('dorm_reviews')->where('id', $editReviewId)->update([
            'rating' => $request->rating,
            'comment_text' => $request->comment_text,
            'updated_at' => now(),
        ]);

        // Update dorm table
        $this->updateDormSummary($review->dorm_id);

        return back()->with('success', 'Review updated successfully!');
    }

    // Check if user already reviewed this dorm
    $existingReview = DB::table('dorm_reviews')
        ->where('dorm_id', $dormId)
        ->where('user_id', Auth::id())
        ->first();

    if ($existingReview) {
        return back()->with('error', 'You have already reviewed this dorm!');
    }

    DB::table('dorm_reviews')->insert([
        'dorm_id' => $dormId,
        'user_id' => Auth::id(),
        'rating' => $request->rating,
        'comment_text' => $request->comment_text,
        'created_at' => now(),
    ]);
    
    // Update dorm table
    $this->updateDormSummary($dormId);

    return back()->with('success', 'Review submitted successfully!');
}

    // Delete review
    public function deleteReview($id)
    {
        $review = DB::table('dorm_reviews')->where('id', $id)->first();

        if (!$review) {
            return back()->with('error', 'Review not found!');
        }

        if ($review->user_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action!');
        }

        DB::table('dorm_reviews')->where('id', $id)->delete();

        // Update dorm table
        $this->updateDormSummary($review->dorm_id);

        return back()->with('success', 'Review deleted successfully!');
    }
    // Helper to update dorm summary
    private function updateDormSummary($dormId)
    {
        $reviews = DB::table('dorm_reviews')
            ->where('dorm_id', $dormId)
            ->get();

        $dormReviewText = $reviews->pluck('comment_text')->implode(' | '); // concatenate all reviews
        $avgRating = $reviews->avg('rating') ?? 0;

        DB::table('dorm')->where('id', $dormId)->update([
            'dorm_review' => $dormReviewText,
            'dorm_rating' => $avgRating,
        ]);
    }

}
