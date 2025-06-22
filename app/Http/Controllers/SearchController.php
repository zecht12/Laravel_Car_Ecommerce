<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        return view('search');
    }
}
