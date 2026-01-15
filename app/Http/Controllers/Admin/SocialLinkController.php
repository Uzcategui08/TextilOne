<?php

namespace App\Http\Controllers\Admin;

use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController
{
  public function index()
  {
    $socialLinks = SocialLink::query()->orderBy('position')->get();

    return view('admin.social-links.index', compact('socialLinks'));
  }

  public function create()
  {
    return view('admin.social-links.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'icon' => ['required', 'string', 'max:255'],
      'url' => ['required', 'string', 'max:2048'],
      'position' => ['nullable', 'integer', 'min:0'],
      'is_active' => ['nullable', 'boolean'],
    ]);

    $validated['position'] = $validated['position'] ?? (SocialLink::query()->max('position') + 1);
    $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

    SocialLink::query()->create($validated);

    return redirect()->route('admin.social-links.index')->with('status', 'Link creado.');
  }

  public function edit(SocialLink $socialLink)
  {
    return view('admin.social-links.edit', compact('socialLink'));
  }

  public function update(Request $request, SocialLink $socialLink)
  {
    $validated = $request->validate([
      'icon' => ['required', 'string', 'max:255'],
      'url' => ['required', 'string', 'max:2048'],
      'position' => ['nullable', 'integer', 'min:0'],
      'is_active' => ['nullable', 'boolean'],
    ]);

    $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

    $socialLink->fill($validated)->save();

    return redirect()->route('admin.social-links.index')->with('status', 'Link actualizado.');
  }

  public function destroy(SocialLink $socialLink)
  {
    $socialLink->delete();

    return redirect()->route('admin.social-links.index')->with('status', 'Link eliminado.');
  }
}
