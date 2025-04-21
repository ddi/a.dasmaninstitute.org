<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all()->toArray();
        $userRoles = DB::table('user_roles')
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->select()
            ->where('roles.id', '!=', '1000')
            ->get()
            ->toArray();
        $userRoles = array_map(function ($value) {
            return (array)$value;
        }, $userRoles);

        foreach ($users as $key => $user) {
            $roles = [];
            foreach ($userRoles as $userRole) {
                if ($userRole['user_id'] == $user['id']) {
                    $roles[] = $userRole['display_name'];
                }
            }
            //$users[$key]['roles'] = implode(', ', $roles);
            $users[$key]['roles'] = $roles;
        }
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::where('id', '!=', '1000')->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'unique:users,username'],
            'user-roles' => ['required']
        ], [
            'username.required' => 'The Username field is required.',
            'username.unique' => 'The Username already exist on the system.',
            'user-roles.required' => 'You have to select at least one role for the user.'
        ]);

        //$sql = "SELECT userId AS person_id FROM users WHERE username = '" . $request->username . "'";
        //$personId = DB::connection('hellohealth')->select($sql);
        $user = new User();
        // if ($personId) {
        //     $user->person_id = $personId[0]->person_id;
        // }
        $user->username = $request->username;
        $user->save();

        foreach ($request->get('user-roles') as $role) {
            $userRole = new UserRole();
            $userRole->user_id = $user->id;
            $userRole->role_id = $role;
            $userRole->save();
        }

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        $roles = Role::where('id', '!=', '1000')->get();
        $roles = $roles->toArray();

        $userRoles = DB::table('user_roles')
            ->select("role_id")
            ->where('user_roles.user_id', '=', $user->id)
            ->where('role_id', '!=', '1000')
            ->get()
            ->toArray();
        $userRoles = array_map(function ($value) {
            return $value->role_id;
        }, $userRoles);

        return view('admin.users.edit', compact('roles', 'user', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'user-roles' => ['required']
        ], [
            'user-roles.required' => 'You have to select at least one role for the user.'
        ]);

        $currentRoles = UserRole::where('user_id', $user->id)
            ->select('role_id')
            ->where('role_id', '!=', '1000')
            ->get()->toArray();
        $currentRoles = array_map(function ($value) {
            return $value['role_id'];
        }, $currentRoles);

        $rolesToAdd = array_diff($request->get('user-roles'), $currentRoles);
        $rolesToRemove = array_diff($currentRoles, $request->get('user-roles'));

        foreach ($rolesToAdd as $role) {
            $userRole = new UserRole();
            $userRole->user_id = $user->id;
            $userRole->role_id = $role;
            $userRole->save();
        }

        foreach ($rolesToRemove as $role) {
            UserRole::where('user_id', $user->id)
                ->where('role_id', $role)
                ->delete();
        }

        return redirect()->route('users.edit', $user->id)
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
