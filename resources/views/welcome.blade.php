@extends('layouts.welcome')

@section('content')

    <div class="flex-center position-ref full-height">

        <div class="container">
            <div class="row justify-content-center mt-4 mb-4">
                <h1 style="font-family:Bahnschrift"> Que bueno verte de nuevo!</h1>
            </div>
            <div class="row">
                <div class="col-md-6 login-form-1">
                    <form method="POST" action="{{route('login')}}">
                        @csrf
                        <h3 style="font-family:Bahnschrift">Asistente</h3>
                        <input type="hidden" id="attendant" name="attendant">
                        <div class="form-group">
                            <input id="email" name="email" type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Correo electronico" required autofocus />
                            @error('email')
                            <span class="invalid-feedback" style="color: whitesmoke" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña" required autofocus/>
                            @error('password')
                            <span class="invalid-feedback" style="color: whitesmoke" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btnSubmit">Login </button>
                        </div>
                        <div class="form-group">
                            <a style="color: whitesmoke" type="button" href="{{route('register')}}" class="btnForgetPwd">No tienes cuenta? Registrate</a>
                        </div>
                    </form>

                </div>
                <div class="col-md-6 login-form-2">
                    <form method="POST" action="{{route('login')}}">
                        @csrf
                        <h3 style="font-family:Bahnschrift">Fotografo</h3>
                        <input type="hidden" id="photographer" name="photographer">
                        <div class="form-group">
                            <input id="email" name="email" type="text" class="form-control @error('email') is-invalid @enderror"  placeholder="Correo electronico" />
                            @error('email')
                            <span class="invalid-feedback" style="color: whitesmoke" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña" />
                            @error('password')
                            <span class="invalid-feedback" style="color: whitesmoke" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btnSubmit">Login </button>
                        </div>
                        <div class="form-group">
                            <a style="color: whitesmoke" type="button" href="{{ route('registerph.view') }}" class="btnForgetPwd">No tienes cuenta? Registrate</a>
                        </div>
                        <div class="form-group">
                            <a style="color: whitesmoke" type="button" href="{{route('becomeph.view')}}" class="btnForgetPwd">Ya tienes cuenta de asistente? Completa tu perfil</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

