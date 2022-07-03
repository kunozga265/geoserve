<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
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
            'id'                =>  $this->id,
            'year'              =>  $this->year,
            'month'             =>  $this->month,
            'requestsCount'     =>  $this->requestForms->count(),
//            'usersCount'        =>  $this->users->count(),
//            'projectsCount'     =>  $this->projects->count(),
//            'vehiclesCount'     =>  $this->vehicles->count(),
        ];
    }
}
