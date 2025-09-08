<?php
// EmployeeController.php
namespace AppController;

use App\Jobs\SendEmployeeMailJob;
use AppCommand\CommandCreateEmployee;
use AppCommand\CommandDeleteEmployee;
use AppCommand\CommandUpdateEmployee;
use AppException\EmployeeActionException;
use AppException\EmployeeNotFoundException;
use AppHelper\Helper;
use AppController\Controller;
use AppQuery\QueryGetAllEmployees;
use AppQuery\QueryGetEmployeeById;
use AppRequest\EmployeeStoreRequest;
use AppRequest\EmployeeUpdateRequest;
use Exception;

class EmployeeController extends Controller
{
    public function __construct(protected Helper $helper)
    {
        // $this->helper = $helper;
    }

    public function index(QueryGetAllEmployees $getAll)
    {
        try {
            $employees = $getAll->execute()->toArray();
            SendEmployeeMailJob::dispatch($employees);
            return Helper::responseSuccess($employees);
        } catch (Exception $e) {
            return EmployeeNotFoundException::sendError($e->getMessage());
        }
    }
    public function show(int $id, QueryGetEmployeeById $getById)
    {
        try {
            $employee = $getById->execute($id)->toArray();
            SendEmployeeMailJob::dispatch([$employee]);
            return Helper::responseSuccess($employee);
        } catch (Exception $e) {
            return EmployeeNotFoundException::sendError($e->getMessage());
        }
    }
    public function store(EmployeeStoreRequest $request, CommandCreateEmployee $create)
    {
        try {
            $employee = $create->handle($request->validated())->toArray();
            SendEmployeeMailJob::dispatch([$employee]);
            return Helper::responseSuccess($employee);
        } catch (Exception $e) {
            return EmployeeActionException::responseError($e->getMessage());
        }
    }
    public function update(int $id, EmployeeUpdateRequest $request, CommandUpdateEmployee $update)
    {
        try {
            $employee = $update->handle($id, $request->validated())->toArray();
            SendEmployeeMailJob::dispatch([$employee]);
            return Helper::responseSuccess($employee);
        } catch (Exception $e) {
            return EmployeeActionException::responseError($e->getMessage());
        }
    }
    public function destroy(int $id, CommandDeleteEmployee $delete)
    {
        try {
            $employee = $delete->handle($id);
            SendEmployeeMailJob::dispatch([['deleted_employee_id' => $id]]);
            return Helper::responseSuccess(['deleted' => $employee]);
        } catch (Exception $e) {
            return EmployeeActionException::responseError($e->getMessage());
        }
    }
}