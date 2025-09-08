<?php

namespace AppCommand;

use AppException\EmployeeActionException;
use AppService\ServiceEmployee;
use Exception;

class CommandDeleteEmployee{
    public function __construct(protected ServiceEmployee $serviceEmployee){
        // $this->serviceEmployee = $serviceEmployee;
    }
    public function handle(int $id): bool
    {
        try{
            return $this->serviceEmployee->deleteEmployee($id);
        }
        catch(Exception $e){
            throw new EmployeeActionException($e->getMessage());
        }
    }
}
