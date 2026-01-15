<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomeService;
use Illuminate\Http\Request;

class HomeServiceController
{
  public function index()
  {
    $services = HomeService::query()->orderBy('position')->get();

    return view('admin.services.index', compact('services'));
  }

  public function create()
  {
    return view('admin.services.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'icon' => ['required', 'string', 'max:255'],
      'title' => ['required', 'string', 'max:255'],
      'description' => ['required', 'string', 'max:2000'],
      'position' => ['nullable', 'integer', 'min:0'],
      'is_active' => ['nullable', 'boolean'],
    ]);

    $validated['position'] = $validated['position'] ?? (HomeService::query()->max('position') + 1);
    $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

    HomeService::query()->create($validated);

    return redirect()->route('admin.services.index')->with('status', 'Servicio creado.');
  }

  public function edit(HomeService $service)
  {
    return view('admin.services.edit', compact('service'));
  }

  public function update(Request $request, HomeService $service)
  {
    $validated = $request->validate([
      'icon' => ['required', 'string', 'max:255'],
      'title' => ['required', 'string', 'max:255'],
      'description' => ['required', 'string', 'max:2000'],
      'position' => ['nullable', 'integer', 'min:0'],
      'is_active' => ['nullable', 'boolean'],
    ]);

    $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

    $service->fill($validated)->save();

    return redirect()->route('admin.services.index')->with('status', 'Servicio actualizado.');
  }

  public function destroy(HomeService $service)
  {
    $service->delete();

    return redirect()->route('admin.services.index')->with('status', 'Servicio eliminado.');
  }
}
