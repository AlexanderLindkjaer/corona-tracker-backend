<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('region_incidents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('region_id');
            $table->foreign('region_id')
                ->references('id')
                ->on('regions');


            $table->integer('confirmed_cases')->default(0);
            $table->integer('population')->default(0);
            $table->double('cumulative_incidence')->default(0);
            $table->double('confirmed_cases_weight', 11, 2 )->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('region_incidents');
    }
}
