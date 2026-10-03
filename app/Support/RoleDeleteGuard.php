<?php

namespace App\Support;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleDeleteGuard
{
    public static function blockIfProtected(Request $request, Role $role): ?Response
    {
        if ($role->name === 'admin') {
            return self::deny($request, "The admin role can't be deleted.");
        }

        $assignedCount = $role->users()->count();
        if ($assignedCount > 0) {
            return self::deny(
                $request,
                "This role is assigned to {$assignedCount} users. Change their role first, then delete it."
            );
        }

        return null;
    }

    private static function deny(Request $request, string $message): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 422);
        }

        return redirect()
            ->back()
            ->with('errors', [$message]);
    }
}
