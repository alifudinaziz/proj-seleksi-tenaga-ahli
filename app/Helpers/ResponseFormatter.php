<?php

namespace App\Helpers;

class ResponseFormatter
{
  protected static $response = [
    'message' => null,
    'data' => null
  ];

  public static function success($data = null, $message = null)
  {
    self::$response['message'] = $message;
    self::$response['data'] = $data;

    return response()->json(self::$response);
  }

  public static function error($data = null, $message = null)
  {
    self::$response['message'] = $message;
    self::$response['data'] = $data;

    return response()->json(self::$response);
  }
}
