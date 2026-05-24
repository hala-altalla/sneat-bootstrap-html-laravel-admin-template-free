<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

  protected $serviceservice ;
  public function __construct(ServiceService $serviceService)
  {
    $this->serviceservice = $serviceService;
  }
  public function show()
  {
    $services=Service::latest()->paginate(5);
    return view('admin.service' , compact('services'));
  }
  public function view($id)
  {
    $service=Service::findorfail($id);
    return view('admin.servicedetails',compact('service'));
  }
  public function accept($id)
  {
      $this->serviceservice->accept($id);
      return redirect()->back();
  }

  public function reject($id)
  {
      $this->serviceservice->reject($id);
      return redirect()->back();
  }
  //orders
  public function indexorder()
{
    $orders = Order::with(['service', 'businessAccount.normalUser'])
        ->latest()
        ->get();

    return view('admin.vieworder', compact('orders'));
}

public function checkService($id)
{
    $service = Service::findOrFail($id);

    $hasPending = $service->orders()
        ->where('status', 'pending')
        ->exists();

    return response()->json([
        'hasPending' => $hasPending
    ]);
}

public function deleteService($id)
{
    $service = Service::findOrFail($id);

    $service->orders()->delete();

    $service->delete();

    return response()->json(['success' => true]);
}
}
