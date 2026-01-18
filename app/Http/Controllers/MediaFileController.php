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

    $response = response($mediaFile->data ?? '');

    $response->headers->set('Content-Type', $mediaFile->mime_type ?: 'application/octet-stream');
    if ($mediaFile->size) {
      $response->headers->set('Content-Length', (string) $mediaFile->size);
    }

    if ($etag) {
      $response->headers->set('ETag', $etag);
    }

    // Cache for a week (safe for public assets; updated assets get new id).
    $response->headers->set('Cache-Control', 'public, max-age=604800');

    return $response;
  }
}
