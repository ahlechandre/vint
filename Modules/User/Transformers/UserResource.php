<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\System\Transformers\RoleResource;

class UserResource extends Resource
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
            'email' => $this->email,
            'identification_number' => $this->identification_number,
            'is_active' => $this->is_active,
            'role' => new RoleResource(
                $this->whenLoaded('role')
            ),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
