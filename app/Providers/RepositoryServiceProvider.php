<?php

namespace App\Providers;

use App\Domain\URLRedirect\Contracts\URLRedirectRepositoryInterface;
use App\Domain\URLRedirect\URLRedirectRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(URLRedirectRepositoryInterface::class, URLRedirectRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
