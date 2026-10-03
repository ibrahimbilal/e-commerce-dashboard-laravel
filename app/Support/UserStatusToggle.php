<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
class UserStatusToggle
{
    /**
     * @return JsonResponse|RedirectResponse
     */
    public static function apply(Request $request, User $user)
    {
        $validated = $request->validate([
            'field' => ['required', 'string', Rule::in(['status'])],
            'value' => ['nullable', 'boolean'],
        ]);

        $targetActive = self::resolveTargetActive($user, $validated['value'] ?? null);
        $newStatus = $targetActive ? 'active' : 'inactive';

        if ($blocked = self::blockIfForbidden($request, $user, $newStatus)) {
            return $blocked;
        }

        $user->forceFill(['status' => $newStatus])->save();

        $message = 'Status updated.';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'field' => 'status',
                'value' => $targetActive,
                'counts' => AdminResourceCounts::users(),
            ]);
        }

        return redirect()
            ->route('users.index')
            ->with('status', $message);
    }

    private static function resolveTargetActive(User $user, mixed $value): bool
    {
        if ($value !== null) {
            return (bool) $value;
        }

        return $user->status !== 'active';
    }

    /**
     * @return JsonResponse|RedirectResponse|null
     */
    private static function blockIfForbidden(Request $request, User $user, string $newStatus)
    {
        if ($newStatus !== 'inactive') {
            return null;
        }

        if ((int) Auth::id() === (int) $user->id) {
            return self::deny($request, 'You cannot deactivate your own account.');
        }

        if ($user->hasRole('admin') && $user->status === 'active') {
            $activeAdmins = User::query()
                ->where('status', 'active')
                ->whereHas('roles', fn ($query) => $query->where('name', 'admin'))
                ->count();

            if ($activeAdmins <= 1) {
                return self::deny($request, 'Cannot deactivate the last active admin account.');
            }
        }

        return null;
    }

    /**
     * @return JsonResponse|RedirectResponse
     */
    private static function deny(Request $request, string $message)
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
