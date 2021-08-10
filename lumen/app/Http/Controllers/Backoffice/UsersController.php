<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\BoUsers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  
  public function show(Request $request) {
    try {
      $token = $request->input('api_token');
      $user = BoUsers::where('bu_token', $token)->first();
      if (!$user) {
        return \JSRESP::not_found('User not found');
      }
      return \JSRESP::ok_with_data('Detail of user', $user);
    } catch (QueryException $err) {
      return \JSRESP::server_error($err);
    }
  }
  
  public function forgotPassword(Request $request)
  {
    $validator = Validator::make($request->all(), [
      "email" => "required|email"
    ]);
    
    if ($validator->fails()) {
      return \JSRESP::validator_response($validator->errors());
    }

    $email = $request->input('email');
    $user = BoUsers::where('bu_email_address', $email)->first();
    if (!$user) {
      \JSRESP::not_found('User not found');
    }

    $reset_password_token = sha1(time()) . Crypt::encrypt($user->bu_id);
    BoUsers::where('bu_id', $user->bu_id)->update([
      "bu_reset_password_token" => $reset_password_token,
      "bu_reset_password_expires" => date('Y-m-d H:i:s', time() + 3600),
    ]);

    $data['email'] = $email;
    $data['token'] = $reset_password_token;
    
    dispatch(new \App\Jobs\SendEmailFP($data));

    return \JSRESP::ok("We are successfully sent recovery code to $email. Please check your \ne-mail inbox");
    sleep(60);
  }

  public function validateToken(Request $request)
  {
    try {
      $token = $request->input('token');
      $user = BoUsers::where('bu_reset_password_token', $token)->first();
      if (!$user) {
        return \JSRESP::not_found('User not found');
      }
      if ($user->bu_reset_password_expires < date('Y-m-d H:i:s')) {
        return \JSRESP::unauthorized('Invalid token');
      }
      return \JSRESP::ok('Valid Token');
    } catch (QueryException $err) {
      return \JSRESP::server_error($err);
    }
  }

  public function resetPassword(Request $request)
  {
    $validator = Validator::make($request->all(), [
      "password" => "required|confirmed",
    ]);

    if ($validator->fails()) {
      return \JSRESP::validator_response($validator->errors());
    }
    
    try {
      $hasher = app()->make('hash');
      $resetToken = $request->input('token');
      $newPassword = $hasher->make($request->input('password'));
      $user = BoUsers::where('bu_reset_password_token', $resetToken)->first();
      if (!$user) {
        return \JSRESP::not_found('User not found');
      }
      $token = sha1(time() . env('APP_KEY'));
      BoUsers::where('bu_id', $user->bu_id)->update([
        "bu_password" => $newPassword,
        "bu_token" => $token,
        "bu_reset_password_token" => ''
      ]);
      return \JSRESP::ok('Password changed successfully');
    } catch (QueryException $err) {
      return \JSRESP::server_error($err);
    }
  }
}