<?php

namespace App\Providers;

use FreelancerSdk\Session;
use FreelancerSdk\Resources\Projects\Projects;
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
            
            if (empty($token)) {
                throw new \RuntimeException(
                    'Freelancer OAuth token not configured. Set FREELANCER_OAUTH_TOKEN in your .env file.'
                );
            }
            
            $url = config('freelancer.use_sandbox') 
                ? config('freelancer.sandbox_url') 
                : config('freelancer.api_url');

            return new Session($token, $url);
        });

        $this->app->singleton(Projects::class, function ($app) {
            return new Projects($app->make(Session::class));
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
