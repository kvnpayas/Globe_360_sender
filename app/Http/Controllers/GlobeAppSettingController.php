<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\GlobeAppSetting;

class GlobeAppSettingController extends Controller
{

  public function index()
  {
    $settings = GlobeAppSetting::first();
    return Inertia::render('Setting', ['settings' => $settings]);
  }

  public function create(Request $request)
  {
    // Validate input fields
    sleep(1);
    $validatedData = $request->validate([
      'appKey' => 'required',
      'appSecret' => 'required',
      'shortcodeMask' => 'required',
    ]);

    $globeSettings = GlobeAppSetting::first();
    if ($globeSettings) {
      $globeSettings->update([
        'app_key' => $validatedData['appKey'],
        'app_secret' => $validatedData['appSecret'],
        'shortcode_mask' => $validatedData['shortcodeMask'],
      ]);
    } else {
      $globeSettings = GlobeAppSetting::create([
        'app_key' => $validatedData['appKey'],
        'app_secret' => $validatedData['appSecret'],
        'shortcode_mask' => $validatedData['shortcodeMask'],
      ]);
    }

  }
}
