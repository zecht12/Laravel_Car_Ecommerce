<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Car;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $buyer = User::where('role', 'buyer')->first();
        $avanza = Car::where('model', 'Avanza')->first();

        Favorite::create([
            'user_id' => $buyer->id,
            'car_id' => $avanza->id,
        ]);
    }
}
