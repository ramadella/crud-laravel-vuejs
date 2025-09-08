<?php

namespace AppCommand;

use AppService\ServiceAuth;
use Exception;

class CommandRegisterUser{
    public function __construct(protected ServiceAuth $serviceAuth){
        // $this->serviceAuth = $serviceAuth;
    }
    public function handle(array $data){
        try{
            return $this->serviceAuth->register($data);
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}