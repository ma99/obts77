<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bus_schedule_id');
            $table->unsignedSmallInteger('city_route_id');
            $table->date('date');
            $table->unsignedTinyInteger('type')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedInteger('driver_id')->nullable();
            $table->unsignedInteger('supervisor_id')->nullable();
            $table->unsignedInteger('helper_id')->nullable();
            // $table->string('entry_by')->nullable();
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
        Schema::dropIfExists('trips');
    }
}
