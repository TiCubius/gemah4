@extends('web._includes._master')
@php($title = "Profil de l'établissement {$etablissement->nom}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.etablissements.index"])
			Profil de l'établissement "{{ $etablissement->nom }}"

			@slot("custom")
				<div class="btn-group">
					<div class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Gestion établissement
					</div>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
						@hasPermission("scolarites/etablissements/edit")
						<a class="dropdown-item" href="{{ route("web.scolarites.etablissements.edit", [$etablissement]) }}">Éditer l'établissement</a>
						@endHas
					</div>
				</div>
			@endslot
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
					@foreach($etablissement->eleves as $eleve)
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