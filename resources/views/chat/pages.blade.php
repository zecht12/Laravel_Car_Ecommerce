@extends('layouts.app')

@section('main_content')
    @php
        use Illuminate\Support\Facades\Auth;
        use Illuminate\Support\Str;

        $user = Auth::user();
        $imagePath = 'user-solid.svg';

        if ($user && $user->photo) {
            if (is_string($user->photo) && str_starts_with($user->photo, '[')) {
                $decoded = json_decode($user->photo, true);
                if (json_last_error() === JSON_ERROR_NONE && isset($decoded[0])) {
                    $imagePath = 'storage/' . $decoded[0];
                }
            } elseif (Str::startsWith($user->photo, 'http')) {
                $imagePath = $user->photo;
            } else {
                $imagePath = 'storage/' . $user->photo;
            }
        }
    @endphp
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $('#session-alert').fadeOut('slow');
            }, 5000);
        });
    </script>

    <style>
        .chat-container {
            padding: 20px;
            background-color: #f2f2f2;
            height: 80vh;
            overflow-y: auto;
        }

        .message-row {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-end;
        }

        .message-row.sent {
            justify-content: flex-end;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background-color: #aaa;
            border-radius: 50%;
            margin: 0 10px;
        }

        .bubble {
            max-width: 60%;
            padding: 10px 15px;
            border-radius: 15px;
            font-size: 14px;
            line-height: 1.4;
            word-wrap: break-word;
        }

        .bubble.sent {
            background-color: #ff7900;
            color: white;
            border-bottom-right-radius: 0;
        }

        .bubble.received {
            background-color: white;
            color: black;
            border-bottom-left-radius: 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .chat-form {
            display: flex;
            padding: 10px;
            background-color: #fff;
            border-top: 1px solid #ccc;
        }

        .chat-form textarea {
            flex: 1;
            resize: none;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .chat-form button {
            background-color: #ff7900;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-left: 10px;
            border-radius: 8px;
        }
    </style>

    <div class="chat-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="session-alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @foreach ($messages as $message)
            @if ($message->from_user == auth()->id())
                <div class="message-row sent">
                    <div class="bubble sent">{{ $message->message }}</div>
                    <div class="avatar">
                        <img src="{{ asset($imagePath) }}" alt="Foto Profil" class="rounded-circle" width="40" height="40">
                    </div>
                </div>
            @else
                <div class="message-row">
                    <div class="avatar"></div>
                    <div class="bubble received">{{ $message->message }}</div>
                </div>
            @endif
        @endforeach
    </div>

    <form method="POST" action="{{ route('chat.store') }}" class="chat-form">
        @csrf
        <input type="hidden" name="to_user" value="{{ $userId }}">
        <textarea name="message" rows="1" placeholder="Type your message..." required></textarea>
        <button type="submit">Send</button>
    </form>
@endsection
