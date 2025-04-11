<?php

namespace Src\Tasks\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Buildings\Models\Building;
use Src\Comments\Models\Comment;

class Task extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'tasks';

    protected $fillable = [
        'name',
        'description',
        'building_id',
        'author_id',
        'owner_id',
        'status',
    ];

    /**
     * Get the building that this task belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * Get the comments for this task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The user that created this task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * The user that owns this task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function owner()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
