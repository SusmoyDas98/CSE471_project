<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;

class ChatController extends Controller
{
    /**
     * Fake authenticated user ID for testing
     * CHANGE THIS VALUE to test as different users
     *
     * Valid IDs (from your DB): 12, 13, 14, 15, 16, 17
     */
    private $authUserId;

    public function __construct()
    {
        
        $this->authUserId = 14; // e.g. 12 = Hiroshi, 13 = Sarah, etc.
    }

    /**
     * Chat landing page (no user selected)
     */
    public function index()
    {
        $users = User::where('id', '!=', $this->authUserId)->get();

        return view('chat', [
            'users' => $users,
            'selectedUser' => null,
            'messages' => collect(),
            'authUserId' => $this->authUserId
        ]);
    }

    /**
     * Show chat with a specific user
     */
    public function show($userId)
    {
        $users = User::where('id', '!=', $this->authUserId)->get();
        $selectedUser = User::findOrFail($userId);

        $messages = Message::where(function ($query) use ($userId) {
                $query->where('sender_id', $this->authUserId)
                      ->where('receiver_id', $userId);
            })
            ->orWhere(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $this->authUserId);
            })
            ->orderBy('sent_at')
            ->get();

        return view('chat', [
            'users' => $users,
            'selectedUser' => $selectedUser,
            'messages' => $messages,
            'authUserId' => $this->authUserId
        ]);
    }

    /**
     * Send a message
     */
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        Message::create([
            'sender_id' => $this->authUserId,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => 0,
            'sent_at' => now()
        ]);

        return redirect()->route('chat.show', $request->receiver_id);
    }
}
