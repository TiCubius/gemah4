@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.utilisateurs.index"])
			Création d'un utilisateur
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.utilisateurs.index") }}" method="POST">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="nom">Nom</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: DOE" value="{{ old("nom") }}" required>
				</div>

				<div class="form-group">
					<label for="prenom">Prénom</label>
					<input id="prenom" class="form-control" name="prenom" type="text" placeholder="Ex: John" value="{{ old("prenom") }}" required>
				</div>

				<div class="form-group">
					<label for="pseudo">Pseudo</label>
					<input id="pseudo" class="form-control" name="pseudo" type="text" placeholder="Ex: djohn" value="{{ old("pseudo") }}" required>
				</div>

				<div class="form-group">
					<label for="email">Adresse E-Mail</label>
					<input id="email" class="form-control" name="email" type="email" placeholder="Ex: john.smith@exemple.fr" value="{{ old("email") }}" required>
				</div>


				<div class="form-group">
					<label for="password">Mot de passe</label>
					<input id="password" class="form-control" name="password" type="password" placeholder="Au moins 8 caractères" minlength="8" required>
				</div>
				<div class="form-group">
					<label for="password_confirmation">Confirmation du mot de passe</label>
					<input id="password_confirmation" class="form-control" name="password_confirmation" type="password" minlength="8" placeholder="Réentrer le même mot de passe" required>
				</div>

				@component('web._includes.components.departement', ['academies' => $academies, 'id' => old("departement_id")])
				@endcomponent

				<div class="form-group">
					<label for="service">Service</label>
					<select id="service" class="form-control" name="service" required>
						<option value="" hidden>Sélectionner un Service</option>
						@foreach($services as $service)
							@if(old("service") == $service->id)
								<option selected value="{{ $service->id }}">{{ $service->nom }}</option>
							@else
								<option value="{{ $service->id }}">{{ $service->nom }}</option>
							@endif
						@endforeach
					</select>
				</div>


				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer l'utilisateur</button>
				</div>
			</form>
		</div>

	</div>
@endsection
