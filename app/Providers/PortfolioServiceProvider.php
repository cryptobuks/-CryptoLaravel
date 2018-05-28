<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class PortfolioServiceProvider extends ServiceProvider
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
      $this->app->bind('portfolioService', 'App\Services\PortfolioService');
      // $this->app->bind('portfolioService', function($app)
      // {
      //     return new PortfolioService(
      //         // Inject in our class of pokemonInterface, this will be our repository
      //         $app->make('App\Repositories\Portfolio\PortfolioInterface')
      //     );
      // });
    }


}
