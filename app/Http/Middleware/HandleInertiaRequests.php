<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'currentRouteName' => $request->route()->getName(),
            'setting' => Setting::first(),
            'currentLang' => session()->get('lang') ?? 'en',
            'auth' => [
                'user' => $request->user(),
                'isAdmin' => $request->user() ? $request->user()->hasRole('admin|super') : false,
                'isDoctor' => $request->user() ? $request->user()->hasRole('doctor') : false,
                'isReceptionist' => $request->user() ? $request->user()->hasRole('receptionist') : false,
                'api_token' => $request->user() ?  $request->user()->api_token : null
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
                'query' => $request->query()
            ],
            'flash' => [
                // in your case, you named your flash message 'success'
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error')
            ],
        ];
    }
}
