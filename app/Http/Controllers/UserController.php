<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\UserResource;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class UserController extends Controller
{
    /*
    | ----------------
    |  List of users.
    | ----------------
    */
    public function index()
    {
        Gate::authorize('viewAny', User::class);

        $users = User::with(['department'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('users/UserList', [
            'users' => UserResource::collection($users),
        ]);
    }

    /*
    | ---------------------
    |  User creation form.
    | ---------------------
    */
    public function create()
    {
        Gate::authorize('create', User::class);

        $departments = Department::all();

        return Inertia::render('users/UserCreate', [
            'departments' => DepartmentResource::collection($departments)
        ]);
    }

    /*
    | ---------------------------------
    |  Store the user in the database.
    | ---------------------------------
    */
    public function store(StoreUserRequest $request)
    {
        Gate::authorize('create', User::class);

        $user = User::create($request->validated());

        switch ($user->department->code) {
            case 'PROCR':
                $role = 'procurement';
                break;
            case 'FIN':
                $role = 'accountant';
                break;
            default:
                $role = 'faculty';
                break;
        }

        $user->syncRoles($role);

        return redirect()
            ->route('users.index')
            ->with('success', "Created user '$user->name' successfully");
    }

    /*
    | -------------------------
    |  Show a particular user.
    | -------------------------
    */
    public function show(User $user)
    {
        Gate::authorize('view', $user);
    }

    /*
    | -------------------------
    |  User modification form.
    | -------------------------
    */
    public function edit(User $user)
    {
        Gate::authorize('update', $user);

        $user->load('department');
        $departments = Department::all();

        return Inertia::render('users/UserEdit', [
            'user' => UserResource::make($user),
            'departments' => DepartmentResource::collection($departments)
        ]);
    }

    /*
    | ---------------------------
    |  Update a particular user.
    | ---------------------------
    */
    public function update(UpdateUserRequest $request, User $user)
    {
        Gate::authorize('update', $user);

        $user->update($request->validated());

        switch ($user->department->code) {
            case 'PROCR':
                $role = 'procurement';
                break;
            case 'FIN':
                $role = 'accountant';
                break;
            default:
                $role = 'faculty';
                break;
        }

        $user->syncRoles($role);

        return redirect()
            ->route('users.index')
            ->with('success', "Updated  user '$user->name' successfully.");
    }

    /*
    | ----------------
    |  Delete a user.
    | ----------------
    */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);
    }
}
