<?php namespace App\Repositories\Portfolio;

/**
 * A simple interface to set the methods in our Pokemon repository, nothing much happening here
 */
use App\Http\Requests\CoinRequest;

interface PortfolioInterface
{
    public function create(CoinRequest $request);

    public function getAll();

    public function getCoinTotalAmount();

    public function getCoinTotalValue($id);

    public function getCoinDetailWithId($id);

    public function calculateInitialPortfolioValue();

    public function calculateTotalMarketValue();

    public function createChart();
}
