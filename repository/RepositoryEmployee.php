<?php
// RepositoryEmployee.php

namespace AppRepository;

use AppHelper\RedisHelper;
use AppInterfaceRepository\IEmployeeRepository;
use AppModel\Employee;
use Illuminate\Database\Eloquent\Collection;

class RepositoryEmployee implements IEmployeeRepository
{
    protected string $cacheAll = 'employees:all';
    protected string $cacheKeyById = 'employees:';

    public function findByName(string $name): ?Employee{
        return Employee::where('name', 'ILIKE', '%' . $name . '%')->first();
    }

    public function findById(int $id): ?Employee
    {
        $cached = RedisHelper::getCacheData($this->cacheKeyById . $id);
        $employee = $cached ? unserialize($cached) : Employee::find($id);
        if (!$cached && $employee) {
            RedisHelper::setCacheData($this->cacheKeyById . $id, serialize($employee));
            RedisHelper::expireCacheData($this->cacheKeyById . $id);
        }
        return $employee;
    }

    public function getAllForUser(int $userId): Collection{
        return Employee::where('user_id', $userId)->get();
    }
    public function getAll(): Collection
    {
        $cached = RedisHelper::getCacheData($this->cacheAll);
        $employees = $cached ? unserialize($cached) : Employee::all();
        if (!$cached && $employees) {
            RedisHelper::setCacheData($this->cacheAll, serialize($employees));
            RedisHelper::expireCacheData($this->cacheAll);
        }
        return $employees;
    }
    public function create(array $data): Employee
    {
        $employee = Employee::create($data);
        return $employee;
    }
    public function update(int $id, array $data): ?Employee
    {
        $employee = Employee::find($id);
        if ($employee) {
            $employee->update($data);
            RedisHelper::deleteCacheData($this->cacheAll);
            RedisHelper::deleteCacheData($this->cacheKeyById . $id);
        }
        return $employee;
    }
    public function delete(int $id): bool
    {
        $delete = Employee::destroy($id) > 0;
        if ($delete) {
            RedisHelper::deleteCacheData($this->cacheAll);
            RedisHelper::deleteCacheData($this->cacheKeyById . $id);
        }
        return $delete;
    }
}