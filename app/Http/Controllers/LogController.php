<?php

namespace App\Http\Controllers;

use App\Models\LogsGlobeSms;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
  public function index()
  {
    $oneHourAgo = Carbon::now()->subHour();
    $logs = LogsGlobeSms::orderBy('created_at', 'desc')->take(30)->get();
    return response()->json(['logs' => $logs]);
  }
}
