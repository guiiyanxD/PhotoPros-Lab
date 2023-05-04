@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-success">{{ __('Registate para ser parte de algun evento u organizar uno. Animate!') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="name" class="form-label mb-0">{{ __('Nombre') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="lastname" class="form-label mb-0">{{ __('Apellido') }}</label>

                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>

                                @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row mt-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label mb-0">{{ __('Correo Electronico') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="bday" class="form-label mb-0">{{ __('Fecha de nacimiento') }}</label>
                                <input id="bday" type="date" class="form-control" name="bday" required >
                                <small class="text-muted">
                                    {{__('Debe tener por lo menos 13 años de edad.')}}
                                </small>

                            </div>
                        </div>

                        <div class="form-row mt-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label mb-0">{{ __('Contraseña') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <small class="text-muted">
                                    {{__('Debe tener 8 caracteres de longitud')}}
                                </small>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password-confirm" class="form-label mb-0">{{ __('Confirma la contraseña') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <small class="text-muted">
                                    {{__('Debe tener 8 caracteres de longitud')}}
                                </small>
                            </div>
                        </div>

                        <div class="form-row mt-3">
                            <div class="col-md-2  ">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                            <div class="col-md-9">
                                <a type="button" class="btn btn-danger" href="/">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
