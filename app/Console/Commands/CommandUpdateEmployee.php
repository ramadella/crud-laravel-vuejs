<?php

namespace AppCommand;

use AppException\EmployeeActionException;
use AppService\ServiceEmployee;
use Exception;

class CommandUpdateEmployee
{
    public function __construct(protected ServiceEmployee $serviceEmployee)
    {
        // $this->serviceEmployee = $serviceEmployee;
    }
    public function handle(int $id, array $data)
    {
        try {
            return $this->serviceEmployee->updateEmployee($id, $data);
        } catch (Exception $e) {
            throw new EmployeeActionException($e->getMessage());
        }
    }
}
