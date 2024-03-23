<?php

namespace App\Enums;


enum PurchaseStatus: int
{
    case PENDING = 0;
    case APPROVED = 1;
    case CANCELLED = 2;
}
