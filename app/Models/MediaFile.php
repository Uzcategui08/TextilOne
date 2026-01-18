<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class MediaFile extends Model
{
  protected $fillable = [
    'original_name',
    'filename',
    'mime_type',
    'size',
    'sha256',
    'data',
  ];

  protected $casts = [
    'size' => 'int',
  ];

  public static function fromUploadedFile(UploadedFile $file): self
  {
    $path = $file->getRealPath();
    if (!$path) {
      throw new \RuntimeException('No se pudo leer el archivo subido (ruta temporal inválida).');
    }

    // Important for PostgreSQL (bytea): send bytes as a stream so PDO binds as LOB.
    $stream = fopen($path, 'rb');
    if ($stream === false) {
      throw new \RuntimeException('No se pudo abrir el archivo subido para lectura.');
    }

    $originalName = (string) $file->getClientOriginalName();
    $mime = (string) ($file->getClientMimeType() ?: $file->getMimeType() ?: 'application/octet-stream');
    $size = (int) ($file->getSize() ?? (is_file($path) ? filesize($path) : 0));
    $sha256 = (string) (hash_file('sha256', $path) ?: '');

    $extension = strtolower((string) $file->getClientOriginalExtension());
    $base = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));
    $base = $base !== '' ? $base : 'upload';
    $filename = $extension !== '' ? ($base . '.' . $extension) : $base;

    try {
      return self::query()->create([
        'original_name' => $originalName,
        'filename' => $filename,
        'mime_type' => $mime,
        'size' => $size,
        'sha256' => $sha256,
        'data' => $stream,
      ]);
    } finally {
      if (is_resource($stream)) {
        fclose($stream);
      }
    }
  }
}
