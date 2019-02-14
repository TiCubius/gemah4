@extends('web._includes._master')@php($title = "Gestion des types matériel")

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
									<div class="btn-group">
										@hasPermission("materiels/types/show")
										<a class="btn btn-sm btn-outline-primary" href="{{ route("web.materiels.types.show", [$type]) }}">
											<i class="fas fa-info-circle"></i>
											Détails
										</a>
										@endHas
										@hasPermission("materiels/types/edit")
										<a class="btn btn-sm btn-outline-primary" href="{{ route("web.materiels.types.edit", [$type]) }}">
											Éditer
										</a>
										@endHas
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
		</div>
	</div>
@endsection
