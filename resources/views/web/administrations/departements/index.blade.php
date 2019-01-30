@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.administrations.departements.create", "permission" => "administrations/departements/create", "back" => "web.administrations.index"])
			Gestion des départements
		@endcomponent

		<div class="col-12">
			@if($departements->isEmpty())
				<div class="alert alert-warning">
					Aucun département n'est enregistré sur l'application
				</div>
			@else
				<table class="table table-sm table-hover text-center">
					<thead class="gemah-bg-primary">
						<tr>
							<th>Code</th>
							<th>Nom</th>
							<th>Académie</th>
							<th>Action</th>
						</tr>
					</thead>

					<tbody>
						@foreach($departements as $departement)
							<tr>
								<td>{{ $departement->id }}</td>
								<td>{{ $departement->nom }}</td>
								<td>{{ $departement->academie->nom }}</td>
								<td>
									@hasPermission("administrations/departements/edit")
									<a href="{{ route("web.administrations.departements.edit", [$departement]) }}">
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
