@extends('adminlte::auth.auth-page', ['authType' => 'login'])

@php
    $loginUrl = route('login');
    $passResetUrl = Route::has('password.request') ? route('password.request') : null;
@endphp

@section('auth_header')
    <a class="t1-auth-logo" href="{{ url('/') }}" aria-label="Ir al inicio">
        <img src="{{ asset('images/TextilOne.png') }}" alt="TextilOne" loading="lazy">
    </a>
    <div class="t1-auth-title">Inicia sesión</div>
@stop

@section('auth_body')
    <form action="{{ $loginUrl }}" method="post">
        @csrf

        <div class="input-group mb-3 t1-input-group">
            <input
                type="email"
                name="email"
                class="form-control t1-input @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                placeholder="Correo"
                autofocus
                autocomplete="username"
                required
            >
            <div class="input-group-append">
                <div class="input-group-text t1-input-icon">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="input-group mb-3 t1-input-group">
            <input
                type="password"
                name="password"
                class="form-control t1-input @error('password') is-invalid @enderror"
                placeholder="Contraseña"
                autocomplete="current-password"
                required
            >
            <div class="input-group-append">
                <div class="input-group-text t1-input-icon">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="row align-items-center">
            <div class="col-7">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Recordarme</label>
                </div>
            </div>
            <div class="col-5">
                <button type="submit" class="btn btn-primary btn-block t1-auth-btn">Ingresar</button>
            </div>
        </div>
    </form>
@stop

@section('auth_footer')
    @if ($passResetUrl)
        <p class="my-0"><a class="t1-auth-link" href="{{ $passResetUrl }}">Olvidé mi contraseña</a></p>
    @endif
@stop

@section('css')
    <style>
        /*
        |--------------------------------------------------------------------------
        | TextilOne: Auth (Login)
        |--------------------------------------------------------------------------
        | Brand palette based on the public site: black + white + red accent.
        */

        .login-page {
            background: radial-gradient(1000px circle at 20% 10%, rgba(255, 0, 0, 0.14), transparent 50%),
                        radial-gradient(900px circle at 85% 25%, rgba(255, 0, 0, 0.10), transparent 55%),
                        linear-gradient(180deg, #060606 0%, #000000 100%) !important;
        }

        .login-box {
            width: min(420px, calc(100% - 32px));
        }

        .login-box .card {
            background: rgba(12, 12, 12, 0.86);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            box-shadow: 0 18px 55px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        /* AdminLTE auth pages often render a white login-card-body by default. */
        .login-box .card-body,
        .login-box .login-card-body,
        .login-box .card-footer,
        .login-box .login-card-footer {
            background: transparent !important;
            color: rgba(255, 255, 255, 0.86);
        }

        .login-box .card::before {
            content: '';
            display: block;
            height: 3px;
            background: linear-gradient(90deg, rgba(255, 0, 0, 0.0), rgba(255, 0, 0, 0.95), rgba(255, 0, 0, 0.0));
        }

        .t1-auth-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            border-radius: 12px;
            opacity: 0.92;
            transition: opacity .2s ease, transform .2s ease, background-color .2s ease;
        }

        .t1-auth-logo:hover {
            opacity: 1;
            transform: translateY(-1px);
            background: rgba(255, 255, 255, 0.03);
        }

        .t1-auth-logo img {
            width: 168px;
            height: auto;
            display: block;
            filter: drop-shadow(0 10px 28px rgba(255, 0, 0, 0.10));
        }

        .t1-auth-title {
            margin-top: 10px;
            font-weight: 800;
            letter-spacing: 0.2px;
            color: rgba(255, 255, 255, 0.90);
            font-size: 16px;
        }

        .t1-input-group .t1-input {
            background: rgba(255, 255, 255, 0.09);
            border: 1px solid rgba(255, 255, 255, 0.16);
            color: rgba(255, 255, 255, 0.92);
            border-radius: 12px 0 0 12px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.06);
        }

        .t1-input-group .t1-input::placeholder {
            color: rgba(255, 255, 255, 0.40);
        }

        .t1-input-group .t1-input:focus {
            border-color: rgba(255, 0, 0, 0.55);
            box-shadow: 0 0 0 0.2rem rgba(255, 0, 0, 0.12), inset 0 1px 0 rgba(255, 255, 255, 0.06);
        }

        .t1-input-icon {
            background: rgba(255, 255, 255, 0.09);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-left: 0;
            color: rgba(255, 255, 255, 0.70);
            border-radius: 0 12px 12px 0;
        }

        /* Keep browser autofill from turning fields bright and hard to read */
        .t1-input-group .t1-input:-webkit-autofill,
        .t1-input-group .t1-input:-webkit-autofill:hover,
        .t1-input-group .t1-input:-webkit-autofill:focus {
            -webkit-text-fill-color: rgba(255, 255, 255, 0.92);
            -webkit-box-shadow: 0 0 0px 1000px rgba(20, 20, 20, 0.90) inset;
            transition: background-color 9999s ease-in-out 0s;
            border-color: rgba(255, 255, 255, 0.16);
        }

        .login-box .form-check-label {
            color: rgba(255, 255, 255, 0.65);
            user-select: none;
        }

        .login-box .form-check-input:checked {
            background-color: #ff0000;
            border-color: #ff0000;
        }

        .t1-auth-btn {
            border-radius: 12px;
            font-weight: 800;
            letter-spacing: 0.2px;
            border: 1px solid rgba(255, 0, 0, 0.35);
            background: linear-gradient(180deg, rgba(255, 0, 0, 0.95), rgba(210, 0, 0, 0.95));
            box-shadow: 0 10px 30px rgba(255, 0, 0, 0.18);
        }

        .t1-auth-btn:hover {
            filter: brightness(1.03);
        }

        .t1-auth-link {
            color: rgba(255, 255, 255, 0.70);
            text-decoration: none;
            transition: color .2s ease;
        }

        .t1-auth-link:hover {
            color: rgba(255, 0, 0, 0.95);
            text-decoration: none;
        }

        .login-box .invalid-feedback {
            color: rgba(255, 130, 130, 0.95);
        }
    </style>
@stop
