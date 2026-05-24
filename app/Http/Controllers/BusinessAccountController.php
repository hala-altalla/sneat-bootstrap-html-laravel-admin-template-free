<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCityRequest;
use App\Models\BusinessAccount;
use App\Models\City;
use App\Services\BusinessAccountService;
use Illuminate\Http\Request;

class BusinessAccountController extends Controller
{
   protected $businessaccountservice;
   public function __construct(BusinessAccountService $businessaccountservice)
   {
       $this->businessaccountservice=$businessaccountservice;
   }

   //cities
   public function  viewcities ()

    {
      $cities=City::all();
      return view('admin.viewcities',compact('cities'));
     }
public function addcitypage()
{
  $cities=City::latest()->get();
  return view('admin.addcity',compact('cities'));
  }
public function addcity(StoreCityRequest $storeCityRequest)
{
    $this->businessaccountservice->addcity($storeCityRequest->validated());
    return redirect()->route('page.addcity');
}

//view business account and accept or reject the account
 public function check()
 {
  $accounts= BusinessAccount::latest()->paginate(5);
  return view('admin.checkbusinessaccount',compact('accounts'));
 }


 public function view(BusinessAccount $account)
{
    return view('admin.businessaccount', compact('account'));
}

public function accept($account)
{
    $this->businessaccountservice->accept($account);
    return redirect()->back();
}

public function reject($account)
{
    $this->businessaccountservice->reject($account);
    return redirect()->back();
}


public function businesscity(City $city)
{
  $businessAccounts = BusinessAccount::with(['activityType','normaluser'])->where('city_id',$city->id)->get();
  return view('admin.viewcityaccount',compact('businessAccounts','city'));
}

public function deleteBusiness($id)
{
    $deleted = $this->businessaccountservice->deleteBusiness($id);

    if (!$deleted) {
        return back()->with('error',__('messages.faielddeletebusinessacc'));
    }

    return back()->with('success', __('messages.successdeletebusinessacc'));
}
public function deletecity($id)
{
  $deleted=$this->businessaccountservice->deletecity($id);
  if($deleted == 'business')
  {
    return back()->with('error',__('messages.faielddeletecity'));

  }
  return back()->with('success', __('messages.successdeletecity'));

}
public function toggle($id)
{
    $account = BusinessAccount::findOrFail($id);

    $account->is_active = !$account->is_active;
    $account->save();

    return back()->with('success', 'Status updated');
}
public function pageeditcity($id)
{
  $city=City::findorfail($id);
  return view('admin.editcity' , compact('city'));

}
public function updatecity($id , StoreCityRequest $storeCityRequest)
{
  $this->businessaccountservice->updatecity($storeCityRequest->validated() , $id);
  return redirect()->route('page.addcity');
}
}
