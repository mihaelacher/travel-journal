<?php

namespace App\Providers;

use App\Services\Map\GooglePlacesDataService;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(GooglePlacesDataService::class, function () {
            return new GooglePlacesDataService();
        });

        Response::macro('api', function ($data, $status = 200) {
            return response()->json($data, $status);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(env('FORCE_HTTPS',true)) { // Default value should be false for local server
            URL::forceScheme('https');
        }
    }
}
