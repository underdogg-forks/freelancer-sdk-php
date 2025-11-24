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
            
            // Don't create session if no token is provided
            if (empty($token)) {
                $token = 'dummy-token-for-testing';
            }
            
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
