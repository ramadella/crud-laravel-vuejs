<?php
namespace AppRepository;

use AppInterfaceRepository\IAuthRepository;
use AppModel\User;

class repositoryAuth implements IAuthRepository{
    public function loginUser(array $credentials): User{
        return User::where('email', $credentials['email'])->first();
    }
    public function registerUser(array $data): User{
        return User::create($data);
    }
}