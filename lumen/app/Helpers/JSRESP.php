<?php

use Symfony\Component\HttpFoundation\Response;

class JSRESP
{
  static function created($message)
  {
    return response()->json(
      // Response Body
      [
        'success' => true,
        'alert' => 'success',
        'message' => $message
      ],
      // Response Code 
      Response::HTTP_CREATED,
      // Response Headers
      ['Content-Type' => 'application/json; charset=utf-8', 'Charset' => 'utf-8'],
      // JSON_UNESCAPED_UNICODE
    );
  }

  static function ok($message)
  {
    return response()->json(
      // Response Body
      [
        'success' => true,
        'alert' => 'success',
        'message' => $message
      ],
      // Response Code 
      Response::HTTP_OK,
      // Response Headers
      ['Content-Type' => 'application/json; charset=utf-8', 'Charset' => 'utf-8'],
      // JSON_UNESCAPED_UNICODE
    );
  }

  static function ok_with_data($message, $data)
  {
    return response()->json(
      [
        'success' => true,
        'message' => $message,
        'data' => $data
      ],
      Response::HTTP_OK,
      ['Content-Type' => 'application/json; charset=utf-8', 'Charset' => 'utf-8'],
    );
  }

  static function not_found($message)
  {
    return response()->json(
      [
        'success' => false,
        'message' => $message,
        'alert' => 'danger'
      ],
      Response::HTTP_NOT_FOUND,
      ['Content-Type' => 'application/json; charset=utf-8', 'Charset' => 'utf-8'],
    );
  }

  static function server_error($err)
  {
    return response()->json(
      [
        'success' => false,
        'alert' => 'error',
        'message' => 'Oops. Something wrong'
      ], 
      Response::HTTP_INTERNAL_SERVER_ERROR,
      ['Content-Type' => 'application/json; charset=utf-8', 'Charset' => 'utf-8']
    );
  }
  
  static function connection_timeout()
  {
    return response()->json(
      [
        'success' => false,
        'alert' => 'error',
        'message' => 'You are offline'
      ], 
      Response::HTTP_REQUEST_TIMEOUT,
      ['Content-Type' => 'application/json; charset=utf-8', 'Charset' => 'utf-8']
    );
  }

  static function isExist($message)
  {
    return response()->json(
      [
        'success' => false,
        'alert' => 'error',
        'message' => $message
      ], 
      Response::HTTP_OK,
      ['Content-Type' => 'application/json; charset=utf-8', 'Charset' => 'utf-8']
    );
  }

  static function authorized($token)
  {
    return response()->json(
      [
        'success' => true,
        'token' => $token,
        'message' => 'Authenticated successfully',
        'alert' => 'info'
      ], 
      Response::HTTP_OK,
      ['Content-Type' => 'application/json; charset=utf-8', 'Charset' => 'utf-8']
    );
  }
  
  static function unauthorized($message='Your username or password incorrect')
  {
    return response()->json(
      [
        'success' => false,
        'message' => $message,
        'alert' => 'danger'
      ], 
      Response::HTTP_UNAUTHORIZED,
      ['Content-Type' => 'application/json; charset=utf-8', 'Charset' => 'utf-8']
    );
  }

  static function forbidden($message='')
  {
    return response()->json(
      [
        'success' => false,
        'message' => $message,
      ], 
      Response::HTTP_FORBIDDEN,
      ['Content-Type' => 'application/json; charset=utf-8', 'Charset' => 'utf-8']
    );
  }

  static function validator_response($errors)
  {
    return response()->json(
      $errors,
      Response::HTTP_UNPROCESSABLE_ENTITY,
      ['Content-Type' => 'application/json; charset=utf-8', 'Charset' => 'utf-8']
    );
  }
}