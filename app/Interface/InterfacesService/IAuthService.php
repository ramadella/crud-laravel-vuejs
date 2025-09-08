<?php
namespace AppInterfaceService;

use AppModel\User;

interface IAuthService{
    public function attemptLogin(array $credentials): ?string;
    public function register(array $data): User;
}