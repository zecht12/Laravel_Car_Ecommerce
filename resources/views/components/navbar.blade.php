<div class="navbar" style="padding: 10px 20px; background-color: #ffffff; box-shadow: 0 4px rgba(0, 0, 0, 0.1);">
    <div class="navbar-brand">
        <a href="{{ url('/') }}" class="navbar-item" style="display: flex; align-items: center;">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="logo" style="height: 50px; width: 50px;">
        </a>
    </div>
    <nav class="navbar-menu"  style="display: flex; justify-content: space-between; align-items: center;">
        <div class="navbar-start">
            <a href="{{ url('/') }}"
            class="btn btn-outline-primary me-2"
            style="display: flex; align-items: center; gap: 8px;
                    --bs-btn-color: #FF6801;
                    --bs-btn-border-color: #FF6801;
                    --bs-btn-hover-bg: #FF6801;
                    --bs-btn-hover-border-color: #FF6801;
                    --bs-btn-hover-color: #fff;">
                <i class="fa-solid fa-plus" style="transition: color 0.3s;"></i> Add New Car
            </a>
        </div>

        <div class="navbar-end">
            @auth
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center; color: #FF6801;">
                        Welcome, {{$user->name }}
                        <img src="{{ asset($imagePath) }}" alt="Profile" style="width: 32px; height: 32px; border-radius: 50%; padding-left: 10px;">
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('profile', $user->id) }}" style="color: #FF6801;">My Profile</a>
                        <a class="dropdown-item" href="" style="color: #FF6801;">My Car</a>
                        <a class="dropdown-item" href="" style="color: #FF6801;">My Favorite Car</a>
                        @if($user->role === 'admin')
                            <a class="dropdown-item" href="" style="color: #FF6801;">Admin Page</a>
                        @endif
                        <hr class="dropdown-devider">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item" style="color: #FF6801;">Logout</button>
                        </form>
                    </div>
                </div>
            @else
            <div>
                <a href="{{ url('/login') }}" class="btn btn-primary" style="--bs-btn-color: #ffff;--bs-btn-bg:#FF6801; --bs-btn-border-color: #FF6801; --bs-btn-hover-bg: #e75c00; --bs-btn-hover-border-color: #e75c00;">Login</a>
            </div>
            @endauth
        </div>
    </nav>
</div>
