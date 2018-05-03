<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name': 'required|alpha_spaces',
            'username': 'required|alpha_num',
            'password': 'required',
            'email': 'required|email',
        ];
    }

    public function messages() {
      return [
        'name.required': 'Please enter your name.',
        'name.alpha_spaces': 'Name must only contain characters, hypens and spaces.',
        'username.required': 'Please enter your username.',
        'username.alpha_num': 'Username must contain only characters and numbers',
        'password.required': 'Please enter your password.',
        'email.required': 'Please enter your email address.',
        'email.email': 'Email format is incorrect.'
      ]
    }
}
