<?php

namespace App\Helpers;

class PaginationFormatter
{
  public static function format($data)
  {
    return [
      'total_data' => $data->total(),
      'per_page' => $data->perPage(),
      'current_page' => $data->currentPage(),
      'last_page' => $data->lastPage(),
      'next_page' => $data->nextPageUrl(),
      'prev_page' => $data->previousPageUrl(),
      'has_more' => $data->hasMorePages(),
    ];
  }
}
