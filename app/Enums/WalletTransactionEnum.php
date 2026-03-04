<?php

namespace App\Enums;

use App\Traits\EnumRetriever;

enum WalletTransactionEnum: int
{
    use EnumRetriever;

    case  CHARGE = 0;
    case  DEBT = 1;
    case  PAY_ORDER = 2;
}
