@extends('layouts.app')

@section('content')
<div id="carouselExampleControls" class=" carousel slide" data-ride="carousel">
            <div class="carousel-inner ">
                <div class="carousel-item active">
                    <img class="d-block mx-auto w-100 "    src="https://picsum.photos/1920/700" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Bienvenido de nuevo</h3>
                        <h5>Williams</h5>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block mx-auto w-100" src="https://picsum.photos/1920/700" alt="Second slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Bienvenido de nuevo</h3>
                        <h5>Williams</h5>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block mx-auto w-100"  src="https://picsum.photos/1920/700" alt="Third slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Bienvenido de nuevo</h3>
                        <h5>Williams</h5>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
                <h1>
                   Home
                </h1>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12 ">
                <h1>
                    Propuestas de trabajo
                </h1>
            </div>
            <div class="col-md-4 mt-4">
                <div class="card" style="">
                    <div class="card-body">
                        <h3 class="card-title">Nombre del evento </h3>
                        <h6 class="card-subtitle mb-2 text-muted">Anfitrion:Te ha pedido trabajar para el evento</h6>
                        <p class="card-text">Descripcion del evento</p>
                        <p class="card-text">Fecha y lugar del evento </p>
                        <p class="card-text">Codigo de invitacion_</p>
                        <a href="" class="card-link">Ver evento</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12 ">
                <h1>
                    Eventos
                </h1>
            </div>
        </div>

        <hr>


        <div class="row ">
            <div class="col-md-5">
                <div class="card border-danger">
                    <div class="card-header bg-danger">{{ __('Cuentanos sobre ti') }}</div>
                    <div class="card-body" style="background-color: #adb5bd">
                        <h4>
                            {{__('Completa tu perfil. Este card va desaparecer si es que el usuario ya ha subido por
                            lo menos unas 5 imagenes de si mismo para poder reconocerlo con la AI.')}}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
