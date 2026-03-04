<?php

namespace App\Enums;

use App\Traits\EnumRetriever;

enum SettlementStatusEnum: int
{
    use EnumRetriever;
    case PENDING = 1;
    case ACCEPTED = 2;
    case REJECTED = 3;
}
