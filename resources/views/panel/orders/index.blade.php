@extends('layouts.app')

@section('content')

	<div class="container">

		<div class="row">
			<div class="offset-md-3 col-6 text-md-center">
				<h1 class="display-5">Ordenes</h1>
			</div>
			<div class="col-md-3 col-6 d-flex align-items-center justify-content-end">
				<a href="{{ route('panel.orders.create') }}" class="btn btn-primary"><i class="fa fa-plus mr-1"></i>Agregar</a>
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
					<div class="card-footer">
						<caption>Lista de ordenes, ordenado por fecha</caption>
					</div>

					<div class="card-body table-responsive p-0">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th>#</th>
									<th>Fecha</th>
									<th>Estado</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
							@foreach($orders as $order)
								<tr>
									<td class="text-muted"><i>{{ $order->id }}</i></td>
									<td>{{ $order->created_at->format("d/m/Y, H:i") }} hs.</td>
									<td>
										{{ ($order->closed)? "Cerrada" : "Abierta" }}
									</td>
									<td class="d-flex">
										<a href="{{route('panel.orders.show', ['id' => $order->id])}}" class="btn btn-dark mx-1"><i class="fa fa-search mr-1"></i>Ver</a>			    															
										
										@if ($order->closed == 0)											
										<form action="{{ route('panel.orders.close', ['id' => $order->id]) }}" method="POST">
											@csrf
											@method("PUT")
											<button class="btn btn-secondary mx-1" type="submit"><i class="fa fa-window-close mr-1"></i>Cerrar</button>
										</form>
										@endif										
										<form action="{{ route('panel.orders.destroy', ['id' => $order->id]) }}" method="POST">
											@csrf
											@method("DELETE")
											<button class="btn btn-danger mx-1" type="submit"><i class="fa fa-trash mr-1"></i>Eliminar</button>
										</form>										
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
        
	</div>
@stop