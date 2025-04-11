<?php

namespace Src\Comments\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Src\Tasks\Http\Resources\TaskResource;

class CommentResource extends JsonResource
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
            'comment' => $this->comment,
            'author' => $this->whenLoaded('author'),
            'task' => TaskResource::make($this->whenLoaded('task')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
