@extends('web._includes._master')
@php($title = "Profil de l'état administratif {$administratif->libelle}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.materiels.etats.administratifs.index"])
			Profil de l'état administratif "{{ $administratif->libelle }}"

			@slot("custom")
				<div class="btn-group">
					<div class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Gestion état administratif
					</div>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
						@hasPermission("administrations/etats/materiels/administratifs/edit")
						<a class="dropdown-item" href="{{ route("web.administrations.materiels.etats.administratifs.edit", [$administratif]) }}">Éditer l'état administratif</a>
						@endHas
					</div>
				</div>
			@endslot
		@endcomponent

		@component("web._includes.components.show_card", ["title" => "Matériels", "id" => "materiel"])
			<table id="materiels" class="table" width="100%">
				<thead>
					<tr class="align-middle">
						<th class="align-middle"><strong>Type</strong></th>
						<th class="align-middle"><strong>Marque</strong></th>
						<th class="align-middle"><strong>Modèle</strong></th>
						<th class="align-middle"><strong>Numéro de Série</strong></th>
						<th class="align-middle"><strong>Prix TTC</strong></th>
						<th class="align-middle"><strong>Assigné à</strong></th>
						<th class="align-middle"><strong>Date de prêt</strong></th>
						<th class="align-middle"><strong>Etat physique</strong></th>
						<th class="align-middle" width="116px"><strong>Actions</strong></th>
					</tr>
				</thead>
				<tbody>
					@foreach($administratif->materiels as $materiel)
						<tr>
							<td>{{ $materiel->type->libelle }}</td>
							<td>{{ $materiel->marque }}</td>
							<td>{{ $materiel->modele }}</td>
							<td>{{ $materiel->numero_serie }}</td>
							<td>{{ $materiel->prix_ttc }}</td>
							@isset($materiel->eleve)
								<td>
									@hasPermission("eleves/show")
									<a href="{{ route("web.scolarites.eleves.show", [$materiel->eleve]) }}">{{ "{$materiel->eleve->nom} {$materiel->eleve->prenom}" }}</a>
									@endHas
								</td>
							@else
								<td></td>
							@endisset
							<td>{{ $materiel->date_pret ? $materiel->date_pret->format("d/m/Y") : null }}</td>
							<td>{{ $materiel->etatPhysique->libelle }}</td>
							<td>
								@hasPermission("materiels/stocks/show")
								<a class="btn btn-sm btn-outline-primary" href="{{ route("web.materiels.stocks.show", [$materiel]) }}">
									<i class="fas fa-info-circle"></i>
									Détails
								</a>
								@endHas
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@endcomponent
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.administrations.materiels.etats.administratifs.destroy", "id" => $administratif])
		@slot("name")
			{{ $administratif->libelle }}
		@endslot
	@endcomponent

@endsection
@section("scripts")
	{{-- Matériels --}}
	<script>
		$(document).ready(function () {
			$('#materiels').DataTable({
				"language": {
					"url": "{{ asset("assets/js/dataTables.french.json") }}",
				},
				"info": false,
				"columnDefs": [
					{"orderable": false, "targets": 1},
				],
				"pageLength": 10,
				"fnInitComplete": function () {
					$("#materiels").show()
				},
			})
		})
	</script>
@endsection
