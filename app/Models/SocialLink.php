<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
  protected $fillable = [
    'icon',
    'url',
    'position',
    'is_active',
  ];

  protected $casts = [
    'position' => 'int',
    'is_active' => 'bool',
  ];
}
