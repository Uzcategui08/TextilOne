@extends('adminlte::auth.auth-page', ['authType' => 'login'])

@php
    $loginUrl = route('login');
    $registerUrl = Route::has('register') ? route('register') : null;
    $passResetUrl = Route::has('password.request') ? route('password.request') : null;
@endphp

@section('auth_header')
    Inicia sesión
@stop

@section('auth_body')
    <form action="{{ $loginUrl }}" method="post">
        @csrf

        <div class="input-group mb-3">
            <input
                type="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                placeholder="Correo"
                autofocus
                autocomplete="username"
                required
            >
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="input-group mb-3">
            <input
                type="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Contraseña"
                autocomplete="current-password"
                required
            >
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="row">
            <div class="col-7">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Recordarme</label>
                </div>
            </div>
            <div class="col-5">
                <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
            </div>
        </div>
    </form>
@stop

@section('auth_footer')
    @if ($passResetUrl)
        <p class="my-0"><a href="{{ $passResetUrl }}">Olvidé mi contraseña</a></p>
    @endif
    @if ($registerUrl)
        <p class="my-0"><a href="{{ $registerUrl }}">Crear cuenta</a></p>
    @endif
@stop
