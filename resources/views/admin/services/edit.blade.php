@extends('adminlte::page')

@section('title', 'Editar servicio')

@section('content_header')
    <h1>Editar servicio #{{ $service->id }}</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('admin.services.update', $service) }}">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4">
                        <x-icon-picker
                            name="icon"
                            label="Icono (Material Icons)"
                            :value="old('icon', $service->icon)"
                            help="Puedes escribir para buscar o seleccionar del menú."
                        />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="position">Posición</label>
                        <input id="position" type="number" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position', $service->position) }}">
                        @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-4 d-flex align-items-end">
                        <div class="custom-control custom-checkbox">
                            <input id="is_active" type="checkbox" name="is_active" value="1" class="custom-control-input" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Activo</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="title">Título</label>
                    <input id="title" type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $service->title) }}">
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $service->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <a class="btn btn-secondary" href="{{ route('admin.services.index') }}">Volver</a>
            </div>
        </div>
    </form>
@stop
