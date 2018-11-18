<?php namespace App\Services;

use App\Repositories\Portfolio\PortfolioInterface;

class PortfolioService
{
    protected $portfolioRepo;
    public function __construct(PortfolioInterface $portfolioRepo)
    {
        $this->portfolioRepo = $portfolioRepo;
    }
    public function testService()
    {
      return 1;
    }
}
