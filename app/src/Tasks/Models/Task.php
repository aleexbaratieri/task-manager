<?php

namespace Src\Tasks\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
