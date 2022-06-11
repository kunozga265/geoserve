<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

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
