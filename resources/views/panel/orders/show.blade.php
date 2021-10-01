@extends('layouts.app')

@section('content')

	<div class="container">
      
        <div class="row">
			<div class="offset-md-3 col-6 text-md-center">
				<h1 class="display-5">Orden</h1>
			</div>
			<div class="col-md-3 col-6 d-flex align-items-center justify-content-end">
				<a href="{{ route('panel.orders.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left mr-1"></i>Volver</a>
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
                    <div class="card-body p-0">

                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td><strong>Mozo</strong></td>
                                    <td>{{ $order->user->name}}</td>
                                </tr>

                                <tr>
                                    <td><strong>Descripcion</strong></td>
                                    <td>{{ $order->description }}</td>
                                </tr>

                                <tr>                                                                    
                                    <td><strong>Estado</strong></td>
                                    <td class="d-flex items-aling-center">{{ ($order->closed)? "Cerrada" : "Abierta" }} 
                                    @if ($order->closed == 0)
                                        <form action="{{ route('panel.orders.close', ['id' => $order->id]) }}" method="POST">
                                            @csrf
                                            @method("PUT")
                                            <button class="btn btn-sm submit btn-dark mx-2"><i class="fa fa-window-close mr-1"></i>Cerrar</a></button>
                                        </form>
                                    @endif   
                                    </td>                                                        
                                </tr>
                                
                                <tr>
                                    <td><strong>Fecha</strong></td>
                                    <td>{{ $order->created_at->format("d/m/Y, H:i")}} hrs.</td>
                                </tr>
                                
                                <tr>
                                    <td><strong>Items</strong></td>
                                    <td>
                                        <ul class="table table-striped px-3">
                                            @foreach ($order->items as $item)                                        
                                                <li>
                                                    <div class="d-flex">
                                                        <p>{{ $item->name }} x{{ $item->pivot->quantity }}</p>
                                                        @if ($order->closed == 0)
                                                        <form action="{{ route('panel.orders.items.destroy', ['id' => $order->id, 'item_id' => $item->id]) }}" method="POST">
                                                            @csrf
                                                            @method("DELETE")
                                                            <button class="btn btn-sm btn-danger ml-3" type="submit"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td>${{ $total }}</td>
                                </tr>

                            </tbody>
                        </table>			

                    </div>
                </div>

                @if ($order->closed == 0)
                <div class="card mt-3">
                    <div class="card-header">Agregar item a la orden</div>
                    <div class="card-body">
                        <form action="{{ route('panel.orders.addItem', ['id' => $order->id]) }}" method="POST">
                            @csrf                            
                            @method("PUT")

                            <div class="form-group">
                                <label for="item_id">Items: <span class="text-danger">*</span></label>
                                <select
                                    id="item_id"
                                    class="form-control @error('item_id') is-invalid @enderror"
                                    name="item_id"
                                    required autocomplete="item_id" autofocus
                                >

                                    @foreach ($items as $item)
                                        <option
                                            value="{{ $item->id }}"
                                            {{ old('item_id') == $item->id ? "selected" : "" }}
                                        >
                                            {{ $item->name }}
                                        </option>   
                                    @endforeach
                                </select>


                                @error('item_id')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div> 

                            <div class="form-group">
                                <label for="quantity">Cantidad: <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" min="1" value="1" name="quantity">
                            </div>

                            <div class="form-group d-flex justify-content-end">
                                <button class="btn btn-primary"><i class="fa fa-floppy-o mr-1"></i>Agregar item</button>
                            </div>

                        </form>
                    </div>
                </div>
                @endif

            </div>
	
        </div>   
         
    </div>
@stop