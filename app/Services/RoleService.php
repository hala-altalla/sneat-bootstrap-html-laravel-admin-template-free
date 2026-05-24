<?php

namespace App\Services ;

use App\Http\Requests\UpdateRoleRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
  public function store(array $data )
  {
    $role=Role::create([
      'name' => $data['name'],
      'guard_name' => 'web',
    ]);

    if (!empty($data['permissions'])) {

        $role->syncPermissions($data['permissions']);
      }
    if(!empty($data['users']))
    {
      foreach($data['users'] as $adminid)
      {

       $admin = Admin::find($adminid);
        $admin->user->assignRole($role);
      }

    }


    return $role;
}

public function deleteRole(Role $role)
   {

         $role->users()->detach();
         $role->permissions()->detach();
         $role->delete();
   }
   public function update(array $data, Role $role)
   {
     $role->update([
        'name'=> $data['name'],
     ]);
       $role->save();
       if(!empty($data['permissions']))
       {
        $role->syncPermissions($data['permissions']);
       }

       else
       {
        $role->syncPermissions([]);

       }
       if(!empty($data['users']))
       {
        foreach($role->users as $user)
        {
          $user->roles()->detach($role->id);
        }
        foreach($data['users'] as $adminid)
        {
          $admin = Admin::find($adminid);
          $user=$admin->user;
          $user->assignRole($role);
        }

       }
       else
       {
       foreach($role->users as $user)
        {
          $user->roles()->detach($role->id);
        }
      }


   }
  }
