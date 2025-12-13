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
            ->select('dorm.*', DB::raw('AVG(dorm_reviews.rating) as avg_rating'), DB::raw('COUNT(dorm_reviews.id) as review_count'))
            ->leftJoin('dorm_reviews', 'dorm.id', '=', 'dorm_reviews.dorm_id')
            ->groupBy('dorm.id', 'dorm.owner_id', 'dorm.name', 'dorm.location', 'dorm.room_count', 'dorm.room_types', 'dorm.status', 'dorm.created_at', 'dorm.updated_at')
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

    // Store review
    public function storeReview(Request $request, $dormId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to leave a review!');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment_text' => 'required|string|min:10|max:1000',
        ]);

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

        return back()->with('success', 'Review deleted successfully!');
    }
}
