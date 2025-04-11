<?php

namespace Src\Comments\Filters;

use Src\Shared\Interfaces\LoadRelationsInterface;

class LoadRelations implements LoadRelationsInterface
{
    /**
     * Get the relations that should be loaded
     *
     * @return array<string>
     */
    public static function handle(): array
    {
        $relations = [];

        if (self::testRelation('authors')) {
            $relations[] = 'author';
        }

        if (self::testRelation('task')) {
            $relations[] = 'task';

            if (self::testRelation('building')) {
                $relations[] = 'task.building';
            }

            if (self::testRelation('authors')) {
                $relations[] = 'task.author';
            }

            if (self::testRelation('owners')) {
                $relations[] = 'task.owner';
            }
        }

        return $relations;
    }

    protected static function testRelation(string $relation): bool
    {
        if (request()->has($relation) && true === filter_var(request()->{$relation}, FILTER_VALIDATE_BOOLEAN)) {
            return true;
        }

        return false;
    }
}
