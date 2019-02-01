@extends('web._includes._master')
@section('content')
	<div class="row">
		@component("web._includes.components.title", ["back" => "web.administrations.index"])
			Historique
		@endcomponent

		<div class="col-12 mb-3">
			<div class="table-responsive">
				<table id="table" class="table table-sm table-hover table-striped" width="100%" style="display: none;">
					<thead class="gemah-bg-primary">
						<tr>
							<td>Date</td>
							<td>Type</td>
							<td>Informations</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody>
						@foreach($historiques as $historique)
							<tr>
								<td data-order="{{ $historique->created_at->timestamp }}" class="align-middle">{{ $historique->created_at->format("d/m/Y à H:i:s") }}</td>
								<td class="align-middle">{{ $historique->type }}</td>
								<td class="align-middle">{{ $historique->information }}</td>
								<td class="align-middle">
                                    @hasPermission("administrations/historiques/show")
									<a type="btn" class="btn btn-sm btn-outline-primary" target="_blank" href="{{ route("web.administrations.historiques.show", [$historique]) }}">
										<i class="fas fa-info-circle"></i>
										Détails
									</a>
									@endHas
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
					"url": "{{ asset("assets/js/dataTables.french.json") }}"
				},
				"info": false,
				autoWidth: false,
				"order": [
					[0, "desc"],
				],
				"columnDefs": [
					{"width": "150px", "targets": 0},
					{"width": "200px", "targets": 1},
					{"orderable": false, "targets": 3},
				],
				"pageLength": 50,
				"fnInitComplete": function () {
					$("#table").show()
				},
			})
		})
	</script>
@endsection