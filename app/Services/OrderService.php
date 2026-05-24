<?php

namespace App\Services ;

use App\Models\BusinessAccount;
use App\Models\NormalUser;
use App\Models\Order;
use App\Models\Service;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\DB;

class OrderService
{
  public function store($data, $user)
  {
      DB::beginTransaction();

      try {


        $id=$data['business_account_id'];
          $service = Service::find($data['service_id']);
         /*  $account = BusinessAccount::where([
            'id' => $id,
            'normal_user_id' => $user->normalUser->id
        ])->first(); */
        $account = BusinessAccount::where([
          'id' => $id,
          'normal_user_id' => $user->normalUser->id,
          'status' => 'accepted'
      ])->first();
          if(!$account)
          {
            return 'notallowed';
          }
          if (!$service || $service->status != 'accepted') {
              return 'service_not_found';
          }
          if($service->quantity < $data['quantity'])
          {
            return 'not found' ;
          }
          if ($service->businessAccount->status != 'accepted') {
            return 'not-avilable';
        }
        if ($service->businessAccount->is_active == false) {
          return 'inactive';
      }


        $account = $data['business_account_id'];
        $normaluser=NormalUser::where('user_id',$user->id)->first();
        $businessAccount = BusinessAccount::where('id', $account)
        ->where('normal_user_id', $normaluser->id)
        ->first();

        if (!$businessAccount)
         {
        return 'no_business_account';
         }
         if ($businessAccount->status==="pending") {
            return 'no_business_account';
      }
          $order = Order::create([
              'business_account_id' => $businessAccount->id,
              'service_id' => $service->id,
              'needed_at' => $data['needed_at'],
              'quantity' => $data['quantity'],
              'details' => $data['details'],
              'status' => 'pending',
          ]);

          DB::commit();

$serviceOwner = $order->service->businessAccount->normaluser->user;

$serviceOwner->notify(new GeneralNotification(
    'New Order',
    'Someone requested your service',
    'order',
    $order->id
));
          return $order;

      } catch (\Exception $e) {
          DB::rollBack();
          throw $e;
      }
  }
  public function update( $id ,$data, $user)
{
    DB::beginTransaction();

    try {

        $order = Order::where('id', $id)
            ->whereHas('businessaccount', function ($q) use ($user) {
                $q->where('normal_user_id', $user->normalUser->id);
            })->first();

        if (!$order) {
            return 'not_allowed';
        }

        if ($order->status !== 'pending') {
            return 'cannot_update';
        }

        $order->update([

            'needed_at' => $data['needed_at'],
            'quantity' => $data['quantity'],
            'details' => $data['details'],
        ]);

        DB::commit();

        return $order;

    } catch (\Exception $e) {
        DB::rollBack();
        throw $e;
    }
}
public function sentOrders($businessAccountId,$user)
{
   $account=BusinessAccount::where('id', $businessAccountId)
        ->where('normal_user_id', $user->normalUser->id)
        ->first();

    if (!$account) {
        return 'no_business_account';
    }

    return Order::where('business_account_id', $businessAccountId)
        ->with('service')
        ->latest()
        ->get();
}

//RECEIVED ORDERS
public function receivedOrders($businessAccountId, $user)
{
    //تأكد إن الحساب إله
    $account = BusinessAccount::where('id', $businessAccountId)
        ->where('normal_user_id', $user->normalUser->id)
        ->first();

    if (!$account) {
        return 'not found this Account';
    }

    return Order::whereHas('service', function ($q) use ($businessAccountId) {
            $q->where('business_account_id', $businessAccountId);
        })
        ->with('service')
        ->latest()

        ->get();
}
public function acceptOrder($businessAccountId,$orderId, $user)
{
  $account = BusinessAccount::where('id', $businessAccountId)
  ->where('normal_user_id', $user->normalUser->id)
  ->first();
  if (!$account)
  {
    return 'no_business_account';
}
    $order = Order::where('id', $orderId)
        ->whereHas('service', function ($q) use ($businessAccountId) {
            $q->where('business_account_id', $businessAccountId);
        })->first();
      if (!$order) {
        return 'not_found';
    }

    if ($order->status !== 'pending') {
        return 'invalid_status';
    }
    $order->update([
        'status' => 'accepted' ,
    ]);
    $newquantity= $order->service->quantity -  $order->quantity ;

    $order->service->update([
      'quantity' => $newquantity
    ]);
    return $order;
}

// Reject order
public function rejectOrder($businessAccountId,$orderId, $user)
{
  $account = BusinessAccount::where('id', $businessAccountId)
  ->where('normal_user_id', $user->normalUser->id)
  ->first();
  if (!$account) {
    return 'no_business_account';
}
    $order = Order::where('id', $orderId)
        ->whereHas('service', function ($q) use ($businessAccountId) {
            $q->where('business_account_id', $businessAccountId);
        })
        ->first();

    if (!$order) {
        return 'not_found';
    }

    if ($order->status !== 'pending') {
        return 'invalid_status';
    }

    $order->update([
        'status' => 'rejected'
    ]);

    return $order;
}
public function deleteorder($id , $businessAccountId , $user)
{
  $account = BusinessAccount::where('id', $businessAccountId)
  ->where('normal_user_id', $user->normalUser->id)
  ->first();
  if (!$account) {
    return 'no_business_account';
}
  $order = Order::where('id', $id)
  ->whereHas('service', function ($q) use ($businessAccountId) {
      $q->where('business_account_id', $businessAccountId);
  })
  ->first();
  if(!$order)
  {
    return('not found');
  }
  if($order->status=='pendding')
  {
    $order->delete();
    return true;
  }
  return false;
}
}
