<?php

namespace Src\Comments\Services;

use Src\Comments\Repositories\CommentRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CommentService implements CommentServiceInterface
{
    /**
     * The Comment Service instance.
     *
     * @param CommentRepositoryInterface $repo The CommentRepositoryInterface instance.
     */
    public function __construct(private readonly CommentRepositoryInterface $repo) {}

    /**
     * Retrieve all comments associated with a given task and building.
     *
     * @param  string                                                                 $buildingId The ID of the building.
     * @param  string                                                                 $taskId     The ID of the task.
     * @return \Illuminate\Database\Eloquent\Collection<\Src\Comments\Models\Comment>
     */
    public function getCommentsFromTask(string $buildingId, string $taskId)
    {
        return $this->repo->getCommentsFromTask($buildingId, $taskId);
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
    public function getCommentFromTask(string $buildingId, string $taskId, string $commentId)
    {
        return $this->repo->getCommentFromTask($buildingId, $taskId, $commentId);
    }

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
    public function creteCommentOnTask(string $buildingId, string $taskId, array $data)
    {
        return $this->repo->creteCommentOnTask(array_merge($data, [
            'building_id' => $buildingId,
            'task_id' => $taskId,
        ]));
    }

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
    public function deleteCommentFromTask(string $buildingId, string $taskId, string $commentId)
    {
        $comment = $this->repo->getCommentFromTask($buildingId, $taskId, $commentId);

        if (auth()->user()->id === $comment->author_id) {
            return $this->repo->deleteCommentFromTask($buildingId, $taskId, $commentId);
        }

        throw new UnauthorizedHttpException('Unauthorized', 'You are not authorized to delete this comment.');
    }
}
