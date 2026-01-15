<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeProduct extends Model
{
  protected $fillable = [
    'title',
    'subtitle',
    'image_path',
    'image_text',
    'position',
    'is_active',
  ];

  protected $casts = [
    'is_active' => 'bool',
    'position' => 'int',
  ];
}
