<?php

namespace App\Http\Controllers;

use App\Models\BusinessAccount;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceRatingController extends Controller
{
    public function index(Request $request)
    {
        $businessAccounts = BusinessAccount::all();

        $services = Service::with(['businessAccount', 'orders.rating'])
            ->when($request->business_account_id, function ($q) use ($request) {
                $q->where('business_account_id', $request->business_account_id);
            })
            ->get();

        return view('admin.services_ratingsindex', compact(
            'services',
            'businessAccounts'
        ));
    }

    //  صفحة الرسم البياني (تطور التقييم)
    public function show($id)
    {
        $service = Service::findOrFail($id);

        $ratings = DB::table('ratings')
            ->join('orders', 'ratings.order_id', '=', 'orders.id')
            ->where('orders.service_id', $id)
            ->selectRaw('DATE(ratings.created_at) as date, AVG(ratings.rating) as avg_rating')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $ratings->pluck('date');
        $data = $ratings->pluck('avg_rating');
         // ⭐ المتوسط العام
        $average = DB::table('ratings')
            ->join('orders', 'ratings.order_id', '=', 'orders.id')
            ->where('orders.service_id', $id)
            ->avg('ratings.rating');
        return view('admin.services_ratingsshow', compact(
            'service',
            'labels',
            'data' ,
            'average'
        ));
    }

}