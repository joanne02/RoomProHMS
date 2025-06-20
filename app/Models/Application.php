<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    
    protected $casts = [
        'preferred_room_feature' => 'array',
    ];

    public function resident()
    {
        return $this->hasOne(Resident::class);
    }

    public function session()
    {
        return $this->belongsTo(ApplicationSession::class, 'session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

}
