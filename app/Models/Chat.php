<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'from_user', 'to_user', 'message', 'is_read', 'read_at',
        'attachment', 'attachment_type', 'sent_at', 'received_at',
        'status', 'chat_type', 'is_deleted', 'is_archived'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'from_user');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'to_user');
    }
}
