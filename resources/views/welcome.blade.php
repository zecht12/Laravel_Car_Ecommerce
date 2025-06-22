@extends('layouts.app')
@section('page_title', 'Home Page')
@section('main_content')
    <div id="heroCarousel" class="carousel slide mb-4 bg-white" style="width: 100%; min-height: 100vh;" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <div class="container py-5">
                    <div class="row align-items-center">
                        <!-- Left: Text -->
                        <div class="col-md-6">
                            <h1 class="fw-bold" style="color: #FF6801;">BUY THE BEST<br>VEHICLES</h1>
                            <h2 class="fw-light text-dark">IN YOUR REGION</h2>
                            <p class="mt-3 text-muted">
                                Use powerful search tool to find your desired cars based on multiple search criteria: Make,
                                Model, Year, Price Range, Car Type, etc...
                            </p>
                            <a href="#" class="btn btn-primary px-4 py-2 mt-2"
                                style="--bs-btn-color: #ffff;--bs-btn-bg:#FF6801; --bs-btn-border-color: #FF6801; --bs-btn-hover-bg: #e75c00; --bs-btn-hover-border-color: #e75c00;">
                                FIND CAR
                            </a>
                        </div>

                        <!-- Right: Image -->
                        <div class="col-md-6 text-center">
                            <img src="{{ asset('car range.png') }}" class="img-fluid" alt="Car Image"
                                style="max-height: 350px;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <div class="container py-5">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="fw-bold" style="color: #FF6801;">SEARCH FOR<br>YOUR DREAM CAR</h1>
                            <h2 class="fw-light text-dark">WITH EASE</h2>
                            <p class="mt-3 text-muted">
                                Filter cars by city, brand, price, and more to find the perfect match for your needs.
                            </p>
                            <a href="#" class="btn btn-primary px-4 py-2 mt-2"
                                style="--bs-btn-color: #ffff;--bs-btn-bg:#FF6801; --bs-btn-border-color: #FF6801; --bs-btn-hover-bg: #e75c00; --bs-btn-hover-border-color: #e75c00;">
                                FIND CAR
                            </a>
                        </div>
                        <div class="col-md-6 text-center">
                            <img src="{{ asset('car range.png') }}" class="img-fluid" alt="Car Image"
                                style="max-height: 350px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle pqee" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="p-4" style="width: 100%; min-height: 100vh; background-color: #E9E9E9;">
        <form action="{{ route('search') }}" method="GET"
            class="card bg-white shadow-sm px-4 py-3 mx-auto d-flex justify-content-center align-items-center"
            style="max-width: 1600px;">
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-2">
                <select class="form-select" style="width: 200px; height: 37px;">
                    <option selected>Brand</option>
                    <option>Toyota</option>
                    <option>Lexus</option>
                    <option>Hyundai</option>
                    <option>Honda</option>
                    <option>BMW</option>
                    <option>Mercedes</option>
                    <option>Audi</option>
                    <option>Volkswagen</option>
                    <option>Nissan</option>
                    <option>Ford</option>
                </select>

                <select class="form-select" style="width: 200px; height: 37px;">
                    <option selected>Type</option>
                    <option>MPV</option>
                    <option>Sedan</option>
                    <option>Hatchback</option>
                    <option>Minivan</option>
                    <option>SUV</option>
                    <option>Pickup</option>
                    <option>Crossover</option>
                    <option>Coupe</option>
                    <option>Convertible</option>
                    <option>Wagon</option>
                    <option>Sports Car</option>
                </select>

                <input type="text" class="form-control" placeholder="State" style="width:200px; height: 37px;">
                <input type="text" class="form-control" placeholder="City" style="width: 200px; height: 37px;">
                <button type="button" class="btn btn-secondary" style="width: 200px; height: 37px;">
                    Reset
                </button>
            </div>
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-2">
                <div>
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <label for="customRange1" class="form-label">Price</label>
                        <label for="customRange1" class="form-label">$1-10000000</label>
                    </div>
                    <input type="range" class="form-range" id="customRange1" style="width: 270px;">
                </div>
                <div class="input-group" style="width: 270px;">
                    <input type="text" class="form-control datepicker" placeholder="Year From" aria-label="Year From">
                    <span class="input-group-text">
                        <i class="fa-solid fa-calendar-days" style="transition: color 0.3s;"></i>
                    </span>
                </div>
                <div class="input-group" style="width: 270px;">
                    <input type="text" class="form-control datepicker" placeholder="Year To" aria-label="Year To">
                    <span class="input-group-text">
                        <i class="fa-solid fa-calendar-days" style="transition: color 0.3s;"></i>
                    </span>
                </div>
                <button type="submit" class="btn btn-primary"
                    style="width: 200px; height: 37px; --bs-btn-color: #ffff; --bs-btn-bg:#FF6801; --bs-btn-border-color: #FF6801; --bs-btn-hover-bg: #e75c00; --bs-btn-hover-border-color: #e75c00;">
                    Search
                </button>
            </div>
        </form>
        <div class="container px-4 py-3 mx-auto" style="max-width: 1600px;">
            <p class="fw-bold fs-4">Trending Car</p>
            <div id="trendingCarCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <!-- Slide 1 -->
                    @foreach ($trendingCars->chunk(4) as $chunkIndex => $chunk)
                        <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}" >
                            <div class="row gx-4">
                                @foreach ($chunk as $car)
                                    <div class="col-md-3" >
                                        <a href="{{ route('car-details', $car->id) }}"
                                            class="text-decoration-none text-dark" >
                                            <div class="card w-100" style="width: 250px; height: 350px;">
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
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#trendingCarCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#trendingCarCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="container px-4 py-3 mx-auto" style="max-width: 1600px;">
            <p class="fw-bold fs-4">Latest Car</p>
            <div class="row g-4 py-3">
                @foreach ($latestCars as $car)
                    <div class="col-md-3">
                        <a href="{{ route('car-details', $car->id) }}" class="card w-100 text-decoration-none text-dark" style="width: 250px; height: 350px;">
                            <img src="{{ asset('storage/' . json_decode($car->images)[0]) }}" class="card-img-top" alt="car" style="height: 200px; object-fit: cover;">
                            <div class="card-body text-center">
                                <p class="card-title">{{ $car->year }} - {{ $car->brand }} {{ $car->model }}</p>
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
    </div>
@endsection
