{{--@php use Illuminate\Support\Facades\Storage; @endphp--}}
@extends('layouts.app')

@section('content')
    <div id="carouselExampleControls" class=" carousel slide" data-ride="carousel">
        <div class="carousel-inner ">
            <div class="carousel-item active">
                <img class="d-block mx-auto w-75 h-auto" src="https://picsum.photos/1920/720" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <div>
                        <h3>Bienvenido de nuevo, fotográfo</h3>
                        <h5>{{Auth::user()->name .' ' . Auth::user()->lastname}}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
                <h1>
                    Inicio
                </h1>
            </div>
            <hr>
            <div class="col-md-3">
                <div class="position-relative d-inline-block flex-shrink-0 mr-5">
                    <img style="width: 260px; height:260px" class="rounded-circle"
                             src="{{ Storage::disk('s3')->temporaryUrl($ph['profile_picture_path'], now()->addMinutes(5) )}}"
                         alt="image profile">
                </div>

            </div>
            <div class="col-md-9">
                <div class="row m-1">
                    <div class="">
                        <h3>
                            Nombre: {{Auth::user()->name .' ' . Auth::user()->lastname}}
                        </h3>
                    </div>
                </div>
                <div class="row m-1">
                    <div class="">
                        <h3>
                            Email: {{Auth::user()->email}}
                        </h3>
                    </div>
                </div>
                <div class="row m-1">
                    <div class="">
                        <h3>
                            Edad: {{Auth::user()->getAge() . ' Años'}}
                        </h3>
                    </div>
                </div>
                <div class="row m-1">
                    <a type="button" href="{{route('user.upload_profile_picture.view')}}"
                       class="btn btn-outline-info mb-3">
                        Actualizar foto de perfil
                    </a>
                </div>
                <div class="row ml-1 mt-0">
                    <small>
                        {{__('*Te recomendamos subir una imagen clara de tu rostro, para asi poder notificarte asistas a un evento')}}
                    </small>
                </div>

            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h3>Panel de control</h3>
            </div>
            <hr>
            <div class="col-md-3">
                <a type="button" href="{{route('ph.show.events')}}" class="btn btn-primary btn-lg btn-block">Ver eventos</a>
            </div>
            <div class="col-md-3">
                <a type="button" href="{{route('ph.lookFor.events')}}" class="btn btn-primary btn-lg btn-block">Buscar Eventos</a>
            </div>
            <div class="col-md-3">
                <a type="button" href="{{route('event.ph.showRequest',['sender'=>'ph'])}}" class="btn btn-primary btn-lg btn-block">Ver solicitudes de eventos</a>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary btn-lg btn-block">Editar Biografia</button>
            </div>
        </div>
        <hr>

        <hr>
    </div>
@endsection
