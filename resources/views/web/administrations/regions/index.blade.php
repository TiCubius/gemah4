@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.administrations.regions.create", "permission" => "administrations/regions/create", "back" => "web.administrations.index"])
			Gestion des régions
		@endcomponent

		<div class="col-12">
			@if($regions->isEmpty())
				<div class="alert alert-warning">
					Aucune région n'est enregistré sur l'application
				</div>
			@else
				<table class="table table-sm table-hover text-center">
					<thead class="gemah-bg-primary">
						<tr>
							<th>Nom</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($regions as $region)
							<tr>
								<td>{{ $region->nom }}</td>
								<td>
									@hasPermission("administrations/regions/edit")
									<a href="{{ route("web.administrations.regions.edit", [$region]) }}">
										<button class="btn btn-sm btn-outline-primary">Editer</button>
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
