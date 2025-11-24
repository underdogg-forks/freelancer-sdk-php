<?php

namespace App\Providers;

use FreelancerSdk\Session;
use Illuminate\Support\ServiceProvider;

class FreelancerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Session::class, function ($app) {
            $token = config('freelancer.oauth_token');
            $url = config('freelancer.use_sandbox') 
                ? config('freelancer.sandbox_url') 
                : config('freelancer.api_url');

            return new Session($token, $url);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
