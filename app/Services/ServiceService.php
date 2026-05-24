<?php

namespace App\Services ;

use App\Http\Controllers\NotificationsController;
use App\Models\BusinessAccount;
use App\Models\DynamicField;
use App\Models\DynamicFieldOption;
use App\Models\DynamicFieldValue;
use App\Models\Service;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class ServiceService
{


  public function getIds(Request $request)
{
    $categoryId = $request->category_id;
    $subCategoryId = $request->sub_category_id;

    if ($subCategoryId) {
        // ✅ فقط حقول الـ subcategory
        $fields = DynamicField::where('sub_category_id', $subCategoryId)
            ->get(['id', 'name', 'type']);
    } else {
        // ✅ فقط حقول الـ category
        $fields = DynamicField::where('category_id', $categoryId)
            ->whereNull('sub_category_id')
            ->get(['id', 'name', 'type']);
    }

    return $fields;
}
  public function store($data, $mainImage = null, $additionalImages = null , $user)
  {
      DB::beginTransaction();

      try {
        $account =BusinessAccount::where('id', $data['business_account_id'])
        ->where('normal_user_id', $user->normalUser->id)
        ->first();

         if (!$account) {
               return 'not_allowed';
         }
         if ($account->status==='pending') {
          return 'not_allowed_add';
    }
    if (!$account->is_active) {
      return 'inactive';
}

          $service = Service::create([
              'business_account_id' => $account->id,
              'category_id' => $data['category_id'],
              'sub_category_id' => $data['sub_category_id'] ?? null,
              'title_ar' => $data['title_ar'],
              'title_en' => $data['title_en'],
              'description' => [
                  'ar' => $data['description']['ar'],
                  'en' => $data['description']['en']
              ],
              'quantity' => $data['quantity'],
              'service_type' => $data['service_type'],

              'price_usd' => $data['price_usd'],
            'price_syp' => $data['price_syp'],
              'latitude' => $data['latitude'] ?? null,
              'longitude' => $data['longitude'] ?? null,
              'status' => 'pending',
          ]);

          // dynamic fields
          $dynamicFields = DynamicField::where('category_id', $service->category_id)
          ->where(function ($q) use ($service) {
              $q->whereNull('sub_category_id');

              if ($service->sub_category_id) {
                  $q->orWhere('sub_category_id', $service->sub_category_id);
              }
          })
          ->get();

          $values = $data['value'] ?? [];

          foreach ($dynamicFields as $field) {

            $key = $field->id; // بدون cast

            $value = $values[$key] ?? null;

            // 🔥 required check (بدون أي هروب)
            if ($field->is_required== 1) {
                if ($value === null || $value === '') {
                    throw new \Exception("Field {$field->id} is required");
                }
            }

            // 🔥 إذا مش موجود وما هو required → تجاهله
            if ($value === null || $value === '') {
                continue;
            }

            DynamicFieldValue::create([
                'service_id' => $service->id,
                'dynamic_field_id' => $field->id,
                'value' => $value,
            ]);
        }

          // main image
          if ($mainImage && $mainImage->isValid()) {
              $service->addMedia($mainImage)->toMediaCollection('main_image' , 'public');
          }

          // additional images
// التعامل مع additional images
if ($additionalImages) {
  // إذا وصلت صورة واحدة فقط، نحولها لـ array
  $additionalImages = is_array($additionalImages) ? $additionalImages : [$additionalImages];

  foreach ($additionalImages as $image) {
      if ($image && $image->isValid()) {
          $service->addMedia($image)->toMediaCollection('additional_images', 'public');
      }
    }
  }

          DB::commit();

 $permission = Permission::where('name', 'accept-service')
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
        'new Service',
        'new service add',
        'service',
        $service->id
      ));
      /* if ($user->device_token) {
        app(NotificationsController::class)->sendNotification($user->device_token,'service');
      } */
  }
  app(NotificationsController::class)->sendNotification($superAdmin->device_token,'service');

  return $service;
      } catch (\Exception $e) {
          DB::rollBack();
          throw $e;
      }
  }




    public function accept( $id)
{
  $service=Service::findorfail($id);
  $service->update([
    'status'=>'accepted' ]);
    $owner = $service->businessAccount->normaluser->user;
    $owner->notify(new GeneralNotification(
        'Service Approved',
        'Your service has been approved',
        'service',
        $service->id
    ));
    return  $service;

}

