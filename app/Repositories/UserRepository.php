<?php

namespace App\Repositories;

use App\Models\Board\BoardQuestion;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    /**
     * @param int $crt_user_sn
     * @return User|null
     */
    public function getUserByUserSn(int $crt_user_sn): ?User
    {
        $user = User::where('user_sn', $crt_user_sn)->first();

        return $user;
    }
}
