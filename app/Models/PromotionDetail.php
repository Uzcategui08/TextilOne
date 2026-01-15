<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromotionDetail extends Model
{
  protected $fillable = [
    'promotion_id',
    'icon',
    'text',
    'position',
  ];

  protected $casts = [
    'position' => 'int',
  ];

  public function promotion(): BelongsTo
  {
    return $this->belongsTo(Promotion::class);
  }
}
