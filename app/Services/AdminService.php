<?php

namespace App\Services ;

use App\Models\ActivityType;
use App\Models\Admin;

class AdminService
{
  public function updateadmin(array $data , $user)
  {
    $id= $user->admin->id;
   $admin=Admin::findorfail($id);
   $admin->user->update([
    "name" => $data['name'],
   ]);
   $admin->update([
    "email"=>$data['email'],
    "password" => $data['password']
   ]);
   $admin->save();
   return $admin;

  }
}