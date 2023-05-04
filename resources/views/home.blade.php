@extends('layouts.app')

@section('content')
<div class="container">
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
