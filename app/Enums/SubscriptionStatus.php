<?php

namespace App\Enums;

enum SubscriptionStatus: int
{
    case STARTED = 0;
    case RENEWED = 1;
    case CANCELLED = 2;
}
