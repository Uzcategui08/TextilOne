<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;

class HomeSetting extends Model
{
  protected $fillable = [
    'site_title',
    'logo_path',
    'logo_media_id',
    'nav_services',
    'nav_promotions',
    'nav_contact',
    'hero_title',
    'hero_subtitle',
    'cta_text',
    'cta_url',
    'cta_dropdown_items',
    'services_title',
    'promotions_title',
    'products_title',
    'guarantee_title',
    'guarantee_text',
    'phone',
    'whatsapp_message',
    'email',
    'location',
    'copyright_text',
  ];

  protected $casts = [
    'cta_dropdown_items' => 'array',
  ];

  public static function current(): self
  {
    $instance = new self();
    if (!Schema::hasTable($instance->getTable())) {
      return $instance;
    }

    return self::query()->first() ?? self::query()->create([]);
  }

  public function logoMedia(): BelongsTo
  {
    return $this->belongsTo(MediaFile::class, 'logo_media_id');
  }
}
