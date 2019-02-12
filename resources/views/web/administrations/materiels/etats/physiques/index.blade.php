@extends("web._includes._master")
@php($title = "Gestion des états physiques matériel")

@section("content")
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.administrations.materiels.etats.physiques.create", "permission" => "administrations/etats/materiels/physiques/create", "back" => "web.administrations.index"])
			Gestion des états physiques matériel
		@endcomponent

		<div class="col-12">
			@if($etats->isEmpty())
				<div class="alert alert-warning">
					Aucun état physique matériel n'est enregistré sur l'application
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
						@foreach($etats as $etat)
							<tr>
								<td>{{ $etat->libelle }}</td>
								<td>
									@hasPermission("administrations/etats/materiels/physiques/show")
									<a href="{{ route("web.administrations.materiels.etats.physiques.show", [$etat]) }}">
										<button class="btn btn-sm btn-outline-primary">
											<i class="fas fa-info-circle"></i>
											Détails
										</button>
									</a>
									@endHas
									@hasPermission("administrations/etats/materiels/physiques/edit")
									<a href="{{ route("web.administrations.materiels.etats.physiques.edit", [$etat]) }}">
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