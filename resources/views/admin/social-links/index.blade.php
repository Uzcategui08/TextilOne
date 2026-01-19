@extends('adminlte::page')

@section('title', 'Redes sociales')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Redes sociales</h1>
        <a class="btn btn-primary" href="{{ route('admin.social-links.create') }}">Nuevo</a>
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
                        <th>URL</th>
                        <th>Posición</th>
                        <th>Activo</th>
                        <th style="width: 220px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($socialLinks as $socialLink)
                        <tr>
                            <td>{{ $socialLink->id }}</td>
                            <td><i class="material-icons">{{ $socialLink->icon }}</i></td>
                            <td style="max-width: 420px; word-break: break-all;">{{ $socialLink->url }}</td>
                            <td>{{ $socialLink->position }}</td>
                            <td>{{ $socialLink->is_active ? 'Sí' : 'No' }}</td>
                            <td>
                                <a class="btn btn-sm btn-secondary" href="{{ route('admin.social-links.edit', $socialLink) }}">Editar</a>
                                <form method="POST" action="{{ route('admin.social-links.destroy', $socialLink) }}" class="d-inline" onsubmit="return confirm('¿Eliminar este link?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-4">Sin links</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
