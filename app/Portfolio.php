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
    return $this->hasMany('App\CryptoCurrency');
  }

  public function setDatePurchasedAttribute($value) //Mutator that converts date into Year/Month/Date format to store into DB
  {
    $this->attributes['date_purchased'] =  Carbon::parse($value)->format('y/m/d');
  }

}
