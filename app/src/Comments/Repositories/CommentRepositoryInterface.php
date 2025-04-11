<?php

namespace Src\Comments\Repositories;

interface CommentRepositoryInterface
{
    /**
     * Retrieve all comments associated with a given task and building.
     *
     * @param  string                                                                 $buildingId The ID of the building.
     * @param  string                                                                 $taskId     The ID of the task.
     * @return \Illuminate\Database\Eloquent\Collection<\Src\Comments\Models\Comment>
     */
    public function getCommentsFromTask(string $buildingId, string $taskId);

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
    public function getCommentFromTask(string $buildingId, string $taskId, string $commentId);

    /**
     * Create a new comment associated with a given task and building.
     *
     * @param  string                       $buildingId The ID of the building.
     * @param  string                       $taskId     The ID of the task.
     * @param  array                        $data       The data for creating the comment.
     * @return \Src\Comments\Models\Comment The newly created comment.
     */
    public function creteCommentOnTask(array $data);

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
    public function deleteCommentFromTask(string $buildingId, string $taskId, string $commentId);
}
