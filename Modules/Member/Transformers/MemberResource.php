<?php

namespace Modules\Member\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\User\Transformers\UserResource;

class MemberResource extends Resource
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
            'user_id' => $this->user_id,
            'cpf' => $this->cpf,
            'user' => new UserResource(
                $this->whenLoaded('user')
            ),
        ];
    }
}
