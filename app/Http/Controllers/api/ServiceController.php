<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DynamicFieldRequest;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\DynamicField;
use App\Models\Service;
use App\Models\Slider;
use App\Services\ServiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
  protected $serviceservice ;
  public function __construct(ServiceService $serviceService)
  {
    $this->serviceservice = $serviceService;
  }


  public function getIds(Request $request)
{
  $fields = $this->serviceservice->getIds($request);

  return response()->json([
    'status' => true,
    'data' => $fields
]);


}
  public function store(StoreServiceRequest $request): JsonResponse
  {
      try {
         $user = $request->user();
          $data = $request->validated();
          $mainImage = $request->file('main_image');       // صورة رئيسية
          $additionalImages = $request->file('images');    // صور إضافية

          $service = $this->serviceservice->store($data, $mainImage, $additionalImages , $user);
          if ($service === 'not_allowed') {
            return response()->json([
                'status' => false,
                'message' =>__('messages.servicemessage1')
            ], 403);
        }
        if ($service === 'not_allowed_add') {
          return response()->json([
              'status' => false,
              'message' => __('messages.accountpendding')
          ], 403);
      }
        if ($service === 'missing_required_field') {
          return response()->json([
              'status' => false,
              'message' => __('messages.missingfields')
          ], 403);
      }
      if ($service === 'inactive') {
        return response()->json([
            'status' => false,
            'message' => __('messages.accountinactive')
        ], 403);
    }

          return response()->json([
              'status' => true,
              'message' => __('messages.serviceadded'),
              'data' => $service
          ], 201);

      } catch (\Exception $e) {
          return response()->json([
              'status' => false,
              'message' => $e->getMessage()
          ], 500);
      }
    }

  public function viewservice()
  {
    //$services=Service::where('status','accepted')->get();
    $services = Service::where('status', 'accepted')
    ->whereHas('businessAccount', function ($q) {
        $q->where('is_active', 1);
    })
    ->get();
    return response()->json([
      'message' => __('messages.allservices') ,
      'data' => $services
  ]);  }
  public function update(UpdateServiceRequest $request, $id): JsonResponse
  {
      try {
          $user = $request->user();
          $data = $request->validated();

          $mainImage = $request->file('main_image');
          $additionalImages = $request->file('images');
          $service = $this->serviceservice->update(
              $id,
              $data,
              $mainImage,
              $additionalImages,
              $user
          );

          if ($service === 'not_allowed') {
              return response()->json([
                  'status' => false,
                  'message' => __('messages.notallowed')
              ], 403);
          }


          if ($service === 'not_found') {
              return response()->json([
                  'status' => false,
                  'message' => __('messages.servicenotfound')
              ], 404);
          }


          if ($service === 'inactive') {
            return response()->json([
                'status' => false,
                'message' => __('messages.accountinactive')
            ], 403);
        }
          return response()->json([
              'status' => true,
              'message' => __('messages.serviceupdate'),
              'data' => $service
          ]);

      } catch (\Exception $e) {
          return response()->json([
              'status' => false,
              'message' => $e->getMessage()
          ], 500);
      }
  }
  //view service
public function myacceptservice(Request $request)
{
    $user=auth()->user();
    $services=$this->serviceservice->myacceptservice($user);
    return response()->json([
      'message' => __('messages.myacceptservices') ,
      'The services ' => $services
    ]);
}
public function myrejectedservice()
{
  $user=auth()->user();
  $services=$this->serviceservice->myrejectedservice($user);
  return response()->json([
    'message' => __('messages.myrejectservices') ,
    'The services ' => $services
  ]);
}
public function mypendingservice()
{
  $user=auth()->user();
  $services=$this->serviceservice->mypendingservice($user);
  return response()->json([
    'message' => __('messages.mypendingservices') ,
    'The services ' => $services
  ]);
}
public function viewsliders()
{
  $sliders=Slider::where('is_active', 1)->latest()->get();
  return response()->json([
    'message' => __('fieldsName.slider') ,
    'data' => $sliders
  ]);
}
}