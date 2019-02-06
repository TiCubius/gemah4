@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.statistiques.index"])
			Liste des élèves dont la décision a expiré
		@endcomponent

		<div class="col-12">
			<div class="table-responsive mb-3">
				<table id="table" class="table table-hover table-sm table-striped text-center">
					<thead class="gemah-bg-primary">
						<tr class="text-center">
							<th>Nom</th>
							<th>Prénom</th>
							<th>Date limite convention</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($eleves as $eleve)
							<tr>
								<td>{{ $eleve->nom }}</td>
								<td>{{ $eleve->prenom }}</td>
								<td data-order="{{ $eleve->decisions->sortByDesc("date_limite")->first()->date_limite->timestamp }}">{{ $eleve->decisions->sortByDesc("date_limite")->first()->date_limite->format("d/m/Y") }}</td>
								<td>
									<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.eleves.show", [$eleve]) }}">
										Détails
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection


@section("scripts")
	<script>
		$(document).ready(function () {
			$('#table').DataTable({
				"language": {
					"url": "{{ asset("assets/js/dataTables.french.json") }}",
				},
				"columnDefs": [
					{"orderable": false, "targets": 3},
				],
				"pageLength": 50,
			})
		})
	</script>
@endsection