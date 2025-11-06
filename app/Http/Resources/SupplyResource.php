<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplyResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'reorder_level' => $this->reorder_level,

            'is_low_stock' => $this->is_low_stock,
            'is_no_stock' => $this->is_no_stock
        ];
    }
}
