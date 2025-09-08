<?php
// ServiceEmployee.php
namespace AppService;
use App\Exceptions\InvalidCredentialsException;
use AppException\EmployeeActionException;
use AppException\EmployeeNotFoundException;
use AppInterfaceService\IEmployeeService;
use AppModel\Employee;
use AppRepository\RepositoryEmployee;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ServiceEmployee implements IEmployeeService
{
    public function __construct(protected RepositoryEmployee $repository)
    {
        // $this->repository = $repository;
    }
    public function getEmployeeById(int $id): ?Employee
    {
        $employee = $this->repository->findById($id);
        if (!$employee) {
            throw new EmployeeNotFoundException("Employees with id $id not found");
        }
        $user = Auth::user();
        if ($user->role === 'staff' && $employee->user_id !== $user->id) {
            throw new InvalidCredentialsException("You are not authorized to view this data.");
        }
        $employee->gaji = number_format($employee->gaji, 0, ',', '.');
        return $employee;
    }
    public function getAllEmployees(): Collection
    {
        $user = Auth::user();
        $employees = new Collection();
        if ($user->role === 'leader') {
            $employees = $this->repository->getAll();
        } else {
            $employees = $this->repository->getAllForUser($user->id);
        }
        return $employees->map(function ($item) {
            $item->gaji = number_format($item->gaji, 0, ',', '.');
            return $item;
        });
    }
    public function createEmployee(array $data): Employee
    {
        try {
            $newName = $data['name'];
            $firstName = explode(' ', $newName)[0];
            $existingEmployee = $this->repository->findByName($firstName);

            if($existingEmployee){
                $data['user_id'] = $existingEmployee->user_id;
            }
            else{
                $data['user_id'] = Auth::id();
            }
            return $this->repository->create($data);
        } catch (Exception $e) {
            throw new EmployeeActionException($e->getMessage());
        }
    }
    public function updateEmployee(int $id, array $data): Employee
    {
        try {
            return $this->repository->update($id, $data);
        } catch (Exception $e) {
            throw new EmployeeActionException($e->getMessage());
        }
    }
    public function deleteEmployee(int $id): bool
    {
        try {
            return $this->repository->delete($id);
        } catch (Exception $e) {
            throw new EmployeeActionException($e->getMessage());
        }
    }
}