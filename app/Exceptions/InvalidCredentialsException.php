<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class InvalidCredentialsException extends Exception
{
    public function __construct(string $message){
        $this->customMessage = $message;
        parent::__construct($message, Response::HTTP_UNAUTHORIZED);
    }

    public static function sendUnAuthorized(string $message){
        return new JsonResponse(['status' => false, 'message' => $message], Response::HTTP_UNAUTHORIZED);
    }

    public static function sendForbidden(string $message){
        return new JsonResponse(['status' => false, 'message' => $message], Response::HTTP_FORBIDDEN);
    }
}
