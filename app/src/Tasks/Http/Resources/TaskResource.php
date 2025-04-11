<?php

namespace Src\Tasks\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Src\Buildings\Http\Resources\BuildingResource;
use Src\Comments\Http\Resources\CommentResource;

class TaskResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'owner' => $this->whenLoaded('owner'),
            'author' => $this->whenLoaded('author'),
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'building' => BuildingResource::make($this->whenLoaded('building')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
