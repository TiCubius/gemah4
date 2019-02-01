@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.administrations.academies.create", "permission" => "administrations/academies/create", "back" => "web.administrations.index"])
			Gestion des académies
		@endcomponent

		<div class="col-12">
			@if($academies->isEmpty())
				<div class="alert alert-warning">
					Aucune académie n'est enregistré sur l'application
				</div>

			@else
				<table class="table table-sm table-hover text-center">
					<thead class="gemah-bg-primary">
						<tr>
							<th>Région</th>
							<th>Nom</th>
							<th>Actions</th>
						</tr>
					</thead>

					<tbody>
						@foreach($academies as $academy)
							<tr>
								<td>{{ $academy->region->nom }}</td>
								<td>{{ $academy->nom }}</td>
								<td>
									@hasPermission("administrations/academies/show")
									<a href="{{ route("web.administrations.academies.show", [$academy]) }}">
										<button class="btn btn-sm btn-outline-primary">
											<i class="fas fa-info-circle"></i>
											Détails
										</button>
									</a>
									@endHas
									@hasPermission("administrations/academies/edit")
									<a href="{{ route("web.administrations.academies.edit", [$academy]) }}">
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
