@extends('web._includes._master')
@php($title = "Gestion des types de décision")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.administrations.types.decisions.create", "permission" => "administrations/types/decisions/create", "back" => "web.administrations.index"])
			Gestion des types de décision
		@endcomponent

		<div class="col-12">
			@if($types->isEmpty())
				<div class="alert alert-warning">
					Aucun type de décision n'est enregistré sur l'application
				</div>

			@else
				<table class="table table-sm table-hover text-center">
					<thead class="gemah-bg-primary">
						<tr>
							<th>Libellé</th>
							<th>Actions</th>
						</tr>
					</thead>

					<tbody>
						@foreach($types as $type)
							<tr>
								<td>{{ $type->libelle }}</td>
								<td>
									@hasPermission("administrations/types/decisions/edit")
									<a href="{{ route("web.administrations.types.decisions.edit", [$type]) }}">
										<button class="btn btn-sm btn-outline-primary">Éditer</button>
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
