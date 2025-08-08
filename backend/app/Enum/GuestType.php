<?php

namespace App\Enum;

enum GuestType: string
{
  case VISITOR = 'visitor';
  case ALUMNI = 'alumni';
  case PARENT = 'parent';
  case COMPANY = 'company';
}