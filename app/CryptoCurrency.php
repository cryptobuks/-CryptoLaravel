<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CryptoCurrency extends Model
{
  protected $table = 'cryptocurrency'; // Define the table name
  protected $primaryKey = "id";
  protected $fillable = ['name', 'symbol', 'rank', 'available_supply', 'total_supply', 'price_usd', '24h_volume_usd', 'market_cap_usd',
   'percent_change_1h', 'percent_change_7d', 'percent_change_24h', 'last_updated', 'created_at', 'updated_at'];

  public function Portfolio() {
    return $this->belongsTo('App\Portfolio', 'coin_id', 'id');
  }
}
