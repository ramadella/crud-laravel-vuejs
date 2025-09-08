<?php
// EmployeeActionException.php
namespace AppException;

use Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class EmployeeActionException extends Exception
{
    protected string $customMessage;
    public function __construct(string $message)
    {
        $this->customMessage = $message;
        parent::__construct($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
    public static function responseError(string $message): JsonResponse
    {
        return new JsonResponse(['status' => false, 'message' => $message], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

}
