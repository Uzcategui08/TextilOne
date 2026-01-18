<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeProduct extends Model
{
  protected $fillable = [
    'title',
    'subtitle',
    'image_path',
    'image_media_id',
    'image_text',
    'position',
    'is_active',
  ];

  protected $casts = [
    'is_active' => 'bool',
    'position' => 'int',
  ];

  public function imageMedia(): BelongsTo
  {
    return $this->belongsTo(MediaFile::class, 'image_media_id');
  }
}
