@extends('adminlte::page')

@section('title', 'Nueva empresa')

@section('content_header')
    <h1>Nueva empresa</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('admin.companies.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="position">Posición</label>
                        <input id="position" type="number" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position') }}">
                        @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-4 d-flex align-items-end">
                        <div class="custom-control custom-checkbox">
                            <input id="is_active" type="checkbox" name="is_active" value="1" class="custom-control-input" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Activo</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="logo">Logo (imagen)</label>
                    <input id="logo" type="file" name="logo" class="form-control-file @error('logo') is-invalid @enderror" accept="image/*">
                    @error('logo')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                    <small class="text-muted d-block mt-2">Recomendado: PNG/SVG, fondo transparente, alto ~60px.</small>
                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Crear</button>
                <a class="btn btn-secondary" href="{{ route('admin.companies.index') }}">Cancelar</a>
            </div>
        </div>
    </form>
@stop