public function reject ($id)
{
  $service=Service::findorfail($id);
  $service->update([
    'status'=>'rejected' ]);
    $owner = $service->businessAccount->normaluser->user;
    $owner->notify(new GeneralNotification(
        'Service Rejected',
        'Your service has been Rejected',
        'service',
        $service->id
    ));
    return  $service;
}
/////////////////////


public function update($id, $data, $mainImage = null, $additionalImages = null, $user)
{
    DB::beginTransaction();

    try {

        $service = Service::where('id', $id)
            ->whereHas('businessAccount', function ($q) use ($user) {
                $q->where('normal_user_id', $user->normalUser->id);
            })
            ->first();
         if($service->businessAccount->is_active== false)
         {
            return'inactive';
         }
        if (!$service) {
            return 'not_allowed';
        }


        // 1. Update main fields
        $service->update([
           'business_account_id' => $service->business_account_id,
            'category_id' => $service->category_id,
            'sub_category_id' => $service->sub_category_id,
            'title_ar' => $data['title_ar'],
            'title_en' => $data['title_en'],
            'description' => [
                'ar' => $data['description']['ar'],
                'en' => $data['description']['en']
            ],
            'quantity' => $data['quantity'],
            'service_type' => $data['service_type'],

            'price_usd' => $data['price_usd'],
            'price_syp' => $data['price_syp'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'status' => 'pending',

        ]);

        // 2. Dynamic fields (IMPORTANT: replace not append)
        DynamicFieldValue::where('service_id', $service->id)->delete();

        $values = $data['value'] ?? [];

        $dynamicFields = DynamicField::where('category_id', $service->category_id)
            ->where(function ($q) use ($service) {
                $q->whereNull('sub_category_id')
                  ->orWhere('sub_category_id', $service->sub_category_id);
            })
            ->get();

        foreach ($dynamicFields as $field) {

            $key = $field->id;
            $value = $values[$key] ?? null;

            //required validation
            if ($field->is_required == 1 && ($value === null || $value === '')) {
                throw new \Exception("Field {$field->id} is required");
            }

            // skip optional empty values
            if ($value === null || $value === '') {
                continue;
            }

            DynamicFieldValue::create([
                'service_id' => $service->id,
                'dynamic_field_id' => $field->id,
                'value' => $value,
            ]);
        }

        // 3. Main image (replace old one)
        if ($mainImage && $mainImage->isValid()) {
            $service->clearMediaCollection('main_image');
            $service->addMedia($mainImage)->toMediaCollection('main_image', 'public');
        }

        // 4. Additional images (replace all)
        if ($additionalImages) {

            $service->clearMediaCollection('additional_images');

            $additionalImages = is_array($additionalImages)
                ? $additionalImages
                : [$additionalImages];

            foreach ($additionalImages as $image) {
                if ($image && $image->isValid()) {
                    $service->addMedia($image)
                        ->toMediaCollection('additional_images', 'public');
                }
            }
        }

        DB::commit();

        return $service;

    } catch (\Exception $e) {
        DB::rollBack();
        throw $e;
    }
}


public function myacceptservice($user)
{
  return Service::where('status', 'accepted')
  ->whereHas('businessAccount.normalUser', function ($q) use ($user) {
      $q->where('user_id', $user->id);
  })
  ->get();
}
public function myrejectedservice($user)
{
  return Service::where('status', 'rejected')
  ->whereHas('businessAccount.normalUser', function ($q) use ($user) {
      $q->where('user_id', $user->id);
  })
  ->get();
}
public function mypendingservice($user)
{
  return Service::where('status', 'pending')
  ->whereHas('businessAccount.normalUser', function ($q) use ($user) {
      $q->where('user_id', $user->id);
  })
  ->get();
}

}
