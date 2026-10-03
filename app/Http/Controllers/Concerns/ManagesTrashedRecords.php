<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

trait ManagesTrashedRecords
{
    protected function registerTrashedMiddleware(string $permissionSection): void
    {
        $this->middleware('permission:restore '.$permissionSection, ['only' => ['restore']]);
        $this->middleware('permission:permanently_delete '.$permissionSection, ['only' => ['forceDelete']]);
    }

    /**
     * @param  class-string<Model>  $modelClass
     */
    protected function findOnlyTrashed(string $modelClass, int|string $id): Model
    {
        return $modelClass::onlyTrashed()->findOrFail($id);
    }

    /**
     * @param  array<string, int>  $counts
     * @param  array<string, mixed>  $extra
     */
    protected function adminResourceActionResponse(
        Request $request,
        string $indexRouteName,
        string $message,
        array $counts,
        bool $success = true,
        array $extra = [],
        ?array $redirectRouteParameters = null
    ): RedirectResponse|JsonResponse {
        if ($request->expectsJson()) {
            return response()->json(array_merge([
                'success' => $success,
                'message' => $message,
                'counts' => $counts,
            ], $extra));
        }

        $redirect = redirect()->route($indexRouteName, $redirectRouteParameters ?? []);

        return $success
            ? $redirect->with('status', $message)
            : $redirect->with('status', $message);
    }

    /**
     * @param  array<string, int>  $counts
     */
    protected function trashedActionResponse(
        Request $request,
        string $indexRouteName,
        string $message,
        array $counts
    ): RedirectResponse|JsonResponse {
        return $this->adminResourceActionResponse(
            $request,
            $indexRouteName,
            $message,
            $counts,
            true,
            [],
            ['trashed' => '1']
        );
    }

    /**
     * @param  array<string, int>  $counts
     */
    protected function destroyActionResponse(
        Request $request,
        string $indexRouteName,
        string $message,
        array $counts
    ): RedirectResponse|JsonResponse {
        return $this->adminResourceActionResponse($request, $indexRouteName, $message, $counts);
    }
}
