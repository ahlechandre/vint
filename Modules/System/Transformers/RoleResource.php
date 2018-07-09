<?php

namespace Modules\System\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\User\Transformers\UserResource;

class RoleResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'abilities' => AbilityResource::collection(
                $this->whenLoaded('abilities')
            ),
            'users' => UserResource::collection(
                $this->whenLoaded('users')
            ),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at, 
        ];
    }
}
