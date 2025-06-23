@extends('layouts.app')
@section('page_title', 'Edit Profile')
@section('main_content')
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="card p-4 shadow" style="width: 600px;">
            <h4 class="text-center fw-bold mb-3">Edit Profile</h4>

            {{-- Show success message --}}
            @if (session('success'))
                <div class="alert alert-success" id="session-alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Show error messages --}}
            @if ($errors->any())
                <div class="alert alert-danger" id="session-alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Profile Image (optional)</label>
                    <input type="file" class="form-control" name="image" id="image">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password (optional)</label>
                    <input type="password" class="form-control" name="password" id="password"placeholder="Leave blank to keep current password">
                </div>

                <button type="submit" class="btn btn-primary w-100"
                        style="width: 650px; height: 37px; --bs-btn-color: #ffff; --bs-btn-bg:#FF6801; --bs-btn-border-color: #FF6801; --bs-btn-hover-bg: #e75c00; --bs-btn-hover-border-color: #e75c00;">
                    Update Profile
                </button>
            </form>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const alert = document.getElementById('session-alert');
            if (alert) alert.style.display = 'none';
        }, 5000);
    </script>
@endsection
