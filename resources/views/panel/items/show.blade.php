@extends('layouts.app')

@section('content')

	<div class="container">

		<div class="row">
			<div class="offset-md-3 col-6 text-md-center">
				<h1 class="display-5">Item</h1>
			</div>
			<div class="col-md-3 col-6 d-flex align-items-center justify-content-end">
				<a href="{{ route('panel.items.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left mr-1"></i>Volver</a>
			</div>
		</div>		
	
		<div class="row">
			<div class="col-12 col-md-6 offset-md-3 ">		
				<div class="card text-center">

					<div class="card-header">
						@if($item->image)						
							<img class="mw-100" src="data:image/jpeg;base64,{{ $item->image }}" alt="Logo {{ $item->name }}">
						@else	
							No se subio imagen										
						@endif
					</div>


					<div class="card-body">
						<h3 class="card-title display-5">{{ $item->name }}</h3>
						
						<p class="card-text">{{ $item->description }}</p>

						<div class="d-flex align-items-center justify-content-center">
							<a href="{{route('panel.items.edit', ['id' => $item->id])}}" class="btn btn-dark mx-1"><i class="fa fa-pencil mr-1"></i>Editar</a>
							<form action="{{ route('panel.items.destroy', ['id' => $item->id]) }}" method="POST">
								@csrf
								@method("DELETE")
								<button class="btn btn-danger mx-1" type="submit"><i class="fa fa-trash mr-1"></i>Eliminar</button>
							</form>
						</div>

					</div>

				</div>
			</div>
		</div>

	</div>

    
@stop