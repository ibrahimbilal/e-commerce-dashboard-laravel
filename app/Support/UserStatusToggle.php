<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserStatusToggle
{
    /**
     * @return JsonResponse|RedirectResponse
     */
    public static function apply(Request $request, User $user)
    {
        $validated = $request->validate([
            'field' => ['required', 'string', Rule::in(['is_active'])],
            'value' => ['nullable', 'boolean'],
        ]);

        $targetActive = self::resolveTargetActive($user, $validated['value'] ?? null);

        self::ensureDeactivationAllowed($request, $user, $targetActive);

        $user->forceFill(['is_active' => $targetActive])->save();

        $message = 'Is active updated.';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'field' => 'is_active',
                'value' => $targetActive,
                'counts' => AdminResourceCounts::users(),
            ]);
        }

        return redirect()
            ->route('users.index')
            ->with('status', $message);
    }

    /**
     * @throws ValidationException
     * @throws HttpResponseException
     */
    public static function ensureDeactivationAllowed(Request $request, User $user, bool $targetActive): void
    {
        $message = self::deactivationBlockedMessage($user, $targetActive);
        if ($message === null) {
            return;
        }

        if ($request->expectsJson()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => $message,
            ], 422));
        }

        throw ValidationException::withMessages([
            'is_active' => $message,
        ]);
    }

    public static function deactivationBlockedMessage(User $user, bool $targetActive): ?string
    {
        if ($targetActive) {
            return null;
        }

        if ((int) Auth::id() === (int) $user->id) {
            return 'You cannot deactivate your own account.';
        }

        if ($user->hasRole('admin') && $user->is_active) {
            $activeAdmins = User::query()
                ->where('is_active', true)
                ->whereHas('roles', fn ($query) => $query->where('name', 'admin'))
                ->count();

            if ($activeAdmins <= 1) {
                return 'Cannot deactivate the last active admin account.';
            }
        }

        return null;
    }

    private static function resolveTargetActive(User $user, mixed $value): bool
    {
        if ($value !== null) {
            return (bool) $value;
        }

        return ! (bool) $user->is_active;
    }
}
