<?php
namespace AppCommand;

use AppService\ServiceAuth;
use Exception;

class CommandLoginUser{
    public function __construct(protected ServiceAuth $serviceAuth){
        // $this->serviceAuth = $serviceAuth;
    }
    public function handle(array $credentials){
        try{
            return $this->serviceAuth->attemptLogin($credentials);
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}