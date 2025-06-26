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
        $(document).ready(function() {
            setTimeout(function() {
                $('#session-alert').fadeOut('slow');
            }, 5000);
        });
    </script>


    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#session-alert').fadeOut('slow');
            }, 5000);
        });
    </script>

    <style>
        .chat-container {
            padding: 24px;
            background: #fafafa;
            height: 80vh;
            overflow-y: auto;
            border-radius: 12px;
            box-shadow: inset 0 0 10px #e0e0e0;
        }

        .message-row {
            display: flex;
            align-items: flex-end;
            margin-bottom: 16px;
        }

        .message-row.sent {
            justify-content: flex-end;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background-color: #ccc;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 10px;
            border: 2px solid #fff;
        }

        .bubble {
            max-width: 65%;
            padding: 12px 16px;
            border-radius: 16px;
            font-size: 14px;
            position: relative;
            word-wrap: break-word;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.08);
        }

        .bubble.sent {
            background-color: #ff6f00;
            color: #fff;
            border-bottom-right-radius: 4px;
        }

        .bubble.received {
            background-color: #ffffff;
            color: #333;
            border-bottom-left-radius: 4px;
        }

        .message-meta {
            font-size: 11px;
            margin-top: 6px;
            color: #999;
            text-align: right;
        }

        .message-meta-left {
            font-size: 11px;
            margin-top: 6px;
            color: #999;
            text-align: left;
        }

        .chat-form {
            display: flex;
            padding: 12px;
            background-color: #fff;
            border-top: 1px solid #ddd;
        }

        .chat-form textarea {
            flex: 1;
            resize: none;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .chat-form button {
            background-color: #ff6f00;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-left: 10px;
            border-radius: 10px;
            font-weight: bold;
            transition: 0.3s;
        }

        .chat-form button:hover {
            background-color: #e85d00;
        }

        .dropdown-toggle::after {
            display: none;
        }

        .dropdown-menu {
            min-width: auto;
        }

        .text-read {
            color: #1e88e5;
        }
    </style>

    <div class="chat-container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="session-alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @foreach ($messages as $message)
            @if ($message->from_user == auth()->id())
                <div>
                    <div class="message-row sent">
                        <div class="bubble sent position-relative dropdown">
                            <a class="text-white text-decoration-none" href="#" role="button"
                                id="dropdownMenu{{ $message->id }}"data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $message->message }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu{{ $message->id }}">
                                <li>
                                    <form method="POST" action="{{ route('chat.delete', $message->id) }}"
                                        onsubmit="return confirm('Delete this message?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <div class="avatar">
                            <img src="{{ asset($imagePath) }}" alt="Foto Profil" class="rounded-circle" width="40"
                                height="40">
                        </div>
                    </div>
                    <div class="message-meta">
                        {{ \Carbon\Carbon::parse($message->sent_at)->format('H:i') }} <br>
                        @if ($message->is_read)
                            ✔✔ Read {{ \Carbon\Carbon::parse($message->read_at)->format('H:i') }}
                        @else
                            ✔ Sent
                        @endif
                    </div>
                </div>
            @else
                <div>
                    <div class="message-row">
                        <div class="avatar">
                            <img src="{{ asset($imagePath) }}" alt="Foto Profil" class="rounded-circle" width="40"
                                height="40">
                        </div>
                        <div class="bubble received">{{ $message->message }}</div>
                    </div>
                    <div class="message-meta-left">
                        {{ \Carbon\Carbon::parse($message->sent_at)->format('H:i') }} <br>
                        @if ($message->is_read)
                            ✔✔ Read {{ \Carbon\Carbon::parse($message->read_at)->format('H:i') }}
                        @else
                            ✔ Sent
                        @endif
                    </div>
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
