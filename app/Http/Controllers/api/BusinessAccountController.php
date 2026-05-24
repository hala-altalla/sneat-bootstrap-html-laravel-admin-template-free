<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessAccountStore;
use App\Http\Requests\UpdateBusineesAccount;
use App\Models\NormalUser;
use App\Services\BusinessAccountService;
use Illuminate\Http\Request;

class BusinessAccountController extends Controller
{
  protected  $busnisseaccountservice;
  public function __construct(BusinessAccountService $businessAccountService)
  {
    $this->busnisseaccountservice=$businessAccountService;
  }

  public function store(BusinessAccountStore $request)
  {
    $user= $request->user();
    $account=$this->busnisseaccountservice->store($request->validated(), $user);
    return  response()->json([
      'message' => __('messages.businessadded'),
      'data' => $account

    ]) ;

  }
  public function update(UpdateBusineesAccount $request , $id)
{
     $user=$request->user();
     $account=$this->busnisseaccountservice->update(  $id,$request->validated() , $user);
     if(!$account)
     {
      return  response()->json([
        'message' => 'not allowed',
         'data' => $account ,
         'status' => false
      ],403) ;
     }
     if($account == 'inactive')
     {
      return  response()->json([
        'message' => __('messages.accountinactive'),
         'data' => $account ,
         'status' => false
      ]) ;
     }
     return  response()->json([
      'message' => __('messages.businessaccountupdate'),
       'data' => $account
    ]) ;}
//myaccount
public function myacceptaccount()
{
  $user=auth()->user();
  $busineesaccounts=$this->busnisseaccountservice->myacceptaccount($user);
  return response()->json(
    [
      'message' => __('messages.acceptbusinessaccount') ,
      'data' => $busineesaccounts
    ]
    );
}
public function myrejectaccount()
{
  $user=auth()->user();
  $busineesaccounts=$this->busnisseaccountservice->myrejectaccount($user);
  return response()->json(
    [
      'message' => __('messages.rejectbusinessaccount') ,
      'data' => $busineesaccounts
    ]
    );
}
public function mypendingaccount()
{
  $user=auth()->user();
  $busineesaccounts=$this->busnisseaccountservice->mypendingaccount($user);
  return response()->json(
    [
      'message' => __('messages.pendingbusinessaccount') ,
      'data' => $busineesaccounts
    ]
    );

}
}
