@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.administrations.types.etablissements.create", "permission" => "administrations/types/etablissements/create" , "back" => "web.administrations.index"])
			Gestion des types d'établissements
		@endcomponent

		<div class="col-12">
			@if($etablissements->isEmpty())
				<div class="alert alert-warning">
					Aucun type d'établissement n'est enregistré sur l'application
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
						@foreach($etablissements as $etablissement)
							<tr>
								<td>{{ $etablissement->libelle }}</td>
								<td>
									@hasPermission("administrations/types/etablissements/edit")
									<a href="{{ route("web.administrations.types.etablissements.edit", [$etablissement]) }}">
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
