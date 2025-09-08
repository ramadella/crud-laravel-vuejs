<?php
namespace AppInterfaceRepository;

use AppModel\User;
interface IAuthRepository{
    public function loginUser(array $credentials): User;
    public function registerUser(array $data): User;
}