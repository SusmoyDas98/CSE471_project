<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RoommateConnection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeekerProfileController extends Controller
{
    public function index(Request $request)
    {
        // Get all seekers (excluding current user) who have filled their preferences
        $query = User::where('role', 'seeker')
            ->where('id', '!=', Auth::id())
            ->whereHas('detail')
            ->with('detail');

        // Get current user's sent roommate connections
        $myConnections = Auth::user()->sentRoommateConnections()->pluck('selected_roommate_id')->all();

        // Filter by search term (name, bio, interests, preferred universities)
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $searchTerms = explode(' ', $search); // Split search into multiple terms
            $query->where(function ($q) use ($search, $searchTerms) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('detail', function ($detailQuery) use ($search, $searchTerms) {
                        $detailQuery->where('bio', 'like', "%{$search}%");
                        // Check each search term against interests and universities
                        foreach ($searchTerms as $term) {
                            $term = trim($term);
                            if ($term) {
                                $detailQuery->orWhereJsonContains('interests', $term)
                                    ->orWhereJsonContains('preferred_areas', $term);
                            }
                        }
                    });
            });
        }

        // Filter by gender preference
        if ($request->has('gender_pref') && $request->gender_pref) {
            $query->whereHas('detail', function ($q) use ($request) {
                $q->where('gender_pref', $request->gender_pref);
            });
        }

        // Filter by smoking preference
        if ($request->has('smoking') && $request->smoking !== '') {
            $query->whereHas('detail', function ($q) use ($request) {
                $q->where('smoking', $request->boolean('smoking'));
            });
        }

        // Filter by pet friendly
        if ($request->has('pet_friendly') && $request->pet_friendly !== '') {
            $query->whereHas('detail', function ($q) use ($request) {
                $q->where('pet_friendly', $request->boolean('pet_friendly'));
            });
        }

        // Filter by budget range
        if ($request->has('budget_min') && $request->budget_min) {
            $query->whereHas('detail', function ($q) use ($request) {
                $q->where(function ($budgetQuery) use ($request) {
                    $budgetQuery->where('budget_max', '>=', $request->budget_min)
                        ->orWhereNull('budget_max');
                });
            });
        }

        if ($request->has('budget_max') && $request->budget_max) {
            $query->whereHas('detail', function ($q) use ($request) {
                $q->where(function ($budgetQuery) use ($request) {
                    $budgetQuery->where('budget_min', '<=', $request->budget_max)
                        ->orWhereNull('budget_min');
                });
            });
        }

        $seekers = $query->latest()->paginate(12);

        return view('seeker.profiles.index', compact('seekers', 'myConnections'));
    }

    public function show(User $user)
    {
        // Ensure user is a seeker and has details
        if ($user->role !== 'seeker' || !$user->detail) {
            abort(404, 'Seeker profile not found.');
        }

        // Don't allow viewing own profile through this route
        if ($user->id === Auth::id()) {
            return redirect()->route('profile.preferences.edit');
        }

        $user->load('detail');

        // Check if current user has selected this user as roommate
        $roommateConnection = RoommateConnection::where('seeker_id', Auth::id())
            ->where('selected_roommate_id', $user->id)
            ->first();

        return view('seeker.profiles.show', compact('user', 'roommateConnection'));
    }

    public function selectRoommate(Request $request, User $user)
    {
        // Ensure user is a seeker and has details
        if ($user->role !== 'seeker' || !$user->detail) {
            abort(404, 'Seeker profile not found.');
        }

        // Don't allow selecting yourself
        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'You cannot select yourself as a roommate.']);
        }

        // Check if already selected
        $existing = RoommateConnection::where('seeker_id', Auth::id())
            ->where('selected_roommate_id', $user->id)
            ->first();

        if ($existing) {
            return back()->withErrors(['error' => 'You have already selected this seeker as a potential roommate.']);
        }

        $data = $request->validate([
            'message' => ['nullable', 'string', 'max:500'],
        ]);

        RoommateConnection::create([
            'seeker_id' => Auth::id(),
            'selected_roommate_id' => $user->id,
            'status' => 'pending',
            'message' => $data['message'] ?? null,
        ]);

        return back()->with('status', 'You have selected ' . $user->name . ' as a potential roommate! They can view your selection in their profile.');
    }

    public function removeRoommate(User $user)
    {
        $connection = RoommateConnection::where('seeker_id', Auth::id())
            ->where('selected_roommate_id', $user->id)
            ->first();

        if ($connection) {
            $connection->delete();
            return back()->with('status', 'Roommate selection removed.');
        }

        return back()->withErrors(['error' => 'Roommate connection not found.']);
    }
}
