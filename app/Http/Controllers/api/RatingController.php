<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RatingService;

class RatingController extends Controller
{
  protected $ratingService;

  public function __construct(RatingService $ratingService)
  {
      $this->ratingService = $ratingService;
  }

  public function store(Request $request)
  {
      $data = $request->validate([
          'order_id' => 'required|exists:orders,id',
          'rating' => 'required|integer|min:1|max:5',
          'comment' => 'nullable|string'
      ]);

      $this->ratingService->store($data);

      return response()->json([
          'message' => __('messages.ratingsend')
      ]);
  }

}