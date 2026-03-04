<?php

namespace App\Enums;

use App\Traits\EnumRetriever;

enum ComplaintTypesEnum: int
{
    use EnumRetriever;
    case Complaint = 1;
    case ContactUs = 2;
    case OrderComplaint = 3;
}
