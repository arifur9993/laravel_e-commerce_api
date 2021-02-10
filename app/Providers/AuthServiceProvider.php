<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use GetResponses;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * Passport Register the routes necessary to issue access tokens and
         * revoke access tokens, clients, and personal access tokens:
         */
        Passport::routes(null, ['prefix' => 'api/v1/oauth']);
        // /* define gate for admin-manage-product permission  */
        Gate::define('admin-manage-product', function ($user) {
            $userRole  = $user->hasRole->hasPermissions;
            foreach ($userRole as $permission) {
                if ($permission->name == 'admin-manage-product') {
                    return true;
                }
            }
            return GetResponses::permissionError();
        });

        // /* define gate for admin-manage-user permission  */
        Gate::define('admin-manage-user', function ($user) {
            $userRole  = $user->hasRole->hasPermissions;
            foreach ($userRole as $permission) {
                if ($permission->name == 'admin-manage-user') {
                    return true;
                }
            }
            return GetResponses::permissionError();
        });
        // /* define gate for admin-manage-order permission  */
        Gate::define('admin-manage-order', function ($user) {
            $userRole  = $user->hasRole->hasPermissions;
            foreach ($userRole as $permission) {
                if ($permission->name == 'admin-manage-order') {
                    return true;
                }
            }
            return GetResponses::permissionError();
        });
        // /* define gate for user-show-product permission  */
        Gate::define('user-show-product', function ($user) {
            $userRole  = $user->hasRole->hasPermissions;
            foreach ($userRole as $permission) {
                if ($permission->name == 'user-show-product') {
                    return true;
                }
            }
            return GetResponses::permissionError();
        });
        // /* define gate for support-manage-order permission  */
        Gate::define('support-manage-order', function ($user) {
            $userRole  = $user->hasRole->hasPermissions;
            foreach ($userRole as $permission) {
                if ($permission->name == 'support-manage-order') {
                    return true;
                }
            }
            return GetResponses::permissionError();
        });
    }
}
