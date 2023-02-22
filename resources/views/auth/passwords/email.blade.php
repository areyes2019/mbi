@extends('template.login')

@section('login')
<p class=" m-0">Parece que olvidaste tu contraseña</p>
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="row mb-0">
        <div class="col-md-12">
            <div class="form-group">
                <label for="email" >Escribe en este campo la contraseña con que te registraste</label>
                <input id="email" type="email" class="form-control rounded-0 shadow-none @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                <small>Ya recorde mi contraseña. <a href="{{route('login')}}">Entrar a mi cuenta</a></small>
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="form-group mt-3">
                <button type="submit" class="btn-connexion-primary text-white text-uppercase">
                    {{ __('Enviarme el link de restablecimiento') }}
                </button>
            </div>
        </div>
    </div>    
</form>
@endsection
