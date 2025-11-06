<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplyRequestItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'supply_request_id' => $this->supply_request_id,
            'supply_id' => $this->supply_id,
            'quantity' => $this->quantity,
            'cost' => $this->cost,

            'supply_request' => new SupplyRequestResource($this->whenLoaded('supplyRequest')),
            'supply' => new SupplyResource($this->whenLoaded('supply'))
        ];
    }
}
