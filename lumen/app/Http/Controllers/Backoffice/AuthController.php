<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\BoUsers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function index(Request $request)
  {
    $validator = Validator::make($request->all(), [
      "username" => "required",
      "password" => "required"
    ]);

    if ($validator->fails()) {
      return \JSRESP::validator_response($validator->errors());
    }

    $hasher = app()->make('hash');
    $username = $request->input('username');
    $password = $request->input('password');

    try {
      $validUser = BoUsers::where('bu_username', $username)->first();
      if (!$validUser) return \JSRESP::unauthorized();
      $validPassword = $hasher->check($password, $validUser->bu_password);
      if (!$validPassword) return \JSRESP::unauthorized();
      $activeUser = $validUser['bu_is_active'] === 'Y';
      if (!$activeUser) return \JSRESP::unauthorized('Your account is inactive');

      $token = sha1(time() . env('APP_KEY'));
      $tfaCode = generateRandomStringNumbers();


      // 2fa goes here
      if (env('APP_2FA')) {
        try {
          $data['phone'] = $validUser->bu_phone;
          $data['tfaCode'] = $tfaCode;
          BoUsers::where('bu_id', $validUser->bu_id)->update([
            'bu_2fa' => $tfaCode
          ]);
          dispatch( new \App\Jobs\SendTFACode($data));
          return \JSRESP::ok_with_data('2FA Sent successfully', ["tfa" => true]);
        } catch (RequestException $err) {
          return \JSRESP::connection_timeout();
        }
      }
      BoUsers::where('bu_id', $validUser->bu_id)->update(['bu_token' => $token]);
      return \JSRESP::authorized($token);
    } catch (QueryException $err) {
      return \JSRESP::server_error($err);
    }
  }
  
  public function tfauth(Request $request) {
    $validator = Validator::make($request->all(), [
      "tfaCode" => "required"
    ]);

    if($validator->fails()) {
      return \JSRESP::validator_response($validator->errors());
    }
    
    $tfaCode = $request->input('tfaCode');
    $user = BoUsers::where('bu_2fa', $tfaCode)->first();
    if (!$user) {
      return \JSRESP::unauthorized('Invalid code');
    }
    $token = sha1(time() . env('APP_KEY'));
    BoUsers::where('bu_id', $user->bu_id)->update(['bu_token' => $token, 'bu_2fa' => '']);
    return \JSRESP::authorized($token);
  }
}
