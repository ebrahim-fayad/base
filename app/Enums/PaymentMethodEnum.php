<?php

namespace App\Enums;

use App\Traits\EnumRetriever;

enum PaymentMethodEnum: int
{
    use EnumRetriever;
    case WALLET = 1;
    case ONLINE = 2;
}
