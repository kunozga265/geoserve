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
            $table->string("code");
            $table->string("type");
            $table->string("personCollectingAdvance")->nullable();
            $table->string("project_id")->nullable();

            $table->json("remarks")->nullable();

            $table->json("information")->nullable();
            $table->double("total")->nullable();

            //Person requesting
            $table->string("user_id");
            $table->double("dateRequested");
            $table->double("editable");

            //Finance Department
            $table->double("dateInitiated")->nullable();
            $table->double("dateReconciled")->nullable();

            //Management Approval
            $table->integer("approval_by_id")->nullable();
            $table->double("approvedDate")->nullable();
            $table->integer("approvalStatus");

            //Stages
            $table->integer("stagesApprovalPosition")->nullable();
            $table->boolean("stagesApprovalStatus");
            $table->integer("currentStage")->nullable();
            $table->integer("totalStages")->nullable();
            $table->json("stages")->nullable();

            //Vehicle Details
            $table->string("assessedBy")->nullable();
            $table->integer("vehicle_id")->nullable();
            $table->string("driverName")->nullable();
            $table->double("fuelRequestedLitres")->nullable();
            $table->double("fuelRequestedMoney")->nullable();
            $table->text("purpose")->nullable();
            $table->double("mileage")->nullable();

            $table->double("lastRefillDate")->nullable();
            $table->double("lastRefillFuelReceived")->nullable();
            $table->double("lastRefillMileageCovered")->nullable();

            $table->json("quotes")->nullable();
            $table->json("receipts")->nullable();

            $table->integer("denied_by_id")->nullable();

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
