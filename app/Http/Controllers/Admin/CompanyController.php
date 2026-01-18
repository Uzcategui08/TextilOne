<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\MediaFile;
use Illuminate\Http\Request;

class CompanyController
{
  public function index()
  {
    $companies = Company::query()->orderBy('position')->get();

    return view('admin.companies.index', compact('companies'));
  }

  public function create()
  {
    return view('admin.companies.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'logo' => ['nullable', 'file', 'image', 'max:4096'],
      'position' => ['nullable', 'integer', 'min:0'],
      'is_active' => ['nullable', 'boolean'],
    ]);

    if ($request->hasFile('logo')) {
      $media = MediaFile::fromUploadedFile($request->file('logo'));
      $validated['logo_media_id'] = $media->id;
      $validated['logo_path'] = null;
    }

    $validated['position'] = $validated['position'] ?? (Company::query()->max('position') + 1);
    $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

    Company::query()->create($validated);

    return redirect()->route('admin.companies.index')->with('status', 'Empresa creada.');
  }

  public function edit(Company $company)
  {
    $logoUrl = $company->logo_media_id
      ? route('media.show', $company->logo_media_id)
      : ($company->logo_path ? asset('storage/' . $company->logo_path) : null);

    return view('admin.companies.edit', compact('company', 'logoUrl'));
  }

  public function update(Request $request, Company $company)
  {
    $validated = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'logo' => ['nullable', 'file', 'image', 'max:4096'],
      'position' => ['nullable', 'integer', 'min:0'],
      'is_active' => ['nullable', 'boolean'],
    ]);

    if ($request->hasFile('logo')) {
      $media = MediaFile::fromUploadedFile($request->file('logo'));

      if ($company->logo_media_id) {
        MediaFile::query()->whereKey($company->logo_media_id)->delete();
      }

      $validated['logo_media_id'] = $media->id;
      $validated['logo_path'] = null;
    }

    $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

    $company->fill($validated)->save();

    return redirect()->route('admin.companies.index')->with('status', 'Empresa actualizada.');
  }

  public function destroy(Company $company)
  {
    if ($company->logo_media_id) {
      MediaFile::query()->whereKey($company->logo_media_id)->delete();
    }

    $company->delete();

    return redirect()->route('admin.companies.index')->with('status', 'Empresa eliminada.');
  }
}
