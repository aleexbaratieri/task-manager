<?php

namespace Src\Buildings\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'buildings';

    protected $fillable = [
        'name',
        'description',
        'address',
    ];
}
