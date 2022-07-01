<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"                            =>  $this->id,
            "photo"                         =>  $this->photo,
            "vehicleRegistrationNumber"     =>  $this->vehicleRegistrationNumber,
            "mileage"                       =>  $this->mileage,
            "lastRefillDate"                =>  $this->lastRefillDate,
            "lastRefillFuelReceived"        =>  $this->lastRefillFuelReceived,
            "lastRefillMileageCovered"      =>  $this->lastRefillMileageCovered,
            "verified"                      =>  intval($this->verified),
        ];
    }
}
