<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use DirectoryIterator;
use App\Models\LogsGlobeSms;
use Illuminate\Http\Request;
use App\Models\GlobeAppSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class LogsGlobeSmsController extends Controller
{
  public function checkFiles(Request $request)
  {
    $folderPath = $request->path;
    // $files = File::files($folderPath);
    $filesProcessed = 0;
    $globeSettings = GlobeAppSetting::first();
    $startTime = microtime(true);
    $timeLimit = 100; // 20 seconds time limit 
    if (is_dir($folderPath)) {
      $directory = new DirectoryIterator($folderPath);
    }else{
      return response()->json(['filesProcessed' => 0, 'errorMessage' => 'Invalid path folder!']);
    }
    
    foreach ($directory as $file) {
      if ($file->isDot()) {
        continue;
      }

      if ($file->isFile()) {
        $filename = explode("_", $file->getFilename())[0]; //Get file name 

        // Check if the time limit has been reached
        if ((microtime(true) - $startTime) > $timeLimit) {
          break;
        }

        $fileContents = File::get($file->getPathname()); //Get the contents of the file
        $dataArray = explode("\n", $fileContents);
        $data['message'] = str_replace("\r", "", $dataArray[0]); // Get message
        foreach (explode(",", str_replace("\r", '', $dataArray[3])) as $number) {
          $data['numbers'][] = $number;
          $messageData = [
            'app_key' => $globeSettings->app_key,
            'app_secret' => $globeSettings->app_secret,
            'msisdn' => $number,
            'content' => $data['message'],
            'shortcode_mask' => $globeSettings->shortcode_mask,
          ];

          // Send Message using Globe APP
          $response = Http::withHeaders([
            'Accept' => 'application/json',
          ])->withoutVerifying()
            ->post('https://api.m360.com.ph/v3/api/broadcast', $messageData);

          // Check if there is error on APP settings
          if ($response->status() == 404 || (isset($response->json()['message']) && $response->json()['message'] == "The shortcode_mask is not provisioned.")) {
            if ($response->failed()) {
              Log::error('API call failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'messageData' => $messageData,
              ]);
              return response()->json(['filesProcessed' => 0, 'error' => $response->json()]);
            }
          }

          // Insert sms detail to database
          LogsGlobeSms::create([
            'code' => $filename,
            'number' => $number,
            'message' => $data['message'],
            'status' => $response->status() == 201 ? 1 : 0,
          ]);

          // Log SMS
          Log::channel('sms_log')->info($filename . ' - ', [
            'number' => $number,
            'message' => $data['message'],
            'status' => $response->status() == 201 ? 1 : 0,
            'sent_at' => now(),
          ]);
        }

        // Back up file
        $backupBasePath = storage_path('backups/' . $filename . '/' . date("m-d-Y") . '/');
        if (file_exists($backupBasePath)) {
          $batchNumber = count(scandir($backupBasePath)) - 2;
          $filesOnFolder = count(scandir($backupBasePath . 'batch' . $batchNumber)) - 2;
          if ($filesOnFolder >= 500) {
            $nxtNumber = $batchNumber + 1;
            mkdir($backupBasePath . 'batch' . $nxtNumber . '/', 0777, true);
            copy($file->getPathname(), $backupBasePath . 'batch' . $nxtNumber . '/' . $file->getFilename());
          } else {
            copy($file->getPathname(), $backupBasePath . 'batch' . $batchNumber . '/' . $file->getFilename());
          }
          // copy($file->getPathname(), $backupPath);
        } else {
          mkdir($backupBasePath . 'batch1/', 0777, true);
          copy($file->getPathname(), $backupBasePath . 'batch1/' . $file->getFilename());
        }

        File::delete($file->getPathname()); // Remove txt file from the folder
        $filesProcessed++; // count the processed

      } else {
        $filesProcessed = 0;
        return response()->json(['filesProcessed' => $filesProcessed]);
      }
    }
    $filesRemaining = File::files($folderPath);
    return response()->json(['filesProcessed' => $filesProcessed, 'count' => count($filesRemaining)]);
  }
}
