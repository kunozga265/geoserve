<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string("photo")->nullable();
            $table->string("vehicleRegistrationNumber");
            $table->double("mileage");
            $table->double("lastRefillDate")->nullable();
            $table->double("lastRefillFuelReceived")->nullable();
            $table->double("lastRefillMileageCovered")->nullable();
            $table->boolean("verified");
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('vehicles');
    }
}
