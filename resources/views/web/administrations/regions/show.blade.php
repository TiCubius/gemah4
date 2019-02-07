@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.regions.index"])
			Profil de la région "{{ $region->nom }}"

			@slot("custom")
				<div class="btn-group">
					<div class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Gestion région
					</div>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
						@hasPermission("administrations/regions/edit")
						<a class="dropdown-item" href="{{ route("web.administrations.regions.edit", [$region]) }}">Éditer la région</a>
						@endHas
					</div>
				</div>
			@endslot
		@endcomponent


		@component("web._includes.components.show_card", ["title" => "Académies", "id" => "academie"])
			<table id="academies" class="table" width="100%">
				<thead>
					<tr>
						<td><strong>Nom</strong></td>
						<td><strong>Action</strong></td>
					</tr>
				</thead>
				<tbody>
					@foreach($region->academies as $academie)
						<tr>
							<td>{{ $academie->nom }}</td>
							<td>
								@hasPermission("administrations/academies/show")
								<a href="{{ route("web.administrations.academies.show", [$academie]) }}" class="btn btn-outline-primary" type="btn">
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
	{{-- Académies --}}
	<script>
		$(document).ready(function () {
			$('#academies').DataTable({
				"language": {
					"url": "{{ asset("assets/js/dataTables.french.json") }}",
				},
				"info": false,
				"columnDefs": [
					{"orderable": false, "targets": 1},
				],
				"pageLength": 10,
				"fnInitComplete": function () {
					$("#academies").show()
				},
			})
		})
	</script>
@endsection