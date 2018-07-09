<?php

namespace Modules\System\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\User\Transformers\UserResource;

class FileResource extends Resource
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
            'disk_name' => $this->disk_name,
            'size' => $this->size,
            'name' => $this->name,
            'content_type' => $this->content_type,
            'is_public' => $this->is_public,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
