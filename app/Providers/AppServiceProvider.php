<?php

namespace App\Providers;

use App\Models\AppSetting;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Storage;
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
        //
        Broadcast::routes();
        $setting = AppSetting::firstOrCreate(
            [],
            [
                'app_name' => 'EEPIS-Telehealth',
                'app_logo' => 'images/logos/logo.png',
                'app_description' => 'Sudut Voting is a web-based voting application.',
            ]
        );
        $setting['app_logo'] = Storage::disk('public')->url($setting->app_logo);
        view()->share('app_setting', $setting->toArray());
    }
}
