<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Models\Department;
use Inertia\Inertia;
use App\Http\Resources\DepartmentResource;
use App\Http\Requests\StoreDepartmentRequest;

class DepartmentController extends Controller
{
    /*
    | ----------------------
    |  List of departments.
    | ----------------------
    */
    public function index()
    {
        Gate::authorize('viewAny', Department::class);

        $departments = Department::with(['user'])
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('departments/DepartmentList', [
            'departments' => DepartmentResource::collection($departments)
        ]);
    }

    /*
    | ---------------------------
    |  Department creation form.
    | ---------------------------
    */
    public function create()
    {
        Gate::authorize('create', Department::class);

        return Inertia::render('departments/DepartmentCreate');
    }

    /*
    | ---------------------------------------
    |  Store the department in the database.
    | ---------------------------------------
    */
    public function store(StoreDepartmentRequest $request)
    {
        $department = Department::create($request->validated());

        return redirect()
            ->route('departments.index')
            ->with('success', "$department->name department created!");
    }

    /*
    | -------------------------------
    |  Show a particular department.
    | -------------------------------
    */
    public function show(Department $department)
    {
        Gate::authorize('view', $department);

        return Inertia::render('departments/DepartmentShow', [
            'department' => DepartmentResource::make($department)
        ]);
    }

    /*
    | -------------------------------
    |  Department modification form.
    | -------------------------------
    */
    public function edit(Department $department)
    {
        Gate::authorize('update', $department);

        $department->load(['user', 'users']);

        return Inertia::render('departments/DepartmentEdit', [
            'department' => DepartmentResource::make($department),
        ]);
    }

    /*
    | ---------------------------------
    |  Update a particular department.
    | ---------------------------------
    */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department->update($request->validated());

        return redirect()
            ->route('departments.index')
            ->with('success', "$department->name department updated!");
    }

    /*
    | ----------------------
    |  Delete a department.
    | ----------------------
    */
    public function destroy(Department $department)
    {
        Gate::authorize('delete', $department);

        $department->delete();

        return redirect()
            ->route('departments.index')
            ->with('success', "$department->name department deleted!");
    }
}
