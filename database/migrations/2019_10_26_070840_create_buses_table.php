<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->bigIncrements('id');            
            // $table->unsignedBigInteger('route_id');             
            $table->foreignId('route_id')
                  ->constrained()
                  ->onDelete('cascade');
            // $table->unsignedBigInteger('seat_plan_id');
            $table->foreignId('seat_plan_id')
                ->constrained()
                ->onDelete('cascade');            
            $table->unsignedBigInteger('type_id');            
            $table->string('reg_no');
            $table->string('number_plate');
            $table->text('description')->nullable();           
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
        Schema::dropIfExists('buses');
    }
}
