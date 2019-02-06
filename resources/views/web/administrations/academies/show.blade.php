@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.academies.index"])
			Profil de l'académie "{{ $academie->nom }}"

			@slot("custom")
				<div class="btn-group">
					<div class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Gestion académie
					</div>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
						@hasPermission("administrations/academies/edit")
						<a class="dropdown-item" href="{{ route("web.administrations.academies.edit", [$academie]) }}">Éditer l'académie</a>
						@endHas
					</div>
				</div>
			@endslot
		@endcomponent

		@component("web._includes.components.show_card", ["title" => "Départements", "id" => "departement"])
			<table id="departements" class="table" width="100%">
				<thead>
					<tr>
						<td><strong>Nom</strong></td>
						<td><strong>Action</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($academie->departements as $departement)
						<tr>
							<td>{{ $departement->nom }}</td>
							<td>
								@hasPermission("administrations/departements/show")
								<a href="{{ route("web.administrations.departements.show", [$departement]) }}" class="btn btn-outline-primary" type="btn">
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
	{{-- Départements --}}
	<script>
		$(document).ready(function () {
			$('#departements').DataTable({
				"language": {
					"url": "{{ asset("assets/js/dataTables.french.json") }}",
				},
				"info": false,
				"columnDefs": [
					{"orderable": false, "targets": 1},
				],
				"pageLength": 10,
				"fnInitComplete": function () {
					$("#departements").show()
				},
			})
		})
	</script>
@endsection