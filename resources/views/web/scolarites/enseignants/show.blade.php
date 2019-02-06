@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.enseignants.index"])
			Profil de l'enseignant "{{ $enseignant->nom }} {{ $enseignant->prenom }}"

			@slot("custom")
				<div class="btn-group">
					<div class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Gestion enseignant
					</div>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
						@hasPermission("scolarites/enseignants/edit")
						<a class="dropdown-item" href="{{ route("web.scolarites.enseignants.edit", []) }}">Éditer l'enseignant</a>
						@endHas
					</div>
				</div>
			@endslot
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
					@foreach($enseignant->etablissements as $etablissement)
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
	</div>
@endsection
@section("scripts")
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
@endsection