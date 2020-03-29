<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name', 'is_region', 'is_province'];


    public function regionIncidents()
    {
        return $this->hasMany(RegionIncident::class);
    }
}
