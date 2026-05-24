<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
        protected $reportService;

      public function __construct(ReportService $reportService)
      {
          $this->reportService = $reportService;
      }

      // 🔥 المستخدم يعمل Report
      public function store(Request $request )
      {
        $user=auth()->user();
          $data = $request->validate([
              'order_id' => 'required|exists:orders,id',
              'business_account_id' => 'required|exists:business_accounts,id',
              'reason' => 'required|string'
          ]);

          $report = $this->reportService->store($data , $user) ;

          return response()->json([
              'message' => __('messages.reportadded') ,
              'data' => $report
          ]);
      }

    }