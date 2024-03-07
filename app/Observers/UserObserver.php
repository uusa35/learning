<?php

namespace App\Observers;

use App\Mail\UserRegistered;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Str;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if (app()->environment('production')) {
            Mail::to($user->email)->send(new UserRegistered($user, Setting::first()));
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $user->categories()->sync([]);
        $user->tags()->sync([]);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
