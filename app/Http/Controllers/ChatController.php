<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;

class ChatController extends Controller
{
    private $authUserId;

    public function __construct()
    {
        $this->authUserId = 14; // fake auth user for testing
    }

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
            ->orderBy('id') // Use ID instead of sent_at
            ->get();

        return view('chat', [
            'users' => $users,
            'selectedUser' => $selectedUser,
            'messages' => $messages,
            'authUserId' => $this->authUserId
        ]);
    }

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

    // ✅ Add this inside the class
    /**
     * Fetch messages between auth user and selected user (JSON)
     */
    public function fetchMessages($userId)
    {
        $messages = Message::where(function ($query) use ($userId) {
                $query->where('sender_id', $this->authUserId)
                      ->where('receiver_id', $userId);
            })
            ->orWhere(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $this->authUserId);
            })
            ->orderBy('id') // works without sent_at column
            ->get();

        return response()->json($messages);
    }
}
