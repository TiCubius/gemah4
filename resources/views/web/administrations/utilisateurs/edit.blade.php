@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.utilisateurs.index"])
			Édition de {{ $utilisateur->nom }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.utilisateurs.update", [$utilisateur]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				<div class="form-group">
					<label for="nom">Nom de l'utilisateur</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Nom" value="{{ $utilisateur->nom }}" required>
				</div>

				<div class="form-group">
					<label for="prenom">Prénom de l'utilisateur</label>
					<input id="prenom" class="form-control" name="prenom" type="text" placeholder="Prénom" value="{{ $utilisateur->prenom }}" required>
				</div>


				<div class="form-group">
					<label for="email">Adresse E-Mail de l'utilisateur</label>
					<input id="email" class="form-control" name="email" type="email" placeholder="Adresse E-Mail" value="{{ $utilisateur->email }}" required>
				</div>


				<div class="form-group">
					<label for="academie">Académie de l'utilisateur</label>
					<select id="academie" class="form-control" name="academie" required>
						<option hidden>Sélectionner une Académie</option>
						@foreach($academies as $academy)
							@if($utilisateur->academie_id === $academy->id)
								<option selected value="{{ $academy->id }}">{{ $academy->nom }}</option>
							@else
								<option value="{{ $academy->id }}">{{ $academy->nom }}</option>
							@endif
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label for="service">Service de l'utilisateur</label>
					<select id="service" class="form-control" name="service" required>
						<option hidden>Sélectionner un Service</option>
						@foreach($services as $service)
							@if($utilisateur->service_id === $service->id)
								<option selected value="{{ $service->id }}">{{ $service->nom }}</option>
							@else
								<option value="{{ $service->id }}">{{ $service->nom }}</option>
							@endif
						@endforeach
					</select>
				</div>


				<div class="d-flex justify-content-between">
					<button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">Supprimer l'utilisateur</button>
					<button class="btn btn-sm btn-outline-success">Éditer l'utilisateur</button>
				</div>
			</form>
		</div>
	</div>

	<form id="modal" class="modal fade" action="{{ route("web.administrations.utilisateurs.destroy", [$utilisateur]) }}" method="POST" tabindex="-1">
		{{ csrf_field() }}
		{{ method_field("DELETE") }}

		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Attention</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body text-center">
					<p>
						Vous êtes sur le point de supprimer <b>{{ "{$utilisateur->nom} {$utilisateur->prenom}" }}</b>.
						<br>
						Cette action est irreversible
					</p>
				</div>
				<div class="modal-footer d-flex justify-content-between">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Annuler</button>
					<button type="submit" class="btn btn-danger">Supprimer l'utilisateur</button>
				</div>
			</div>
		</div>
	</form>

	@component("web._includes.components.modals.destroy", ["route" => "web.administrations.utilisateurs.destroy", "id" => $utilisateur])
		@slot("name")
			{{ "{$utilisateur->nom} {$utilisateur->prenom}" }}
		@endslot
	@endcomponent

@endsection
