<?php

namespace Src\Tasks\Filters;

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

        if (self::testRelation('building')) {
            $relations[] = 'building';
        }

        if (self::testRelation('authors')) {
            $relations[] = 'author';
        }

        if (self::testRelation('owners')) {
            $relations[] = 'owner';
        }

        if (self::testRelation('comments')) {

            $relations[] = 'comments';

            if (self::testRelation('authors')) {
                $relations[] = 'comments.author';
            }
        }

        return $relations;
    }

    /**
     * Tests if the given relation is requested
     */
    protected static function testRelation(string $relation): bool
    {
        if (request()->has($relation) && true === filter_var(request()->{$relation}, FILTER_VALIDATE_BOOLEAN)) {
            return true;
        }

        return false;
    }
}
