<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Policies\CartPolicy;
use App\Models\Cart;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Cart::class, CartPolicy::class);
        //
    }
}
