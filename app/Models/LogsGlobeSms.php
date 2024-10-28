<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogsGlobeSms extends Model
{
    use HasFactory;

    protected $fillable = [
      'code',
      'number',
      'message',
      'status',
    ];
}
