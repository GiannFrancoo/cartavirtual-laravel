@extends('layouts.app')

@section('content')


    <div class="container">

        <div class="row">            
			<div class="offset-md-3 col-6 text-md-center">
				<h1 class="display-5">Items</h1>
			</div>          
			<div class="col-md-3 col-6 d-flex align-items-center justify-content-end">
				<a href="{{ route('panel.items.index') }}" class="btn btn-secondary"> <i class="fa fa-arrow-left mr-1"></i>Volver</a>
			</div>
		</div>       

        <div class="row">
            <div class="col-12">
                @if(Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">Editar item</div>
                    <div class="card-body">
                        <form action="{{ route('panel.items.update',["id" => $item->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")

                            <div class="form-group">
                                <label for="name">Nombre: <span class="text-danger">*</span></label>

                                <input
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    name="name"
                                    value="{{ old('name') ?? $item->name }}"
                                    required autocomplete="off" autofocus
                                >

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="price">Precio: <span class="text-danger">*</span></label>

                                <input
                                    type="text"
                                    class="form-control @error('price') is-invalid @enderror"
                                    name="price"
                                    value="{{ old('price') ?? $item->price }}"
                                    required autocomplete="off" autofocus
                                >

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="stock">Stock: <span class="text-danger">*</span></label>

                                <input
                                    type="text"
                                    class="form-control @error('stock') is-invalid @enderror"
                                    name="stock"
                                    value="{{ old('stock') ?? $item->stock }}"
                                    required autocomplete="off" autofocus
                                >

                                @error('stock')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                                             
                            <div class="form-group">
                                <label for="category_id">Categoria: <span class="text-danger">*</span></label>
                                <select
                                    id="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror"
                                    name="category_id"
                                    required autocomplete="category_id" autofocus
                                >

                                    @foreach ($categories as $category)
                                        <option
                                            value="{{ $category->id }}"
                                            {{ old('category_id', $item->category_id) == $category->id ? "selected" : "" }}
                                        >
                                            {{ $category->name }}
                                        </option>   
                                    @endforeach
                                </select>


                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>                           

                            <div class="form-group">                            
                                <label for="description">Descripción: <span class="text-danger">*</span></label>

                                <textarea                                    
                                    rows="3"
                                    class="form-control @error('description') is-invalid @enderror"
                                    name="description"
                                    required autocomplete="off" autofocus
                                >{{ old('description') ?? $item->description }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group form-check">
                                <input  
                                    class="form-check-input"
                                    type="checkbox"
                                    value="true"
                                    name="noImage"
                                >
                                <label class="form-check-label" for="defaultCheck">
                                    ¿Desea borrar la imagen?
                                </label>


                                @error('noImage')
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

                            @if ($item->image)
                                <div class="form-group">
                                    <img class="mw-100" src="data:image/jpeg;base64,{{ $item->image }}" alt="Imagen de {{ $category->name }}">
                                </div>
                            @endif

                            <div class="form-group">
                                <button class="btn btn-primary"><i class="fa fa-pencil ml-1"></i>Actualizar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

@stop
