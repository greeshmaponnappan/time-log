<?php

namespace App\Repositories;

use App\Models\User;

class LoginRepository
{
    public function register(array $data)
    {
        return User::create($data);
    }
}
