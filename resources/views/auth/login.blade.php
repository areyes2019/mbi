@extends('template.login')

@section('login')
<p class=" m-0">Bienvenido de regreso</p>
<p class=" m-0">Introduce tus credenciales para entrar</p>
<p class=" m-0">¿No tienes cuenta? <span><a href="{{ route('register') }}">Crear una cuenta</a></span></p>
<form action="{{route('login')}}" method="post" class=" mt-3">
    @csrf
    <div class="row m-0">
    <div class="col-md-6">
        <div class="form-group">
        <label for="">Correo</label>
        <input id="email" type="email" placeholder="@" class="form-control rounded-0 shadow-none @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Contraseña</label>
            <input id="password" type="password" placeholder="**********" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group mt-1">
        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        <small class="text-muted">Mantener mi connexion</small><br>
        <small id="helpId" class="text-muted">Olivdé mi contraseña. <a href="{{ route('password.request') }}" id="rec">Recuperar</a></small>
    </div>
    <div class="form-group mt-5">
        <button type="submit" class="btn-connexion-primary text-white text-uppercase">Entrar a mi cuenta</button>
    </div>
    </div>
</form>

@endsection
