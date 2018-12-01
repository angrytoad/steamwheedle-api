<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PriceAdjustmentService;

class PriceAdjustmentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PriceAdjustmentService::class, function ($app) {
            return new PriceAdjustmentService(config('adjustment'));
        });
    }
}
