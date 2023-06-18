<?php

namespace App\Enums\Models\User;

use App\Enums\EnumHelper;

enum UserForm: string
{
    use EnumHelper;

    case MENTI = 'menti';
    case MENTO = 'mento';
}
