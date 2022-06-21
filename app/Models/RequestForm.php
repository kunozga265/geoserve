<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestForm extends Model
{
    use HasFactory;

    protected $table = "requests";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsToMany(User::class,'requests_user','request_id','user_id');
    }

    public function deniedBy()
    {
        return $this->belongsTo(User::class,'denied_by_id','id');
    }

    public function approvalBy()
    {
        return $this->belongsTo(User::class,'approval_by_id','id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    protected $fillable=[
        "code",
        "type",
        "personCollectingAdvance",
        "project_id",
        "information",
        "total",
        "user_id",
        "dateRequested",
        "dateInitiated",
        "dateReconciled",
        "approval_by_id",
        "approvedDate",
        "approvalStatus",
        "stagesApprovalPosition",
        "stagesApprovalStatus",
        "currentStage",
        "totalStages",
        "stages",
        "assessedBy",
        "driverName",
        "fuelRequestedLitres",
        "fuelRequestedMoney",
        "purpose",
        "mileage",
        "lastRefillDate",
        "lastRefillFuelReceived",
        "lastRefillMileageCovered",
        "remarks",
        "vehicle_id",
        "quotes",
        "receipts",
        "editable",
        "denied_by_id"
    ];
}
