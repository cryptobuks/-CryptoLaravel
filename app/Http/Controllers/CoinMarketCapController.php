<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\CryptoCurrency;

class CoinMarketCapController extends Controller
{
    function index() {
      $client = new Client(['base_uri' => 'https://api.coinmarketcap.com/v1/']);
      $response = $client->get('ticker/?start=0&limit=100')->getBody()->getContents();
      $jsonResponse = json_decode($response);
      //return response()->json($jsonResponse);

      foreach($jsonResponse as $item) {
        $data[] = CryptoCurrency::updateOrCreate(
          [
            'name' => $item->name
          ],
          [
            'name' => $item->name,
            'symbol' => $item->symbol,
            'rank' => $item->rank,
            'price_usd' => $item->price_usd,
            '24h_volume_usd' => $item->{'24h_volume_usd'},
            'market_cap_usd' => $item->market_cap_usd,
            'available_supply' => $item->available_supply,
            'total_supply' => $item->total_supply,
            'percent_change_1h' => $item->percent_change_1h,
            'percent_change_24h' => $item->percent_change_24h,
            'percent_change_7d' => $item->percent_change_7d,
            'last_updated' => $item->last_updated
          ]
        );
      }

      return $data;
    }



}
