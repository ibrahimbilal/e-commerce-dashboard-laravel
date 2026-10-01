<?php

namespace App\Support;

use Illuminate\Http\Request;

class IndexListing
{
    /**
     * @param  array<int, string>  $allowedKeys
     * @return array<string, mixed>
     */
    public static function activeFilters(Request $request, array $allowedKeys): array
    {
        $filters = [];

        foreach ($allowedKeys as $key) {
            if (! $request->has($key)) {
                continue;
            }

            $filters[$key] = $request->query($key);
        }

        return $filters;
    }
}
