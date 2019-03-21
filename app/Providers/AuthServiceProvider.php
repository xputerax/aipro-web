<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    const AIPRO_CEO_GROUP_ID = 1;
    const AIPRO_MANAGER_GROUP_ID = 2;
    const AIPRO_CLERK_GROUP_ID = 3;
    const AIPRO_SALES_GROUP_ID = 4;
    const AIPRO_REPAIR_GROUP_ID = 5;

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
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
         * Allow all actions for CEO
         */
        Gate::before(function ($user, $ability) {
            if($user->group_id === self::AIPRO_CEO_GROUP_ID){
                return true;
            }
        });

        /**
         * Branch section
         */
        Gate::define('list-branch', function($user) {
            return $user->group_id === self::AIPRO_CEO_GROUP_ID;
        });

        Gate::define('create-branch', function($user) {
            return $user->group_id === self::AIPRO_CEO_GROUP_ID;
        });

        Gate::define('view-branch', function($user, $branch) {
            return $user->group_id === self::AIPRO_CEO_GROUP_ID;
        });

        Gate::define('edit-branch', function($user, $branch) {
            return $user->group_id === self::AIPRO_CEO_GROUP_ID;
        });

        Gate::define('delete-branch', function($user, $branch) {
            return $user->group_id === self::AIPRO_CEO_GROUP_ID;
        });

        /**
         * Brand section
         */
        Gate::define('list-brand', function($user) {
            return $user->group_id === self::AIPRO_MANAGER_GROUP_ID;
        });

        Gate::define('create-brand', function($user) {
            return $user->group_id === self::AIPRO_MANAGER_GROUP_ID;
        });

        Gate::define('view-brand', function($user, $brand) {
            return $user->group_id === self::AIPRO_MANAGER_GROUP_ID
                && $user->branch->id === $brand->branch_id;
        });

        Gate::define('edit-brand', function($user, $brand) {
            return $user->group_id === self::AIPRO_MANAGER_GROUP_ID
                && $user->branch->id === $brand->branch_id;
        });

        Gate::define('delete-brand', function($user, $brand) {
            return $user->group_id === self::AIPRO_MANAGER_GROUP_ID
                && $user->branch->id === $brand->branch_id;
        });

        /**
         * Customer section
         */
        Gate::define('list-customer', function($user) {
            return true;
        });

        Gate::define('create-customer', function($user) {
            return true;
        });

        Gate::define('view-customer', function($user, $customer) {
            return $user->branch->id === $customer->branch_id;
        });

        Gate::define('edit-customer', function($user, $customer) {
            return $user->branch->id === $customer->branch_id;
        });

        Gate::define('delete-customer', function($user, $customer) {
            return $user->branch->id === $customer->branch_id;
        });

        /**
         * Order section
         */
        Gate::define('list-order', function($user) {
            return true;
        });

        Gate::define('create-order', function($user) {
            return true;
        });

        Gate::define('view-order', function($user, $order) {
            return $user->branch->id === $order->customer->branch->id;
        });

        Gate::define('edit-order', function($user, $order) {
            return $user->branch->id === $order->customer->branch->id;
        });

        Gate::define('delete-order', function($user, $order) {
            return $user->branch->id === $order->customer->branch->id;
        });

        /**
         * Product section
         */
        Gate::define('list-product', function($user) {
            return true;
        });

        Gate::define('create-product', function($user) {
            return true;
        });

        Gate::define('view-product', function($user, $product) {
            return $user->branch->id === $product->branch_id;
        });

        Gate::define('edit-product', function($user, $product) {
            return $user->branch->id === $product->branch_id;
        });

        Gate::define('delete-product', function($user, $product) {
            return $user->branch->id === $product->branch_id;
        });

        /**
         * User section
         */
        Gate::define('list-user', function($currentUser) {
            return $currentUser->group_id === self::AIPRO_MANAGER_GROUP_ID;
        });

        Gate::define('create-user', function($currentUser) {
            return $currentUser->group_id === self::AIPRO_MANAGER_GROUP_ID;
        });

        Gate::define('view-user', function($currentUser, $user) {
            return $currentUser->group_id === self::AIPRO_MANAGER_GROUP_ID
                && $currentUser->branch->id === $user->branch->id;
        });

        Gate::define('edit-user', function($currentUser, $user) {
            return $currentUser->group_id === self::AIPRO_MANAGER_GROUP_ID
                && $currentUser->branch->id === $user->branch->id;
        });

        Gate::define('delete-user', function($currentUser, $user) {
            return $currentUser->group_id === self::AIPRO_MANAGER_GROUP_ID
                && $currentUser->branch->id === $user->branch->id;
        });

        /**/

        Gate::define('search-users-across-branches', function($user) {
            return $user->group_id === self::AIPRO_CEO_GROUP_ID;
        });

        Gate::define('get-sales-report-all-branches', function($user) {
            return $user->group_id === self::AIPRO_CEO_GROUP_ID;
        });

        Gate::define('get-brands-all-branches', function($user) {
            return $user->group_id === self::AIPRO_CEO_GROUP_ID;
        });

        Gate::define('list-orders-all-branches', function ($user) {
            return $user->group_id === self::AIPRO_CEO_GROUP_ID;
        });

    }
}
