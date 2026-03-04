<?php

namespace App\Enums;

use App\Traits\EnumRetriever;

enum ComplaintStatusEnum: int
{
  use EnumRetriever;

  case New = 1;
  case Pending = 2;
  case Finished = 3;
}

