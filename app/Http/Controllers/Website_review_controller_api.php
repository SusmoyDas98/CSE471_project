<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Website_Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;

class Website_review_controller_api extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function get_reviews(Request $request, $type)
{
    // If "deleted" → fetch deleted
    if ($type === 'Deleted') {
        $reviews = Website_Reviews::where('label', 'Deleted')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    // If "hidden" → fetch hidden
    else if ($type === 'Hidden') {
        $reviews = Website_Reviews::where('label', 'Hidden')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    // Otherwise show visible reviews
    else {
        $reviews = Website_Reviews::whereNull('label')
            ->orWhere('label', 'Visible')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    return response()->json([
        'status'  => true,
        'reviews' => $reviews
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        
        $validated_request = Validator::make(
        $request->all(),[
            'user_id' => 'integer',
            'review_text' => 'string|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ],
    
    );

        if ($validated_request->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Kindly Fill The Review Completely',
                'errors' => $validated_request->errors()
            ], 401);
        }


        $add_review = Website_Reviews::create([
            'user_id' => "19",
            'user_name' => "Sakura Haruno",
            'message' => $request->review_text,
            'rating' => $request->rating,
        ]);

        return response()->json([
                'status' => true,
                'message' => 'Review Submitted Successfully',
                'review' => $add_review
            ], 201);
        }        

    
        // return redirect()->route('website_feedback.index')->with('success', 'Thank you for your review!');                
    

    public function update_label(Request $request, $message_id, $label)
    {
        //
        // dd($request->all());
        $review = Website_Reviews::findOrFail($message_id);
        if (!$review){
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Review Not Found',
                ]
                );
        }
        $review->label = $label;
        $review->labeled_at = Carbon::now();
        $review->save();
        return  response()->json([
            'status' => true,
            'message' => 'Review Label Updated Successfully',
        ]);

    }


}
