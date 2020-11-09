<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityRouteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_route', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('route_id');
            $table->unsignedBigInteger('first_city_id');
            $table->unsignedBigInteger('second_city_id');
            $table->smallInteger('distance')->unsigned();
            $table->timestamps();

            $table->foreign('first_city_id')
                  ->references('id')->on('cities')
                  ->onDelete('cascade');            
            $table->foreign('route_id')
                  ->references('id')->on('routes')
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
        Schema::dropIfExists('city_route');
    }
}
