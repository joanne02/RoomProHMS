<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacilityType extends Model
{
    use SoftDeletes, HasFactory;
    protected $guarded = [];

    public function facilities()
    {
        return $this->hasMany(Facility::class, 'facility_type_id');
    }
}
