@extends('layouts.welcome')

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="container">
            <div class="row justify-content-center mt-4 mb-4">
                <h1 style="font-family:Bahnschrift"> Unete y comienza a organizar eventos!</h1>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-12 login-form-1" style="padding: 5%" >
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-row">
                            <div class="col-md-6">
                                <input id="name" type="text" placeholder="Nombre" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input id="lastname" type="text" placeholder="Apellido" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>
                                @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row mt-3">
                            <div class="col-md-6 ">
                                <input id="email" type="email" placeholder="Correo electronico" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                            <div class="col-md-6 ">
                                <input id="bday" type="date" placeholder="Fecha de nacimiento" class="form-control" name="bday" required >
                                <small class="text-white">
                                    {{__('Debe tener por lo menos 13 años de edad.')}}
                                </small>

                            </div>
                        </div>

                        <div class="form-row mt-3">
                            <div class="col-md-6">
                                <input id="password" type="password" placeholder="Contraseña" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <small class="text-white">
                                    {{__('Debe tener 8 caracteres de longitud')}}
                                </small>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" placeholder="Confirmar contraseña" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <small class="text-white">
                                    {{__('Debe tener 8 caracteres de longitud')}}
                                </small>
                            </div>
                        </div>
                        <div class="row form-group mt-4 mb-0">
                            <div class="col text-center text-white" >
                                <button type="submit" class="btnSubmit text-white" style="background-color: #1b1e21">
                                    {{ __('Register') }}
                                </button>
                            </div>
                            <div class="col text-center">
                                <a type="button" class="btnSubmit text-center" style="text-decoration: none; " href="/">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
