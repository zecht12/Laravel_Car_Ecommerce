<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        return view('cars');
    }
    public function create(Request $request)
    {
        return view('cars.create');
    }
    public function store(Request $request)
    {
        // Logic to store car details
        return redirect()->route('mycars');
    }
    public function edit($id)
    {
        // Logic to get car details for editing
        return view('cars.edit', compact('id'));
    }
    public function update(Request $request, $id)
    {
        // Logic to update car details
        return redirect()->route('mycars');
    }
    public function destroy($id)
    {
        // Logic to delete car
        return redirect()->route('mycars');
    }
    public function show($id)
    {
        // Logic to show car details
        return view('cars.show', compact('id'));
    }
}
