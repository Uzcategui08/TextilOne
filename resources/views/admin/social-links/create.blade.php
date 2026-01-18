@extends('adminlte::page')

@section('title', 'Nuevo link')

@section('content_header')
    <h1>Nuevo link</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('admin.social-links.store') }}">
        @csrf

        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4">
                        <x-icon-picker
                            name="icon"
                            label="Icono (Material Icons o social)"
                            :value="old('icon', 'language')"
                            help="Puedes usar Material Icons (ej: language, photo_camera) o: facebook, instagram, x"
                        />
                    </div>
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
                    <label for="url">URL</label>
                    <input id="url" type="text" name="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url') }}">
                    @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Crear</button>
                <a class="btn btn-secondary" href="{{ route('admin.social-links.index') }}">Cancelar</a>
            </div>
        </div>
    </form>
@stop
