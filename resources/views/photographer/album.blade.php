@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>
                    Album del evento
                </h1>
            </div>
        </div>
        <div class="row">
            @foreach($album as $key => $photo)
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-img-top">
{{--                            @if($isPh)--}}
                                <img class="img-thumbnail" src="{{ Storage::disk('s3')->temporaryUrl($photo["pathToS3"], now()->addMinutes(15))  }}" alt="PhotoproLab">
{{--                            @else--}}
{{--                                <img class="img-thumbnail" src="{{ asset($photo["pathToLocal"]) }}" alt="PhotoproLab">--}}
{{--                            @endif--}}
                        </div>
                        @if( $isPh )
                            <div class="card-footer">
                                <button class="btn btn-danger">
                                    Eliminar
                                </button>
                            </div>
                        @else
                            <div class="card-footer">
                                <button class="btn btn-success">
                                    Adquirir
                                </button>
                            </div>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
