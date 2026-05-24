<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Services\RatingService;
use Illuminate\Http\Request;

class RatingController extends Controller
{
  protected $ratingService;

  public function __construct(RatingService $ratingService)
  {
      $this->ratingService = $ratingService;
  }
  public function index()
{
    $ratings = Rating::with([ 'order.service', 'businessAccount'])
        ->latest()
        ->get();

    return view('admin.ratingsindex', compact('ratings'));
}
public function show($id)
    {
        $rating = Rating::with([
            'order.service',
            'order.businessAccount.normalUser.user',
            'businessAccount'
        ])->findOrFail($id);

        return view('admin.ratingshow', compact('rating'));
    }
}