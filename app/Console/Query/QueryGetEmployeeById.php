<?php

namespace AppQuery;

use AppException\EmployeeNotFoundException;
use AppService\ServiceEmployee;
use Exception;

class QueryGetEmployeeById
{
    public function __construct(protected ServiceEmployee $serviceEmployee)
    {
        // $this->serviceEmployee = $serviceEmployee;
    }

    public function execute(int $id)
    {
        try {
            return $this->serviceEmployee->getEmployeeById($id);
        } catch (Exception $e) {
            throw new EmployeeNotFoundException($e->getMessage());
        }
    }
}