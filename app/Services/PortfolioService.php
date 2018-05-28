<?php namespace App\Services;

use App\Repositories\Portfolio\PortfolioInterface;

class PortfolioService
{
    // Containing our pokemonRepository to make all our database calls to
    protected $portfolioRepo;

    /**
    * Loads our $pokemonRepo with the actual Repo associated with our pokemonInterface
    *
    * @param pokemonInterface $pokemonRepo
    * @return PokemonService
    */
    public function __construct(PortfolioInterface $portfolioRepo)
    {
        $this->portfolioRepo = $portfolioRepo;
    }

    /**
    * Method to get pokemon based either on name or ID
    *
    * @param mixed $pokemon
    * @return string
    */
    public function testService()
    {
      return 1;
    }
}
