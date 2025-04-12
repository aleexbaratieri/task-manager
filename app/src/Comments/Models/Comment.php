<?php

namespace Src\Comments\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Tasks\Models\Task;

class Comment extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'comments';

    protected $fillable = [
        'building_id',
        'task_id',
        'author_id',
        'comment',
    ];

    /**
     * The task that this comment belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user that authored this comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
