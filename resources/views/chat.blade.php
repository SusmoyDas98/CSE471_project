<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DormMate | Chat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
</head>
<body>

<nav class="navbar">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="#">DormMate</a>
        <div class="nav-links">
            <a href="#"><i class="fas fa-home"></i> Home</a>
            <a href="#" class="active"><i class="fas fa-comments"></i> Chat</a>
            <a href="#"><i class="fas fa-credit-card"></i> Payments</a>
            <a href="#"><i class="fas fa-wrench"></i> Maintenance</a>
            <a href="#"><i class="fas fa-user"></i> Profile</a>
        </div>
    </div>
</nav>

<div class="chat-container">

    <!-- USERS LIST -->
    <div class="users-panel">
        <h4 class="panel-title">
            <i class="fas fa-users"></i> Users
        </h4>

        @foreach($users as $user)
            <a href="{{ route('chat.show', $user->id) }}" class="chat-user">
                <div class="user-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="user-info">
                    <div class="user-name">{{ $user->name }}</div>
                    <small>Tap to chat</small>
                </div>
            </a>
        @endforeach
    </div>

    <!-- CHAT PANEL -->
    <div class="chat-panel">

        @if($selectedUser)
            <!-- HEADER -->
            <div class="chat-header">
                <div class="chat-header-avatar">
                    {{ strtoupper(substr($selectedUser->name, 0, 1)) }}
                </div>
                <div>
                    <h5>{{ $selectedUser->name }}</h5>
                    <small class="status">Online</small>
                </div>
            </div>

            <!-- MESSAGE AREA (SCROLLS) -->
            <div class="chat-messages">
                @foreach($messages as $message)
                    @php $isMe = $message->sender_id == $authUserId; @endphp

                    <div class="chat-row {{ $isMe ? 'me' : 'them' }}">
                        <div class="chat-bubble {{ $isMe ? 'me' : 'them' }}">
                            <p>{{ $message->message }}</p>
                            <span class="chat-time">
                                {{ \Carbon\Carbon::parse($message->sent_at)->format('h:i A') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- INPUT -->
            <form method="POST" action="{{ route('chat.send') }}" class="chat-input">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $selectedUser->id }}">
                <input type="text" name="message" placeholder="Type your message..." required>
                <button type="submit">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>

        @else
            <div class="chat-empty">
                <i class="fas fa-comments"></i>
                <h3>Select a user to start chatting</h3>
                <p>Choose a user from the left panel</p>
            </div>
        @endif

    </div>
</div>

</body>
</html>
