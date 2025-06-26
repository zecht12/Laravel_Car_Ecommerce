@extends('layouts.cars')
@section('page_title', 'Home Page')
@section('main_content')
    @php
        use Illuminate\Support\Facades\Auth;
        use App\Models\Car;
        $user = Auth::user();
        $cars = Car::where('user_id', $user->id)->get();
    @endphp
    <div class="d-flex justify-content-center align-items-center p-4">
        <div style="width: 100%; height: 100%;">
            <h5 class="fw-bold">My Cars</h5>
            <div class="card w-100 p-5" style=" background-color: #fff;">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr style="text-align: center;">
                            <th>Car Image</th>
                            <th>Car Title</th>
                            <th>Car Price</th>
                            <th>Car Mileage</th>
                            <th>Car Published</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cars as $car)
                            <tr style="text-align: center;">
                                <td>
                                    <img src="{{ asset('storage/' . json_decode($car->images)[0]) }}" class="card-img-top"
                                        alt="car" style="height: 100px; object-fit: cover;">
                                </td>
                                <td>{{ $car->brand }} {{ $car->model }} - {{ $car->year }}</td>
                                <td>${{ number_format($car->price, 0, ',', '.') }}</td>
                                <td>{{ number_format($car->mileage, 0, ',', '.') }} km</td>
                                <td>{{ $car->created_at }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <a href="{{ route('car-details', $car->id) }}" class="btn btn-primary"
                                            style="width: 100px;">Details</a>
                                        <form action="{{ route('cars.destroy', $car->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                style="width: 100px;">Delete</button>
                                        </form>
                                        <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-warning"
                                            style="width: 100px;">Edit</a>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
