<?php

namespace AppQuery;

use AppException\EmployeeNotFoundException;
use AppService\ServiceEmployee;
use Exception;

class QueryGetAllEmployees
{
    public function __construct(protected ServiceEmployee $serviceEmployee)
    {
        // $this->serviceEmployee = $serviceEmployee;
    }
    public function execute()
    {
        try {
            return $this->serviceEmployee->getAllEmployees();
        } catch (Exception $e) {
            throw new EmployeeNotFoundException($e->getMessage());
        }
    }
}