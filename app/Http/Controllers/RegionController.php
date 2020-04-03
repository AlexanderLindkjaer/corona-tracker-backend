<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\RegionIncident;
use App\OfficialStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

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
        $date = now();

        if(!OfficialStat::whereDate('date', now())->first()){

            $date->subDay();
        }


        $stats = OfficialStat::whereDate('date', $date)->orderBy('group')->groupBy()->get();

        return $stats;
    }

    public function uploadRegionData(Request $request)
    {


        foreach ($request->all() as $index => $item) {
            $region = Region::where('name', $index)->first();

            if(!$region) continue;

            $incident = RegionIncident::where('region_id', $region->id)->first();

            $incident->update([
                'confirmed_cases' => (int) str_replace('.', '', $item['confirmed_cases']),
                'population' => (int) str_replace('.', '', $item['population']),
                'cumulative_incidence' => (double) str_replace(',', '.', $item['cumulative_incidence']),
            ]);

        }

        Artisan::call('calc:weight');
    }
}
