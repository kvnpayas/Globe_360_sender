<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobeAppSetting extends Model
{
    use HasFactory;

    protected $fillable = [
      'app_key',
      'app_secret',
      'shortcode_mask',
    ];
}
