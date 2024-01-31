
@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="container">
            <div class="row mt-4 mb-4 justify-content-start">
                <h1 style="font-family:Bahnschrift">{{$event['name']}}</h1>
            </div>

            <div class="row mt-4 mb-4">
                <div class="col-md-8">
                    <div class="card">
                        <img class="card-img-top" src="{{ Storage::disk('s3')->temporaryUrl($event['cover_picture'], now()->addMinutes(5)) }}" alt="">
                        <div class="card-body text-white" style="background-color: #4b4b4b">
                            <div class="col-md-12 d-inline-block">
                                <p><strong>Anfitrion:</strong> {{Auth::user()->fullName()}} (Tu)</p>
                            </div>
                            <div class="col-md-12 d-inline-block">
                                <p><strong>Descripción:</strong> {{ $event['description'] }}</p>
                            </div>
                            <div class="col-md-12 d-inline-block">
                                <p><strong>Cuando:</strong> El evento inicia el {{ $event['date_event_ini_lit'] }}
                                    y finaliza el {{ $event['date_event_end_lit'] }}
                                </p>
                            </div>
                            <div class="col-md-12 d-inline-block">
                                <p><strong>Lugar:</strong> {{ $event['address'] }} </p>
                            </div>
                            <div class="col-md-12 d-inline-block">
                                <h5 class=""><strong>Comparte tu codigo de invitacion:</strong></h5>
                                <h4 id="code_invitation" style="color: #f05837">{{ $event['code_invitation'] }}</h4>
                            </div>

                            <div class="row form-group mt-4 mb-0">
                                <div class="col text-center ">
                                    <a type="button" href="{{route('event.show.album',['event_id'=>$id])}}" {{-- el id del evento --}} class="btn btn-primary btn-lg btn-block">
                                        {{ __('Ver Album') }}
                                    </a>
                                </div>
                                <div class="col text-center text-white">
                                    <a type="button" href="{{route('ph.hire',['id'=>$id])}}" {{-- el id del evento --}} class="btn btn-primary btn-lg btn-block">
                                        {{ __('Buscar fotografos') }}
                                    </a>
                                </div>
                                <div class="col text-center text-white">
                                    <a type="button" href="{{route('event.ph.showRequest',['sender'=> 'evt', 'evt'=>$id])}}" class="btn btn-primary btn-lg btn-block">
                                        {{ __('Ver solicitudes') }}
                                    </a>
                                </div>
                                <div class="col text-center">
                                    <a type="button" class="btn btn-light btn-lg btn-block "
                                       href="{{route('home')}}">Volver</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="container ">
                        <div class="row pb-0">
                            <div class="col-md-12 ">
                                <h5>
                                    <strong>Codigo Qr de ingreso al evento: </strong>
                                </h5>
                                <br>
                            </div>
                        </div>
                        <div class="row pb-5 pt-0 ">
                            <div class="col-md-12 m-0 pt-0">
                                <div class="">
                                    {{QrCode::generate('Embed me into an e-mail!')}}
                                    <a class="btn" role="button" id="descargarBtn">Descargar SVG</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row pb-0">
                            <div class="col-md-12">
                                <h5>
                                    <strong>Personas invitadas al evento:</strong>
                                </h5>
                                <br>
                            </div>
                        </div>
                        <div class="row pb-5 pt-0 ">
                            <div class="col-md-12 m-0 pt-0 " style="margin: inherit">
                                <div class="position-relative">
                                    @foreach($arrayAtt as $key => $att)
                                        <div class="image-round-100 rounded-circle">
                                            <img title="{{$arrayAtt[$key]['fname'] }} {{$arrayAtt[$key]['lname']}}" style="width: 40px; height: 40px" src="{{ Storage::disk('s3')->temporaryUrl( $arrayAtt[$key]['profile_picture_path'], now()->addMinutes(5) )}}"  alt="att"/>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container ">
                        <div class="row pb-0">
                            <div class="col-md-12 ">
                                <h5>
                                    <strong>Fotografos del evento: </strong>
                                </h5>
                                <br>
                            </div>
                        </div>
                        <div class="row pb-5 pt-0 ">
                            <div class="col-md-12 m-0 pt-0" style="margin: inherit">
                                <div class="position-relative">
                                    @foreach($arrayPh as $key => $phh)
                                        <div class="image-round-100 rounded-circle">
                                            <img title="{{$arrayPh[$key]['fname'] }} {{$arrayPh[$key]['lname']}}" style="width: 40px; height: 40px" src="{{ Storage::disk('s3')->temporaryUrl( $arrayPh[$key]['profile_picture_path'], now()->addMinutes(5) )}}"  alt="ph"/>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.getElementById('descargarBtn').addEventListener('click', function() {
                    // Obtener la imagen como un Blob
                    var img = document.getElementById('miImagen');
                    var canvas = document.createElement('canvas');
                    var ctx = canvas.getContext('2d');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    ctx.drawImage(img, 0, 0);
                    canvas.toBlob(function(blob) {
                        // Crear un enlace temporal y simular un clic para descargar el archivo
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'miImagen.jpg';
                        link.click();
                    }, 'image/jpeg');
                });
            </script>
            {{--<div class="row mt-4 mb-4">
                <div class="col-md-12">
                    <h1>Album del evento</h1>
                </div>
                ///TODO TRAER IMAGENES DEL SERVIDOR

                <div class="col-md-3">
                    <div class="card" style="">
                        <img class="card-img-top" src="https://dkrn4sk0rn31v.cloudfront.net/uploads/2022/09/PUB-DEV.jpg"
                             alt="Card image cap">
                        <div class="card-footer text-white" style="background-color: #4b4b4b">
                            <a href="#" class="btn btn-primary">Comprar</a>
                            <a href="#" class="btn btn-primary">Adquirir</a>
                        </div>
                    </div>

                </div>
            </div>--}}
        </div>
    </div>
    <style>
        .image-round-100 {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .image-round-100:nth-child(2) {
            /*top: 20px;*/
            left: 20px;
            border-radius: 50%;
            z-index: 2;
        }
    </style>
@endsection
