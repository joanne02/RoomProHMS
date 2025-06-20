<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitation extends Model
{
    use SoftDeletes, HasFactory;
    protected $casts = [
        'appendix' => 'array', // Assuming appendix is stored as a JSON array
    ];
}
