<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityTypeRequest;
use App\Http\Requests\UpdateActivityTypeRequest;
use App\Models\ActivityType;
use App\Services\ActivityService;
use Illuminate\Http\Request;

class ActivityTypeController extends Controller
{
   protected $activityservice;
   public function __construct(ActivityService $activityService)
   {
    $this->activityservice=$activityService;

   }
   public function pageactivitytype()
   {
    $activityTypes = ActivityType::latest()->get();
    return view('admin.addactivitytypes', compact('activityTypes'));
   }
   public function store(StoreActivityTypeRequest $storeActivityTypeRequest)
   {
        $this->activityservice->store($storeActivityTypeRequest->validated());
        return redirect()->back();
   }

   public function update(UpdateActivityTypeRequest $updateActivityTypeRequest , $id)
   {
    $this->activityservice->update($updateActivityTypeRequest->validated() , $id);
    return redirect()->back();
   }
   public function delete($id)
   {
    $result =$this->activityservice->delete($id);
    if (!$result) {
      return back()->with('error',__('messages.faileddeleteactivite'));
  }

  return back()->with('success', __('messages.successdeleteactivity'));
}   }