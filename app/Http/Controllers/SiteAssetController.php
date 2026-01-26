<?php

namespace App\Http\Controllers;

use App\Models\HomeSetting;
use App\Models\MediaFile;
use Illuminate\Http\Request;

class SiteAssetController
{
  public function logo(Request $request)
  {
    $settings = HomeSetting::current();

    if ($settings->logo_media_id) {
      $mediaFile = MediaFile::query()->find($settings->logo_media_id);
      if ($mediaFile) {
        return $this->respondWithMediaFile($request, $mediaFile, 86400);
      }
    }

    if ($settings->logo_path) {
      $publicBaseUrl = rtrim((string) config('filesystems.disks.public.url', asset('storage')), '/');
      $url = $publicBaseUrl . '/' . ltrim($settings->logo_path, '/');

      return redirect()->away($url);
    }

    $fallbackPath = public_path('images/TextilOne.png');
    if (is_file($fallbackPath)) {
      return $this->respondWithFile($request, $fallbackPath, 86400);
    }

    abort(404);
  }

  public function favicon(Request $request)
  {
    // Use the same uploaded logo for the favicon to keep branding consistent.
    // If the logo changes, this endpoint stays stable.
    return $this->logo($request);
  }

  public function appleTouchIcon(Request $request)
  {
    return $this->logo($request);
  }

  private function respondWithMediaFile(Request $request, MediaFile $mediaFile, int $cacheSeconds)
  {
    $etag = $mediaFile->sha256 ? '"' . $mediaFile->sha256 . '"' : null;
    if ($etag && $request->headers->get('If-None-Match') === $etag) {
      return response('', 304)->header('ETag', $etag);
    }

    $headers = [
      'Content-Type' => $mediaFile->mime_type ?: 'application/octet-stream',
      'Cache-Control' => 'public, max-age=' . $cacheSeconds,
    ];

    if ($mediaFile->size) {
      $headers['Content-Length'] = (string) $mediaFile->size;
    }

    if ($etag) {
      $headers['ETag'] = $etag;
    }

    $data = $mediaFile->data;

    if (is_resource($data)) {
      return response()->stream(function () use ($data) {
        try {
          @rewind($data);
        } catch (\Throwable $e) {
          // Ignore; we'll still attempt to read.
        }

        while (!feof($data)) {
          $chunk = fread($data, 8192);
          if ($chunk === false) {
            break;
          }
          echo $chunk;
        }
      }, 200, $headers);
    }

    return response($data ?? '', 200, $headers);
  }

  private function respondWithFile(Request $request, string $path, int $cacheSeconds)
  {
    $mtime = @filemtime($path);
    $size = @filesize($path);
    $etag = ($mtime !== false && $size !== false)
      ? '"' . dechex((int) $mtime) . '-' . dechex((int) $size) . '"'
      : null;

    if ($etag && $request->headers->get('If-None-Match') === $etag) {
      return response('', 304)->header('ETag', $etag);
    }

    $headers = [
      'Cache-Control' => 'public, max-age=' . $cacheSeconds,
    ];

    if ($etag) {
      $headers['ETag'] = $etag;
    }

    return response()->file($path, $headers);
  }
}
