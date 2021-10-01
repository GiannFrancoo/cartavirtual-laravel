@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">            
			<div class="offset-md-3 col-6 text-md-center">
				<h1 class="display-5">Categorias</h1>
			</div>          
			<div class="col-md-3 col-6 d-flex align-items-center justify-content-end">
				<a href="{{ route('panel.categories.index') }}" class="btn btn-secondary"> <i class="fa fa-arrow-left mr-1"></i>Volver</a>
			</div>
		</div>


        <div class="row">
            <div class="col-12">
                @if(Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">Cargar categoria</div>
                    <div class="card-body">
                        <form action="{{ route('panel.categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="name">Nombre: <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required autocomplete="off" autofocus
                                >

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="image">Imagen:</label>
                                <input
                                    type="file"
                                    class="form-control @error('image') is-invalid @enderror"
                                    name="image"
                                >

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary"><i class="fa fa-floppy-o mr-1"></i>Guardar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
