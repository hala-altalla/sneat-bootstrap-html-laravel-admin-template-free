<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountAdminController extends Controller
{
    //
    protected $adminservice;
    public function __construct(AdminService $adminservice)
    {
       $this->adminservice=$adminservice;
    }
    public function viewmyaccount()
    {
       $user=Auth::user();
       $id= $user->admin->id;
      $admin=Admin::findorfail($id)->load(['roles','user']);
      return view('admin.viewmyaccount',compact('admin'));
    }
    public function showupdate()
    {
       $user=Auth::user();
       $id= $user->admin->id;
      $admin=Admin::findorfail($id)->load(['roles','user']);
      return view('admin.updatemyaccount',compact('admin'));
    }
    public function updateadmin(Request $request )
    {
      $user=Auth::user();

      $this->adminservice->updateadmin($request->all(),$user);
      return redirect()->route('view.myaccount');
    }
}