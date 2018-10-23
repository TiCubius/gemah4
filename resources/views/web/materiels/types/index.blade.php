@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.materiels.types.create", "back" => "web.materiels.index"])
			Gestion des Types Matériel
		@endcomponent

		<div class="col-12">
			@if($types->isEmpty())
				<div class="alert alert-warning">
					Aucun type n'est enregistré sur l'application
				</div>
			@else
				<table class="table table-sm table-hover text-center">
					<thead class="gemah-bg-primary">
						<tr>
							<th>Nom</th>
							<th>Domaine</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($types as $type)
							<tr>
								<th>{{ $type->nom }}</th>
								<th>{{ $type->domaine->nom }}</th>
								<td>
									<a href="{{ route("web.materiels.types.edit", [$type->id]) }}">
										<button class="btn btn-sm btn-outline-primary">Editer</button>
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
		</div>
	</div>
@endsection
