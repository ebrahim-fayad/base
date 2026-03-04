<?php

namespace App\Enums;

use App\Traits\EnumRetriever;

enum AuthUpdatesAttributesEnum: int
{
    use EnumRetriever;
    case Phone = 1;
    case NewPhone = 2;
    case Email = 3;
    case NewEmail = 4;
    case Password = 5;
}
