<?php

 namespace App\Services ;

use App\Models\BusinessAccount;
use App\Models\NormalUser;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\GeneralNotification;
use App\Http\Controllers\NotificationsController;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Permission;

 class ReportService
 {
  public function store($data, $user)
  {
      //هات الطلب مع العلاقات كاملة
      $order = Order::with('businessaccount.normaluser.user')
          ->findOrFail($data['order_id']);

      //  تحقق أن الطلب Accepted
      if ($order->status !== 'accepted') {
          throw new \Exception(__('messages.reportmessage'));
      }

      //  تحقق ملكية البزنس أكاونت
      $normalUser = NormalUser::where('user_id', $user->id)->first();

      if (!$normalUser) {
          throw new \Exception('Normal user not found');
      }

      $businessAccount = BusinessAccount::where('id', $data['business_account_id'])
          ->where('normal_user_id', $normalUser->id)
          ->first();

      if (!$businessAccount) {
          throw new \Exception(__('messages.No-account'));
      }

      // تحقق إنو الطلب تابع لنفس البزنس أكاونت
      if ($order->business_account_id !== $businessAccount->id) {
          throw new \Exception(__('messages.notbelongs'));
      }

      //  منع التكرار (بدون user_id)
      $exists = Report::where('order_id', $order->id)
          ->where('business_account_id', $businessAccount->id)
          ->exists();

      if ($exists) {
          throw new \Exception(__('messages.reportalready'));
      }

      //  إنشاء البلاغ
     $report= Report::create([
          'order_id' => $order->id,
          'business_account_id' => $businessAccount->id,
          'reason' => $data['reason'],
          'status' => 'pending',
      ]);

    $adminsWithPermission = User::where('type', 'admin')
    ->whereHas('roles.permissions', function ($q) {
        $q->where('name', 'manage-Reports');
    })
    ->get();

$superAdmins = User::where('type', 'super_admin')->get();
$superAdmin = User::where('type', 'super_admin')->first();

// دمج + منع التكرار بشكل نهائي
$users = $adminsWithPermission
    ->concat($superAdmins)
    ->unique('id')
    ;


     foreach ($users as $recipient) {
      $recipient->notify(new GeneralNotification(
        'New Report',
        'A new report has been added',
        'report',
        $report->id
    ));

  //   if (!empty($recipient->device_token)) {
  //     app(NotificationsController::class)->sendNotification($recipient->device_token, 'report');
  // }

}
   app(NotificationsController::class)->sendNotification($superAdmin->device_token, 'report');




  }


     // Admin
     public function updateStatus($id, $status)
     {
         $report = Report::findOrFail($id);

         $report->update([
             'status' => $status
         ]);

         return $report;
     }

     public function getAll()
     {
         return Report::with(['order.service', 'businessAccount'])->latest()->get();
     }
 }