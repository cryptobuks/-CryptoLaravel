<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Validator;
use Session;
use Redirect;
use Auth;
use Illuminate\Support\Facades\Input;
use App\CryptoCurrency;

class CryptoCurrencyController extends Controller
{
  public function find(Request $request)
  {
    return CryptoCurrency::search($request->get('q'))->get();
  }
}
