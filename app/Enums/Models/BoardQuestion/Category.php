<?php

namespace App\Enums\Models\BoardQuestion;

use App\Enums\EnumHelper;

enum Category: string
{
    use EnumHelper;

    case SLAVE = 'slave';
    case FEED = 'feed';
    case GROOMING = 'grooming';
}

