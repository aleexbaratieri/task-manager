<?php

namespace Src\Comments\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Comments\Http\Resources\CommentResource;
use Src\Comments\Services\CommentServiceInterface;

class CommentController extends Controller
{
    /**
     * The comment controller instance.
     *
     * @param CommentServiceInterface $service The CommentServiceInterface instance.
     */
    public function __construct(private readonly CommentServiceInterface $service) {}

    /**
     * Retrieve all comments associated with a given task and building.
     *
     * @param  string                                              $buildingId The ID of the building.
     * @param  string                                              $taskId     The ID of the task.
     * @return array<\Src\Comments\Http\Resources\CommentResource>
     */
    public function index(string $buildingId, string $taskId)
    {
        return CommentResource::collection($this->service->getCommentsFromTask($buildingId, $taskId));
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
     * @return \Src\Comments\Http\Resources\CommentResource
     */
    public function show(string $buildingId, string $taskId, string $commentId)
    {
        return CommentResource::make($this->service->getCommentFromTask($buildingId, $taskId, $commentId));
    }

    /**
     * Create a new comment associated with a given task and building.
     *
     * @param  string                                       $buildingId The ID of the building.
     * @param  string                                       $taskId     The ID of the task.
     * @param  Request                                      $request    The request object containing the data for creating the comment.
     * @return \Src\Comments\Http\Resources\CommentResource
     */
    public function store(string $buildingId, string $taskId, Request $request)
    {
        return CommentResource::make($this->service->creteCommentOnTask($buildingId, $taskId, $request->validated()));
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
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $buildingId, string $taskId, string $commentId)
    {
        $comment = $this->service->deleteCommentFromTask($buildingId, $taskId, $commentId);

        if ($comment) {
            return response()->noContent();
        }
    }
}
