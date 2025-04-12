<?php

namespace Src\Buildings\Filters;

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

        if (self::testRelation('tasks')) {

            if (self::testRelation('authors')) {
                $relations[] = 'tasks.author';
            }

            if (self::testRelation('owners')) {
                $relations[] = 'tasks.owner';
            }

            if (self::testRelation('comments')) {

                $relations[] = 'tasks.comments';

                if (self::testRelation('authors')) {
                    $relations[] = 'tasks.comments.author';
                }
            }

            $relations[] = 'tasks';
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
