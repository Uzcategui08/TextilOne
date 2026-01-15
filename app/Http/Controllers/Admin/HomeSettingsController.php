<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSettingsController
{
  public function edit()
  {
    $settings = HomeSetting::current();

    $logoUrl = $settings->logo_path
      ? asset('storage/' . $settings->logo_path)
      : asset('images/TextilOne.png');

    return view('admin.home.edit', compact('settings', 'logoUrl'));
  }

  public function update(Request $request)
  {
    $settings = HomeSetting::current();

    $validated = $request->validate([
      'site_title' => ['nullable', 'string', 'max:255'],
      'nav_services' => ['nullable', 'string', 'max:255'],
      'nav_promotions' => ['nullable', 'string', 'max:255'],
      'nav_contact' => ['nullable', 'string', 'max:255'],
      'hero_title' => ['nullable', 'string', 'max:255'],
      'hero_subtitle' => ['nullable', 'string', 'max:2000'],
      'cta_text' => ['nullable', 'string', 'max:255'],
      'cta_url' => ['nullable', 'string', 'max:2048'],
      'services_title' => ['nullable', 'string', 'max:255'],
      'promotions_title' => ['nullable', 'string', 'max:255'],
      'products_title' => ['nullable', 'string', 'max:255'],
      'guarantee_title' => ['nullable', 'string', 'max:255'],
      'guarantee_text' => ['nullable', 'string', 'max:2000'],
      'phone' => ['nullable', 'string', 'max:255'],
      'email' => ['nullable', 'string', 'max:255'],
      'location' => ['nullable', 'string', 'max:255'],
      'copyright_text' => ['nullable', 'string', 'max:255'],
      'logo' => ['nullable', 'file', 'image', 'max:4096'],
    ]);

    if ($request->hasFile('logo')) {
      $newPath = $request->file('logo')->store('home', 'public');

      if ($settings->logo_path && Storage::disk('public')->exists($settings->logo_path)) {
        Storage::disk('public')->delete($settings->logo_path);
      }

      $validated['logo_path'] = $newPath;
    }

    $settings->fill($validated)->save();

    return redirect()
      ->route('admin.home.edit')
      ->with('status', 'Contenido actualizado.');
  }
}
