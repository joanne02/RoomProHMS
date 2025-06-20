<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationSession extends Model
{
    use SoftDeletes, HasFactory;
    protected $guarded = [];

// public function isActive()
// {
//     $today = now()->toDateString();
//     return $this->start_date <= $today && $this->end_date >= $today;
// }

    public function getIsActiveAttribute()
    {
        $now = now();
        return $now->between($this->application_start_date, $this->acceptance_end_date);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }


}
