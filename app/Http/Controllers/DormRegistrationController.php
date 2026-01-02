<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dorm_registration_submission;
use App\Models\User;
use App\Models\User_details;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Dorm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DormRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $user_role = "user";
        if ($user_role == "admin") {
            return redirect()->route("dorm_reg_admin_view");
        } else {
            return redirect()->route("dorm_reg");
        }
    }
    

    public function admin_view(){
        $all_submissions = Dorm_registration_submission::where('status', 'Pending')->get();
        $all_pending = Dorm_registration_submission::where('status', 'Pending')->count();
        $total_submissions = Dorm_registration_submission::count();
        $all_approved = Dorm_registration_submission::where('status', 'Approved')->count();
        $all_declined = Dorm_registration_submission::where('status', 'Declined')->count();
        return view("dorm_reg_admin_view", ["all_submissions" => $all_submissions, "all_approved" => $all_approved, 'all_declined' => $all_declined, "total_submissions" => $total_submissions, "all_pending" => $all_pending]);
    }

    public function user_view(){
        return view("dorm_reg");
    }
    public function submitted_dorm_view($id){
        $submission_infos = Dorm_registration_submission::find($id);
        $dorm_owner_infos = User_details::select("user_id","gender","age","contact_number")
                                ->where('user_id', $submission_infos->owner_id)
                                ->first();
        $dorm_owner_user_infos = User::select("name","email","role","subscription_type",'created_at')
                                ->where('id', $submission_infos->owner_id)
                                ->first();                                
        $status_update = false;
        if($submission_infos->status !== "Pending"){
            $status_update = true;
        }
        return view("submitted_dorm", [
            "submission_infos" => $submission_infos, 
            "dorm_owner_infos" => $dorm_owner_infos,
            "dorm_owner_user_infos" => $dorm_owner_user_infos,
            "status_update" => $status_update
        ]);
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


public function store(Request $request)
{
    $status = "Pending";

    $request->validate([
        'owner_name' => 'required|string|max:255',
        'owner_phone' => 'required|string',
        'dorm_name' => 'required|string|max:255',
        'dorm_address' => 'required|string|max:255',
        "latitude" =>'nullable|numeric',
        "longitude" =>"nullable|numeric",
        'num_rooms' => 'required|integer|min:1',
        'room_types' => 'required|array',
        'room_types.*' => 'required|string|max:255',
        'national_id' => 'required|mimes:png,jpg,pdf|max:5000',
        'passport' => 'required|mimes:png,jpg,pdf|max:5000',
        'ownership_document' => 'required',
        'ownership_document.*' => 'required|mimes:png,jpg,pdf|max:5000',

        'dorm_pictures' => 'required|array|min:1|max:5',
        'dorm_pictures.*' => 'required|image|mimes:png,jpg|max:5000',
        // 'gender' => 'required|string|in:Male,Female,Not Gender Specified',
        'gender' => 'required|string',
        'student_only' => 'required|string|in:Yes,No',
        'expected_matrimonial_status' => 'required|string',
        'facilities' => 'required|array',
        'facilities.*' => 'string', 
        'facilities_other' => 'nullable|string|max:255',
    ], []);

    if(!$request->latitude || !$request->longitude){
        return redirect()->back()
            ->withInput()
            ->withErrors(['location' => 'Location must be pointed on the map']);
    }

    DB::beginTransaction();
    $roomTypesArray = array_map('trim', explode(',', $request->room_types[0] ?? $request->room_types));
    $roomTypesArray = array_map("ucwords", $roomTypesArray);

    // Handle facilities
// Handle facilities
$facilities = $request->input('facilities', []);

// Only process 'facilities_other' if the "Other" checkbox is checked
if (in_array('Other', $facilities) && $request->filled('facilities_other')) {
    // Split by comma, trim spaces
    $otherFacilities = array_map('trim', explode(',', $request->input('facilities_other')));
    // Merge with existing facilities
    $facilities = array_merge($facilities, $otherFacilities);
}

// Remove the literal "Other" entry
$facilities = array_filter($facilities, function($f) {
    return strtolower($f) !== 'other';
});

// Reindex array to have clean sequential numeric indexes starting from 0
$facilities = array_values($facilities);

    try {
        // dd($request->all());
        Dorm_registration_submission::create([
            "owner_id" => 1,
            "dorm_owner_name" => $request->owner_name,
            "dorm_hotline" => $request->owner_phone,
            "dorm_name" => $request->dorm_name,
            "dorm_location" => $request->dorm_address,
            "latitude" => $request->latitude,
            "longitude"  => $request->longitude,
            "number_of_rooms" => $request->num_rooms,
            "status" => $status,
            "room_types" => json_encode($roomTypesArray),
            "gender_preference" => $request->gender,
            "student_only" => $request->student_only,
            "expected_marital_status" => $request->expected_matrimonial_status,
            "facilities" => json_encode($facilities), // store as JSON
            "owner_national_id" => $request->file('national_id')->store('dorm_registrations/national_ids', 'public'),
            "passport" => $request->file('passport')->store('dorm_registrations/passports', 'public'),
            "property_ownership_doc" => json_encode(collect($request->file('ownership_document'))->map(function ($file) {
                return $file->store('dorm_registrations/ownership_documents', 'public');
            })->toArray()),          
            "dorm_pictures" => json_encode(collect($request->file('dorm_pictures'))->map(function ($file) {
                return $file->store('dorm_registrations/dorm_pictures', 'public');
            })->toArray())
        ]);

        DB::commit();
        return redirect()->route("dorm_reg")->with('status', 'Successfully submitted to the admins for approval');
    } catch (\Throwable $error) {
        dd($error);
        DB::rollBack();
        Log::error("Submission Failed!!!", ['error' => $error->getMessage()]);
        return redirect()->back()
            ->withInput()
            ->withErrors(['submission_error' => "Something went wrong while submitting!!! Please try again..."]);
    }
}


    // public function approve($id){
    //     $infos = Dorm_registration_submission::findOrFail($id);
        
    //     Dorm::create([
    //         "owner_id"   => $infos->owner_id,
    //         "name"       => $infos->dorm_name,
    //         "dorm_location"   => $infos->dorm_location,	
    //         "latitude" =>   $infos->latitude,
    //         "longitude"  => $infos->longitude,            
    //         "dorm_review"=> 0.0,
    //         "room_count" => $infos->number_of_rooms,
    //         "room_types" => is_array($infos->room_types) ? json_encode($infos->room_types) : $infos->room_types,
    //         "status"     => "approved"
    //     ]);

    //     $infos->update([
    //         'status' => 'approved'
    //     ]);

    //     return redirect()->back()->with(['status'=>'Approved','message'=>'Dorm registration approved successfully.']);
    // }



    
    // public function decline($id){
    //     // return $dec_id;
    //     $infos = Dorm_registration_submission::findOrFail($id);

    //     $infos->update(
    //         ['status' => 'declined'],        );
        
    //     return redirect()->back()->with(['status'=>"Declined",'message'=>'Dorm Registration Application Declined successfully.']);

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
