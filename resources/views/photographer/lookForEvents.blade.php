@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>
                    Postulate a alguno de los eventos proximos
                </h1>
            </div>
        </div>
        <div class="row">
            @foreach($events as $key => $evt)
                <div class="col-md-4 mt-3 ">
                    <div class="card" style="">
                        <img class="card-img-top" src="{{ Storage::disk('s3')->temporaryUrl( /*'holders/no_profile_picture.jpg'*/ $evt->data()['cover_picture'], '+2 minutes')}}" alt="Card image cap">
                        <div class="card-body text-white" style="background-color: #4b4b4b">
                            <h5 class="card-title"> {{ $evt->data()['name'] }}</h5>
                            <p class="card-text"> {{ $evt->data()['description'] }}</p>
                            <p class="card-text"> {{ $evt->data()['date_event_ini_lit'] }}</p>
                            <p class="card-text"> {{ $evt->data()['date_event_end_lit'] }}</p>
                            <a href="{{route('event.ph.requesting',
                                [
                                    'event_id'  =>  $evt->id(),
                                    'ph_id'     =>  Auth::user()->localId,
                                    'sender'    =>  'ph',
                                ])}}" class="btn btn-primary">Postular</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
