<?php namespace App\Services;

use Illuminate\Support\Facades\Facade;
class PortfolioFacade extends Facade {

    protected static function getFacadeAccessor() { return 'portfolioService'; }

}
