<?php

namespace Src\Buildings\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Tasks\Models\Task;

class Building extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'buildings';

    protected $fillable = [
        'name',
        'description',
        'address',
    ];

    /**
     * Get the tasks associated with the building.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
