<?php
// IEmployeeService.php
namespace AppInterfaceService;
use AppModel\Employee;
use Illuminate\Database\Eloquent\Collection;

interface IEmployeeService{
    public function getEmployeeById(int $id): ?Employee;
    public function getAllEmployees(): Collection;
    public function createEmployee(array $data): Employee;
    public function updateEmployee(int $id, array $data): Employee;
    public function deleteEmployee(int $id): bool;
}