<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Portfolio extends Model
{
  protected $table = 'portfolio'; // Define the table name
  protected $primaryKey = "id";
  protected $fillable = ['coin_id', 'user_id', 'buy_price', 'amount', 'date_purchased', 'created_at', 'updated_at'];

  public function User() {
    return $this->belongsTo('App\User');
  }

  public function CryptoCurrency() {
    return $this->hasOne('App\CryptoCurrency', 'id', 'coin_id');
  }

  public function setDatePurchasedAttribute($value) //Mutator that converts date into Year/Month/Date format to store into DB
  {
    $this->attributes['date_purchased'] =  Carbon::parse($value)->format('y/m/d');
  }

  public function getDatePurchasedAttribute()
  {
    return  Carbon::parse($this->attributes['date_purchased'])->format('d-m-y');
  }

  public function getCreatedAtAttribute()
  {
    return  Carbon::parse($this->attributes['created_at'])->format('d-m-y');
  }

  public function getTotalCoinValueAttribute() {
    return '$' . $this->totalAmount * $this->CryptoCurrency->price_usd;
  }

  public function getCurrentCoinValueAttribute() {
    return '$' . $this->amount * $this->CryptoCurrency->price_usd;
  }

  public function getInitialCoinValueAttribute() {
    return '$' . $this->amount * $this->buy_price;
  }

  public function getProfitAttribute() {
    return '$' . (string)($this->amount * ($this->CryptoCurrency->price_usd - $this->buy_price));
    //return '$' . (string)(($this->amount * $this->CryptoCurrency->price_usd) - ($this->amount * $this->buy_price));
  }

  public function getCoinNameAttribute() {
    return $this->CryptoCurrency->name;
  }

  public function getCurrentPriceAttribute() {
    return $this->CryptoCurrency->price_usd;
  }

}
