<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'idx'=>$this->id,
            'namex'=>$this->name,
            'emailx'=>$this->email,
            'role_idx'=>$this->role_id,
            'created'=>$this->created_at,
            'updated'=>$this->updated_at,

        ];
    }
}
