<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string("type");

            $table->string("firstName");
            $table->string("middleName")->nullable();
            $table->string("lastName");
            $table->integer("person_collecting_advance_id")->nullable();
            $table->string("projectName")->nullable();
            $table->string("projectClient")->nullable();
            $table->string("projectSite")->nullable();
            $table->json("information")->nullable();

            //Person requesting
            $table->string("user_id");
            $table->double("dateRequested");

            //Finance Department
            $table->double("dateInitiated")->nullable();
            $table->double("dateReconciled")->nullable();

            //Management Approval
            $table->integer("approval_by_id")->nullable();
            $table->double("approvedDate")->nullable();
            $table->boolean("approvalStatus");

            //Stages
            $table->boolean("stagesApprovalStatus");
            $table->integer("currentStage")->nullable();
            $table->integer("totalStages")->nullable();
            $table->json("stages")->nullable();

            //Vehicle Details
            $table->string("assessedBy")->nullable();
            $table->string("vehicleRegistrationNumber")->nullable();
            $table->string("driverName")->nullable();
            $table->double("fuelRequestedLitres")->nullable();
            $table->double("fuelRequestedMoney")->nullable();
            $table->text("purpose")->nullable();
            $table->double("mileage")->nullable();

            $table->double("lastRefillDate")->nullable();
            $table->double("lastRefillFuelReceived")->nullable();
            $table->double("lastRefillMileageCovered")->nullable();

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
        Schema::dropIfExists('requests');
    }
}
