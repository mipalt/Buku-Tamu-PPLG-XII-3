<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class ApiFormatter
{
  private static function sendResponse(string $status, int $status_code, string $message, $data = null, array $meta = [], array $extraFields = [])
  {
    $response = array_merge([
      'status' => $status,
      'status_code' => $status_code,
      'message' => $message,
      'data' => $data,
    ], $extraFields);

    if (!empty($meta)) {
      $response['meta'] = $meta;
    }

    if ($status === 'error') {
      Log::error("API Error: {$message}", ['status_code' => $status_code, 'data' => $data]);
    }

    return response($response, $status_code);
  }

  public static function sendSuccess(string $message, $data = null, int $status_code = 200, array $meta = [], array $extraFields = [])
  {
    return self::sendResponse('success', $status_code, $message, $data, $meta, $extraFields);
  }

  public static function sendError(string $message, $data = null, int $status_code = 400, array $meta = [])
  {
    return self::sendResponse('error', $status_code, $message, $data, $meta);
  }

  public static function sendNotFound(string $message = 'Data not found', $data = null, array $meta = [])
  {
    return self::sendError($message, $data, 404, $meta);
  }

  public static function sendServerError(string $message = 'Server error', $data = null, array $meta = [])
  {
    return self::sendError($message, $data, 500, $meta);
  }

  public static function sendValidationError(string $message = 'Validation Error', array $errors = [], array $meta = [])
  {
    return self::sendError($message, $errors, 422, $meta);
  }

  public static function sendUnauthorized(string $message = 'Unauthorized', $data = null, array $meta = [])
  {
    return self::sendError($message, $data, 401, $meta);
  }

  public static function sendForbidden(string $message = 'Forbidden', $data = null, array $meta = [])
  {
    return self::sendError($message, $data, 403, $meta);
  }
}