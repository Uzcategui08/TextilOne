@extends('adminlte::page')

@section('title', 'Editar empresa')

@section('content_header')
    <h1>Editar empresa #{{ $company->id }}</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('admin.companies.update', $company) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="position">Posición</label>
                                <input id="position" type="number" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position', $company->position) }}">
                                @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group col-md-4 d-flex align-items-end">
                                <div class="custom-control custom-checkbox">
                                    <input id="is_active" type="checkbox" name="is_active" value="1" class="custom-control-input" {{ old('is_active', $company->is_active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Activo</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $company->name) }}">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="logo">Cambiar logo</label>
                            <input id="logo" type="file" name="logo" class="form-control-file @error('logo') is-invalid @enderror" accept="image/*">
                            @error('logo')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit">Guardar</button>
                        <a class="btn btn-secondary" href="{{ route('admin.companies.index') }}">Volver</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Logo actual</h3>
                    </div>
                    <div class="card-body text-center">
                        @if ($logoUrl)
                            <img src="{{ $logoUrl }}" alt="Logo" style="max-width: 100%; height: auto;">
                        @else
                            <div class="text-muted">Sin logo</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
