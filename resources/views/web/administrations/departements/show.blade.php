@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.departements.index"])
			Profil du département "{{ $departement->nom }}"

			@slot("custom")
				<div class="btn-group">
					<div class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Gestion département
					</div>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
						@hasPermission("administrations/departements/edit")
						<a class="dropdown-item" href="{{ route("web.administrations.departements.edit", [$departement]) }}">Éditer le département</a>
						@endHas
					</div>
				</div>
			@endslot
		@endcomponent

		@component("web._includes.components.show_card", ["title" => "Services", "id" => "service"])
			<table id="services" class="table" width="100%">
				<thead>
					<tr>
						<td><strong>Nom</strong></td>
						<td><strong>Action</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($departement->services as $service)
						<tr>
							<td>{{ $service->nom }}</td>
							<td>
								@hasPermission("administrations/services/show")
								<a href="{{ route("web.administrations.services.show", [$service]) }}" class="btn btn-outline-primary" type="btn">
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

		@component("web._includes.components.show_card", ["title" => "Etablissements", "id" => "etablissement"])
			<table id="etablissements" class="table" width="100%">
				<thead>
					<tr>
						<td><strong>Nom</strong></td>
						<td><strong>Action</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($departement->etablissements as $etablissement)
						<tr>
							<td>{{ $etablissement->nom }}</td>
							<td>
								@hasPermission("etablissements/show")
								<a href="{{ route("web.scolarites.etablissements.show", [$etablissement]) }}" class="btn btn-outline-primary" type="btn">
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

		@component("web._includes.components.show_card", ["title" => "Eleves", "id" => "eleve"])
			<table id="eleves" class="table" width="100%">
				<thead>
					<tr class="align-middle">
						<th class="align-middle"><strong>Nom</strong></th>
						<th class="align-middle"><strong>Prénom</strong></th>
						<th class="align-middle"><strong>Date de naissance</strong></th>
						<th class="align-middle" width="116px"><strong>Actions</strong></th>
					</tr>
				</thead>
				<tbody>
					@foreach($departement->eleves as $eleve)
						<tr>
							<td>{{ $eleve->nom }}</td>
							<td>{{ $eleve->prenom }}</td>
							<td>{{ \Carbon\Carbon::parse($eleve->date_naissance)->format("d/m/Y") }}</td>
							<td>
								@hasPermission("eleves/show")
								<a href="{{ route("web.scolarites.eleves.show", [$eleve]) }}" class="btn btn-outline-primary" type="btn">
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

		@component("web._includes.components.show_card", ["title" => "Materiels", "id" => "materiel"])
			<table id="materiels" class="table" width="100%">
				<thead>
					<tr class="align-middle">
						<th class="align-middle"><strong>Etat</strong></th>
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
					@foreach($departement->materiels as $materiel)
						<tr>
							<td class="couleur" data-toggle="tooltip" data-placement="bottom" title="{{ $materiel->etatAdministratif->libelle }}" style="width: 57px; background:{{ $materiel->etatAdministratif->couleur }}"></td>
							<td>{{ $materiel->type->libelle }}</td>
							<td>{{ $materiel->marque }}</td>
							<td>{{ $materiel->modele }}</td>
							<td>{{ $materiel->numero_serie }}</td>
							<td>{{ $materiel->prix_ttc }}</td>
							@isset($materiel->eleve)
								<td>
									@hasPermission("eleves/show")
									<a href="{{ route("web.scolarites.eleves.show", [$materiel->eleve]) }}">
										{{ "{$materiel->eleve->nom} {$materiel->eleve->prenom}" }}
									</a>
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
									Détail
								</a>
								@endHas
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@endcomponent

		@component("web._includes.components.show_card", ["title" => "Responsables", "id" => "responsable"])
			<table id="responsables" class="table" width="100%">
				<thead>
					<tr class="align-middle">
						<th class="align-middle">Nom</th>
						<th class="align-middle">Prénom</th>
						<th class="align-middle">Adresse E-Mail</th>
						<th class="align-middle">Téléphone</th>
						<th class="align-middle" width="116px">Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($departement->responsables as $responsable)
						<tr>
							<td>{{ $responsable->nom }}</td>
							<td>{{ $responsable->prenom }}</td>
							<td>{{ $responsable->email}}</td>
							<td>{{ $responsable->telephone }}</td>
							<td>
								@hasPermission("responsables/show")
								<a href="{{ route("web.responsables.show", [$responsable]) }}" class="btn btn-outline-primary" type="btn">
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
@endsection
@section("scripts")
	{{-- Services --}}
	<script>
		$(document).ready(function () {
			$('#services').DataTable({
				"language": {
					"url": "{{ asset("assets/js/dataTables.french.json") }}",
				},
				"info": false,
				"columnDefs": [
					{"orderable": false, "targets": 1},
				],
				"pageLength": 10,
				"fnInitComplete": function () {
					$("#services").show()
				},
			})
		})
	</script>

	{{-- Etablissements --}}
	<script>
		$(document).ready(function () {
			$('#etablissements').DataTable({
				"language": {
					"url": "{{ asset("assets/js/dataTables.french.json") }}",
				},
				"info": false,
				"columnDefs": [
					{"orderable": false, "targets": 1},
				],
				"pageLength": 10,
				"fnInitComplete": function () {
					$("#etablissements").show()
				},
			})
		})
	</script>

	{{-- Eleves --}}
	<script>
		$(document).ready(function () {
			$('#eleves').DataTable({
				"language": {
					"url": "{{ asset("assets/js/dataTables.french.json") }}",
				},
				"info": false,
				"columnDefs": [
					{"orderable": false, "targets": 1},
				],
				"pageLength": 10,
				"fnInitComplete": function () {
					$("#eleves").show()
				},
			})
		})
	</script>

	{{-- Materiels --}}
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

	{{-- Responsables --}}
	<script>
		$(document).ready(function () {
			$('#responsables').DataTable({
				"language": {
					"url": "{{ asset("assets/js/dataTables.french.json") }}",
				},
				"info": false,
				"columnDefs": [
					{"orderable": false, "targets": 1},
				],
				"pageLength": 10,
				"fnInitComplete": function () {
					$("#responsables").show()
				},
			})
		})
	</script>
@endsection