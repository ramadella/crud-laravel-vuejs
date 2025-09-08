<?php
// IEmployeeRepository.php
namespace AppInterfaceRepository;

use AppModel\Employee;
use Illuminate\Database\Eloquent\Collection;

interface IEmployeeRepository
{
    public function findByName(string $name): ?Employee;
    public function findById(int $id): ?Employee;
    public function getAll(): Collection;
    public function getAllForUser(int $userId): Collection;
    public function create(array $data):Employee;
    public function update(int $id, array $data): ?Employee;
    public function delete(int $id): bool;
    
}
