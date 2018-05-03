<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Notifications\UserRegisteredSuccessfully;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    public function register(Request $request) {
      $validatedData = $request->validate([
        'name' => 'required|alpha_spaces|max:255',
        'username' => 'required|alpha_num|max:255',
        'email' => 'required|email|max:255',
        'password' => 'required|min:6',
      ]);
      try {
        $validatedData['password']= bcrypt(array_get($validatedData, 'password'));
        $validatedData['activation_code'] = str_random(30).time();
        $user = User::create($validatedData);
      } catch (\Exception $exception) {
        logger()->error($exception);
        return redirect()->back()->with('message', 'Unable to create new user.');
      }
      $user->notify(new UserRegisteredSuccessfully($user));
      return redirect()->back()->with('message', 'Successfully created a new account. Please check your email and activate your account.');
    }

    public function activateUser(string $activationCode) {
      try {
        $user = User::where('activation_code', $activationCode)->first();
        if (!$user) {
          return "The account has already been activated or the code doesn't exist.";
        }
        $user->activated = 1;
        $user->activation_code = null;
        $user->save();
        auth()->login($user);
      } catch (\Exception $exception) {
        logger()->error($exception);
        return "Whoops! something went wrong.";
      }
      return redirect()->to('/home');
    }
}
