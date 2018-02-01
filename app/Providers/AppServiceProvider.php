<?php

namespace App\Providers;

use GrahamCampbell\GitHub\GitHubFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('GitHub', function ($app) {
            if (!auth()->check() && auth()->user()->token) {
                throw new \Exception('GitHub can only be resolved for authenticated users');
            }

            return $app->make(GitHubFactory::class)
                ->make(['token' => auth()->user()->token, 'method' => 'token']);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
