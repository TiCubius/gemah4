@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.administrations.utilisateurs.create", "back" => "web.administrations.index"])
			Gestion des utilisateurs
		@endcomponent

		<div class="col-12">
			@if($utilisateurs->isEmpty())
				<div class="alert alert-warning">
					Aucun utilisateur n'est enregistré sur l'application
				</div>
			@else
				<table class="table table-sm table-hover text-center">
					<thead class="gemah-bg-primary">
						<tr>
							<th>Service</th>
							<th>Nom</th>
							<th>Email</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($utilisateurs as $utilisateur)
							<tr>
								<td>{{ $utilisateur->service->nom }}</td>
								<td>{{ "{$utilisateur->nom} {$utilisateur->prenom}" }}</td>
								<td>{{ $utilisateur->email }}</td>
								<td>
									<a href="{{ route("web.administrations.utilisateurs.edit", [$utilisateur]) }}">
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
