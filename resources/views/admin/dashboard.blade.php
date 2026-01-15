@extends('adminlte::page')

@section('title', 'Panel de Administración')

@section('content_header')
    <h1>Panel de Administración</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Bienvenido</h5>
                    <p class="card-text">
                        Desde aquí podrás administrar el contenido del sitio (promociones, imágenes y textos).
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <h6 class="card-title">Accesos rápidos</h6>
                    <ul class="mb-0">
                        <li><a href="{{ route('admin.home.edit') }}">Editar pantalla principal</a></li>
                        <li><a href="{{ route('admin.promotions.index') }}">Promociones</a></li>
                        <li><a href="{{ route('admin.services.index') }}">Servicios</a></li>
                        <li><a href="{{ route('admin.products.index') }}">Productos</a></li>
                        <li><a href="{{ route('admin.social-links.index') }}">Redes sociales</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
