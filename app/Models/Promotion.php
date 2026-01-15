<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promotion extends Model
{
  protected $fillable = [
    'carousel_group',
    'position',
    'is_active',
    'title',
    'description',
    'image_path',
    'badge_icon',
  ];

  protected $casts = [
    'carousel_group' => 'int',
    'position' => 'int',
    'is_active' => 'bool',
  ];

  public function details(): HasMany
  {
    return $this->hasMany(PromotionDetail::class)->orderBy('position');
  }
}
