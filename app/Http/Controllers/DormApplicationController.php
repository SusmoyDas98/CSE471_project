<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

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
        $existingApplication = DB::table('dorm_applications')
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
            'message' => 'required|string|max:1000',
        ]);

        $dorms = DB::table('dorms')->where('id', $dormId)->first();

        if (!$dorms) {
            return redirect()->route('dorms.index')->with('error', 'Dorm not found');
        }

        // Check if user already applied
        $existingApplication = DB::table('dorm_applications')
            ->where('dorm_id', $dormId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingApplication) {
            return back()->with('error', 'You have already applied to this dorm');
        }

        // Create application
        DB::table('dorm_applications')->insert([
            'dorm_id' => $dormId,
            'user_id' => Auth::id(),
            'status' => 'pending',
            'message' => $request->message,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Notify dorm owner
        $applicantName = Auth::user()->name;
        Notification::create([
            'user_id' => $dorm->owner_id,
            'type' => 'application',
            'title' => 'New Dorm Application',
            'message' => $applicantName . ' has applied to your dorm: ' . $dorms->name,
            'related_id' => $dormId,
            'is_read' => 0,
        ]);

        return redirect()->route('dorms.show', $dormId)->with('success', 'Application submitted successfully! The owner will be notified.');
    }

    // View my applications (for dorm seekers)
    public function myApplications()
    {
        $applications = DB::table('dorm_applications')
            ->join('dorms', 'dorm_applications.dorm_id', '=', 'dorms.id')
            ->where('dorm_applications.user_id', Auth::id())
            ->select('dorm_applications.*', 'dorms.name as dorm_name', 'dorms.location')
            ->orderBy('dorm_applications.created_at', 'desc')
            ->get();

        return view('applications.my-applications', compact('applications'));
    }

    // View applications for my dorms (for dorm owners)
    public function receivedApplications()
    {
        $applications = DB::table('dorm_applications')
            ->join('dorms', 'dorm_applications.dorm_id', '=', 'dorms.id')
            ->join('users', 'dorm_applications.user_id', '=', 'users.id')
            ->where('dorms.owner_id', Auth::id())
            ->where('dorm_applications.status', 'pending') // only pending
            ->select('dorm_applications.*', 'dorms.name as dorm_name', 'users.name as applicant_name', 'users.email as applicant_email')
            ->orderBy('dorm_applications.created_at', 'desc')
            ->get();

        return view('applications.received-applications', compact('applications'));
    }
}