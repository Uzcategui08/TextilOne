@extends('adminlte::page')

@section('title', 'Nueva promoción')

@section('content_header')
    <h1>Nueva promoción</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('admin.promotions.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="carousel_group">Grupo carrusel (0,1,2)</label>
                        <input id="carousel_group" type="number" name="carousel_group" class="form-control @error('carousel_group') is-invalid @enderror" value="{{ old('carousel_group', 0) }}">
                        @error('carousel_group')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="position">Posición</label>
                        <input id="position" type="number" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position') }}">
                        @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <x-icon-picker
                            name="badge_icon"
                            label="Icono badge (Material Icons)"
                            :value="old('badge_icon', 'star')"
                        />
                    </div>
                    <div class="form-group col-md-3 d-flex align-items-end">
                        <div class="custom-control custom-checkbox">
                            <input id="is_active" type="checkbox" name="is_active" value="1" class="custom-control-input" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Activo</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="title">Título</label>
                    <input id="title" type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea id="description" name="description" rows="2" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="image">Imagen (opcional)</label>
                    <input id="image" type="file" name="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                </div>

                <hr>

                <h5>Detalles (icono + texto)</h5>
                @for ($i = 0; $i < 3; $i++)
                    <div class="form-row">
                        <div class="col-md-3">
                            <x-icon-picker
                                :name="'details[' . $i . '][icon]'"
                                label="Icono"
                                :value="old('details.' . $i . '.icon')"
                                :id="'details_' . $i . '_icon'"
                                placeholder="Ej: straighten"
                            />
                        </div>
                        <div class="form-group col-md-7">
                            <label>Texto</label>
                            <input type="text" name="details[{{ $i }}][text]" class="form-control" value="{{ old('details.' . $i . '.text') }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Posición</label>
                            <input type="number" name="details[{{ $i }}][position]" class="form-control" value="{{ old('details.' . $i . '.position', $i) }}">
                        </div>
                    </div>
                @endfor
            </div>

            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Crear</button>
                <a class="btn btn-secondary" href="{{ route('admin.promotions.index') }}">Cancelar</a>
            </div>
        </div>
    </form>
@stop
