<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Car;
use App\Models\Favorite;
use App\Models\Follow;
use App\Models\Report;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'photo',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function followedSellers()
    {
        return $this->hasMany(Follow::class, 'buyer_id');
    }

    public function followers()
    {
        return $this->hasMany(Follow::class, 'seller_id');
    }

    public function reportsSent()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function reportsReceived()
    {
        return $this->hasMany(Report::class, 'reported_id');
    }

    public function carsForSale()
    {
        return $this->hasMany(Car::class, 'user_id')->where('status', 'sale');
    }

    public function purchasedCars()
    {
        return $this->hasMany(Car::class, 'sold_to_user_id');
    }
    public function soldAt()
    {
        return $this->hasMany(Car::class, 'sold_at');
    }
}
