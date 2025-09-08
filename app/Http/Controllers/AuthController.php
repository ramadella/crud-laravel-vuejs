<?php
// AuthController.php
namespace AppController;

use App\Exceptions\InvalidCredentialsException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use AppCommand\CommandLoginUser;
use AppCommand\CommandRegisterUser;
use AppException\EmployeeActionException;
use AppHelper\Helper;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request, CommandLoginUser $login){
        try{
            $token = $login->handle($request->validated());
            return Helper::responseSuccessToken($token);
        }
        catch(Exception $e){
            return InvalidCredentialsException::sendUnAuthorized($e->getMessage());
        }
    }

    public function register(RegisterRequest $request, CommandRegisterUser $register){
        try{
            $user = $register->handle($request->validated());
            return Helper::responseSuccess($user->toArray());
        }
        catch(Exception $e){
            return EmployeeActionException::responseError($e->getMessage());             
        }
    }

    public function logout(){
        auth()->logout();
        return Helper::responseSuccess();
    }

    public function me(){
        return Helper::responseSuccess(auth()->user()->toArray());
    }
}
