{{--
@extends('layouts.user.home')
@section('profileInformation')
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
                         @if( $path!= '')
                             src="{{ Storage::disk('s3')->temporaryUrl($path, now()->addMinutes(5) )}}"
                         @else
                             src="{{ Storage::disk('s3')->temporaryUrl('holders/no_profile_picture.jpg', now()->addMinutes(5) )}}"
                         @endif
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
    </div>
    <hr>
@endsection
--}}
