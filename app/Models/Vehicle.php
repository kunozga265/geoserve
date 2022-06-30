<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    public function requestForms()
    {
        return $this->hasMany(RequestForm::class);
    }

    protected $fillable=[
        "photo",
        "vehicleRegistrationNumber",
        "mileage",
        "lastRefillDate",
        "lastRefillFuelReceived",
        "lastRefillMileageCovered",
        "verified",
    ];

    protected $hidden=[
        "lastRefillDate",
        "lastRefillFuelReceived",
        "lastRefillMileageCovered",
        "created_at",
        "updated_at",
    ];
}
