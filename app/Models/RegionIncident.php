<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegionIncident extends Model
{
    protected $fillable = [
        'region_id',
        'confirmed_cases',
        'population',
        'cumulative_incidence',
        'confirmed_cases_weight'
    ];


    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
