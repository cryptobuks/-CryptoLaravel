<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use App\CryptoCurrency;
use App\CoinPrice;

use DateTime;
use DatePeriod;
use DateIntercal;
class CryptoDataController extends Controller
{
    function cmc() {
      set_time_limit(0);
      $client = new Client(['base_uri' => 'https://api.coinmarketcap.com/v1/']);
      $response = $client->get('ticker/?start=0&limit=100')->getBody()->getContents();
      $jsonResponse = json_decode($response);
      //return response()->json($jsonResponse);

      foreach($jsonResponse as $item) {
        $data[] = CryptoCurrency::updateOrCreate(
          [
            'symbol' => $item->symbol
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

        //$this->cc($item->symbol, $item->rank);
        //echo '</br>' . $item->symbol . '  -  ' . $item->rank . '</br>';
      }

      return 'Done. Added/Updated ' . count($data) . ' items.';
    }

    public function cc($coin, $coinId) {
      $begin = new DateTime('2018-05-15');
      $end = new DateTime("now");
      for($i = $begin; $i <= $end; $i->modify('+1 day')) {
        //header('Content-Type: application/json');
        echo '</br>' . $i->format('d-m-y') . '  $';
        // https://min-api.cryptocompare.com/data/dayAvg?fsym=ETH&tsym=USD&toTs=1527146071
        $timestamp = $i->getTimestamp();
        $client = new Client(['base_uri' => 'https://min-api.cryptocompare.com/data/']);
        $response = $client->get('dayAvg?fsym=' . $coin . '&tsym=USD&toTs=' . $timestamp)->getBody()->getContents();
        $jsonResponse = json_decode($response);
        //echo json_encode($jsonResponse->USD, JSON_PRETTY_PRINT);

        CoinPrice::firstOrCreate(
          ['coin_id' => $coinId, 'date' => $i->format('y-m-d')],
          ['price' => isset($jsonResponse->USD) ? $jsonResponse->USD : -1]
        );

      }


      //Asynch Version
      // $begin = new DateTime('2018-05-15');
      // $end = new DateTime("now");
      // $coin = 'ETH';
      // header('Content-Type: application/json');
      // for($i = $begin; $i <= $end; $i->modify('+1 day')) {
      //   //echo '</br>' . $i->format('d-m-y') . '  $';
      //   // https://min-api.cryptocompare.com/data/dayAvg?fsym=ETH&tsym=USD&toTs=1527146071
      //
      //   $timestamp = $i->getTimestamp();
      //   $client = new Client(['base_uri' => 'https://min-api.cryptocompare.com/data/', 'timeout'  => 5.0,]);
      //   $promise = $client->getAsync('dayAvg?fsym=' . $coin . '&tsym=USD&toTs=' . $timestamp)->then(
      //       function ($response) {
      //           return $response->getBody();
      //       }, function ($exception) {
      //           return $exception->getMessage();
      //       }
      //   );
      // }
      // $response = $promise->wait();
      // echo $response;





      // $client = new Client(['timeout'  => 5.0,]);
      // $promise = $client->getAsync('http://loripsum.net/api')->then(
      //     function ($response) {
      //         return $response->getBody();
      //     }, function ($exception) {
      //         return $exception->getMessage();
      //     }
      // );
      // // wait for request to finish and display its response
      // $response = $promise->wait();
      // echo $response;
    }




}
