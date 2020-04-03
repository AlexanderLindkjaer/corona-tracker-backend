<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TriggerNetlifyBuild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'netlify:build';

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
        $client = new \GuzzleHttp\Client();

        try{
            $client->post('https://api.netlify.com/build_hooks/5e87a82eb02005f0d9db8b4f');
        }catch (\Exception $e){
            throw $e;
        }
    }
}
