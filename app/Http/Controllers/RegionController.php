<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\RegionIncident;
use App\OfficialStat;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function getAllRegions()
    {
        $regions = Region::all();

        foreach ($regions as $region) {
            $region->incidents = RegionIncident::where('region_id', $region->id)
                ->orderBy('updated_at')
                ->first();
            $region->geoJson = null;
        }


        return $regions;
    }

    public function getAllStats()
    {
        $stats = OfficialStat::whereDate('date', now())->orderBy('group')->groupBy()->get();

        return $stats;
    }
}
