@extends('adminlte::page')

@section('title', 'Promociones')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Promociones</h1>
        <a class="btn btn-primary" href="{{ route('admin.promotions.create') }}">Nueva</a>
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
                        <th>Grupo carrusel</th>
                        <th>Posición</th>
                        <th>Título</th>
                        <th>Activo</th>
                        <th style="width: 220px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($promotions as $promotion)
                        <tr>
                            <td>{{ $promotion->id }}</td>
                            <td>{{ $promotion->carousel_group }}</td>
                            <td>{{ $promotion->position }}</td>
                            <td>{{ trim((string) $promotion->title) !== '' ? $promotion->title : '—' }}</td>
                            <td>{{ $promotion->is_active ? 'Sí' : 'No' }}</td>
                            <td>
                                <a class="btn btn-sm btn-secondary" href="{{ route('admin.promotions.edit', $promotion) }}">Editar</a>
                                <form method="POST" action="{{ route('admin.promotions.destroy', $promotion) }}" class="d-inline" onsubmit="return confirm('¿Eliminar esta promoción?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-4">Sin promociones</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
