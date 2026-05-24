<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Admin;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

  protected $roleservice;
  public function __construct(RoleService $roleService)
  {
      $this->roleservice = $roleService ;
  }
  public function index()
  {
      $roles = Role::with('permissions')->latest()->paginate(9);

      // تمريرها للـ view
      return view('admin.viewrolepermission', compact('roles'));
  }

  public function addrolepage()
  {
    $permissions=Permission::all();
    $admins=Admin::all();
    return view('admin.addrole', compact('permissions','admins'));
  }
  public function store(StoreRoleRequest $storeRoleRequest )
  {
    $this->roleservice->store($storeRoleRequest->validated());
    return redirect()->route('roles.permissions');
  }
  public function destroy(Role $role)
    {
        $this->roleservice->deleteRole($role);
        return redirect()->route('roles.permissions');
    }
  public function update(UpdateRoleRequest $updateRoleRequest , Role $role)
  {
       $this->roleservice->update($updateRoleRequest->validated(),$role);
       return redirect()->route('roles.permissions')->with('Success','Role Updated Successfully');

  }

public function  updaterole(Role $role)
{
  $permissions=Permission::all();
  $admins=Admin::all();
  return view('admin.updaterole',compact('permissions','admins','role'));
}
public function viewuser(Role $role)
{

  $users = $role->users;

  return view('admin.viewuserrole',compact('users','role'));
}


}