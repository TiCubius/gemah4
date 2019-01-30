@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.materiels.types.create", "permission" => "materiels/types/create", "back" => "web.materiels.index"])
			Gestion des types matériel
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
							<th>Domaine</th>
							<th>Nom</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($types as $type)
							<tr>
								<td>{{ $type->domaine->libelle }}</td>
								<td>{{ $type->libelle }}</td>
								<td>
									@hasPermission("materiels/types/edit")
									<a href="{{ route("web.materiels.types.edit", [$type]) }}">
										<button class="btn btn-sm btn-outline-primary">Editer</button>
									</a>
									@endHas
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
		</div>
	</div>
@endsection
