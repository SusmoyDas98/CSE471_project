<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::whereHas('vacancy.room.dorm', function ($q) {
            $q->where('user_id', Auth::id());
        })->with(['vacancy.room.dorm', 'seeker.detail']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by dorm
        if ($request->has('dorm_id') && $request->dorm_id) {
            $query->whereHas('vacancy.room', function ($q) use ($request) {
                $q->where('dorm_id', $request->dorm_id);
            });
        }

        $applications = $query->latest()->paginate(20);

        // Get statistics
        $stats = [
            'total' => Application::whereHas('vacancy.room.dorm', function ($q) {
                $q->where('user_id', Auth::id());
            })->count(),
            'pending' => Application::whereHas('vacancy.room.dorm', function ($q) {
                $q->where('user_id', Auth::id());
            })->where('status', 'submitted')->count(),
            'reviewing' => Application::whereHas('vacancy.room.dorm', function ($q) {
                $q->where('user_id', Auth::id());
            })->where('status', 'reviewing')->count(),
            'accepted' => Application::whereHas('vacancy.room.dorm', function ($q) {
                $q->where('user_id', Auth::id());
            })->where('status', 'accepted')->count(),
        ];

        // Get owner's dorms for filter
        $dorms = \App\Models\Dorm::where('user_id', Auth::id())->get();

        return view('owner.applications.index', compact('applications', 'stats', 'dorms'));
    }

    public function byVacancy(Vacancy $vacancy)
    {
        $this->authorizeVacancy($vacancy);

        $applications = $vacancy->applications()->with('seeker.detail')->latest()->get();

        return view('owner.applications.by-vacancy', compact('vacancy', 'applications'));
    }

    public function show(Application $application)
    {
        $this->authorizeVacancy($application->vacancy);

        $application->load(['vacancy.room.dorm', 'seeker.detail']);

        // Generate document URL if exists
        $documentUrl = null;
        if ($application->seeker->detail && $application->seeker->detail->verification_document) {
            $documentUrl = Storage::disk('public')->url($application->seeker->detail->verification_document);
        }

        return view('owner.applications.show', compact('application', 'documentUrl'));
    }

    public function viewSeekerDocument(Application $application)
    {
        $this->authorizeVacancy($application->vacancy);

        $detail = $application->seeker->detail;

        if (!$detail || !$detail->verification_document) {
            abort(404, 'Document not found');
        }

        if (!Storage::disk('public')->exists($detail->verification_document)) {
            abort(404, 'File not found');
        }

        return Storage::disk('public')->response($detail->verification_document);
    }

    public function updateStatus(Request $request, Application $application)
    {
        $this->authorizeVacancy($application->vacancy);

        $data = $request->validate([
            'status' => ['required', 'in:submitted,reviewing,accepted,rejected,waitlisted'],
            'owner_notes' => ['nullable', 'string'],
        ]);

        $application->update($data);

        // If accepted, optionally reject other applications for the same vacancy
        if ($data['status'] === 'accepted' && $request->boolean('reject_others')) {
            $application->vacancy->applications()
                ->where('id', '!=', $application->id)
                ->where('status', '!=', 'rejected')
                ->update(['status' => 'rejected']);
        }

        $statusMessage = match ($data['status']) {
            'accepted' => 'Application accepted! The seeker will be notified of your decision.',
            'rejected' => 'Application rejected. The seeker will be notified of your decision.',
            'waitlisted' => 'Application waitlisted. The seeker will be notified.',
            default => 'Application status updated successfully.'
        };

        return back()->with('status', $statusMessage);
    }

    public function quickAction(Request $request, Application $application)
    {
        $this->authorizeVacancy($application->vacancy);

        $action = $request->input('action');

        if (in_array($action, ['accept', 'reject', 'waitlist'])) {
            $statusMap = [
                'accept' => 'accepted',
                'reject' => 'rejected',
                'waitlist' => 'waitlisted',
            ];

            $application->update(['status' => $statusMap[$action]]);

            // If accepted, optionally reject others
            if ($action === 'accept' && $request->boolean('reject_others')) {
                $application->vacancy->applications()
                    ->where('id', '!=', $application->id)
                    ->where('status', '!=', 'rejected')
                    ->update(['status' => 'rejected']);
            }

            $statusMessage = match ($action) {
                'accept' => 'Application accepted! The seeker will be notified that they have been selected.',
                'reject' => 'Application rejected. The seeker will be notified of your decision.',
                'waitlist' => 'Application waitlisted. The seeker will be notified.',
                default => 'Application ' . $action . 'ed successfully.'
            };

            return back()->with('status', $statusMessage);
        }

        return back()->withErrors(['action' => 'Invalid action.']);
    }

    private function authorizeVacancy(Vacancy $vacancy): void
    {
        if ($vacancy->room->dorm->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
