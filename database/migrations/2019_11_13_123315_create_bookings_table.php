<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('creator_id');            
            $table->unsignedBigInteger('bus_schedule_id');
            $table->unsignedSmallInteger('city_route_id');
            $table->tinyInteger('total_seats');
            $table->float('amount', 8, 2); 
            $table->date('date');
            $table->string('pickup_point')->nullable();
            $table->string('dropping_point')->nullable();
            $table->timestamps();

            $table->foreign('creator_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('bus_schedule_id')
                  ->references('id')->on('bus_schedule')
                  ->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
