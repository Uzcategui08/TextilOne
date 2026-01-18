@extends('adminlte::page')

@section('title', 'Empresas')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Empresas</h1>
        <a class="btn btn-primary" href="{{ route('admin.companies.create') }}">Nueva</a>
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
                        <th>Logo</th>
                        <th>Nombre</th>
                        <th>Posición</th>
                        <th>Activo</th>
                        <th style="width: 220px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($companies as $company)
                        <tr>
                            <td>{{ $company->id }}</td>
                            <td>
                                @if ($company->logo_media_id)
                                    <img src="{{ route('media.show', $company->logo_media_id) }}" alt="{{ $company->name }}" style="height: 28px; width: auto; max-width: 140px; object-fit: contain;">
                                @elseif ($company->logo_path)
                                    <img src="{{ asset('storage/' . $company->logo_path) }}" alt="{{ $company->name }}" style="height: 28px; width: auto; max-width: 140px; object-fit: contain;">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $company->name }}</td>
                            <td>{{ $company->position }}</td>
                            <td>{{ $company->is_active ? 'Sí' : 'No' }}</td>
                            <td>
                                <a class="btn btn-sm btn-secondary" href="{{ route('admin.companies.edit', $company) }}">Editar</a>
                                <form method="POST" action="{{ route('admin.companies.destroy', $company) }}" class="d-inline" onsubmit="return confirm('¿Eliminar esta empresa?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-4">Sin empresas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
