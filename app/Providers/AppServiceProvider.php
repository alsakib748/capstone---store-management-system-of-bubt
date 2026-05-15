<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Custom Blade directive for permission check with Super Admin/Admin bypass
        Blade::if('can', function ($permission) {
            $user = Auth::guard('web')->user();

            if (!$user) {
                return false;
            }

            // Super Admin and Admin bypass all permission checks
            if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
                return true;
            }

            return $user->hasPermissionTo($permission);
        });

        // Custom Blade directive for checking if user has specific role
        Blade::if('role', function ($role) {
            $user = Auth::guard('web')->user();

            if (!$user) {
                return false;
            }

            return $user->hasRole($role);
        });
    }
}
