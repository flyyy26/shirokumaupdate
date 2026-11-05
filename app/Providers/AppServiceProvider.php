<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ✅ Gunakan absolute path
        $this->app->bind('path.public', function () {
            return '/home/u143612213/domains/lpkshirokuma.com/public_html';
        });
    }
}