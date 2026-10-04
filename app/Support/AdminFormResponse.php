<?php

namespace App\Support;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminFormResponse
{
    /**
     * @param  callable(): RedirectResponse  $redirect
     */
    public static function saved(Request $request, string $message, callable $redirect): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'redirect' => $redirect()->getTargetUrl(),
            ]);
        }

        return $redirect()->with('status', $message);
    }
}
