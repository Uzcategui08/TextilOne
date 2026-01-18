<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomeSetting;
use App\Models\MediaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeSettingsController
{
  public function edit()
  {
    $settings = HomeSetting::current();

    $publicBaseUrl = rtrim((string) config('filesystems.disks.public.url', asset('storage')), '/');

    $logoUrl = $settings->logo_media_id
      ? route('media.show', $settings->logo_media_id)
      : ($settings->logo_path
        ? $publicBaseUrl . '/' . ltrim($settings->logo_path, '/')
        : asset('images/TextilOne.png'));

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

    if (!$logoFile && str_contains((string) $request->header('content-type'), 'multipart/form-data')) {
      logger()->warning('HomeSettings update received multipart request without logo file', [
        'request_id' => $requestId,
        'all_files_keys' => array_keys($request->allFiles()),
      ]);
    }

    if ($logoFile && !$logoFile->isValid()) {
      return back()
        ->withErrors(['logo' => 'No se pudo subir el archivo. Verifica el tamaño máximo permitido por el servidor y vuelve a intentar.'])
        ->withInput();
    }

    try {
      if ($logoFile) {
        $media = MediaFile::fromUploadedFile($logoFile);

        if ($settings->logo_media_id) {
          MediaFile::query()->whereKey($settings->logo_media_id)->delete();
        }

        // Keep old path as fallback, but new uploads will live in DB.
        $validated['logo_media_id'] = $media->id;
        $validated['logo_path'] = null;

        logger()->info('HomeSettings logo stored', [
          'request_id' => $requestId,
          'media_id' => $media->id,
        ]);
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
