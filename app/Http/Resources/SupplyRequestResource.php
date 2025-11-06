<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplyRequestResource extends JsonResource
{
    /*
    | ---------------------------------------
    |  Transform the resource into an array.
    | ---------------------------------------
    */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'department_id' => $this->department_id,
            'user_id' => $this->user_id,
            'subject' => $this->subject,
            'message' => $this->message,
            'status' => $this->status,
            'total_cost' => $this->total_cost,
            'requested_at' => Carbon::parse($this->requested_at)->format('F j, Y h:i A'),
            'approved_at' => $this->approved_at
                ? Carbon::parse($this->approved_at)->format('F j, Y h:i A')
                : null,
            'remarks' => $this->remarks,

            'department' => DepartmentResource::make($this->whenLoaded('department')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'supply_request_items' => SupplyRequestItemResource::collection($this->whenLoaded('supplyRequestItems'))
        ];
    }
}
