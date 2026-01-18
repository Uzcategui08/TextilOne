<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\HomeProduct;
use App\Models\HomeService;
use App\Models\HomeSetting;
use App\Models\Promotion;
use App\Models\SocialLink;
use Illuminate\Support\Facades\Schema;

class HomeController
{
  public function __invoke()
  {
    $settings = HomeSetting::current();

    $publicBaseUrl = rtrim((string) config('filesystems.disks.public.url', asset('storage')), '/');

    $logoUrl = $settings->logo_media_id
      ? route('media.show', $settings->logo_media_id)
      : ($settings->logo_path
        ? $publicBaseUrl . '/' . ltrim($settings->logo_path, '/')
        : asset('images/TextilOne.png'));

    $services = Schema::hasTable((new HomeService())->getTable())
      ? HomeService::query()->where('is_active', true)->orderBy('position')->get()
      : collect();

    $products = Schema::hasTable((new HomeProduct())->getTable())
      ? HomeProduct::query()->where('is_active', true)->orderBy('position')->get()
      : collect();

    $promotions = Schema::hasTable((new Promotion())->getTable())
      ? Promotion::query()
      ->where('is_active', true)
      ->with('details')
      ->orderBy('carousel_group')
      ->orderBy('position')
      ->get()
      ->groupBy('carousel_group')
      : collect();

    $socialLinks = Schema::hasTable((new SocialLink())->getTable())
      ? SocialLink::query()->where('is_active', true)->orderBy('position')->get()
      : collect();

    $companies = Schema::hasTable((new Company())->getTable())
      ? Company::query()->where('is_active', true)->orderBy('position')->get()
      : collect();

    return view('textilone.welcome', compact(
      'settings',
      'logoUrl',
      'services',
      'products',
      'promotions',
      'socialLinks',
      'companies'
    ));
  }
}
