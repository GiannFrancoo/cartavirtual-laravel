@extends('layouts.app')

@section('content')    

    <div class="container">

        @if(Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif

        <div class="row">

            @if (auth()->user()->role_id == \App\Models\Role::ADMIN)          
                <div class="col-md-4 col-12 pb-5">                 
                    <div class="card text-center">
                        <img src="{{ asset('images/birra.jpg') }}" class="card-img-top" alt="imagen categoria">
                        <div class="card-body">
                        <a href="{{ route('panel.categories.index') }}" class="btn btn-secondary"> <i class="fa fa-book mr-1"></i>Categorias</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-12 pb-5">    
                    <div class="card text-center">
                        <img src="{{ asset('images/hamburguesas.jpg') }}" class="card-img-top" alt="imagen items">
                        <div class="card-body">
                        <a href="{{ route('panel.items.index') }}" class="btn btn-secondary"> <i class="fa fa-book mr-1"></i>Items</a>
                        </div>
                    </div>  
                </div>
            @endif

            <div class="col-md-4 col-12 pb-5">  
                <div class="card text-center">
                    <img src="{{ asset('images/pizzas.jpg') }}" class="card-img-top" alt="imagen ordenes">
                    <div class="card-body">
                      <a href="{{ route('panel.orders.index') }}" class="btn btn-secondary"> <i class="fa fa-book mr-1"></i>Ordenes</a>
                    </div>
                </div>    
            </div>

        </div>
    </div>

@stop
