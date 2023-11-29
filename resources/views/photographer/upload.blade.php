@php use Illuminate\Support\Facades\Session; @endphp
[@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <h1>
                    Album del evento
                </h1>
            </div>
            <div class="col-md-12">
                @if(Session::has('status'))
                    <div class="alert-danger">
                        {{Session::get('status')}}
                    </div>
                @endif
                <div class="card border-info">
                    <div class="card-header bg-info text-white">{{ __('Subiendo fotos del evento') }}</div>
                    <div class="card-body" style="">
                        <form method="POST" action="{{route('event.album_to_process')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <label for="imageProfile"> Escoja las imagenes del evento para subir. </label>
                            <input class="form-control" type="file" name="album_photos[]" id="photos" multiple accept="image/*">
                            <input type="hidden" name="eventId" value="{{$eventId}}">

                            <div class="row m-4 text-center">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-outline-info">
                                        Subir imagen
                                    </button>
                                </div>
                                <div>
                                    <div class="col-md-6">
                                        <a type="button" href="{{route('photographer.home')}}" class="btn btn-outline-danger">
                                            Cancelar
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <small class="text-danger">* Al subir la imagen se agregara su marca de agua automaticamente</small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr>


    </div>
@endsection
