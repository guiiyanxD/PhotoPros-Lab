@extends('layouts.welcome')

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="container">
            <div class="row mt-4 mb-4 justify-content-center">
                <h1 style="font-family:Bahnschrift"> Informacion del evento!</h1>
            </div>

            <div class="row mt-4 mb-4">
                <div class="col-md-12" style="padding:5%" >
                    <div class="card">
                        <div class="card-header text-white bg-dark">
                            <strong>
                                <h2> {{$event->snapshot()->data()['name']}} </h2>
                            </strong>
                        </div>
                        <div class="card-body text-white" style="background-color: #4b4b4b">
                            <div class="col-md-12 d-inline-block">
                                <h5><strong>Anfitrion:</strong></h5>
                                <p> {{\Illuminate\Support\Facades\Auth::user()->fullName()}} (Tu)
                                </p>
                            </div>
                            <div class="col-md-12 d-inline-block">
                                <h5><strong>Descripcion:</strong></h5> <p>{{ $event->snapshot()->data()['description'] }}</p>
                            </div>
                            <div class="col-md-12 d-inline-block">
                                <h5><strong>Cuando?:</strong></h5>
                                <p>El evento inicia el {{ $event->snapshot()->data()['date_event_ini_lit'] }}
                                    y terminar el {{ $event->snapshot()->data()['date_event_end_lit'] }}
                                </p>
                            </div>
                            <div class="col-md-12 d-inline-block">
                                <h5><strong>Donde?:</strong></h5>
                                <p>{{ $event->snapshot()->data()['address'] }} </p>
                            </div>
                            <div class="col-md-12 d-inline-block">
                                <h5 class="" ><strong>Comparte tu codigo de invitacion:</strong></h5>
                                <h4 style="color: #f05837">{{ $event->snapshot()->data()['code_invitation'] }}</h4>

                            </div>
                            <div class="col-md-12 d-inline-block">
                                <h5><strong>Invitados:</strong></h5>
                                @foreach($event->snapshot()->data()['attendants'] as $attendants)
                                    <p>{{ $attendants->snapshot()->data()['fname'] }}</p>
                                @endforeach
                            </div>
                            <div class="row form-group mt-4 mb-0">
                                <div class="col text-center text-white" >
                                    <button type="button" class="btnSubmit text-white" style="background-color: #f05837">
                                        {{ __('Ver album del evento') }}
                                    </button>
                                </div>
                                <div class="col text-center text-white" >
                                    <a type="button" href="{{route('ph.hire')}}" class="btnSubmit text-white" style="background-color: #f05837">
                                        {{ __('Buscar fotografos') }}
                                    </a>
                                </div>
                                <div class="col text-center">
                                    <a type="button" class="btnSubmit text-center" style="text-decoration: none; " href="/home">Volver</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 mb-4">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-white bg-dark">

                        </div>
                        <div class="card-body text-white" style="background-color: #4b4b4b">

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card" style="">
                        <img class="card-img-top" src="..." alt="Card image cap">
                        <div class="card-body text-white" style="background-color: #4b4b4b">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
