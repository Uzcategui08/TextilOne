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
    $data = file_get_contents($file->getRealPath());
    if ($data === false) {
      throw new \RuntimeException('No se pudo leer el archivo subido.');
    }

    $originalName = (string) $file->getClientOriginalName();
    $mime = (string) ($file->getClientMimeType() ?: $file->getMimeType() ?: 'application/octet-stream');
    $size = (int) ($file->getSize() ?? strlen($data));
    $sha256 = hash('sha256', $data);

    $extension = strtolower((string) $file->getClientOriginalExtension());
    $base = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));
    $base = $base !== '' ? $base : 'upload';
    $filename = $extension !== '' ? ($base . '.' . $extension) : $base;

    return self::query()->create([
      'original_name' => $originalName,
      'filename' => $filename,
      'mime_type' => $mime,
      'size' => $size,
      'sha256' => $sha256,
      'data' => $data,
    ]);
  }
}
