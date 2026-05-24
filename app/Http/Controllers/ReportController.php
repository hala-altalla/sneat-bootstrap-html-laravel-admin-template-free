<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
  protected $reportService;

  public function __construct(ReportService $reportService)
  {
      $this->reportService = $reportService;
  }

  public function index()
  {
      $reports = $this->reportService->getAll();

      return view('admin.reportindex', compact('reports'));
  }

  public function update($id, Request $request)
  {
      $request->validate([
          'status' => 'required|in:accepted,rejected'
      ]);

      $this->reportService->updateStatus($id, $request->status);

    //  return back()->with('success', 'Report updated');
    return redirect()->route('admin.reports.index');
  }
}