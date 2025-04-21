<?php

namespace App\Http\Controllers\GateLog;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sql = "SELECT 
                    e.id AS employee_id,
                    e.english_name,
                    e.arabic_name,
                    CONCAT(di.`name`, ' / ', d.`name`) AS division_department,
                    e.is_active
                FROM employees_new AS e
                JOIN departments AS d ON e.department_id = d.id
                JOIN divisions AS di ON d.division_id = di.id
                ORDER BY e.english_name";
        $employees = DB::connection("gatelog")->select($sql);
        return view('gatelog.employees.index', [
            'employees' => $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('gatelog.employees.edit', [
            'employee' => $employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
