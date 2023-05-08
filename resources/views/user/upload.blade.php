[@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <h1>
                    Fotos de perfil
                </h1>
            </div>
            <div class="col-md-12">
                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">{{ __('Cuentanos sobre ti') }}</div>
                    <div class="card-body" style="">
                        <form method="POST" action="{{route('user.upload_profile_picture')}}" enctype="multipart/form-data">
                            @csrf
                            <label for="imageProfile"> Escoja una imagen para subir</label>
                            <input class="" type="file" name="imageProfile" accept="image/*">

                            <div class="row m-4 text-center">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-outline-danger">
                                        Subir imagen
                                    </button>
                                </div>
                                <div>
                                    <div class="col-md-6">
                                        <a type="button" href="{{route('home')}}" class="btn btn-outline-dark">
                                            cancelar
                                        </a>
                                    </div>
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
