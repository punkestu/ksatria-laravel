<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        if (Schema::hasTable('settings')) {
            $settings = Cache::remember('settings', 60, function () {
                $settings = \App\Models\Setting::find(1);
                if (!$settings) {
                    $settings = new \App\Models\Setting();
                    $settings->save();
                }
                return $settings;
            });
            view()->share('settings', $settings);
        }
    }
}
