<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterAccountRequest;
use App\Services\ManageAccountService;

use App\Http\Requests\storeAccountRequest;
use App\Http\Requests\UpdateAdmin;
use App\Http\Requests\Updateuser;
use App\Http\Requests\UsersAccountStore;
use App\Models\Admin;
use App\Models\BusinessAccount;
use App\Models\Category;
use App\Models\City;
use App\Models\NormalUser;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Report;
use App\Models\Service;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;

class ManageAccountController extends Controller
    {
      protected $manageaccountservice;

      public function __construct(ManageAccountService $manageAccountService)
      {
          $this->manageaccountservice = $manageAccountService;
      }
//home page
public function home()
{

  $admins=Admin::all();
  $normalusers=NormalUser::all();
  $categories=Category::all();
  $accounts=BusinessAccount::all();
  $services=Service::all();
  $cities=City::all();
  $orders=Order::all();
  $sliders=Slider::all();
  $highRatings = Rating::with([
    'order.service',
    'order.businessAccount.normalUser.user',
    'order.service.businessAccount'
])
->whereIn('rating', [4, 5])
->latest()
->take(10)
->get();
$reportsLatest = Report::with([
  'order.service',
  'order.businessAccount.normalUser.user',
  'businessAccount'
])
->where('status', 'pending')
->latest()
->take(10)
->get();
$reports=Report::all();
  return view('admin.home',compact('normalusers','admins','categories','accounts','services','cities','sliders','orders' , 'highRatings', 'reportsLatest', 'reports'));
}
      public function addAccount()
      {
        $admins= Admin::latest()->get();
          return view('admin.addaccount',compact('admins'));
      }

      public function store(storeAccountRequest $request)
      {
           $this->manageaccountservice->store($request->validated());
          return redirect()->back()->with('success', 'User created successfully!');
      }
      public function viewaccount()
      {
        $admins= Admin::latest()->get();
          return view('admin.viewaccount',compact('admins'));
      }



      //add normal user page
     public function pageaddusers()
     {
      $normalusers=NormalUser::latest()->paginate(2);
      return view('admin.addusers',compact('normalusers'));
     }
     //store new normal-user
      public function addusers( RegisterAccountRequest $request)
      {
        $this->manageaccountservice->addusers($request->validated());
        return redirect()->route('add.pagenormalusers');

      }
      //search user
      public function search(Request $request)
      {
          $users = $this->manageaccountservice->search($request->search);

          return response()->json($users);
      }
//edit admin page
    public function pageeditadmin(Admin $admin)
    {
      return view('admin.editadmin',compact('admin'));
    }
    //update admin
    public function updateadmin(UpdateAdmin  $request , $idadmin)
    {
      $this->manageaccountservice->updateadmin($request->validated(),$idadmin);
      return redirect()->route('view.account');
    }
    //delete admin
    public function deleteadmin(Admin $admin)
    {
       $this->manageaccountservice->deleteadmin($admin);
       return redirect()->back();
    }
    //edit user page
    public function pageedituser($id)
    {
         $user=NormalUser::findorfail($id);
          $user->with('user')->get();
         return view('admin.edituserpage',compact('user'));
    }
    //update user
    public function updatenormaluser($id, Updateuser $request)
    {

      $this->manageaccountservice->updatenormaluser($request->all(), $id);
      return redirect()->route('add.pagenormalusers');
    }

    public function deleteuser($id)
    {
      $deleted= $this->manageaccountservice->deleteuser($id);
      if($deleted=='business')
      {
        return back()->with('error',__('messages.faielddeleteuser'));

      }

      return back()->with('success', __('messages.successdeleteuser'));
    }
  }