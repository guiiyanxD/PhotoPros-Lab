@extends('layouts.welcome')

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="container">
            <div class="row justify-content-center mt-4 mb-4">
                <h1 style="font-family:Bahnschrift"> Informacion del evento!</h1>
            </div>
            <div class="row">
            </div>
            <div class="row justify-content-center">
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
                                <p>{{ $event->snapshot()->data()['host_id']
                                        ->snapshot()
                                        ->data()['fname']
                                    }}
                                    {{ $event->snapshot()->data()['host_id']
                                        ->snapshot()
                                        ->data()['lname']
                                    }}
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
                                <h5><strong>Invitados:</strong></h5>
                                @foreach($event->snapshot()->data()['attendants'] as $attendants)
                                    <p>{{ $attendants->snapshot()->data()['fname'] }} {{ $attendants->snapshot()->data()['lname'] }}, </p>
                                @endforeach
                            </div>
                            <div class="row form-group mt-4 mb-0">
                                <div class="col text-center text-white" >
                                    <button type="button" class="btnSubmit text-white" style="background-color: #f05837">
                                        {{ __('Ver album del evento') }}
                                    </button>
                                </div>
                                <div class="col text-center">
                                    <a type="button" class="btnSubmit text-center" style="text-decoration: none; " href="/home">Volver</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
