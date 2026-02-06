@extends('adminlte::page')

@section('title', 'Editar Home')

@section('content_header')
    <h1>Editar pantalla principal</h1>
@stop

@section('content')
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.home.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Textos</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="site_title">Título del sitio</label>
                            <input id="site_title" type="text" name="site_title" class="form-control @error('site_title') is-invalid @enderror" value="{{ old('site_title', $settings->site_title) }}">
                            @error('site_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="nav_services">Menú: Servicios</label>
                                <input id="nav_services" type="text" name="nav_services" class="form-control @error('nav_services') is-invalid @enderror" value="{{ old('nav_services', $settings->nav_services) }}">
                                @error('nav_services')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="nav_promotions">Menú: Promociones</label>
                                <input id="nav_promotions" type="text" name="nav_promotions" class="form-control @error('nav_promotions') is-invalid @enderror" value="{{ old('nav_promotions', $settings->nav_promotions) }}">
                                @error('nav_promotions')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="nav_contact">Menú: Contacto</label>
                                <input id="nav_contact" type="text" name="nav_contact" class="form-control @error('nav_contact') is-invalid @enderror" value="{{ old('nav_contact', $settings->nav_contact) }}">
                                @error('nav_contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="hero_title">Hero: Título</label>
                            <input id="hero_title" type="text" name="hero_title" class="form-control @error('hero_title') is-invalid @enderror" value="{{ old('hero_title', $settings->hero_title) }}">
                            @error('hero_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="hero_subtitle">Hero: Subtítulo</label>
                            <textarea id="hero_subtitle" name="hero_subtitle" rows="3" class="form-control @error('hero_subtitle') is-invalid @enderror">{{ old('hero_subtitle', $settings->hero_subtitle) }}</textarea>
                            @error('hero_subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="cta_text">Botón: Texto</label>
                                <input id="cta_text" type="text" name="cta_text" class="form-control @error('cta_text') is-invalid @enderror" value="{{ old('cta_text', $settings->cta_text) }}">
                                @error('cta_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cta_url">Botón: URL</label>
                                <input id="cta_url" type="text" name="cta_url" class="form-control @error('cta_url') is-invalid @enderror" value="{{ old('cta_url', $settings->cta_url) }}">
                                @error('cta_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        @php
                            $ctaDropdownLines = collect(old('cta_dropdown_items_text') !== null
                                ? preg_split("/\r\n|\r|\n/", (string) old('cta_dropdown_items_text'))
                                : (is_array($settings->cta_dropdown_items) ? $settings->cta_dropdown_items : []))
                                ->filter()
                                ->map(function ($item) {
                                    if (is_string($item)) {
                                        return $item;
                                    }

                                    $label = is_array($item) ? ($item['label'] ?? '') : '';
                                    $url = is_array($item) ? ($item['url'] ?? '') : '';

                                    return trim($label) !== '' || trim($url) !== '' ? (trim($label) . '|' . trim($url)) : null;
                                })
                                ->filter()
                                ->values()
                                ->implode("\n");
                        @endphp

                        <div class="form-group">
                            <label for="cta_dropdown_items_text">Botón: Desplegable (opcional)</label>
                            <textarea id="cta_dropdown_items_text" name="cta_dropdown_items_text" rows="4" class="form-control @error('cta_dropdown_items_text') is-invalid @enderror" placeholder="Ej: WhatsApp|https://wa.me/569XXXXXXXX\nEmail|mailto:ventas@tuempresa.cl\nLlamar|tel:+569XXXXXXXX">{{ $ctaDropdownLines }}</textarea>
                            <small class="form-text text-muted">Una opción por línea, formato: <strong>Texto|URL</strong>. Máximo 10 opciones.</small>
                            @error('cta_dropdown_items_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="services_title">Título: Servicios</label>
                                <input id="services_title" type="text" name="services_title" class="form-control @error('services_title') is-invalid @enderror" value="{{ old('services_title', $settings->services_title) }}">
                                @error('services_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="promotions_title">Título: Promociones</label>
                                <input id="promotions_title" type="text" name="promotions_title" class="form-control @error('promotions_title') is-invalid @enderror" value="{{ old('promotions_title', $settings->promotions_title) }}">
                                @error('promotions_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="products_title">Título: Productos</label>
                                <input id="products_title" type="text" name="products_title" class="form-control @error('products_title') is-invalid @enderror" value="{{ old('products_title', $settings->products_title) }}">
                                @error('products_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="guarantee_title">Garantía: Título</label>
                            <input id="guarantee_title" type="text" name="guarantee_title" class="form-control @error('guarantee_title') is-invalid @enderror" value="{{ old('guarantee_title', $settings->guarantee_title) }}">
                            @error('guarantee_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="guarantee_text">Garantía: Texto</label>
                            <textarea id="guarantee_text" name="guarantee_text" rows="3" class="form-control @error('guarantee_text') is-invalid @enderror">{{ old('guarantee_text', $settings->guarantee_text) }}</textarea>
                            @error('guarantee_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="phone">Teléfono</label>
                                <input id="phone" type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $settings->phone) }}">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group col-md-8">
                                <label for="whatsapp_message">WhatsApp: Mensaje</label>
                                <input id="whatsapp_message" type="text" name="whatsapp_message" class="form-control @error('whatsapp_message') is-invalid @enderror" value="{{ old('whatsapp_message', $settings->whatsapp_message) }}" placeholder="Ej: Hola, quisiera cotizar...">
                                @error('whatsapp_message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input id="email" type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $settings->email) }}">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="location">Ubicación</label>
                                <input id="location" type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $settings->location) }}">
                                @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="copyright_text">Copyright</label>
                            <input id="copyright_text" type="text" name="copyright_text" class="form-control @error('copyright_text') is-invalid @enderror" value="{{ old('copyright_text', $settings->copyright_text) }}">
                            @error('copyright_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Volver</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Logo</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 text-center">
                            <img id="logo_preview" src="{{ $logoUrl }}" alt="Logo" style="max-width: 100%; height: auto;">
                        </div>

                        <div class="form-group">
                            <label for="logo">Subir nuevo logo</label>
                            <div class="custom-file">
                                <input id="logo" type="file" name="logo" class="custom-file-input @error('logo') is-invalid @enderror" accept="image/*">
                                <label class="custom-file-label" for="logo" id="logo_label">Ningún archivo seleccionado</label>
                            </div>
                            @error('logo')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                            <small class="form-text text-muted">PNG/JPG/WEBP, máximo 4MB. Selecciona el archivo y luego guarda los cambios.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('logo');
            const label = document.getElementById('logo_label');
            const preview = document.getElementById('logo_preview');

            if (!input) return;

            input.addEventListener('change', function () {
                const file = input.files && input.files[0] ? input.files[0] : null;

                if (label) {
                    label.textContent = file ? file.name : 'Ningún archivo seleccionado';
                }

                if (file && preview) {
                    const objectUrl = URL.createObjectURL(file);
                    preview.src = objectUrl;
                    preview.onload = function () {
                        URL.revokeObjectURL(objectUrl);
                    };
                }
            });
        });
    </script>
@endpush
