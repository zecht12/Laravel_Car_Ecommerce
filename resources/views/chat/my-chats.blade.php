@extends('layouts.app')
@section('page_title', 'My Chats')

@section('main_content')
    @php
        use Illuminate\Support\Str;
    @endphp
    <style>
        .chat-user-card {
            transition: 0.3s;
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 12px 20px;
            margin-bottom: 15px;
        }

        .chat-user-card:hover {
            background-color: #fdf6f3;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .chat-avatar {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ddd;
        }

        .chat-username {
            font-weight: 600;
            font-size: 16px;
            color: #333;
            margin-bottom: 2px;
        }

        .chat-button {
            background-color: #FF6801;
            color: white;
            border: none;
        }

        .chat-button:hover {
            background-color: #e75c00;
        }
    </style>

    <div class="container py-4" style="max-width: 700px;">
        <h4 class="mb-4 fw-bold text-center">🗨️ Your Conversations</h4>

        @forelse ($users as $chatUser)
            @php
                $image = 'user-solid.svg';

                if ($chatUser->photo) {
                    if (is_string($chatUser->photo) && str_starts_with($chatUser->photo, '[')) {
                        $decoded = json_decode($chatUser->photo, true);
                        if (json_last_error() === JSON_ERROR_NONE && isset($decoded[0])) {
                            $image = 'storage/' . $decoded[0];
                        }
                    } elseif (Str::startsWith($chatUser->photo, 'http')) {
                        $image = $chatUser->photo;
                    } else {
                        $image = 'storage/' . $chatUser->photo;
                    }
                }
            @endphp

            <div class="chat-user-card d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ asset($image) }}" class="chat-avatar" alt="Avatar">
                    <div>
                        <div class="chat-username">{{ $chatUser->name }}</div>
                        <small class="text-muted">{{ $chatUser->email }}</small>
                    </div>
                </div>
                <a href="{{ route('chat.index', $chatUser->id) }}" class="btn chat-button">
                    Chat
                </a>
            </div>
        @empty
            <div class="alert alert-warning text-center">
                You have no conversations yet.
            </div>
        @endforelse
    </div>
@endsection
