@extends('layouts.app')

@section('content')

	<div class="container">

		<div class="row">
			<div class="offset-md-3 col-6 text-md-center">
				<h1 class="display-5">Items</h1>
			</div>
			<div class="col-md-3 col-6 d-flex align-items-center justify-content-end">
				<a href="{{ route('panel.items.create') }}" class="btn btn-primary"><i class="fa fa-plus mr-1"></i>Agregar</a>
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
						<caption>Lista de items, ordenado por categoria</caption>
					</div>

					<div class="card-body table-responsive p-0">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th>#</th>
									<th>Nombre</th>
									<th>Precio</th>
									<th>Stock</th>
									<th>Categoria</th>
									<th>Creada el</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
							@foreach($items as $item)
								<tr>
									<td class="text-muted"><i>{{ $item->id }}</i></td>
									<td>{{ $item->name }}</td>
									<td>${{ $item->price }}</td>
									<td>{{ $item->stock }}</td>
									<td>{{ $item->category->name }}</td>
									<td>{{ $item->created_at->format("d/m/Y, H:i") }} hs.</td>				
									<td class="d-flex">
										<a href="{{route('panel.items.show', ['id' => $item->id])}}" class="btn btn-dark mx-1"><i class="fa fa-search mr-1"></i>Ver</a>			    					
										<a href="{{route('panel.items.edit', ['id' => $item->id])}}" class="btn btn-light mx-1"><i class="fa fa-pencil mr-1"></i>Editar</a>
										
										<form action="{{ route('panel.items.destroy', ['id' => $item->id]) }}" method="POST">
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