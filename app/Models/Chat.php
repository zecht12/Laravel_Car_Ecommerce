<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Chat extends Model
{
    protected $fillable = ['from_user', 'to_user', 'message'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'from_user');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'to_user');
    }
}
