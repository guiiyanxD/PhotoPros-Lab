@extends('layouts.welcome')

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="container">
            <div class="row mt-4 mb-4 justify-content-center">
                <h1 style="font-family:Bahnschrift"> Listado de fotografos disponibles</h1>
            </div>

            <div class="row mt-4 mb-4">
                @foreach($phs as $key => $ph)
                    <div class="col-md-4 mt-4">
                        <div class="card" style="">
                            <img class="card-img-top" height="250px" src="{{ Storage::disk('s3')->temporaryUrl('holders/no_profile_picture.png', '+2 minutes')}}" alt="Card image cap">
                            <div class="card-body text-white" style="background-color: #4b4b4b">
                                <h5 class="card-title">Hola, yo soy {{ $ph->data()['fname'] }}</h5>
                                <p class="card-text">Mi fuerte son las fotografias de
                                    @foreach($ph->data()['categories'] as $doc)
                                        {{$doc}},
                                    @endforeach
                                y suelo cobrar
                                    @if($ph->data()['preference'] == true)
                                        por evento
                                    @else por foto tomada @endif un monto de {{$ph->data()['price']}}$. Contactame.
                                    Mi numero de telefono es {{$ph->data()['telefono']}}
                                </p>

                                <a href="#" class="btn btn-primary">Contratar</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <a  class="btn btn-danger" href="{{route('home')}}">
                            Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
