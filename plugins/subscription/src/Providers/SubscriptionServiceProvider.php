<?php

namespace Juzaweb\Subscription\Providers;

use Juzaweb\Subscription\Contracts\SubscriptionContract;
use Juzaweb\Subscription\Manage\SubscriptionManage;
use Juzaweb\Subscription\SubscriptionAction;
use Juzaweb\Support\ServiceProvider;

class SubscriptionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'subr');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'subr');

        $this->registerAction([
            SubscriptionAction::class
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->singleton(SubscriptionContract::class, function () {
            return new SubscriptionManage();
        });
    }
}