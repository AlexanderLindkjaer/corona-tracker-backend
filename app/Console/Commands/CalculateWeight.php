<?php

namespace App\Console\Commands;

use App\Models\Region;
use App\Models\RegionIncident;
use Illuminate\Console\Command;

class CalculateWeight extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc:weight';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $midnight = now()->startOfDay();

        $regions = RegionIncident::whereHas('region', function ($q) {
            $q->where('is_region', true);
        })
            ->where('updated_at', '>=', $midnight)
            ->orderBy('confirmed_cases', 'desc')
            ->get();

        $provinces = RegionIncident::whereHas('region', function ($q) {
            $q->where('is_province', true);
        })
            ->where('updated_at', '>=', $midnight)
            ->orderBy('confirmed_cases', 'desc')
            ->get();

        $this->calcWeight($regions);
        $this->calcWeight($provinces);
    }

    private function calcWeight($incidents)
    {
        if(count($incidents) === 0) return;

        $max = $incidents[0]->confirmed_cases;

        foreach ($incidents as $incident) {
            $cases = $incident->confirmed_cases;

            $weight = $cases / $max;

            $incident->confirmed_cases_weight = $weight;
            $incident->save();
        }

    }
}
