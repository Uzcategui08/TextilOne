<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
  protected $fillable = [
    'name',
    'logo_path',
    'logo_media_id',
    'position',
    'is_active',
  ];

  protected $casts = [
    'position' => 'int',
    'is_active' => 'bool',
  ];

  public function logoMedia(): BelongsTo
  {
    return $this->belongsTo(MediaFile::class, 'logo_media_id');
  }
}
