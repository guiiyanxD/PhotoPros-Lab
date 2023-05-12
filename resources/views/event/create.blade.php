@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="container">
            <div class="row justify-content-center mt-4 mb-4">
                <h1 style="font-family:Bahnschrift"> Unete y comienza a trabajar con nuestros partners!</h1>
            </div>
            <div class="row">
                @if (session('event'))
                    <div class="alert alert-warning" role="alert">
                        {{ session('event') }}
                    </div>
                @endif
            </div>

            <div class="row justify-content-center">
                <div class="col-md-12 login-form-2" style="padding:5%" >
                    {{--<div id="map"></div>
                    <script
                        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqWsTxm4pS4K447okfechVp4T3fOsnd8U&callback=initMap&v=weekly"
                        defer
                    ></script>
                    <script>
                        /**
                         * @license
                         * Copyright 2019 Google LLC. All Rights Reserved.
                         * SPDX-License-Identifier: Apache-2.0
                         */
                        let map;
                        let marker;
                        let geocoder;
                        let responseDiv;
                        let response;

                        function initMap() {
                            map = new google.maps.Map(document.getElementById("map"), {
                                zoom: 8,
                                center: { lat: -34.397, lng: 150.644 },
                                mapTypeControl: false,
                            });
                            geocoder = new google.maps.Geocoder();

                            const inputText = document.createElement("input");

                            inputText.type = "text";
                            inputText.placeholder = "Enter a location";

                            const submitButton = document.createElement("input");

                            submitButton.type = "button";
                            submitButton.value = "Geocode";
                            submitButton.classList.add("button", "button-primary");

                            const clearButton = document.createElement("input");

                            clearButton.type = "button";
                            clearButton.value = "Clear";
                            clearButton.classList.add("button", "button-secondary");
                            response = document.createElement("pre");
                            response.id = "response";
                            response.innerText = "";
                            responseDiv = document.createElement("div");
                            responseDiv.id = "response-container";
                            responseDiv.appendChild(response);

                            const instructionsElement = document.createElement("p");

                            instructionsElement.id = "instructions";
                            instructionsElement.innerHTML =
                                "<strong>Instructions</strong>: Enter an address in the textbox to geocode or click on the map to reverse geocode.";
                            map.controls[google.maps.ControlPosition.TOP_LEFT].push(inputText);
                            map.controls[google.maps.ControlPosition.TOP_LEFT].push(submitButton);
                            map.controls[google.maps.ControlPosition.TOP_LEFT].push(clearButton);
                            map.controls[google.maps.ControlPosition.LEFT_TOP].push(
                                instructionsElement
                            );
                            map.controls[google.maps.ControlPosition.LEFT_TOP].push(responseDiv);
                            marker = new google.maps.Marker({
                                map,
                            });
                            map.addListener("click", (e) => {
                                geocode({ location: e.latLng });
                            });
                            submitButton.addEventListener("click", () =>
                                geocode({ address: inputText.value })
                            );
                            clearButton.addEventListener("click", () => {
                                clear();
                            });
                            clear();
                        }

                        function clear() {
                            marker.setMap(null);
                        }

                        function geocode(request) {
                            clear();
                            geocoder
                                .geocode(request)
                                .then((result) => {
                                    const { results } = result;

                                    map.setCenter(results[0].geometry.location);
                                    marker.setPosition(results[0].geometry.location);
                                    marker.setMap(map);
                                    response.innerText = JSON.stringify(result, null, 2);
                                    return results;
                                })
                                .catch((e) => {
                                    alert("Geocode was not successful for the following reason: " + e);
                                });
                        }

                        window.initMap = initMap;
                    </script>
                    <style>
                        /**
                        * @license
                        * Copyright 2019 Google LLC. All Rights Reserved.
                        * SPDX-License-Identifier: Apache-2.0
                        */
                        /*
                         * Always set the map height explicitly to define the size of the div element
                         * that contains the map.
                         */
                        #map {
                            height: 100%;
                        }

                        /*
                         * Optional: Makes the sample page fill the window.
                         */
                        html,
                        body {
                            height: 100%;
                            margin: 0;
                            padding: 0;
                        }

                        input[type=text] {
                            background-color: #fff;
                            border: 0;
                            border-radius: 2px;
                            box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
                            margin: 10px;
                            padding: 0 0.5em;
                            font: 400 18px Roboto, Arial, sans-serif;
                            overflow: hidden;
                            line-height: 40px;
                            margin-right: 0;
                            min-width: 25%;
                        }

                        input[type=button] {
                            background-color: #fff;
                            border: 0;
                            border-radius: 2px;
                            box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
                            margin: 10px;
                            padding: 0 0.5em;
                            font: 400 18px Roboto, Arial, sans-serif;
                            overflow: hidden;
                            height: 40px;
                            cursor: pointer;
                            margin-left: 5px;
                        }
                        input[type=button]:hover {
                            background: rgb(235, 235, 235);
                        }
                        input[type=button].button-primary {
                            background-color: #1a73e8;
                            color: white;
                        }
                        input[type=button].button-primary:hover {
                            background-color: #1765cc;
                        }
                        input[type=button].button-secondary {
                            background-color: white;
                            color: #1a73e8;
                        }
                        input[type=button].button-secondary:hover {
                            background-color: #d2e3fc;
                        }

                        #response-container {
                            background-color: #fff;
                            border: 0;
                            border-radius: 2px;
                            box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
                            margin: 10px;
                            padding: 0 0.5em;
                            font: 400 18px Roboto, Arial, sans-serif;
                            overflow: hidden;
                            overflow: auto;
                            max-height: 50%;
                            max-width: 90%;
                            background-color: rgba(255, 255, 255, 0.95);
                            font-size: small;
                        }

                        #instructions {
                            background-color: #fff;
                            border: 0;
                            border-radius: 2px;
                            box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
                            margin: 10px;
                            padding: 0 0.5em;
                            font: 400 18px Roboto, Arial, sans-serif;
                            overflow: hidden;
                            padding: 1rem;
                            font-size: medium;
                        }


                    </style>--}}
                    <form method="POST" action="{{route('event.store')}}">
                        @csrf

                        <div class="form-row">
                            {{--Nombre--}}
                            <div class="col-md-4">
                                <input id="name" name="name" type="text" placeholder="Nombre del evento" class="form-control @error('name') is-invalid @enderror"  value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            {{--Fecha y hora de inicio del evento--}}
                            <div class="col-md-4">
                                <input id="date_event_ini" name="date_event_ini" type="datetime-local" placeholder="Fecha del evento" class="form-control"  required >
                                <small class="text-white">
                                    {{__('Debe seleccionar la fecha y hora de inicio del evento')}}
                                </small>
                            </div>
                            {{--Fecha y hora de fin del evento--}}
                            <div class="col-md-4">
                                <input id="date_event_end" name="date_event_end" type="datetime-local" placeholder="Fecha del evento" class="form-control"  required >
                                <small class="text-white">
                                    {{__('Debe seleccionar la fecha y hora de finalizacion del evento')}}
                                </small>

                            </div>
                        </div>
                        {{--Descripcion--}}
                        <div class="form-row mt-3">
                            {{--Descripcion--}}
                            <div class="col-md-12">
                                <input id="description" name="description" type="text" placeholder="descripcion del evento" class="form-control @error('description') is-invalid @enderror"  value="{{ old('description') }}" required autocomplete="description" autofocus>
                                <small class="text-white">
                                    {{__('Debe escribir una breve descripcion del evento ')}}
                                </small>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        {{--Direccion--}}
                        <div class="form-row mt-3">
                            {{--Direccion del evento--}}
                            <div class="col-md-12">
                                <input id="address" name="address" type="text" placeholder="Direccion del evento" class="form-control"  required >
                                <small class="text-white">
                                    {{__('Debe ingresar la direccion del evento')}}
                                </small>
                            </div>
                        </div>


                        <div class="row form-group mt-4 mb-0">
                            <div class="col text-center text-white" >
                                <button type="submit" class="btnSubmit text-white" style="background-color: #f05837">
                                    {{ __('Guardar evento') }}
                                </button>
                            </div>
                            <div class="col text-center">
                                <a type="button" class="btnSubmit text-center" style="text-decoration: none; " href="/">Cancelar</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection
