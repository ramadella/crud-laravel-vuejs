<?php

namespace AppCommand;

use AppException\EmployeeActionException;
use AppService\ServiceEmployee;
use Exception;

class CommandCreateEmployee{
    public function __construct(protected ServiceEmployee $serviceEmployee){
        // $this->serviceEmployee = $serviceEmployee;
    }
    public function handle(array $data)
    {
        try{
            return $this->serviceEmployee->createEmployee($data);
        }
        catch(Exception $e){
            throw new EmployeeActionException($e->getMessage());
        }
    }
}
