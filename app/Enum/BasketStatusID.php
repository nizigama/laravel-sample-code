<?php

declare(strict_types=1);

namespace App\Enum;

enum BasketStatusID: int
{
    case ADDED = 1;
    case REMOVED = 2;
    case BOUGHT = 3;
}
