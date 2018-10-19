@extends('web._includes._master')
@section('content')
	<div class="row">
		<div class="col-12">
			<div class="d-flex flex-column">
				<div class="d-flex justify-content-between align-items-center">
					<h4>Liste des Régions</h4>
					<div>
						<a href="{{ route("web.administrations.regions.create") }}">
							<button class="btn btn-outline-primary">Ajouter</button>
						</a>
						<a href="{{ route("web.administrations.index") }}">
							<button class="btn btn-outline-primary">Retour</button>
						</a>
					</div>
				</div>
				<hr class="w-100">
			</div>
		</div>

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
									<a href="{{ route("web.administrations.regions.edit", [$region->id]) }}">
										<button class="btn btn-sm btn-outline-primary">Editer</button>
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
		</div>
	</div>
@endsection
