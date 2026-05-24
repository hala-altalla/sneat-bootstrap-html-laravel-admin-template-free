<?php

namespace App\Services ;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthService
{
  public function login($data)
  {
      $admin=Admin::where('email',$data['email'])->first();
      if(!$admin)
      {
        return null;
      }
      if(Hash::check($data['password'],$admin->password))
      {
        $user= $admin;
        return   $user ;
      }
    return null;

  }

  public function logout(Request $request):void
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    }

}