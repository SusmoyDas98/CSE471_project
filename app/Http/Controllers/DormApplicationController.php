<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use App\Models\DormApplication;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class DormApplicationController extends Controller
{
    // Show application form
    public function create($dormId)
    {
        $dorms = DB::table('dorms')->where('id', $dormId)->first();

        if (!$dorms) {
            return redirect()->route('dorms.index')->with('error', 'Dorm not found');
        }

        // Check if user already applied
        $existingApplication = DB::table('applications')
            ->where('dorm_id', $dormId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingApplication) {
            return back()->with('error', 'You have already applied to this dorm');
        }

        return view('dorms.apply', compact('dorms'));
    }

    // Submit application
    public function store(Request $request, $dormId)
    {
        $request->validate([
            'Student_id' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'Government_id' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'Personal_photo' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'Reference' => 'nullable|string|max:1000',
        ]);

        $dorms = DB::table('dorms')->where('id', $dormId)->first();

        if (!$dorms) {
            return redirect()->route('dorms.index')->with('error', 'Dorm not found');
        }

        // Check if user already applied
        $existingApplication = DB::table('applications')
            ->where('dorm_id', $dormId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingApplication) {
            return back()->with('error', 'You have already applied to this dorm');
        }

        // Store uploaded files
        $studentPath = $request->file('Student_id')->store('applications/student_ids', 'public');
        $governmentPath = $request->file('Government_id')->store('applications/government_ids', 'public');
        $photoPath = $request->file('Personal_photo')->store('applications/personal_photos', 'public');

        // Create application using model to get id
        $application = DormApplication::create([
            'dorm_id' => $dormId,
            'user_id' => Auth::id(),
            'status' => 'Pending',
            'Student_id' => $studentPath,
            'Government_id' => $governmentPath,
            'Personal_photo' => $photoPath,
            'Reference' => $request->input('Reference'),
            'applied_at' => now(),
        ]);

        // Notify dorm owner
        $applicantName = Auth::user()->name;
        Notification::create([
            'user_id' => $dorms->owner_id,
            'type' => 'application',
            'title' => 'New Dorm Application',
            'message' => $applicantName . ' has applied to your dorm: ' . $dorms->name,
            'related_id' => $application->id,
            'is_read' => 0,
        ]);

        return redirect()->route('dorms.show', $dormId)->with('success', 'Application submitted successfully! The owner will be notified.');
    }

    // View my applications (for dorm seekers)
    public function myApplications()
    {
        $applications = DB::table('applications')
            ->join('dorms', 'applications.dorm_id', '=', 'dorms.id')
            ->where('applications.user_id', Auth::id())
            ->select('applications.*', 'dorms.name as dorm_name', 'dorms.location')
            ->orderBy('applications.created_at', 'desc')
            ->get();

        return view('applications.my-applications', compact('applications'));
    }

    // View applications for my dorms (for dorm owners)
    public function receivedApplications()
    {
        $applications = DB::table('applications')
            ->join('dorms', 'applications.dorm_id', '=', 'dorms.id')
            ->join('users', 'applications.user_id', '=', 'users.id')
            ->where('dorms.owner_id', Auth::id())
            ->whereRaw("LOWER(applications.status) = 'pending'") // only pending (case-insensitive)
            ->select('applications.*', 'dorms.name as dorm_name', 'users.name as applicant_name', 'users.email as applicant_email')
            ->orderBy('applications.created_at', 'desc')
            ->get();

        return view('applications.received-applications', compact('applications'));
    }

    // Serve stored application documents securely (owner or applicant)
    public function serveDocument($id, $type)
    {
        $application = DormApplication::findOrFail($id);

        // get dorm owner id
        $dorm = DB::table('dorms')->where('id', $application->dorm_id)->first();
        $ownerId = $dorm ? $dorm->owner_id : null;

        if (Auth::id() !== $application->user_id && Auth::id() !== $ownerId) {
            abort(403);
        }

        $map = [
            'student' => 'Student_id',
            'government' => 'Government_id',
            'photo' => 'Personal_photo',
        ];

        if (!isset($map[$type])) {
            abort(404);
        }

        $column = $map[$type];
        $path = $application->{$column};

        if (!$path) {
            abort(404);
        }

        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath)) {
            abort(404);
        }

        return response()->file($fullPath);
    }

    // Owner approves an application
    public function approve($id)
    {
        $application = DormApplication::findOrFail($id);

        $dorm = DB::table('dorms')->where('id', $application->dorm_id)->first();
        if (!$dorm) {
            return back()->with('error', 'Dorm not found');
        }

        if (Auth::id() !== $dorm->owner_id) {
            abort(403);
        }

        if (strtolower($application->status) !== 'pending') {
            return back()->with('info', 'Application already processed.');
        }

        $application->status = 'Approved';
        $application->save();

        // notify applicant
        Notification::create([
            'user_id' => $application->user_id,
            'type' => 'application_status',
            'title' => 'Application Approved',
            'message' => 'Your application for dorm "' . ($dorm->name ?? 'Dorm') . '" has been approved.',
            'related_id' => $application->id,
            'is_read' => 0,
        ]);

        return back()->with('success', 'Application approved and applicant notified.');
    }

    // Owner declines an application
    public function decline($id)
    {
        $application = DormApplication::findOrFail($id);

        $dorm = DB::table('dorms')->where('id', $application->dorm_id)->first();
        if (!$dorm) {
            return back()->with('error', 'Dorm not found');
        }

        if (Auth::id() !== $dorm->owner_id) {
            abort(403);
        }

        if (strtolower($application->status) !== 'pending') {
            return back()->with('info', 'Application already processed.');
        }

        $application->status = 'Declined';
        $application->save();

        // notify applicant
        Notification::create([
            'user_id' => $application->user_id,
            'type' => 'application_status',
            'title' => 'Application Declined',
            'message' => 'Your application for dorm "' . ($dorm->name ?? 'Dorm') . '" has been declined.',
            'related_id' => $application->id,
            'is_read' => 0,
        ]);

        return back()->with('success', 'Application declined and applicant notified.');
    }
}