<?php

namespace App\Enums;

use App\Traits\EnumRetriever;

enum DailyStatusEnum: int
{
    use EnumRetriever;
    case NOT_STARTED  = 1;
    case IN_PROGRESS  = 2;
    case COMPLETED    = 3;
}
