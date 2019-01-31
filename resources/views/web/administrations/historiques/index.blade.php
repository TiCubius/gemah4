@extends('web._includes._master')
@section('content')
	<div class="row">
		@component("web._includes.components.title", ["back" => "web.administrations.index"])
			Historique
		@endcomponent

		<div class="col-12 mb-3">
			<div class="table-responsive">
				<table id="table" class="table table-sm table-hover text-center" width="100%" style="display: none;">
					<thead class="gemah-bg-primary">
						<tr>
							<td>Type</td>
							<td>Contenue</td>
							<td>Date</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody>
						@foreach($historiques as $historique)
							<tr>
								<td>{{ $historique->type }}</td>
								<td>{{ $historique->contenue }}</td>
								<td>{{ $historique->created_at->format("d/m/Y") }}</td>
								<td>
									@hasPermission("administrations/historiques/show")
									<a type="btn" class="btn btn-outline-primary" target="_blank" href="{{ route("web.administrations.historiques.show", [$historique]) }}">
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
				"info": false,
				"columnDefs": [
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