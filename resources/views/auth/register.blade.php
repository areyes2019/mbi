@extends('template.login')

@section('login')
<p class=" m-0">Bienvenido</p>
<p class=" m-0">Estas a punto de inicar la experiecia Connexion</p>
<small>Ya soy usario <a href="{{route('login')}}">Entrar</a></small>
<div class="side-login-register">
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="form-group">
        <label for="">Tu nombre</label>
        <input id="name" type="text" placeholder="Nombre" class="form-control rounded-0 shadow-none @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Tu correo electrónico</label>
        <input id="email" type="email" placeholder="@" class="form-control rounded-0 shadow-none @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group">
      <label for="">Contraseña</label>
        <input id="password" type="password"  placeholder="*******" class="form-control shadow-none rounded-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group">
      <label for="">Confirmar contraseña</label>
      <input id="password-confirm" type="password" placeholder="*******" class="form-control rounded-0 shadow-none" name="password_confirmation" required autocomplete="new-password">
    </div>
    <div class="form-group mt-3">
        <button type="submit" class="btn-connexion-primary text-white">
            Obtener mi cuenta
        </button>
    </div>
</form>
</div>
@endsection
