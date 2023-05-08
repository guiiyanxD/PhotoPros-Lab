@extends('layouts.welcome')

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="container">
            <div class="row justify-content-center mt-4 mb-4">
                <h1 style="font-family:Bahnschrift"> Unete y comienza a trabajar con nuestros partners!</h1>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-12 login-form-2" style="padding: 5%" >
                    <form method="POST" action="{{ route('register',['is_newph'=>true]) }}">
                        @csrf

                        <input type="hidden" name="newph&user">

                        <div class="form-row">
                            {{--Nombre--}}
                            <div class="col-md-4">
                                <input id="name" type="text" placeholder="Nombre" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            {{--Apellido--}}
                            <div class="col-md-4">
                                <input id="lastname" type="text" placeholder="Apellido" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>
                                @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            {{--Fecha de nacimiento--}}
                            <div class="col-md-4">
                                <input id="bday" type="date" placeholder="Fecha de nacimiento" class="form-control" name="bday" required >
                                <small class="text-white">
                                    {{__('Debe tener por lo menos 13 años de edad.')}}
                                </small>

                            </div>
                        </div>

                        <div class="form-row mt-3">
                            {{--Numero de contacto--}}
                            <div class="col-md-4">
                                <input id="telefono" name="telefono" type="number" placeholder="Numero de contacto" class="form-control"  required >
                                <small class="text-white">
                                    {{__('Debe ingresar su numero de contacto')}}
                                </small>
                            </div>
                            {{--precio de contrato--}}
                            <div class="col-md-4">
                                <input id="price" name="price" type="number" class="form-control" placeholder="Costo de contrato"  required>
                                <small class="text-white">
                                    {{__('Ingrese el precio de su servicio')}}
                                </small>
                            </div>

                            <div class="col-md-1">
                                <label class=" text-white">Como cobrar:</label>
                            </div>
                            {{--Preferencia--}}
                            <div class="col-md-3">
                                <div class="form-check-inline">
                                    <label class=" text-white m-1">Por evento</label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="preference" class="custom-control-input form-control" id="customSwitch1">
                                        <label class="custom-control-label text-white" for="customSwitch1">Por fotografia</label>
                                    </div>
                                </div>

                            </div>


                        </div>

                        <div class="form-row mt-3">
                            {{--Categorias--}}
                            <div class="col-md-12">
                                <input id="categories" name="categories" data-role="tagsinput" type="text" class="form-control"  required>
                                <small class="text-white">
                                    {{__('Enter para separar las categorias')}}
                                </small>
                                <script>
                                    (function(){

                                        "use strict"


                                        // Plugin Constructor
                                        var TagsInput = function(opts){
                                            this.options = Object.assign(TagsInput.defaults , opts);
                                            this.init();
                                        }

                                        // Initialize the plugin
                                        TagsInput.prototype.init = function(opts){
                                            this.options = opts ? Object.assign(this.options, opts) : this.options;

                                            if(this.initialized)
                                                this.destroy();

                                            if(!(this.orignal_input = document.getElementById(this.options.selector)) ){
                                                console.error("tags-input couldn't find an element with the specified ID");
                                                return this;
                                            }

                                            this.arr = [];
                                            this.wrapper = document.createElement('div');
                                            this.input = document.createElement('input');
                                            init(this);
                                            initEvents(this);

                                            this.initialized =  true;
                                            return this;
                                        }

                                        // Add Tags
                                        TagsInput.prototype.addTag = function(string){

                                            if(this.anyErrors(string))
                                                return ;

                                            this.arr.push(string);
                                            var tagInput = this;

                                            var tag = document.createElement('span');
                                            tag.className = this.options.tagClass;
                                            tag.innerText = string;

                                            var closeIcon = document.createElement('a');
                                            closeIcon.innerHTML = '&times;';

                                            // delete the tag when icon is clicked
                                            closeIcon.addEventListener('click' , function(e){
                                                e.preventDefault();
                                                var tag = this.parentNode;

                                                for(var i =0 ;i < tagInput.wrapper.childNodes.length ; i++){
                                                    if(tagInput.wrapper.childNodes[i] == tag)
                                                        tagInput.deleteTag(tag , i);
                                                }
                                            })


                                            tag.appendChild(closeIcon);
                                            this.wrapper.insertBefore(tag , this.input);
                                            this.orignal_input.value = this.arr.join(',');

                                            return this;
                                        }

                                        // Delete Tags
                                        TagsInput.prototype.deleteTag = function(tag , i){
                                            tag.remove();
                                            this.arr.splice( i , 1);
                                            this.orignal_input.value =  this.arr.join(',');
                                            return this;
                                        }

                                        // Make sure input string have no error with the plugin
                                        TagsInput.prototype.anyErrors = function(string){
                                            if( this.options.max != null && this.arr.length >= this.options.max ){
                                                console.log('max tags limit reached');
                                                return true;
                                            }

                                            if(!this.options.duplicate && this.arr.indexOf(string) != -1 ){
                                                console.log('duplicate found " '+string+' " ')
                                                return true;
                                            }

                                            return false;
                                        }

                                        // Add tags programmatically
                                        TagsInput.prototype.addData = function(array){
                                            var plugin = this;

                                            array.forEach(function(string){
                                                plugin.addTag(string);
                                            })
                                            return this;
                                        }

                                        // Get the Input String
                                        TagsInput.prototype.getInputString = function(){
                                            return this.arr.join(',');
                                        }


                                        // destroy the plugin
                                        TagsInput.prototype.destroy = function(){
                                            this.orignal_input.removeAttribute('hidden');

                                            delete this.orignal_input;
                                            var self = this;

                                            Object.keys(this).forEach(function(key){
                                                if(self[key] instanceof HTMLElement)
                                                    self[key].remove();

                                                if(key != 'options')
                                                    delete self[key];
                                            });

                                            this.initialized = false;
                                        }

                                        // Private function to initialize the tag input plugin
                                        function init(tags){
                                            tags.wrapper.append(tags.input);
                                            tags.wrapper.classList.add(tags.options.wrapperClass);
                                            tags.orignal_input.setAttribute('hidden' , 'true');
                                            tags.orignal_input.parentNode.insertBefore(tags.wrapper , tags.orignal_input);
                                        }

                                        // initialize the Events
                                        function initEvents(tags){
                                            tags.wrapper.addEventListener('click' ,function(){
                                                tags.input.focus();
                                            });


                                            tags.input.addEventListener('keydown' , function(e){
                                                var str = tags.input.value.trim();

                                                if( !!(~[9 , 13 , 188].indexOf( e.keyCode ))  )
                                                {
                                                    e.preventDefault();
                                                    tags.input.value = "";
                                                    if(str != "")
                                                        tags.addTag(str);
                                                }

                                            });
                                        }


                                        // Set All the Default Values
                                        TagsInput.defaults = {
                                            selector : '',
                                            wrapperClass : 'tags-input-wrapper',
                                            tagClass : 'tag',
                                            max : null,
                                            duplicate: false
                                        }

                                        window.TagsInput = TagsInput;

                                    })();

                                    var tagInput1 = new TagsInput({
                                        selector: 'categories',
                                        duplicate : false,
                                        max : 10
                                    });

                                </script>
                                <style>

                                    .tags-input-wrapper{
                                        background: #fff;
                                        padding: 3px;
                                        border-radius: 5px;
                                        max-width: 100%;
                                        height: calc(1.6em + 0.75rem + 2px);
                                        border: 1px solid #ced4da;
                                    }
                                    .tags-input-wrapper input{
                                        border: none;
                                        background: whitesmoke;
                                        outline: none;
                                        width: 140px;
                                        margin-left: 8px;
                                    }
                                    .tags-input-wrapper .tag{
                                        display: inline-block;
                                        background-color: #f05837;
                                        color: white;
                                        border-radius: 40px;
                                        padding: 0px 3px 0px 7px;
                                        margin-right: 2px;
                                        margin-bottom:2px;
                                    }
                                    .tags-input-wrapper .tag a {
                                        margin: 0 7px 3px;
                                        display: inline-block;
                                        cursor: pointer;
                                    }
                                </style>
                            </div>
                        </div>

                        <div class="form-row mt-3">
                            {{--Email--}}
                            <div class="col-md-4 ">
                                <input id="email" type="email" placeholder="Correo electronico" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            {{--Password--}}
                            <div class="col-md-4">
                                <input id="password" type="password" placeholder="Contraseña" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <small class="text-white">
                                    {{__('Debe tener 8 caracteres de longitud')}}
                                </small>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            {{--ConfirmPassword--}}
                            <div class="col-md-4">
                                <input id="password-confirm" type="password" placeholder="Confirmar contraseña" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <small class="text-white">
                                    {{__('Debe tener 8 caracteres de longitud')}}
                                </small>
                            </div>
                        </div>


                        <div class="row form-group mt-4 mb-0">
                            <div class="col text-center text-white" >
                                <button type="submit" class="btnSubmit text-white" style="background-color: #f05837">
                                    {{ __('Registrar') }}
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
@endsection
