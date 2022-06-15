<?php

namespace App\Http\Resources;

use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        switch ($this->type){

            case "MATERIALS":
            case "CASH":
                return [
                    'id'                                  =>  $this->id,
                    'code'                                =>  $this->code,
                    'type'                                =>  $this->type,
                    'personCollectingAdvance'             =>  $this->personCollectingAdvance,
                    'project'                             =>  $this->project,
                    'information'                         =>  json_decode($this->information),
                    'total'                               =>  $this->total,
                    'requestedBy'                         =>  $this->user,
                    'dateRequested'                       =>  $this->dateRequested,
                    'stagesApprovalPosition'              =>  $this->approvalPosition($this->stagesApprovalPosition),
                    'stagesApprovalStatus'                =>  $this->stagesApprovalStatus,
                    'currentStage'                        =>  $this->currentStage,
                    'totalStages'                         =>  $this->totalStages,
                    'stages'                              =>  json_decode($this->stages),
                    'approvalStatus'                      =>  $this->approvalStatus,
                    'status'                              =>  $this->getApprovalStatus($this->approvalStatus),
                    'approvedBy'                          =>  $this->getApprovedBy($this->approval_by_id),
                    'remarks'                             =>  json_decode($this->remarks),
                    'quotes'                              =>  json_decode($this->quotes),
                    'receipts'                            =>  json_decode($this->receipts),
                ];

            case "VEHICLE_MAINTENANCE":
                return [
                    'id'                                  =>  $this->id,
                    'type'                                =>  $this->type,
                    'assessedBy'                          =>  $this->assessedBy,
                    'vehicle'                             =>  $this->vehicle,
                    'information'                         =>  json_decode($this->information),
                    'total'                               =>  $this->total,
                    'requestedBy'                         =>  $this->user,
                    'dateRequested'                       =>  $this->dateRequested,
                    'stagesApprovalPosition'              =>  $this->approvalPosition($this->stagesApprovalPosition),
                    'stagesApprovalStatus'                =>  $this->stagesApprovalStatus,
                    'currentStage'                        =>  $this->currentStage,
                    'totalStages'                         =>  $this->totalStages,
                    'stages'                              =>  json_decode($this->stages),
                    'approvalStatus'                      =>  $this->approvalStatus,
                    'status'                              =>  $this->getApprovalStatus($this->approvalStatus),
                    'approvedBy'                          =>  $this->getApprovedBy($this->approval_by_id),
                    'remarks'                             =>  json_decode($this->remarks),
                    'quotes'                              =>  json_decode($this->quotes),
                    'receipts'                            =>  json_decode($this->receipts),
                ];

            case "FUEL":
                return [
                    'id'                                  =>  $this->id,
                    'type'                                =>  $this->type,
                    'driverName'                          =>  $this->driverName,
                    'fuelRequestedLitres'                 =>  $this->fuelRequestedLitres,
                    'fuelRequestedMoney'                  =>  $this->fuelRequestedMoney,
                    'purpose'                             =>  $this->purpose,
                    'vehicle'                             =>  $this->vehicle,
                    'mileage'                             =>  $this->mileage,
                    'lastRefillDate'                      =>  $this->lastRefillDate,
                    'lastRefillFuelReceived'              =>  $this->lastRefillFuelReceived,
                    'lastRefillMileageCovered'            =>  $this->lastRefillMileageCovered,
                    'requestedBy'                         =>  $this->user,
                    'dateRequested'                       =>  $this->dateRequested,
                    'stagesApprovalPosition'              =>  $this->approvalPosition($this->stagesApprovalPosition),
                    'stagesApprovalStatus'                =>  $this->stagesApprovalStatus,
                    'currentStage'                        =>  $this->currentStage,
                    'totalStages'                         =>  $this->totalStages,
                    'stages'                              =>  json_decode($this->stages),
                    'approvalStatus'                      =>  $this->approvalStatus,
                    'status'                              =>  $this->getApprovalStatus($this->approvalStatus),
                    'approvedBy'                          =>  $this->getApprovedBy($this->approval_by_id),
                    'remarks'                             =>  json_decode($this->remarks),
                    'quotes'                              =>  json_decode($this->quotes),
                    'receipts'                            =>  json_decode($this->receipts),
                ];

            default:
                return [];
        }
    }

    private function approvalPosition($positionId){
        $position=Position::find($positionId);
        if(is_object($position))
            return new PositionResource($position);
        else
            return null;
    }

    private function getApprovedBy($id){
        $user=User::find($id);
        if(is_object($user))
            return new UserResource($user);
        else
            return null;
    }

    private function getApprovalStatus($status){
        switch ($status){
            case 0:
                return "Pending";
            case 1:
                return "Approved";
            case 2:
                return "Denied";
            case 3:
                return "Initiated";
            case 4:
                return "Reconciled";
            default:
                return "Unknown";
        }
    }
}
