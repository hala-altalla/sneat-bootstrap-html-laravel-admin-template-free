<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreorderRequest;
use App\Http\Requests\UpdateorderRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   protected $orderservice ;
   public function __construct(OrderService $orderService)
   {
      $this->orderservice = $orderService;
   }
   public function store(StoreorderRequest $request)
    {

      $result = $this->orderservice->store($request->validated(), auth()->user());

      if ($result === 'notallowed') {
        return response()->json(['message' => __('messages.orderaccount')], 404);
    }
        if ($result === 'service_not_found') {
            return response()->json(['message' =>  __('messages.service_not_found')], 404);
        }
        if ($result ===  'not found') {
          return response()->json(['message' => __('messages.quantity')], 404);
      }
      if($result == 'not-avilable')
      {
        return response()->json(['message' => __('messages.not-avilable')]) ;
      }
      if($result == 'inactive')
      {
        return response()->json(['message' => __('messages.inactive')]) ;
      }

        return response()->json($result, 201);
    }

    public function update(UpdateorderRequest $request, $id)
    {
        $result = $this->orderservice->update($id, $request->validated(), auth()->user());
        if ($result === 'not_allowed') {
            return response()->json(['message' => __('messages.ordernotforyou')], 403);
        }

        if ($result === 'cannot_update') {
            return response()->json(['message' => __('messages.ordercannotupdate')], 400);
        }

        return response()->json($result);
    }
     //  sent
     public function sent(Request $request)
     {
         $result = $this->orderservice->sentOrders($request->business_account_id,auth()->user());

         if ($result === 'no_business_account') {
             return response()->json(['message' => __('messages.No-account')], 400);
         }

         return response()->json($result);
     }

     //  received
     public function received(Request $request)
     {
         $result = $this->orderservice->receivedOrders( $request->business_account_id ,auth()->user());

         if ($result === 'no_business_account') {
             return response()->json(['message' => __('messages.No-account')], 400);
         }

         return response()->json($result);
     }
// accept
public function accept(Request $request,$id)
{
    $result = $this->orderservice->acceptOrder($request->business_account_id,$id, auth()->user());
    if ($result === 'no_business_account') {
      return response()->json(['message' => __('messages.No-account')], 400);
  }
    if ($result === 'not_found') {
        return response()->json(['message' => __('messages.ordernotfound')], 404);
    }

    if ($result === 'invalid_status') {
        return response()->json(['message' => __('messages.notacceptorder')], 400);
    }

    return response()->json($result);
}

// reject
public function reject(Request $request,$id)
{
    $result = $this->orderservice->rejectOrder($request->business_account_id,$id, auth()->user());
    if ($result === 'no_business_account') {
      return response()->json(['message' => __('messages.No-account')], 400);
  }
    if ($result === 'not_found') {
        return response()->json(['message' => __('messages.ordernotfound')], 404);
    }

    if ($result === 'invalid_status') {
        return response()->json(['message' =>__('messages.ordernotreject')], 400);
    }


    return response()->json($result);
}
public function deleteorder(Request $request ,$id)
{

   $result= $this->orderservice->deleteorder($id , $request->business_account_id ,  auth()->user()) ;
   if ($result === 'no_business_account') {
    return response()->json(['message' => __('messages.No-account')], 400);
}

   if ($result=='not found')
   {
    return response()->json([
      'message'=>__('messages.ordernotfound')
    ]);
   }
   if($result==true)
   {
    return response()->json([
      'message'=>__('messages.deletedorder')
    ]);
   }

   return response()->json([
    'message'=>__('messages.cant_deleted')
  ]);

}
}
