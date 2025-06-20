<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
{
    use SoftDeletes, HasFactory;
    protected $guarded = [];

    public function facilityType()
    {
        return $this->belongsTo(FacilityType::class, 'facility_type_id');
    }

}
