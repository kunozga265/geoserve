<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            "name"                          =>  $this->name,
            "client"                        =>  $this->client,
            "site"                          =>  $this->site,
            "verified"                      =>  intval($this->verified),
            "status"                        =>  intval($this->status),
        ];
    }
}
