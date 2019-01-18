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
					<label for="nom">Nom</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: DOE" value="{{ $utilisateur->nom }}" required>
				</div>

				<div class="form-group">
					<label for="prenom">Prénom</label>
					<input id="prenom" class="form-control" name="prenom" type="text" placeholder="Ex: John" value="{{ $utilisateur->prenom }}" required>
				</div>

				<div class="form-group">
					<label for="pseudo">Pseudo</label>
					<input id="pseudo" class="form-control" name="pseudo" type="text" placeholder="Ex: djohn" value="{{ $utilisateur->pseudo }}" required>
				</div>

				<div class="form-group">
					<label for="email">Adresse E-Mail</label>
					<input id="email" class="form-control" name="email" type="email" placeholder="Ex: john.smith@exemple.fr" value="{{ $utilisateur->email }}" required>
				</div>


				@component('web._includes.components.departement', ['academies' => $academies, 'id' => $utilisateur->service->departement_id])
				@endcomponent

				<div class="form-group">
					<label for="service">Service</label>
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


				@component("web._includes.components.form_edit")
				@endcomponent
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
					<button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal"><i class="far fa-trash-alt"></i> Supprimer</button>
					<button class="btn btn-sm btn-outline-success"><i class="far fa-edit"></i> Éditer</button>
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
