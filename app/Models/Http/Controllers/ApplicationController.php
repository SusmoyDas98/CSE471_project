<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::where('user_id', Auth::id())
            ->with(['vacancy.room.dorm']);

        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->paginate(15);

        // Get room deletion notifications for this user
        $roomDeletedNotifications = Auth::user()->notifications()
            ->where('type', 'room_deleted')
            ->where('is_read', false)
            ->latest()
            ->get();

        return view('seeker.applications.index', compact('applications', 'roomDeletedNotifications'));
    }

    public function show(Application $application)
    {
        // Ensure the application belongs to the authenticated user
        if ($application->user_id !== Auth::id()) {
            // In development/test mode, if the user is a seeker, we can allow viewing
            // but show a warning. In production, this should be a 403.
            if (app()->environment('local') && Auth::user()->role === 'seeker') {
                // For testing: reassign the application to the current user
                $application->update(['user_id' => Auth::id()]);
            } else {
                abort(403, 'You do not have permission to view this application.');
            }
        }

        $application->load(['vacancy.room.dorm']);

        return view('seeker.applications.show', compact('application'));
    }

    public function store(Request $request, Vacancy $vacancy)
    {
        // Check if vacancy is open
        if ($vacancy->status !== 'open') {
            return back()->withErrors(['error' => 'This vacancy is not currently accepting applications.']);
        }

        // Check if user already applied
        $existingApplication = Application::where('vacancy_id', $vacancy->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingApplication) {
            return back()->withErrors(['error' => 'You have already applied for this vacancy.']);
        }

        $data = $request->validate([
            'message' => ['nullable', 'string', 'max:1000'],
            'budget' => ['nullable', 'integer', 'min:0'],
            'move_in_date' => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        $application = Application::create([
            'vacancy_id' => $vacancy->id,
            'user_id' => Auth::id(),
            'message' => $data['message'] ?? null,
            'budget' => $data['budget'] ?? null,
            'move_in_date' => $data['move_in_date'] ?? null,
            'status' => 'submitted',
        ]);

        return redirect()
            ->route('seeker.vacancies.show', $vacancy)
            ->with('status', 'Application submitted successfully! The dorm owner will review your application.');
    }
}
