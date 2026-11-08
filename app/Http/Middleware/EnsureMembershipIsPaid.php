<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMembershipIsPaid
{
    /**
     * Handle an incoming request.
     * Ensure member has paid their annual membership dues before accessing member portal routes.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->guest(route('login'));
        }

        // Administrators bypass membership dues requirement
        if ($user->isAdmin()) {
            return $next($request);
        }

        $member = $user->member;

        if (! $member || ! $member->isPaid()) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'message' => 'Annual membership dues payment required to access this resource.',
                    'payment_required' => true,
                    'payment_url' => route('membership.payment'),
                ], 402);
            }

            return redirect()->route('membership.payment')->with(
                'warning',
                'Annual membership dues required: Please complete your membership dues payment to activate your member portal access.'
            );
        }

        return $next($request);
    }
}
