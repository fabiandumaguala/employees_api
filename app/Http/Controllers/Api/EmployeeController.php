<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use App\Models\Employee;

use App\Http\Resources\Employee as EmployeeResource;
use App\Http\Resources\EmployeeCollection;

use App\Http\Requests\Employee_Create_Request;
use App\Http\Requests\Employee_Update_Request;

class EmployeeController extends Controller
{

    /**
     * Middleware
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = Employee::search($request->get('search'))
        ->orderBy('id', 'DESC')
        ->paginate(15);

        return new EmployeeCollection($employees);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Employee_Create_Request $request)
    {
        $validated = $request->validated();
        // Retrieve a portion of the validated input data...
        $validated = $request->safe()->only(['name', 'email']);

        $employee = new Employee($request->all());
        $employee->save();

        return (new EmployeeResource($employee))
        ->response()
        ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return (new EmployeeResource($employee))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Employee_Update_Request $request, Employee $employee)
    {
        $employee->fill($request->all());
        $employee->save();

        return (new EmployeeResource($employee))
        ->response()
        ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json($employee, 204);
    }
}
