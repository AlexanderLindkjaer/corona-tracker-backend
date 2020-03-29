<?php

namespace App\Console\Commands;

use App\Models\Region;
use App\Models\RegionIncident;
use Illuminate\Console\Command;

class RerunDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:rerun';

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
        $this->call('migrate:fresh');

        $incidents = [
            ['is_region' => 1, 'is_province' => 0, 'name' => 'Hovedstaden', 'region_id' => 1, 'confirmed_cases' => 1117, 'population' => 1846023, 'cumulative_incidence' => 60.5],
            ['is_region' => 1, 'is_province' => 0, 'name' => 'Sjælland', 'region_id' => 2, 'confirmed_cases' => 292, 'population' => 837359, 'cumulative_incidence' => 34.9],
            ['is_region' => 1, 'is_province' => 0, 'name' => 'Syddanmark', 'region_id' => 3, 'confirmed_cases' => 296, 'population' => 1223105, 'cumulative_incidence' => 24.2],
            ['is_region' => 1, 'is_province' => 0, 'name' => 'Midtjylland', 'region_id' => 4, 'confirmed_cases' => 367, 'population' => 1326340, 'cumulative_incidence' => 27.7],
            ['is_region' => 1, 'is_province' => 0, 'name' => 'Nordjylland', 'region_id' => 5, 'confirmed_cases' => 122, 'population' => 589936, 'cumulative_incidence' => 20.7],
            ['is_region' => 0, 'is_province' => 1, 'name' => 'København by', 'region_id' => 6, 'confirmed_cases' => 534, 'population' => 794128 , 'cumulative_incidence' => 67.2],
            ['is_region' => 0, 'is_province' => 1, 'name' => 'Københavns omegn', 'region_id' => 7, 'confirmed_cases' => 332, 'population' => 548370, 'cumulative_incidence' => 60.5],
            ['is_region' => 0, 'is_province' => 1, 'name' => 'Nordsjælland', 'region_id' => 8, 'confirmed_cases' => 239, 'population' => 463942, 'cumulative_incidence' => 51.5],
            ['is_region' => 0, 'is_province' => 1, 'name' => 'Bornholm', 'region_id' => 9, 'confirmed_cases' => 12, 'population' => 39583, 'cumulative_incidence' => 30.3],
            ['is_region' => 0, 'is_province' => 1, 'name' => 'Østsjælland', 'region_id' => 10, 'confirmed_cases' => 115, 'population' => 250702, 'cumulative_incidence' => 45.9],
            ['is_region' => 0, 'is_province' => 1, 'name' => 'Vest- og Sydsjælland', 'region_id' => 11, 'confirmed_cases' => 177, 'population' => 586657, 'cumulative_incidence' => 30.2],
            ['is_region' => 0, 'is_province' => 1, 'name' => 'Fyn', 'region_id' => 12, 'confirmed_cases' => 128, 'population' => 498506 , 'cumulative_incidence' => 257],
            ['is_region' => 0, 'is_province' => 1, 'name' => 'Sydjylland', 'region_id' => 13, 'confirmed_cases' => 168, 'population' => 724599, 'cumulative_incidence' => 23.2],
            ['is_region' => 0, 'is_province' => 1, 'name' => 'Østjylland', 'region_id' => 14, 'confirmed_cases' => 239, 'population' => 897129, 'cumulative_incidence' => 26.6],
            ['is_region' => 0, 'is_province' => 1, 'name' => 'Vestjylland', 'region_id' => 15, 'confirmed_cases' => 128, 'population' => 429211 , 'cumulative_incidence' => 29.8],
            ['is_region' => 0, 'is_province' => 1, 'name' => 'Nordjylland', 'region_id' => 16, 'confirmed_cases' => 122, 'population' => 589936, 'cumulative_incidence' => 20.7],
        ];

        foreach ($incidents as $incident) {

            Region::create($incident);
            RegionIncident::create($incident);
        }

        $this->call('calc:weight');
    }
}
