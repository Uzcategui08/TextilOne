<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
      $validated['logo_path'] = $request->file('logo')->store('companies', 'public');
    }

    $validated['position'] = $validated['position'] ?? (Company::query()->max('position') + 1);
    $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

    Company::query()->create($validated);

    return redirect()->route('admin.companies.index')->with('status', 'Empresa creada.');
  }

  public function edit(Company $company)
  {
    $logoUrl = $company->logo_path ? asset('storage/' . $company->logo_path) : null;

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
      $newPath = $request->file('logo')->store('companies', 'public');

      if ($company->logo_path && Storage::disk('public')->exists($company->logo_path)) {
        Storage::disk('public')->delete($company->logo_path);
      }

      $validated['logo_path'] = $newPath;
    }

    $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

    $company->fill($validated)->save();

    return redirect()->route('admin.companies.index')->with('status', 'Empresa actualizada.');
  }

  public function destroy(Company $company)
  {
    if ($company->logo_path && Storage::disk('public')->exists($company->logo_path)) {
      Storage::disk('public')->delete($company->logo_path);
    }

    $company->delete();

    return redirect()->route('admin.companies.index')->with('status', 'Empresa eliminada.');
  }
}
