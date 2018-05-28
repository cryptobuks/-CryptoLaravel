<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "coin" => "required|exists:cryptocurrency,name",
            "buy_price" => "required|money",
            "amount" => "required|numeric",
            "date_purchased" => "required|date",
        ];
    }
}
