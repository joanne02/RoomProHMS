<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Diglactic\Breadcrumbs\Breadcrumbs;
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
        // Set up the morph map for Bouncer roles and abilities
        // Role::morphMap([
        //     'roles' => Role::class,
        // ]);

        // Ability::morphMap([
        //     'abilities' => Ability::class,
        // ]);

        // $breadcrumbsFile = base_path('routes/breadcrumbs.php');
        //     if (file_exists($breadcrumbsFile)) {
        //         require $breadcrumbsFile;
        //     }


        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            $notificationCount = Auth::check() ? Auth::user()->unreadNotifications->count() : 0;
            $view->with('notificationCount', $notificationCount);
        });

    }
}
