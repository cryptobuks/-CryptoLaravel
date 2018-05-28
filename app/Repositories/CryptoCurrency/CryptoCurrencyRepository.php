<?php namespace App\Repositories\CryptoCurrency;

use Validator;
use App\Portfolio;
use App\CryptoCurrency;
use Carbon\Carbon;
use App\Http\Requests\CoinRequest;
use Illuminate\Support\Facades\Input;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\Repositories\Portfolio\PortfolioInterface;
use App\Repositories\CryptoCurrency\CryptoCurrencyInterface;

abstract class CryptoCurrencyRepository implements CryptoCurrencyInterface
{
    protected $model;
    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getCoinDetails($id)
    {
      return CryptoCurrency::where('id', $id)->first();
    }

}
