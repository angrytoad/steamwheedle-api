<?php namespace App\Providers;
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 09/01/19
 * Time: 14:23
 */

use App\Services\MetricService;
use Illuminate\Support\ServiceProvider;

class MetricServiceProvider extends ServiceProvider
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
        $this->app->bind(MetricService::class, function ($app) {
            return new MetricService();
        });
    }
}