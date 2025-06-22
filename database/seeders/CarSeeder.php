<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $seller = User::where('role', 'seller')->first();
        $buyer = User::where('role', 'buyer')->first();

        if (!$seller || !$buyer) {
            $this->command->error('Seller or buyer user not found.');
            return;
        }

        if (!Storage::exists('public/car')) {
            Storage::makeDirectory('public/car');
        }

        $filesToCopy = [
            'public/car/avanza.jpeg' => 'storage/app/public/car/avanza.jpeg',
            'public/car/1.jpeg' => 'storage/app/public/car/1.jpeg',
            'public/car/pajero.jpeg' => 'storage/app/public/car/pajero.jpg',
            'public/car/fortuner.jpeg' => 'storage/app/public/car/fortuner.jpeg',
        ];

        foreach ($filesToCopy as $source => $destination) {
            $srcPath = base_path($source);
            $destPath = base_path($destination);

            if (File::exists($srcPath) && !File::exists($destPath)) {
                File::copy($srcPath, $destPath);
                $this->command->info("Copied: $source -> $destination");
            } else {
                $this->command->warn("Skipped copy (exists?): $source");
            }
        }

        Car::create([
            'user_id' => $seller->id,
            'brand' => 'Toyota',
            'model' => 'Avanza',
            'year' => 2022,
            'type' => 'MPV',
            'price' => 17000,
            'vin' => 'AVZ2022TOYOTA001',
            'miles' => 15000,
            'fuel_type' => 'petrol',
            'address' => 'Jl. Merdeka No. 1, Jakarta',
            'phone' => '081234567890',
            'specification' => 'Avanza MPV family car',
            'description' => 'Toyota Avanza in good condition, very efficient.',
            'images' => json_encode(['car/avanza.jpeg']),
        ]);

        Car::create([
            'user_id' => $seller->id,
            'brand' => 'Lexus',
            'model' => 'RX450',
            'year' => 2024,
            'type' => 'SUV',
            'price' => 55000,
            'vin' => 'RX4502024LEXUS002',
            'miles' => 5000,
            'fuel_type' => 'hybrid',
            'address' => 'Jl. Sudirman No. 88, Jakarta',
            'phone' => '089876543210',
            'specification' => 'Luxury SUV hybrid',
            'description' => 'Lexus RX450 with premium features and hybrid engine.',
            'images' => json_encode(['car/1.jpeg']),
        ]);

        Car::create([
            'user_id' => $seller->id,
            'brand' => 'Mitsubishi',
            'model' => 'Pajero',
            'year' => 2023,
            'type' => 'SUV',
            'price' => 47000,
            'vin' => 'PJ2023MITSUBISHI003',
            'miles' => 12000,
            'fuel_type' => 'diesel',
            'address' => 'Jl. Gatot Subroto No. 11, Bandung',
            'phone' => '082134567891',
            'specification' => 'Powerful diesel SUV for family and adventure',
            'description' => 'Well-maintained Pajero, ready for long drives.',
            'images' => json_encode(['car/pajero.jpeg']),
            'status' => 'sold',
            'sold_to_user_id' => $buyer->id,
            'sold_at' => Carbon::now(),
        ]);

        Car::create([
            'user_id' => $seller->id,
            'brand' => 'Toyota',
            'model' => 'Fortuner',
            'year' => 2023,
            'type' => 'SUV',
            'price' => 46000,
            'vin' => 'FT2023TOYOTA004',
            'miles' => 10000,
            'fuel_type' => 'diesel',
            'address' => 'Jl. Diponegoro No. 22, Surabaya',
            'phone' => '081298765432',
            'specification' => 'Durable diesel SUV with strong resale value',
            'description' => 'Toyota Fortuner diesel, like new.',
            'images' => json_encode(['car/fortuner.jpeg']),
            'status' => 'sold',
            'sold_to_user_id' => $buyer->id,
            'sold_at' => Carbon::now(),
        ]);

        $this->command->info('Cars seeded successfully.');
    }
}
