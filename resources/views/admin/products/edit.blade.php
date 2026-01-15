@extends('adminlte::page')

@section('title', 'Editar producto')

@section('content_header')
    <h1>Editar producto #{{ $product->id }}</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="position">Posición</label>
                                <input id="position" type="number" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position', $product->position) }}">
                                @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group col-md-4 d-flex align-items-end">
                                <div class="custom-control custom-checkbox">
                                    <input id="is_active" type="checkbox" name="is_active" value="1" class="custom-control-input" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Activo</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title">Título</label>
                            <input id="title" type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $product->title) }}">
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="subtitle">Subtítulo</label>
                            <textarea id="subtitle" name="subtitle" rows="2" class="form-control @error('subtitle') is-invalid @enderror">{{ old('subtitle', $product->subtitle) }}</textarea>
                            @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="image_text">Texto sobre imagen (fallback)</label>
                            <input id="image_text" type="text" name="image_text" class="form-control @error('image_text') is-invalid @enderror" value="{{ old('image_text', $product->image_text) }}">
                            @error('image_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Cambiar imagen</label>
                            <input id="image" type="file" name="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/*">
                            @error('image')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit">Guardar</button>
                        <a class="btn btn-secondary" href="{{ route('admin.products.index') }}">Volver</a>
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
