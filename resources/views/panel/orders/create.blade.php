@extends('layouts.app')

@section('content')   

    <div class="container">
  
        <div class="row">            
			<div class="offset-md-3 col-6 text-md-center">
				<h1 class="display-5">Ordenes</h1>
			</div>          
			<div class="col-md-3 col-6 d-flex align-items-center justify-content-end">
				<a href="{{ route('panel.orders.index') }}" class="btn btn-secondary"> <i class="fa fa-arrow-left mr-1"></i>Volver</a>
			</div>
		</div>


        <div class="row">
            <div class="col-12">
                @if(Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif
                

                <div class="card">
                    <div class="card-header">Cargar orden</div>
                    <div class="card-body">
                        <form action="{{ route('panel.orders.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf                           

                            <div class="form-group">
                                <label for="user_id">Mozo: <span class="text-danger">*</span></label>
                                <select
                                    id="user_id"
                                    class="form-control @error('user_id') is-invalid @enderror"
                                    name="user_id"
                                    required autocomplete="user_id" autofocus
                                >

                                    @foreach ($waiters as $waiter)
                                        <option
                                            value="{{ $waiter->id }}"
                                            {{ old('user_id') == $waiter->id ? "selected" : "" }}
                                        >
                                            {{ $waiter->name }}
                                        </option>   
                                    @endforeach
                                </select>


                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div> 

                            <div class="form-group">
                                <label for="closed">Estado: <span class="text-danger">*</span></label>
                                <select
                                    id="closed"
                                    class="form-control @error('closed') is-invalid @enderror"
                                    name="closed"
                                    required autocomplete="closed" autofocus
                                >                                    
                                    <option value="0" {{ old('closed') == 0 ? "selected" : "" }}>Abierta</option>  
                                    <option value="1" {{ old('closed') == 1 ? "selected" : "" }}>Cerrada</option> 
                                        
                                </select>

                                @error('closed')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div> 
                            
                            <div class="form-group">                            
                                <label for="description">Descripción:</label>
                                <textarea 
                                    rows="3"
                                    class="form-control @error('description') is-invalid @enderror"
                                    name="description"
                                >{{ old('description') }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>   

                            <div class="form-group d-flex justify-content-end">
                                <button class="btn btn-primary"><i class="fa fa-floppy-o ml-1"></i>Guardar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@stop
