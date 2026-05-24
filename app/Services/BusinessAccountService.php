<?php

namespace App\Services ;

use App\Http\Controllers\NotificationsController;
use App\Models\ActivityType;
use App\Models\Admin;
use App\Models\BusinessAccount;
use App\Models\City;
use App\Models\NormalUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Models\Permission as ModelsPermission;

class BusinessAccountService
{
  public function addcity(array $data)
  {
    $city = City::create([
      'name'=>[
        'ar'=>$data['name']['ar'],
        'en'=>$data['name']['en']
      ] ,
      ]);
      return $city;
  }

//
public function store(array $data , $user)
{
  DB::beginTransaction();
  try
  {
    $account = BusinessAccount::create([
      'activity_type_id' => $data['activity_id'],
      'city_id' => $data['city_id'],
      'license_number' => $data['license_number'],
      'business_name_ar' => $data['business_name_ar'],
      'business_name_en' => $data['business_name_en'],
      'description' => $data['description'],
      'latitude' => $data['latitude'],
      'longitude' => $data['longitude'],
       'status' => 'pending' ,
      'normal_user_id' => $user->normalUser->id,

    ]);
// الصورة (logo)
if (isset($data['logo'])) {
  $account->addMedia($data['logo'])
      ->toMediaCollection('logo', 'public');
}

// 🟢 الملفات (attachments)
if (isset($data['attachments'])) {

  $files = is_array($data['attachments'])
      ? $data['attachments']
      : [$data['attachments']];

  foreach ($files as $file) {
      $account->addMedia($file)
          ->toMediaCollection('attachments', 'public');
  }
}

DB::commit();

     $permission = ModelsPermission::where('name', 'accept-businessAccount')
    ->where('guard_name', 'web')
    ->first();

$adminsWithPermission = User::where('type', 'admin')
    ->whereHas('roles.permissions', function ($q) use ($permission) {
        $q->where('id', $permission->id);
    })
    ->get();
     $superAdmins = User::where('type', 'super_admin')->get();
     $superAdmin = User::where('type', 'super_admin')->first();

     $users = $adminsWithPermission->merge($superAdmins)->unique('id');
     foreach ($users as $user) {

      $user->notify(new GeneralNotification(
          'new business Account',
          'new business Account added',
          'business',
          $account->id
      ));

      // if ($user->device_token) {
      //     app(NotificationsController::class)->sendNotification($user->device_token, 'business');
      // }
              app(NotificationsController::class)->sendNotification($superAdmin->device_token, 'business');

  }
  return $account;

    }

catch (\Exception $e) {
  DB::rollBack();
  throw $e;
}
}
public function update($id, array $data, $user)
{
    DB::beginTransaction();

    try {

        $account = BusinessAccount::where('id', $id)
            ->where('normal_user_id', $user->normalUser->id)
            ->first();

        if (!$account) {
            return null;
        }
        if($account->is_active==false)
        {
          return 'inactive';
        }

        $account->update([
            'activity_type_id' => $data['activity_id'],
            'city_id' => $data['city_id'],
            'license_number' => $data['license_number'],
            'business_name_ar' => $data['business_name_ar'],
            'business_name_en' => $data['business_name_en'],
            'description' => $data['description'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'status' => 'pending',
        ]);

        // 🟢 تحديث الصورة
        if (isset($data['logo'])) {
            $account->clearMediaCollection('logo');
            $account->addMedia($data['logo'])
                ->toMediaCollection('logo', 'public');
        }

        // 🟢 تحديث الملفات
        if (isset($data['attachments'])) {

            $account->clearMediaCollection('attachments');

            $files = is_array($data['attachments'])
                ? $data['attachments']
                : $data['attachments'];

            foreach ($files as $file) {
                $account->addMedia($file)
                    ->toMediaCollection('attachments', 'public');
            }
        }

        DB::commit();

        return $account;

    } catch (\Exception $e) {
        DB::rollBack();
        throw $e;
    }
}
//
public function accept( $account)
{
  $businessaccount=BusinessAccount::findorfail($account);
  $businessaccount->update([
    'status'=>'accepted' ]);
    $user=$businessaccount->normaluser->user;
    $user->notify(new GeneralNotification(
      'Account Approved' ,
      'your Account has been Approved' ,
      'account' ,
      $businessaccount->id
    ));
    return  $businessaccount;
}

public function reject ($account)
{
  $businessaccount=BusinessAccount::findorfail($account);
  $businessaccount->update([
    'status'=>'rejected' ]);
    $user=$businessaccount->normaluser->user;
    $user->notify(new GeneralNotification(
      'Account Rejected' ,
      'your Account has been Rejected' ,
      'account' ,
      $businessaccount->id
    ));
    return  $businessaccount;
}

//
public function myacceptaccount($user)
{
  return BusinessAccount::where('status', 'accepted')
  ->whereHas('normaluser', function ($q) use ($user) {
      $q->where('user_id', $user->id);
  })
  ->get();
}
public function myrejectaccount($user)
{
  return BusinessAccount::where('status', 'rejected')
  ->whereHas('normaluser', function ($q) use ($user) {
      $q->where('user_id', $user->id);
  })
  ->get();
}

public function mypendingaccount($user)
{

return BusinessAccount::where('status', 'pending')
  ->whereHas('normaluser', function ($q) use ($user) {
      $q->where('user_id', $user->id);
  })
  ->get();

}
public function deleteBusiness($id)
{
    $business = BusinessAccount::findOrFail($id);

    //  إذا عنده خدمات
    if ($business->services()->exists()) {
        return false;
    }

    $business->delete();

    return true;
}

public function deletecity($id)
{
  $city=City::findorfail($id);
  if($city->businessAccounts()->exists())
  {
    return'business';
  }
  $city->delete();
}
public function updatecity(array $data ,$id)
{
  $city=City::findorfail($id);
  $city->update([ 'name'=>[
    'ar'=>$data['name']['ar'],
    'en'=>$data['name']['en']
  ],]);
  $city->save();
  return $city;
}
}