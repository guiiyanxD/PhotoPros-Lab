@extends('layouts.welcome')

@section('content')

    <div class="flex-center position-ref full-height">
        {{--@if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif--}}
        <div class="container">
            <div class="row justify-content-center mt-4 mb-4">
                <h1 style="font-family:Bahnschrift"> Que bueno verte de nuevo!</h1>
            </div>
            <div class="row">
                <div class="col-md-6 login-form-1">
                    <form method="POST" action="{{route('login')}}">
                        @csrf
                        <h3 style="font-family:Bahnschrift">Asistente</h3>
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
                        <h3 style="font-family:Bahnschrift">Fotografo</h3>
                        <div class="form-group">
                            <input id="email" name="password" type="text" class="form-control" placeholder="Correo electronico" value="" />
                        </div>
                        <div class="form-group">
                            <input id="email" name="password" type="password" class="form-control" placeholder="Contraseña" value="" />
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btnSubmit" value="Login" />
                        </div>
                        <div class="form-group">
                            <a style="color: whitesmoke" type="button" href="{{route('register')}}" class="btnForgetPwd">No tienes cuenta? Registrate</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

