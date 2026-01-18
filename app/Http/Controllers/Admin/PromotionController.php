<?php

namespace App\Http\Controllers\Admin;

use App\Models\MediaFile;
use App\Models\Promotion;
use App\Models\PromotionDetail;
use Illuminate\Http\Request;

class PromotionController
{
  public function index()
  {
    $promotions = Promotion::query()
      ->orderBy('carousel_group')
      ->orderBy('position')
      ->get();

    return view('admin.promotions.index', compact('promotions'));
  }

  public function create()
  {
    return view('admin.promotions.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'carousel_group' => ['required', 'integer', 'min:0'],
      'position' => ['nullable', 'integer', 'min:0'],
      'is_active' => ['nullable', 'boolean'],
      'title' => ['nullable', 'string', 'max:255'],
      'description' => ['required', 'string', 'max:2000'],
      'badge_icon' => ['nullable', 'string', 'max:255'],
      'image' => ['nullable', 'file', 'image', 'max:4096'],
      'apply_title_to_group' => ['nullable', 'boolean'],
      'details' => ['nullable', 'array'],
      'details.*.icon' => ['nullable', 'string', 'max:255'],
      'details.*.text' => ['nullable', 'string', 'max:255'],
      'details.*.position' => ['nullable', 'integer', 'min:0'],
    ]);

    $validated['title'] = trim((string) ($validated['title'] ?? ''));

    if ($request->hasFile('image')) {
      $media = MediaFile::fromUploadedFile($request->file('image'));
      $validated['image_media_id'] = $media->id;
      $validated['image_path'] = null;
    }

    $validated['position'] = $validated['position'] ?? (Promotion::query()
      ->where('carousel_group', $validated['carousel_group'])
      ->max('position') + 1);
    $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

    $applyTitleToGroup = (bool) ($validated['apply_title_to_group'] ?? false);
    unset($validated['apply_title_to_group']);

    $promotion = Promotion::query()->create($validated);

    if ($applyTitleToGroup) {
      Promotion::query()
        ->where('carousel_group', $promotion->carousel_group)
        ->update(['title' => $promotion->title]);
    }

    $details = $validated['details'] ?? [];
    foreach ($details as $detail) {
      $icon = trim((string) ($detail['icon'] ?? ''));
      $text = trim((string) ($detail['text'] ?? ''));
      if ($icon === '' && $text === '') {
        continue;
      }

      $promotion->details()->create([
        'icon' => $icon,
        'text' => $text,
        'position' => (int) ($detail['position'] ?? 0),
      ]);
    }

    return redirect()->route('admin.promotions.index')->with('status', 'Promoción creada.');
  }

  public function edit(Promotion $promotion)
  {
    $promotion->load('details');
    $imageUrl = $promotion->image_media_id
      ? route('media.show', $promotion->image_media_id)
      : ($promotion->image_path ? asset('storage/' . $promotion->image_path) : null);

    return view('admin.promotions.edit', compact('promotion', 'imageUrl'));
  }

  public function update(Request $request, Promotion $promotion)
  {
    $validated = $request->validate([
      'carousel_group' => ['required', 'integer', 'min:0'],
      'position' => ['nullable', 'integer', 'min:0'],
      'is_active' => ['nullable', 'boolean'],
      'title' => ['nullable', 'string', 'max:255'],
      'description' => ['required', 'string', 'max:2000'],
      'badge_icon' => ['nullable', 'string', 'max:255'],
      'image' => ['nullable', 'file', 'image', 'max:4096'],
      'apply_title_to_group' => ['nullable', 'boolean'],
      'details' => ['nullable', 'array'],
      'details.*.id' => ['nullable', 'integer'],
      'details.*.icon' => ['nullable', 'string', 'max:255'],
      'details.*.text' => ['nullable', 'string', 'max:255'],
      'details.*.position' => ['nullable', 'integer', 'min:0'],
    ]);

    $validated['title'] = trim((string) ($validated['title'] ?? ''));

    if ($request->hasFile('image')) {
      $media = MediaFile::fromUploadedFile($request->file('image'));

      if ($promotion->image_media_id) {
        MediaFile::query()->whereKey($promotion->image_media_id)->delete();
      }

      $validated['image_media_id'] = $media->id;
      $validated['image_path'] = null;
    }

    $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

    $applyTitleToGroup = (bool) ($validated['apply_title_to_group'] ?? false);
    unset($validated['apply_title_to_group']);

    $promotion->fill($validated)->save();

    if ($applyTitleToGroup) {
      Promotion::query()
        ->where('carousel_group', $promotion->carousel_group)
        ->update(['title' => $promotion->title]);
    }

    $keepIds = [];
    $details = $validated['details'] ?? [];
    foreach ($details as $detail) {
      $icon = trim((string) ($detail['icon'] ?? ''));
      $text = trim((string) ($detail['text'] ?? ''));
      if ($icon === '' && $text === '') {
        continue;
      }

      $payload = [
        'icon' => $icon,
        'text' => $text,
        'position' => (int) ($detail['position'] ?? 0),
      ];

      $id = $detail['id'] ?? null;
      if ($id) {
        $existing = $promotion->details()->whereKey($id)->first();
        if ($existing) {
          $existing->fill($payload)->save();
          $keepIds[] = $existing->id;
          continue;
        }
      }

      $created = $promotion->details()->create($payload);
      $keepIds[] = $created->id;
    }

    $promotion->details()->whereNotIn('id', $keepIds)->delete();

    return redirect()->route('admin.promotions.index')->with('status', 'Promoción actualizada.');
  }

  public function destroy(Promotion $promotion)
  {
    $promotion->load('details');
    $promotion->details()->delete();

    if ($promotion->image_media_id) {
      MediaFile::query()->whereKey($promotion->image_media_id)->delete();
    }

    $promotion->delete();

    return redirect()->route('admin.promotions.index')->with('status', 'Promoción eliminada.');
  }
}
