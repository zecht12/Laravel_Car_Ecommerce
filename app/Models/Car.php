<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Favorite;

class Car extends Model
{
    protected $fillable = [
        'user_id', 'brand', 'model', 'year', 'type',
        'price', 'vin', 'miles', 'fuel_type',
        'address', 'phone', 'specification',
        'description', 'images','status', 'sold_to_user_id', 'sold_at'
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'sold_to_user_id');
    }
    public function soldAt()
    {
        return $this->hasOne(User::class, 'sold_at');
    }
}
