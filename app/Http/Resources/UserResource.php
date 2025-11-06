<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->getRole,
            'is_department_head' => $this->is_department_head,

            'department' => DepartmentResource::make($this->whenLoaded('department')),
            'supply_requests' => SupplyRequestResource::collection($this->whenLoaded('supplyRequests'))
        ];
    }
}
