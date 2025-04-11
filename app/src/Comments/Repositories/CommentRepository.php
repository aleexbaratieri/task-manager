<?php

namespace Src\Comments\Repositories;

use Src\Comments\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * The Comment Repository instance.
     *
     * @param Comment $resource The Comment resource (Eloquent model)
     */
    public function __construct(private readonly Comment $resource) {}

    /**
     * Retrieve all comments associated with a given task and building.
     *
     * @param  string                                                                 $buildingId The ID of the building.
     * @param  string                                                                 $taskId     The ID of the task.
     * @return \Illuminate\Database\Eloquent\Collection<\Src\Comments\Models\Comment>
     */
    public function getCommentsFromTask(string $buildingId, string $taskId)
    {
        return $this->resource->where('building_id', $buildingId)->where('task_id', $taskId)->get();
    }

    /**
     * Retrieve a specific comment associated with a given task and building.
     *
     * @param string $buildingId The ID of the building.
     * @param string $taskId     The ID of the task.
     * @param string $commentId  The ID of the comment.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the comment is not found.
     *
     * @return \Src\Comments\Models\Comment The comment.
     */
    public function getCommentFromTask(string $buildingId, string $taskId, string $commentId, array $relations = [])
    {
        return $this->resource
            ->where('building_id', $buildingId)
            ->where('task_id', $taskId)
            ->where('id', $commentId)
            ->with($relations)
            ->firstOrFail();
    }

    /**
     * Create a new comment associated with a given task and building.
     *
     * @param  string                       $buildingId The ID of the building.
     * @param  string                       $taskId     The ID of the task.
     * @param  array                        $data       The data for creating the comment.
     * @return \Src\Comments\Models\Comment The newly created comment.
     */
    public function creteCommentOnTask(array $data)
    {
        return $this->resource->create($data);
    }

    /**
     * Delete a specific comment associated with a given task and building.
     *
     * @param string $buildingId The ID of the building.
     * @param string $taskId     The ID of the task.
     * @param string $commentId  The ID of the comment.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the comment is not found.
     *
     * @return bool True if the comment was deleted, false if not.
     */
    public function deleteCommentFromTask(string $buildingId, string $taskId, string $commentId)
    {
        return $this->getCommentFromTask($buildingId, $taskId, $commentId)->delete();
    }
}
