<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllocationStatus extends Model
{
    use HasFactory;
    protected $fillable = ['is_running', 'message','is_confirmed', 'chunk_number', 'overall_match_percentage', 'session_id'];
}
