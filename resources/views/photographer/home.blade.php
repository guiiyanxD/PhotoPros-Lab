@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.app')

@section('content')
    <div id="carouselExampleControls" class=" carousel slide" data-ride="carousel">
        <div class="carousel-inner ">
            <div class="carousel-item active">
                <img class="d-block mx-auto w-100" src="https://picsum.photos/1920/720" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <div>
                        <h3>Bienvenido de nuevo</h3>
                        <h5>{{ $ph['fname'] .' '.  $ph['lname'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <br>
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12 ">
                <h1>
                    Home
                </h1>
            </div>
        </div>
        <hr>
        <div class="row">
            @foreach($events as $key => $evt)
                <div class="col-md-4">
                    <div class="card">
                        <img class="card-img-top" src="{{Storage::disk('s3')->temporaryUrl($evt['cover_picture'], now()->addMinutes(5))}}" alt="cover_picture">
                        <div class="card-body text-white" style="background-color: #4b4b4b">
                            <div class="col-md-12 d-inline-block">
                                <p><strong> {{$hosts[$key]['fname']}} {{$hosts[$key]['lname']}}</strong>
                                    (Organizador(a)) </p>
                            </div>
                            <div class="col-md-12 d-inline-block">
                                <p><strong>Informacion Adicional:</strong> El evento inicia
                                    el {{ $evt['date_event_ini_lit'] }}
                                    y finaliza el {{ $evt['date_event_end_lit'] }}. En {{ $evt['address'] }}
                                </p>
                            </div>
{{--                            {{$ids[$key]}}--}}
                            <div class="row form-group mt-4 mb-0">
                                <div class="col text-center text-white">
                                    <a type="button" href="{{route('ph.uploadAlbum',[$ids[$key]])}}" class="btn text-white"
                                       style="background-color: #f05837">
                                        {{ __('Subir Fotos') }}
                                    </a>
                                    <a type="button" href="{{route('event.show.album',[$ids[$key]])}}" class="btn text-white"
                                       style="background-color: #f05837">
                                        {{ __('Ver Album') }}
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <hr>
    </div>
@endsection
