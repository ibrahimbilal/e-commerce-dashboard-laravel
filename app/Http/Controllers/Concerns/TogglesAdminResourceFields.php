<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait TogglesAdminResourceFields
{
    /**
     * @param  list<string>  $allowedFields
     * @param  callable(): array<string, int>  $countsResolver
     */
    protected function toggleResourceField(
        Request $request,
        Model $model,
        array $allowedFields,
        callable $countsResolver,
        string $indexRouteName
    ): JsonResponse|RedirectResponse {
        $validated = $request->validate([
            'field' => ['required', 'string', Rule::in($allowedFields)],
            'value' => ['nullable', 'boolean'],
        ]);

        $field = $validated['field'];

        if (array_key_exists('value', $validated) && $validated['value'] !== null) {
            $newValue = (bool) $validated['value'];
        } else {
            $newValue = ! (bool) $model->getAttribute($field);
        }

        $model->forceFill([$field => $newValue])->save();

        $message = ucfirst(str_replace('_', ' ', $field)).' updated.';

        return $this->toggleActionResponse(
            $request,
            $indexRouteName,
            $message,
            $countsResolver(),
            $field,
            $newValue
        );
    }

    /**
     * @param  array<string, int>  $counts
     */
    protected function toggleActionResponse(
        Request $request,
        string $indexRouteName,
        string $message,
        array $counts,
        string $field,
        bool $value
    ): JsonResponse|RedirectResponse {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'field' => $field,
                'value' => $value,
                'counts' => $counts,
            ]);
        }

        return redirect()
            ->route($indexRouteName)
            ->with('status', $message);
    }
}
