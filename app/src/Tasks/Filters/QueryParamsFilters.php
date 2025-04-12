<?php

namespace Src\Tasks\Filters;

use Carbon\Carbon;

class QueryParamsFilters
{
    /**
     * Retrieve the value associated with a specific key from the filters array.
     *
     * If the key is 'created_start' or 'created_end', the value is converted to a Carbon instance.
     * Otherwise, the value is returned as is. If the key does not exist in the array, null is returned.
     *
     * @param array  $filters The array of filters with potential key-value pairs.
     * @param string $key     The key to retrieve the value for.
     *
     * @return mixed The value associated with the key, possibly as a Carbon instance, or null if the key is not present.
     */
    public static function getFilterValue(array $filters, string $key): mixed
    {
        if (isset($filters[$key])) {

            return match ($key) {
                'created_start', 'created_end' => Carbon::make($filters[$key]),
                default => $filters[$key],
            };
        }

        return null;
    }
}