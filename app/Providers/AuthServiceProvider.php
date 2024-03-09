<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Appointment;
use App\Models\Order;
use App\Models\User;
use App\Policies\AppointmentPolicy;
use App\Policies\OrderPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Appointment::class => AppointmentPolicy::class,
        Order::class => OrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            dd('before policy applied');
            return $user->hasRole('super');
        });
        $this->registerPolicies();
    }
}
