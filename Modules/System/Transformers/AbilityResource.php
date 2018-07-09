<?php

namespace Modules\System\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class AbilityResource extends Resource
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
            'method' => new MethodResource(
                $this->whenLoaded('method')
            ),
            'resource' => new ResourceResource(
                $this->whenLoaded('resource')
            ),
        ];
    }
}
