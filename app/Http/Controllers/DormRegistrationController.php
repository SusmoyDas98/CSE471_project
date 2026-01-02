<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Dorm_registration_submission;
use App\Models\Dorm;
use App\Models\Notification;
use App\Models\DormApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DormRegistrationController extends Controller
{
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
        return view("dorms.dorm_reg");
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

    // Show dorm registration form
    public function create()
    {
        return view('dorms.dorm_reg'); // matches your Blade file
    }

    // Handle form submission
    public function store(Request $request)
    {
        $status = 'pending';

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
            'ownership_document.*' => 'required|mimes:png,jpg|max:5000',

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
        $facilities = $request->input('facilities', []);
        if ($request->filled('facilities_other')) {
            $facilities[] = $request->input('facilities_other');
        }
try {
    $submission = Dorm_registration_submission::create([
        "owner_id" => auth()->id(), // use the actual logged-in user
        "dorm_owner_name" => $request->owner_name,
        "dorm_hotline" => $request->owner_phone,
        "dorm_name" => $request->dorm_name,
        "dorm_location" => $request->dorm_address,
        "latitude" => $request->latitude,
        "longitude"  => $request->longitude,
        "number_of_rooms" => $request->num_rooms,
        "status" => $status,
        "room_types" => $roomTypesArray,
        "gender_preference" => $request->gender,
        "student_only" => $request->student_only,
        "expected_marital_status" => $request->expected_matrimonial_status,
        "facilities" => $facilities,
        "owner_national_id" => $request->file('national_id')->store('dorm_registrations/national_ids', 'public'),
        "passport" => $request->file('passport')->store('dorm_registrations/passports', 'public'),
        "property_ownership_doc" => collect($request->file('ownership_document'))->map(function ($file) {
            return $file->store('dorm_registrations/ownership_documents', 'public');
        })->toArray(),          
        "dorm_pictures" => collect($request->file('dorm_pictures'))->map(function ($file) {
            return $file->store('dorm_registrations/dorm_pictures', 'public');
        })->toArray()
    ]);

    // ✅ Notify all admins BEFORE redirect
    $admins = User::where('role', 'admin')->get();
    foreach ($admins as $admin) {
        Notification::create([
            'user_id' => $admin->id,
            'type' => 'dorm_registration',
            'title' => 'New Dorm Registration',
            'message' => 'A new dorm "' . $submission->dorm_name .
                         '" has been registered by ' . auth()->user()->name .
                         ' and requires approval.',
            'related_id' => $submission->id,
            'is_read' => false,
        ]);
    }

    DB::commit();
    return redirect()->route("dorm_reg")->with('status', 'Successfully submitted to the admins for approval');
} catch (\Throwable $error) {
    DB::rollBack();
    Log::error("Submission Failed!!!", ['error' => $error->getMessage()]);
    return redirect()->back()
        ->withInput()
        ->withErrors(['submission_error' => "Something went wrong while submitting!!! Please try again..."]);
}


        return redirect()->back()->with('success', 'Dorm registration submitted successfully!');
    }    

    // Show pending dorm registrations (only pending ones)
    public function pendingRegistrations()
    {
        $pendingDorms = Dorm_registration_submission::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pending-dorms', compact('pendingDorms'));
    }

    // Approve dorm registration
    public function approve($id)
    {
        $submission = Dorm_registration_submission::findOrFail($id);

        // Add to dorms table
        Dorm::create([
            'name' => $submission->dorm_name,
            'location' => $submission->dorm_location,
            'dorm_hotline' => $submission->dorm_hotline,
            'number_of_rooms' => $submission->number_of_rooms,
            'room_types' => $submission->room_types,
            'owner_id' => $submission->owner_id,
            'gender_preference' => $submission->gender_preference,
            'student_only' => $submission->student_only,
            'expected_marital_status' => $submission->expected_marital_status,
            'facilities' => $submission->facilities,
            'latitude' => $submission->latitude,
            'longitude' => $submission->longitude,
            'dorm_images' => $submission->dorm_pictures,
            'property_document' => $submission->property_ownership_doc,
            'owner_passport' => $submission->passport,
        ]);

        // Update status and reviewed_at
        $submission->update([
            'status' => 'approved',
            'updated_at' => now(),
        ]);

        // Send notification
        Notification::create([
            'user_id' => $submission->owner_id,
            'type' => 'dorm_registration',
            'title' => 'Dorm Registration Approved',
            'message' => "Your dorm '{$submission->dorm_name}' has been approved!",
            'related_id' => null,
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Dorm approved successfully!');
    }

    // Decline dorm registration
    public function decline(Request $request, $id)
    {
        $submission = Dorm_registration_submission::findOrFail($id);
        $reason = $request->input('reason');

        // Update status and reviewed_at
        $submission->update([
            'status' => 'declined',
            'updated_at' => now(),
        ]);

        // Send notification
        Notification::create([
            'user_id' => $submission->owner_id,
            'type' => 'dorm_registration',
            'title' => 'Dorm Registration Declined',
            'message' => "Your dorm '{$submission->dorm_name}' was declined. Reason: $reason",
            'related_id' => null,
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Dorm declined successfully!');
    }



   // Approve application of dorm seeker
    public function approveApplication($id)
    {
        $application = DormApplication::findOrFail($id);

        $application->status = 'approved';
        $application->save();

        // Notify the dorm seeker
        Notification::create([
            'user_id' => $application->user_id, // correct column
            'type' => 'application',
            'title' => 'Application Approved',
            'message' => 'Your application for "' . $application->dorms->name . '" has been approved.',
            'is_read' => false,
        ]);

        return back()->with('success', 'Application approved successfully.');
    }


    // Decline application of dorm seeker
    public function declineApplication($id)
    {
        $application = DormApplication::findOrFail($id);

        $application->status = 'declined';
        $application->save();

        // Notify the dorm seeker
        Notification::create([
            'user_id' => $application->user_id, // correct column
            'type' => 'application',
            'title' => 'Application Declined',
            'message' => 'Your application for "' . $application->dorms->name . '" has been declined.',
            'is_read' => false,
        ]);

        return back()->with('success', 'Application declined successfully.');
    }



}
