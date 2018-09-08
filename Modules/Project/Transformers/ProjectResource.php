<?php

namespace Modules\Project\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Group\Transformers\GroupResource;

class ProjectResource extends Resource
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
            'description' => $this->description,
            'group' => new GroupResource($this->whenLoaded('group')),
        ];
    }
}
