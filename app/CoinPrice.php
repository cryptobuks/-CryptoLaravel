<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoinPrice extends Model
{
  protected $table = 'coin_price'; // Define the table name
  protected $primaryKey = "id";
  protected $fillable = ['coin_id', 'date', 'price'];
  public $timestamps = false;

  public function Portfolio() {
    return $this->belongsTo('App\Portfolio', 'coin_id', 'coin_id');
  }
}
