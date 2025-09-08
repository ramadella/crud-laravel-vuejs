<?php
// helper.php
namespace AppHelper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class Helper
{
    public static function responseSuccess(array $data = null): JsonResponse
    {
        return new JsonResponse(['status' => true, 'message' => 'success', 'data' => $data], Response::HTTP_OK);
    }

    public static function responseSuccessToken(string $token){
        return new JsonResponse(['access_token' => $token, 'token_type' => 'bearer', 'expires_in' => JWTAuth::factory()->getTTL() * 60, 'user' => auth()->user()], Response::HTTP_OK);
    }
}

// 08170172011