<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // parent::boot();

        // Route::bind('remark', function ($value) {
        //     return \App\Models\TaskRemark::findOrFail($value);
        // });
    }
}
