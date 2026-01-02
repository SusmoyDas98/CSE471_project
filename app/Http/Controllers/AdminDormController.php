<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DormRegistrationSubmission;
use App\Models\Dorm;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class AdminDormController extends Controller
{
    // Approve dorm
    public function approve($id)
    {
        $submission = DormRegistrationSubmission::findOrFail($id);

        // Create new dorm entry
        Dorm::create([
            'name' => $submission->dorm_name,
            'location' => $submission->dorm_location,
            'number_of_rooms' => $submission->number_of_rooms,
            'room_types' => $submission->room_types,
            'owner_id' => $submission->owner_id,
        ]);

        // Send notification to owner
        Notification::create([
            'user_id' => $submission->owner_id,
            'type' => 'dorm_registration',
            'title' => 'Dorm Registration Approved',
            'message' => "Your dorm '{$submission->dorm_name}' has been approved by the admin!",
            'related_id' => null,
            'is_read' => false,
        ]);

        // Remove from submissions table
        $submission->delete();

        return redirect()->back()->with('success', 'Dorm approved successfully!');
    }

    // Decline dorm
    public function decline(Request $request, $id)
    {
        $submission = DormRegistrationSubmission::findOrFail($id);

        $reason = $request->input('reason');

        // Send notification to owner
        Notification::create([
            'user_id' => $submission->owner_id,
            'type' => 'dorm_registration',
            'title' => 'Dorm Registration Declined',
            'message' => "Your dorm '{$submission->dorm_name}' was declined. Reason: $reason",
            'related_id' => null,
            'is_read' => false,
        ]);

        // Remove from submissions table
        $submission->delete();

        return redirect()->back()->with('success', 'Dorm declined successfully!');
    }
}
