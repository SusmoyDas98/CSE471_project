<?php

namespace App\Http\Controllers;

use App\Models\CommunityPost;
use App\Models\Dorm;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // If no user is authenticated, create/get a test user
        if (!$user) {
            $user = \App\Models\User::where('role', 'seeker')->first();
            if (!$user) {
                $user = \App\Models\User::create([
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'seeker',
                ]);
            }
            Auth::login($user, true);
        }

        $memberships = $user->communityDorms()->pluck('dorm_id')->all();
        $dorms = Dorm::withCount('communityPosts')->get();

        return view('community.index', compact('dorms', 'memberships'));
    }

    public function join(Dorm $dorm)
    {
        $user = Auth::user();

        // If no user is authenticated, create/get a test user
        if (!$user) {
            $user = \App\Models\User::where('role', 'seeker')->first();
            if (!$user) {
                $user = \App\Models\User::create([
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'seeker',
                ]);
            }
            Auth::login($user, true);
        }

        // Check if already a member
        if ($user->communityDorms->contains($dorm->id)) {
            return redirect()->route('community.index')->with('status', 'You are already a member of this community.');
        }

        $user->communityDorms()->syncWithoutDetaching([
            $dorm->id => ['joined_at' => now()],
        ]);

        return redirect()->route('community.index')->with('status', 'Successfully joined ' . $dorm->name . ' community!');
    }

    public function leave(Dorm $dorm)
    {
        $user = Auth::user();

        // Check if user is a member
        if (!$user->communityDorms->contains($dorm->id)) {
            return redirect()->route('community.index')->with('status', 'You are not a member of this community.');
        }

        $user->communityDorms()->detach($dorm->id);

        return redirect()->route('community.index')->with('status', 'Successfully left ' . $dorm->name . ' community.');
    }

    public function show(Dorm $dorm)
    {
        $user = Auth::user();

        // If no user is authenticated, create/get a test user
        if (!$user) {
            $user = \App\Models\User::where('role', 'seeker')->first();
            if (!$user) {
                $user = \App\Models\User::create([
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'seeker',
                ]);
            }
            Auth::login($user, true);
        }

        // If user is not a member, auto-join them (for testing purposes)
        if (!$user->communityDorms->contains($dorm->id)) {
            $user->communityDorms()->syncWithoutDetaching([
                $dorm->id => ['joined_at' => now()],
            ]);
            // Refresh the relationship
            $user->load('communityDorms');
        }

        $query = $dorm->communityPosts()
            ->whereNull('parent_id') // Only top-level posts
            ->with(['author', 'replies.author'])
            ->latest();

        if (!$user->is_subscribed) {
            $query->where('created_at', '>=', Carbon::now()->subMonths(3));
        }

        $posts = $query->paginate(20);

        return view('community.show', compact('dorm', 'posts'));
    }

    public function store(Request $request, Dorm $dorm)
    {
        $user = Auth::user();

        if (!$user->communityDorms->contains($dorm->id)) {
            abort(403, 'Join this dorm to post.');
        }

        $data = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
            'parent_id' => ['nullable', 'exists:community_posts,id'],
        ]);

        // If parent_id is provided, verify it belongs to the same dorm
        if ($data['parent_id']) {
            $parent = CommunityPost::findOrFail($data['parent_id']);
            if ($parent->dorm_id !== $dorm->id) {
                abort(403, 'Invalid parent post.');
            }
        }

        CommunityPost::create([
            'dorm_id' => $dorm->id,
            'user_id' => $user->id,
            'body' => $data['body'],
            'parent_id' => $data['parent_id'] ?? null,
        ]);

        $message = $data['parent_id'] ? 'Reply posted.' : 'Message posted.';
        return redirect()->route('community.show', $dorm)->with('status', $message);
    }
}
