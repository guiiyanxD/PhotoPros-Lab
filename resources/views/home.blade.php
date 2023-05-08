@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <h1>
                Fotos de perfil
            </h1>
        </div>
        <div class="col-md-12">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">{{ __('Cuentanos sobre ti') }}</div>
                <div class="card-body" style="">
                    <p>
                        {{__('*Para poder notificarte cuando aparezcas en una foto, por favor, agrega 3 fotos a tu perfil. Te recomendamos subir una imagen clara de tu rostro')}}
                    </p>
                    <p>
{{--                        {{$countImages}}--}}
                    </p>
                    <a type="button" href="{{route('user.upload_profile_picture.view')}}" class="btn btn-outline-danger mb-3">
                        Subir foto
                    </a>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header"> Holaaaa gg</div>
                                <div class="card-body">
                                    Hola gg
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header"> Holaaaa gg</div>
                                <div class="card-body">
                                    Hola gg
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header"> Holaaaa gg</div>
                                <div class="card-body">
                                    Hola gg
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>


    <div class="row">
        <div class="col-md-12">
            <h1>
                Eventos
            </h1>
        </div>
        <hr>
        <div class="col-md-5 justify-content-center">
            <div class="card border-success">
                <div class="card-header bg-success">{{ __('Vamos allà!') }}</div>
                <div class="card-body">
                    <h4>
                        {{__('Agenda un nuevo evento')}}
                    </h4>
                </div>

                <div class=" m-3 ">
                    <a type="button" class="btn btn-outline-success">
                        Nuevo Evento
                    </a>
                </div>
            </div>
        </div>
    </div>



</div>
@endsection
