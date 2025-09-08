<?php
namespace AppService;

use App\Exceptions\InvalidCredentialsException;
use AppModel\User;
use AppRepository\repositoryAuth;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class ServiceAuth{
    public function __construct(protected repositoryAuth $repository){

    }
    public function attemptLogin(array $credentials): ?string{
        $user = $this->repository->loginUser($credentials);
        if(!$user || $user->role !== $credentials['role']){
            throw new InvalidCredentialsException('Invalid credentials or role mismatch.');
        }
        $token = JWTAuth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']]);
        if(!$token){
            throw new InvalidCredentialsException('Invalid credentials.');
        }
        return $token;
    }
    public function register(array $data): User{
        try{
            return $this->repository->registerUser($data);
        }
        catch(Exception $e){
            throw new Exception("Registration failed: " . $e->getMessage());
        }
    }
}