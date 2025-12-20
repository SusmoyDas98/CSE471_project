<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website_Reviews;

use function PHPUnit\Framework\isEmpty;

class Website_review_controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $all_reviews = Website_Reviews::orderBy('created_at', 'desc')->get();
        $user_id = 19;
        if (Website_Reviews::where('user_id', $user_id)->exists()) {
            return view("website_feedback", ['already_have'=> 'You have already submitted a review. Thank you for your Participation 😃!','all_reviews'=>$all_reviews]);
        }
        else{
            return view("website_feedback", ['all_reviews'=>$all_reviews]); 
        }
       }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    //     // dd($request->all());
    //     $request->validate([
    //         'review_text' => 'string|max:500',
    //         'rating' => 'required|integer|min:1|max:5',
    //     ]);
    //     Website_Reviews::create([
    //         'user_id' => "12",
    //         'user_name' => "Kakashi Hatake",
    //         'message' => $request->review_text,
    //         'rating' => $request->rating,
    //     ]);
    //     return redirect()->route('website_feedback.index')->with('success', 'Thank you for your review!');
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
