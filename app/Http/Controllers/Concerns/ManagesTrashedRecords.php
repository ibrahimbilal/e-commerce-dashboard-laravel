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

    protected function trashedActionResponse(Request $request, string $indexRouteName, string $message): RedirectResponse|JsonResponse
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return redirect()
            ->route($indexRouteName, ['trashed' => '1'])
            ->with('status', $message);
    }
}
