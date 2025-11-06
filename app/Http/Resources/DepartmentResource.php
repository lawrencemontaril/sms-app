<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'user_id' => $this->user_id,
            'name' => $this->name,
            'code' => $this->code,

            'head' => UserResource::make($this->whenLoaded('user')),
            'members' => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
