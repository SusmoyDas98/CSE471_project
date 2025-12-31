<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DormRegistrationSubmission;
use App\Models\Dorm;
use App\Models\Notification;
use App\Models\DormApplication;
use Illuminate\Support\Facades\Auth;


class DormRegistrationController extends Controller
{

    // Show dorm registration form
    public function create()
    {
        return view('dorms.dorm-register'); // matches your Blade file
    }

    // Handle form submission
    public function store(Request $request)
    {
        $request->validate([
            'dorm_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'number_of_rooms' => 'required|integer|min:1',
            'room_types' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $submission = DormRegistrationSubmission::create([
            'dorm_name' => $request->dorm_name,
            'dorm_location' => $request->location,
            'number_of_rooms' => $request->number_of_rooms,
            'room_types' => $request->room_types,
            'description' => $request->description,
            'owner_id' => auth()->id(),
            'dorm_owner_name' => auth()->user()->name,
            'dorm_owner_email' => auth()->user()->email,
            'submitted_at' => now(),
        ]);

        // Notify all admins about new dorm registration

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

        return redirect()->back()->with('success', 'Dorm registration submitted successfully!');
    }    

// Show pending dorm registrations (only pending ones)
public function pendingRegistrations()
{
    $pendingDorms = DormRegistrationSubmission::where('status', 'pending')
        ->orderBy('submitted_at', 'desc')
        ->get();

    return view('admin.pending-dorms', compact('pendingDorms'));
}

// Approve dorm
public function approve($id)
{
    $submission = DormRegistrationSubmission::findOrFail($id);

    // Add to dorms table
    Dorm::create([
        'name' => $submission->dorm_name,
        'location' => $submission->dorm_location,
        'number_of_rooms' => $submission->number_of_rooms,
        'room_types' => $submission->room_types,
        'owner_id' => $submission->owner_id,
    ]);

    // Update status and reviewed_at
    $submission->update([
        'status' => 'approved',
        'reviewed_at' => now(),
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

// Decline dorm
public function decline(Request $request, $id)
{
    $submission = DormRegistrationSubmission::findOrFail($id);
    $reason = $request->input('reason');

    // Update status and reviewed_at
    $submission->update([
        'status' => 'declined',
        'reviewed_at' => now(),
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
