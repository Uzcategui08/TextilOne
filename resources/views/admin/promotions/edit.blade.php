@extends('adminlte::page')

@section('title', 'Editar promoción')

@section('content_header')
    <h1>Editar promoción #{{ $promotion->id }}</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('admin.promotions.update', $promotion) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @php
            $details = $promotion->details->values();
            $rows = max(3, $details->count() + 1);
        @endphp

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="carousel_group">Grupo carrusel (0,1,2)</label>
                                <input id="carousel_group" type="number" name="carousel_group" class="form-control @error('carousel_group') is-invalid @enderror" value="{{ old('carousel_group', $promotion->carousel_group) }}">
                                @error('carousel_group')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="position">Posición</label>
                                <input id="position" type="number" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position', $promotion->position) }}">
                                @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3">
                                <x-icon-picker
                                    name="badge_icon"
                                    label="Icono badge (Material Icons)"
                                    :value="old('badge_icon', $promotion->badge_icon)"
                                />
                            </div>
                            <div class="form-group col-md-3 d-flex align-items-end">
                                <div class="custom-control custom-checkbox">
                                    <input id="is_active" type="checkbox" name="is_active" value="1" class="custom-control-input" {{ old('is_active', $promotion->is_active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Activo</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title">Título (opcional)</label>
                            <input id="title" type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $promotion->title) }}">
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="form-text text-muted">Puedes dejar el título en blanco si no aplica. Si marcas la opción de abajo, se copiará este título a todas las promociones del mismo grupo carrusel.</small>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input id="apply_title_to_group" type="checkbox" name="apply_title_to_group" value="1" class="custom-control-input" {{ old('apply_title_to_group') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="apply_title_to_group">Aplicar este título a todas las promociones del mismo grupo carrusel</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea id="description" name="description" rows="2" class="form-control @error('description') is-invalid @enderror">{{ old('description', $promotion->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Cambiar imagen (opcional)</label>
                            <input id="image" type="file" name="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/*">
                            @error('image')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <hr>

                        <h5>Detalles (icono + texto)</h5>
                        @for ($i = 0; $i < $rows; $i++)
                            @php
                                $d = $details->get($i);
                            @endphp
                            <div class="form-row">
                                <div class="col-md-3">
                                    <input type="hidden" name="details[{{ $i }}][id]" value="{{ $d?->id }}">
                                    <x-icon-picker
                                        :name="'details[' . $i . '][icon]'"
                                        label="Icono"
                                        :value="old('details.' . $i . '.icon', $d?->icon)"
                                        :id="'details_' . $i . '_icon'"
                                    />
                                </div>
                                <div class="form-group col-md-7">
                                    <label>Texto</label>
                                    <input type="text" name="details[{{ $i }}][text]" class="form-control" value="{{ old('details.' . $i . '.text', $d?->text) }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Posición</label>
                                    <input type="number" name="details[{{ $i }}][position]" class="form-control" value="{{ old('details.' . $i . '.position', $d?->position ?? $i) }}">
                                </div>
                            </div>
                        @endfor
                    </div>

                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit">Guardar</button>
                        <a class="btn btn-secondary" href="{{ route('admin.promotions.index') }}">Volver</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Imagen actual</h3>
                    </div>
                    <div class="card-body text-center">
                        @if ($imageUrl)
                            <img src="{{ $imageUrl }}" alt="Imagen" style="max-width: 100%; height: auto;">
                        @else
                            <div class="text-muted">Sin imagen</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
