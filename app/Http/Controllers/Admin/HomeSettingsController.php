<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    $requestId = (string) Str::uuid();

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

    $logoFile = $request->file('logo');

    if ($logoFile && !$logoFile->isValid()) {
      return back()
        ->withErrors(['logo' => 'No se pudo subir el archivo. Verifica el tamaño máximo permitido por el servidor y vuelve a intentar.'])
        ->withInput();
    }

    try {
      if ($logoFile) {
        $newPath = $logoFile->store('home', 'public');

        if (!$newPath) {
          throw new \RuntimeException('Store returned empty path');
        }

        if ($settings->logo_path && Storage::disk('public')->exists($settings->logo_path)) {
          Storage::disk('public')->delete($settings->logo_path);
        }

        $validated['logo_path'] = $newPath;
      }

      $settings->fill($validated)->save();
    } catch (\Throwable $e) {
      logger()->error('HomeSettings update failed', [
        'request_id' => $requestId,
        'method' => $request->method(),
        'content_type' => $request->header('content-type'),
        'has_logo' => (bool) $logoFile,
        'logo' => $logoFile ? [
          'original_name' => $logoFile->getClientOriginalName(),
          'mime' => $logoFile->getClientMimeType(),
          'size' => $logoFile->getSize(),
          'error' => $logoFile->getError(),
          'is_valid' => $logoFile->isValid(),
        ] : null,
        'exception' => get_class($e),
        'message' => $e->getMessage(),
      ]);

      report($e);

      return back()
        ->withErrors(['logo' => "No se pudo guardar el logo. Código: {$requestId}"])
        ->withInput();
    }

    return redirect()
      ->route('admin.home.edit')
      ->with('status', 'Contenido actualizado.');
  }
}
