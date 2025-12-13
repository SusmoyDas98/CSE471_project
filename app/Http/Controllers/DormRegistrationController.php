<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dorm_registration_submission;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Dorm;

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
        $dorm_owner_infos = User::select("id","name","email","role","subscription_type","created_at")
                                ->where('id', $submission_infos->owner_id)
                                ->first();

        return view("submitted_dorm", [
            "submission_infos" => $submission_infos, 
            "dorm_owner_infos" => $dorm_owner_infos
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
        //
        $status = "pending";

        $request->validate([
            'owner_name' => 'required|string|max:255',
            'owner_phone' => 'required|string',
            'dorm_name' => 'required|string|max:255',
            'dorm_location' => 'required|string|max:255',
            'num_rooms' => 'required|integer|min:1',
            'room_types' => 'required|array',
            'room_types.*' => 'required|string|max:255',
            'national_id' => 'required|mimes:png,jpg,pdf|max:5000',
            'passport' => 'required|mimes:png,jpg,pdf|max:5000',
            'ownership_document' => 'required|mimes:png,jpg,pdf|max:5000',
            'dorm_pictures' => 'required|array|min:1|max:5',
            'dorm_pictures.*' => 'required|image|mimes:png,jpg|max:5000'
        ]);
        // dd($request->all());
        $roomTypesArray = array_map('trim', explode(',', $request->room_types[0] ?? $request->room_types));

        Dorm_registration_submission::create([
            "owner_id" => "12",
            "dorm_owner_name" => $request->owner_name,
            "phone_number" => $request->owner_phone,
            "dorm_name" => $request->dorm_name,
            "dorm_location" => $request->dorm_location,
            "number_of_rooms" => $request->num_rooms,
            "status" =>   $status,
            "room_types" => $roomTypesArray,
            "owner_nid" => $request->file('national_id')->store('dorm_registrations/national_ids', 'public'),
            "owner_passport" => $request->file('passport')->store('dorm_registrations/passports', 'public'),
            "property_document" => $request->file('ownership_document')->store('dorm_registrations/ownership_documents', 'public'),
            "dorm_images" => collect($request->file('dorm_pictures'))->map(function ($file) {
                return $file->store('dorm_registrations/dorm_pictures', 'public');
            })->toArray()
        ]);

        return redirect()->route("dorm_reg")->with('status', 'Successfully submitted to the admins for approval');


    }



    public function approve($id){
        $infos = Dorm_registration_submission::findOrFail($id);
        
        Dorm::create([
            "owner_id"   => $infos->owner_id,
            "name"       => $infos->dorm_name,
            "location"   => $infos->dorm_location,	
            "dorm_review"=> 0.0,
            "room_count" => $infos->number_of_rooms,
            "room_types" => is_array($infos->room_types) ? json_encode($infos->room_types) : $infos->room_types,
            "status"     => "approved"
        ]);

        $infos->update([
            'status' => 'approved'
        ]);

        return redirect()->back()->with(['status'=>'Approved','message'=>'Dorm registration approved successfully.']);
    }



    
    public function decline($id){
        // return $dec_id;
        $infos = Dorm_registration_submission::findOrFail($id);

        $infos->update(
            ['status' => 'declined'],        );
        
        return redirect()->back()->with(['status'=>"Declined",'message'=>'Dorm Registration Application Declined successfully.']);

    }


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
