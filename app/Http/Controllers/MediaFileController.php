<?php

namespace App\Http\Controllers;

use App\Models\MediaFile;
use Illuminate\Http\Request;

class MediaFileController
{
  public function show(Request $request, MediaFile $mediaFile)
  {
    $etag = $mediaFile->sha256 ? '"' . $mediaFile->sha256 . '"' : null;
    if ($etag && $request->headers->get('If-None-Match') === $etag) {
      return response('', 304)->header('ETag', $etag);
    }

    $headers = [
      'Content-Type' => $mediaFile->mime_type ?: 'application/octet-stream',
      // Cache for a week (safe for public assets; updated assets get new id).
      'Cache-Control' => 'public, max-age=604800',
    ];

    if ($mediaFile->size) {
      $headers['Content-Length'] = (string) $mediaFile->size;
    }

    if ($etag) {
      $headers['ETag'] = $etag;
    }

    $data = $mediaFile->data;

    // PostgreSQL may return bytea columns as stream resources.
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
}
