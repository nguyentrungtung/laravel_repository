<?php

namespace App\Http\Controllers\Admin\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Exception;

class RolePermissionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $roles = Role::paginate(20);

        $title = 'rolepermission';
        $subTile = '';
        return view('admin.rolepermission.index', compact('title', 'roles', 'subTile'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'rolepermission';
        $subTitle = '';
        return view('admin.rolepermission.create', compact('title', 'subTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->roleName]);
        return redirect()->route('rolepermission.index')->with('success', 'Update successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Create';
        $subTitle = '';

        $role = Role::findById($id);

        $permissions = Permission::all();

        $rolePermissions = $role->getAllPermissions();

        $rolePermissionArr= [];

        foreach ($rolePermissions as $rolePermission) {
            $rolePermissionArr[$rolePermission->id]['id'] = $rolePermission->id;
            $rolePermissionArr[$rolePermission->id]['name'] = $rolePermission->name;
            $rolePermissionArr[$rolePermission->id]['guard_name'] = $rolePermission->guard_name;
        }

        return view('admin.rolepermission.edit', compact('title', 'subTitle', 'role', 'permissions', 'rolePermissions', 'rolePermissionArr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id is role id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $role = Role::findById($id);
            $permission = $request->get('permission');
            $role->syncPermissions($permission);

        } catch (\Exception $e) {
            throw new \Exception($e);
        }

        return redirect()->route('rolepermission.index')->with('success', 'Update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findById($id);
        if (empty($role)) {
            session()->flash('error', 'Not found role.');

            return ['error' => true];
        }
        try {
            $role->delete();

            session()->flash('success', 'Destroy successfully.');

            return ['error' => false];
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
