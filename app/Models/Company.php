<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
  protected $fillable = [
    'name',
    'logo_path',
    'position',
    'is_active',
  ];

  protected $casts = [
    'position' => 'int',
    'is_active' => 'bool',
  ];
}
