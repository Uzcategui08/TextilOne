@extends('adminlte::page')

@section('title', 'Servicios')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Servicios</h1>
        <a class="btn btn-primary" href="{{ route('admin.services.create') }}">Nuevo</a>
    </div>
@stop

@section('content')
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Icono</th>
                        <th>Título</th>
                        <th>Posición</th>
                        <th>Activo</th>
                        <th style="width: 220px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td><i class="material-icons">{{ $service->icon }}</i></td>
                            <td>{{ $service->title }}</td>
                            <td>{{ $service->position }}</td>
                            <td>{{ $service->is_active ? 'Sí' : 'No' }}</td>
                            <td>
                                <a class="btn btn-sm btn-secondary" href="{{ route('admin.services.edit', $service) }}">Editar</a>
                                <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="d-inline" onsubmit="return confirm('¿Eliminar este servicio?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-4">Sin servicios</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
