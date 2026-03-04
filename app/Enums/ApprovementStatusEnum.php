<?php

namespace App\Enums;

use App\Traits\EnumRetriever;

enum ApprovementStatusEnum: int
{
    use EnumRetriever;
    case PENDING  = 1;
    case APPROVED      = 2;
    case REJECTED      = 3;
}
