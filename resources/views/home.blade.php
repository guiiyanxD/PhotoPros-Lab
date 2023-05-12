@php use Illuminate\Support\Facades\Storage; @endphp
@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <h1>
                    {{__('Perfil')}}
                </h1>
            </div>
            <hr>
            <div class="col-md-3">
                <div class="position-relative d-inline-block flex-shrink-0 mr-5">
                    <img style="width: 260px; height:260px" class="rounded-circle"
                         src="{{ Storage::disk('s3')->temporaryUrl($path, '+2 minutes')}}"
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
                <h1>
                    Mis Eventos
                </h1>
            </div>
            @if (session('event'))
                <div class="alert alert-warning" role="alert">
                    {{ session('event') }}
                </div>
            @endif
            <hr>
            <div class="col-md-12 text-center">
                <div class="card border-info">
                    <div class="card-header bg-info">{{ __('Tienes una fiesta en mente?') }}</div>
                    <div class="card-body">
                        <h4>
                            {{__('Sé un anfitrión! Agenda un nuevo evento')}}
                        </h4>
                    </div>

                    <div class=" m-3 ">
                        <a type="button" href="{{route('event.create')}}" class="btn btn-outline-info">
                            Nuevo Evento
                        </a>
                    </div>
                    <hr>
                    <div class=" card-body col-md-12">
                        <form action="{{ route('event.join') }}" method="POST">
                            @csrf
                        <label for="code_invitation">
                            {{__('Si tiene un codigo de invitacion, escribelo aqui!')}}
                        </label>
                        <input type="text" id="code_invitation" name="code_invitation" class="form-control">
                        <div class=" m-3 ">
                            <button type="submit" class="btn btn-outline-info">
                                Unete!
                            </button>
                        </div>
                        @if (session('event-error'))
                            <small class=" alert alert-warning">
                                {{ session('event-error') }}
                            </small>
                        @endif
                        </form>
                    </div>
                </div>
            </div>
            ///TODO: He llegado hasta enviar solicitudes de trabajo a los fotografos, configurando y actualizando las credenciales de aws s3 y firebase el proyecto funciona. Falta configurar el reconocimiento facial de amazon rekognition

        @foreach( $events as $doc)
            <div class="col-md-4 mt-4">
                <div class="card" style="">
                    <div class="card-body">
                        <h3 class="card-title">{{$doc['name']}}</h3>
                        <h6 class="card-subtitle mb-2 text-muted">Anfitrion: {{$doc['host_id']->snapshot()['fname']}}</h6>
                        <p class="card-text">{{$doc['description']}}</p>
                        <p class="card-text">Desde {{$doc['date_event_ini_lit']}} hasta {{$doc['date_event_end_lit']}} </p>
                        <p class="card-text">Codigo de invitacion: {{$doc['code_invitation']}}</p>
                        <a href="{{route('event.show.host',['id' => $doc->id()])}}" class="card-link">Ver evento</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h1>Eventos a los que estas invitado</h1>
            </div>
            @foreach( $asAttendant as $doc)
                <div class="col-md-4 mt-4">
                    <div class="card" style="">
                        <div class="card-body">
                            <h3 class="card-title">{{$doc->snapshot()->data()['name']}}</h3>
                            <h6 class="card-subtitle mb-2 text-muted">Anfitrion: {{$doc->snapshot()->data()['host_id']->snapshot()['fname']}}</h6>
                            <p class="card-text">{{$doc->snapshot()->data()['description']}}</p>
                            <p class="card-text">Desde {{$doc->snapshot()->data()['date_event_ini_lit']}} hasta {{$doc->snapshot()->data()['date_event_end_lit']}} </p>
{{--                            <p class="card-text">Codigo de invitacion: {{$doc->snapshot()->data()['code_invitation']}}</p>--}}
                            <a href="{{route('event.show.attendant',['id' => $doc->snapshot()->id()])}}" class="card-link">Ver evento</a>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </div>
@endsection
