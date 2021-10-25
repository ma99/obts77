<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')
                  ->constrained()
                  ->onDelete('cascade');
            // $table->foreignId('supervisor_id')
            //       ->constrained()
            //       ->onDelete('cascade');
            // $table->foreignId('driver_id')
            //       ->constrained()
            //       ->onDelete('cascade');
            // $table->foreignId('bus_id')
            //       ->constrained()
            //       ->onDelete('cascade');
            $table->unsignedBigInteger('supervisor_id');
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('helper_id');
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
        Schema::dropIfExists('staff');
    }
}
