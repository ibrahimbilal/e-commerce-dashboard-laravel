<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserForceDeleteGuard
{
    public static function blockIfForbidden(Request $request, User $target, User $actor): ?Response
    {
        if ((int) $target->id === (int) $actor->id) {
            return self::blocked($request, 'You cannot permanently delete your own account.');
        }

        if ($target->hasRole('admin')) {
            $remainingAdmins = User::query()
                ->role('admin')
                ->where('id', '!=', $target->id)
                ->count();

            if ($remainingAdmins < 1) {
                return self::blocked($request, 'Cannot permanently delete the last admin account.');
            }
        }

        return null;
    }

    private static function blocked(Request $request, string $message): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'errors' => ['force_delete' => [$message]],
            ], 422);
        }

        return redirect()
            ->back(302, [], url()->previous() ?: '/')
            ->with('status', $message);
    }
}
