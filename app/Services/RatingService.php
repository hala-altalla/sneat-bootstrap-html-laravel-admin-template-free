<?php

namespace App\Services ;

use App\Models\NormalUser;
use App\Models\Order;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingService
{
  public function store($data)
    {
        $user = Auth::user();

        $normalUser = NormalUser::where('user_id', $user->id)->first();

        if (!$normalUser) {
            abort(403, 'User not allowed');
        }

        $order = Order::where('id', $data['order_id'])
            ->whereHas('businessaccount', function ($q) use ($normalUser) {
                $q->where('normal_user_id', $normalUser->id);
            })
            ->first();

        if (!$order) {
            abort(403, 'This order is not yours');
        }

        //  لازم يكون accepted
        if ($order->status !== 'accepted') {
            abort(400, 'Order not accepted yet');
        }

        //  منع التكرار
        if ($order->rating) {
            abort(400, 'Already rated');
        }

        // إنشاء التقييم
        return Rating::create([
            'order_id' => $order->id,
            'business_account_id' => $order->business_account_id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);
    }
}