<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeService extends Model
{
  protected $fillable = [
    'icon',
    'title',
    'description',
    'position',
    'is_active',
  ];

  protected $casts = [
    'is_active' => 'bool',
    'position' => 'int',
  ];
}
