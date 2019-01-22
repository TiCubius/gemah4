@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.administrations.etablissements.types.create", "back" => "web.administrations.index"])
			Gestion des types d'établissements
		@endcomponent

		<div class="col-12">
			@if($types_etablissements->isEmpty())
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
						@foreach($types_etablissements as $types_etablissement)
							<tr>
								<td>{{ $types_etablissement->libelle }}</td>
								<td>
									<a href="{{ route("web.administrations.etablissements.types.edit", [$types_etablissement]) }}">
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
