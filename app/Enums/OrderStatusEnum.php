<?php

namespace App\Enums;

use App\Traits\EnumRetriever;

enum OrderStatusEnum: int
{
    use EnumRetriever;
    case NEW = 1;
    case WAIT_APPROVE = 2;
    case FINISHED = 3;
    case CANCELLED = 4;
}
