<?php

namespace App\Enums;


enum ApprovementStatusEnum: int
{
    case PENDING  = 1;
    case APPROVED      = 2;
    case REJECTED      = 3;
}
