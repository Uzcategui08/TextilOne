<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class HomeSetting extends Model
{
  protected $fillable = [
    'site_title',
    'logo_path',
    'nav_services',
    'nav_promotions',
    'nav_contact',
    'hero_title',
    'hero_subtitle',
    'cta_text',
    'cta_url',
    'services_title',
    'promotions_title',
    'products_title',
    'guarantee_title',
    'guarantee_text',
    'phone',
    'email',
    'location',
    'copyright_text',
  ];

  public static function current(): self
  {
    $instance = new self();
    if (!Schema::hasTable($instance->getTable())) {
      return $instance;
    }

    return self::query()->first() ?? self::query()->create([]);
  }
}
