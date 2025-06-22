<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::query();

        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('state')) {
            $query->where('state', 'like', '%' . $request->state . '%');
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('year')) {
            $query->whereYear('year', $request->year);
        }

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        $filteredCars = $query->latest()->get();

        $latestCars = Car::latest()->take(8)->get();
        $trendingCars = Car::withCount('favorites')
            ->orderByDesc('favorites_count')
            ->take(8)
            ->get();

        return view('welcome', compact('filteredCars', 'latestCars', 'trendingCars'));
    }
}
