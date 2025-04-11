<?php

namespace Src\Comments\Services;

interface CommentServiceInterface
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
     * This method merges additional data such as author ID, building ID,
     * and task ID into the provided data array before creating
     * the comment.
     *
     * @param  string                       $buildingId The ID of the building.
     * @param  string                       $taskId     The ID of the task.
     * @param  array                        $data       The data for creating the comment.
     * @return \Src\Comments\Models\Comment The newly created comment.
     */
    public function creteCommentOnTask(string $buildingId, string $taskId, array $data);

    /**
     * Delete a specific comment associated with a given task and building.
     * Checks if the authenticated user is the author of the comment before deleting it.
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
