<?php
// EmployeeNotFoundException.php
namespace AppException;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EmployeeNotFoundException extends Exception
{
    protected string $customMessage;
    public function __construct(string $message)
    {
        $this->customMessage = $message;
        parent::__construct($message, Response::HTTP_NOT_FOUND);
    }

    public static function sendError(string $message): JsonResponse{
        return new JsonResponse(['status' => false, 'message' => $message], Response::HTTP_NOT_FOUND);
    }

    public static function sendValidationError(array $errors): JsonResponse
    {
        return response()->json(['status' => false, 'errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
