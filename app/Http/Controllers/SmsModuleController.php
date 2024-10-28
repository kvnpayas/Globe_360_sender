<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmsModuleController extends Controller
{
  public function index()
  {
    // dd(DB::connection('icss_db')->table('custservice_customer_noti_dtl_soa_presend_v2')->get());
    return Inertia::render('SmsSetting');
  }
}
