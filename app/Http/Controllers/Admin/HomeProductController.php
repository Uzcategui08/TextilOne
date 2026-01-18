<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomeProduct;
use App\Models\MediaFile;
use Illuminate\Http\Request;

class HomeProductController
{
  public function index()
  {
    $products = HomeProduct::query()->orderBy('position')->get();

    return view('admin.products.index', compact('products'));
  }

  public function create()
  {
    return view('admin.products.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'title' => ['required', 'string', 'max:255'],
      'subtitle' => ['required', 'string', 'max:2000'],
      'image_text' => ['nullable', 'string', 'max:255'],
      'image' => ['nullable', 'file', 'image', 'max:4096'],
      'position' => ['nullable', 'integer', 'min:0'],
      'is_active' => ['nullable', 'boolean'],
    ]);

    if ($request->hasFile('image')) {
      $media = MediaFile::fromUploadedFile($request->file('image'));
      $validated['image_media_id'] = $media->id;
      $validated['image_path'] = null;
    }

    $validated['position'] = $validated['position'] ?? (HomeProduct::query()->max('position') + 1);
    $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

    HomeProduct::query()->create($validated);

    return redirect()->route('admin.products.index')->with('status', 'Producto creado.');
  }

  public function edit(HomeProduct $product)
  {
    $imageUrl = $product->image_media_id
      ? route('media.show', $product->image_media_id)
      : ($product->image_path ? asset('storage/' . $product->image_path) : null);

    return view('admin.products.edit', compact('product', 'imageUrl'));
  }

  public function update(Request $request, HomeProduct $product)
  {
    $validated = $request->validate([
      'title' => ['required', 'string', 'max:255'],
      'subtitle' => ['required', 'string', 'max:2000'],
      'image_text' => ['nullable', 'string', 'max:255'],
      'image' => ['nullable', 'file', 'image', 'max:4096'],
      'position' => ['nullable', 'integer', 'min:0'],
      'is_active' => ['nullable', 'boolean'],
    ]);

    if ($request->hasFile('image')) {
      $media = MediaFile::fromUploadedFile($request->file('image'));

      if ($product->image_media_id) {
        MediaFile::query()->whereKey($product->image_media_id)->delete();
      }

      $validated['image_media_id'] = $media->id;
      $validated['image_path'] = null;
    }

    $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

    $product->fill($validated)->save();

    return redirect()->route('admin.products.index')->with('status', 'Producto actualizado.');
  }

  public function destroy(HomeProduct $product)
  {
    if ($product->image_media_id) {
      MediaFile::query()->whereKey($product->image_media_id)->delete();
    }

    $product->delete();

    return redirect()->route('admin.products.index')->with('status', 'Producto eliminado.');
  }
}
