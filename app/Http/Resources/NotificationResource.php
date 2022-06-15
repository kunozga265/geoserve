<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'id'            =>  $this->id,
            'contents'      =>  json_decode($this->contents),
            'type'          =>  $this->type,
            'read'          =>  $this->read,
            'user'          =>  $this->user,
            'date'          =>  [
                'formatted' =>  date('jS F, Y',$this->created_at->getTimestamp()),
                'month'   => date("M",$this->created_at->getTimestamp()),
                'year'   => date("Y",$this->created_at->getTimestamp())
            ]
        ];
    }
}
