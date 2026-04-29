<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;

class CartPolicy
{
    public function update(User $user, Cart $cart): bool
    {
        return $user->id === $cart->user_id;
    }

    public function delete(User $user, Cart $cart): bool
    {
        return $user->id === $cart->user_id;
    }
}

/*
|--------------------------------------------------------------------------
| Register in AuthServiceProvider or AppServiceProvider:
|--------------------------------------------------------------------------
| use App\Models\Cart;
| use App\Policies\CartPolicy;
|
| Gate::policy(Cart::class, CartPolicy::class);
|--------------------------------------------------------------------------
*/


// ============================================================
// FILE: app/Http/Middleware/AdminMiddleware.php
// ============================================================

// namespace App\Http\Middleware;
//
// use Closure;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
//
// class AdminMiddleware
// {
//     public function handle(Request $request, Closure $next): Response
//     {
//         if (!auth()->check() || !auth()->user()->is_admin) {
//             abort(403, 'Akses ditolak.');
//         }
//         return $next($request);
//     }
// }
