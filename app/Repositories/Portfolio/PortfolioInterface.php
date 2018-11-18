<?php namespace App\Repositories\Portfolio;

use App\Http\Requests\CoinRequest;

interface PortfolioInterface
{
    public function create(CoinRequest $request);

    public function find($id);

    public function update(CoinRequest $request, $id);

    public function destroy($id);

    public function getAll();

    public function getCoinTotalValue($id);

    public function getReturnOfInvestment();

    public function getCoinTotalAmount();

    public function getCoinCurrentValue($id);

    public function getCoinInitialValue($id);

    public function getCoinProfit($id);

    public function getCoinData($id);

    public function getPortfolioWithId($id);

    public function calculateInitialPortfolioValue();

    public function calculateTotalMarketValue();

    public function createChart();
}
