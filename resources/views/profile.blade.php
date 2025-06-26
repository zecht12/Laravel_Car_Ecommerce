@extends('layouts.app')
@section('page_title', 'Profile Page')
@section('main_content')
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#session-alert').fadeOut('slow');
            }, 5000);
        });
    </script>
    @php
        use Illuminate\Support\Facades\Auth;
        use App\Models\User;
        use App\Models\Car;
        use App\Models\Favorite;
        use App\Models\Follow;
        $currentUser = Auth::user();
        $id = $currentUser ? $currentUser->id : null;
        $photo = $user->photo;

        if (is_string($photo) && str_starts_with($photo, '[')) {
            $decoded = json_decode($photo, true);
            $imagePath = isset($decoded[0]) ? 'storage/' . $decoded[0] : 'user-solid.svg';
        } else {
            $imagePath = $photo ? 'storage/' . $photo : 'user-solid.svg';
        }

        $viewingOwnProfile = $currentUser && $currentUser->id === $user->id;
        $isFollowing = false;

        if ($currentUser && $currentUser->id !== $user->id) {
            $isFollowing = Follow::where('follower_id', $currentUser->id)->where('followed_id', $user->id)->exists();
        }

        $totalFollow = Follow::where('follower_id', $user->id)->count();
        $totalLiked = Favorite::where('user_id', $user->id)->count();
        $totalCarBuy = Car::where('sold_to_user_id', $user->id)->count();
        $totalCarList = Car::where('user_id', $user->id)->count();
        $totalCarSold = Car::where('user_id', $user->id)->where('status', 'sold')->count();

    @endphp

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="session-alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="session-alert">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            @endforeach
        </div>
    @endif


    <div>
        <div class="d-flex justify-content-center my-3">
            <img src="{{ asset($imagePath) }}" alt="Profile Photo"
                style="width: 250px; height: 250px; object-fit: cover; border-radius: 50%; border: 2px solid #ddd;">
        </div>

        <h5 class="text-center fw-bold">{{ strtoupper($user->name) }}</h5>
        @if ($user->role === 'seller')
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-md-4 mb-4">
                        <p class="fw-bold">{{ $totalFollow }}</p>
                        <p>Total Follow</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <p class="fw-bold">{{ $totalCarBuy }}</p>
                        <p>Total Car Buy</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <p class="fw-bold">{{ $totalLiked }}</p>
                        <p>Total Liked Car</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <p class="fw-bold">{{ $totalCarList }}</p>
                        <p>Total Car List</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <p class="fw-bold">{{ $totalCarSold }}</p>
                        <p>Total Car Sold</p>
                    </div>
                </div>
            </div>
        @else
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3" style="padding: 0 400px">
                <div class="text-center">
                    <p class="fw-bold">{{ $totalFollow }}</p>
                    <p>Total Follow</p>
                </div>
                <div class="text-center">
                    <p class="fw-bold">{{ $totalLiked }}</p>
                    <p>Total Liked Car</p>
                </div>
                <div class="text-center">
                    <p class="fw-bold">{{ $totalCarBuy }}</p>
                    <p>Total Car Buy</p>
                </div>
            </div>
        @endif

        <div class="text-center mb-3">
            @if ($viewingOwnProfile)
                <a href="{{ route('profile.edit', ['id' => $user->id]) }}" class="btn btn-primary" style="width: 650px; height: 37px; --bs-btn-color: #ffff; --bs-btn-bg:#FF6801; --bs-btn-border-color: #FF6801; --bs-btn-hover-bg: #e75c00; --bs-btn-hover-border-color: #e75c00;">
                    Edit Profile
                </a>
            @else
                @if ($isFollowing)
                    <form action="{{ route('unfollow', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-secondary" style="width: 300px">Unfollow</button>
                    </form>
                @else
                    <form action="{{ route('follow', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary" style="width: 300px;">Follow</button>
                    </form>
                @endif
                <a href="{{ route('report', ['reported' => $user->id]) }}" class="btn btn-danger" style="width: 300px;">Report</a>
                <button class="btn btn-primary"
                    style="width: 50px; height: 37px; --bs-btn-color: #ffff; --bs-btn-bg:#FF6801; --bs-btn-border-color: #FF6801; --bs-btn-hover-bg: #e75c00; --bs-btn-hover-border-color: #e75c00;">✉️</button>
            @endif
        </div>
        @if ($user->role === 'seller')
            <div class="container px-4 py-3 mx-auto" style="max-width: 1600px;">
                <p class="fw-bold fs-4 text-center">My Car</p>
                <div class="row g-4 py-3">
                    @foreach ($myCars as $car)
                        <div class="col-md-3">
                            <a href="{{ route('car-details', $car->id) }}"
                                class="card w-100 text-decoration-none text-dark" style="width: 250px; height: 350px;">
                                <img src="{{ asset('storage/' . json_decode($car->images)[0]) }}" class="card-img-top"
                                    alt="car" style="height: 200px; object-fit: cover;">
                                <div class="card-body text-center">
                                    <p class="card-title">{{ $car->year }} - {{ $car->brand }} {{ $car->model }}
                                    </p>
                                    <p class="card-text fw-bold">${{ $car->price }}</p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <span class="badge bg-secondary">{{ $car->type }}</span>
                                        <span class="badge bg-secondary">{{ $car->fuel_type }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="container px-4 py-3 mx-auto" style="max-width: 1600px;">
                <p class="fw-bold fs-4 text-center">Liked Car</p>
                <div class="row g-4 py-3">
                    @foreach ($likedCars as $car)
                        <div class="col-md-3">
                            <a href="{{ route('car-details', $car->id) }}"
                                class="card w-100 text-decoration-none text-dark" style="width: 250px; height: 350px;">
                                <img src="{{ asset('storage/' . json_decode($car->images)[0]) }}" class="card-img-top"
                                    alt="car" style="height: 200px; object-fit: cover;">
                                <div class="card-body text-center">
                                    <p class="card-title">{{ $car->year }} - {{ $car->brand }}
                                        {{ $car->model }}</p>
                                    <p class="card-text fw-bold">${{ $car->price }}</p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <span class="badge bg-secondary">{{ $car->type }}</span>
                                        <span class="badge bg-secondary">{{ $car->fuel_type }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
