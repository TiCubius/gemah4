@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.utilisateurs.index"])
			Création d'un Utilisateur
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.utilisateurs.index") }}" method="POST">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="nom">Nom de l'utilisateur</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Nom" value="{{ old("nom") }}" required>
				</div>

				<div class="form-group">
					<label for="prenom">Prénom de l'utilisateur</label>
					<input id="prenom" class="form-control" name="prenom" type="text" placeholder="Prénom" value="{{ old("prenom") }}" required>
				</div>


				<div class="form-group">
					<label for="email">Adresse E-Mail de l'utilisateur</label>
					<input id="email" class="form-control" name="email" type="email" placeholder="Adresse E-Mail" value="{{ old("email") }}" required>
				</div>


				<div class="form-group">
					<label for="password">Mot de passe de l'utilisateur</label>
					<input id="password" class="form-control" name="password" type="password" placeholder="Mot de passe" minlength="8" required>
				</div>
				<div class="form-group">
					<label for="password_confirmation">Confirmation du mot de passe de l'utilisateur</label>
					<input id="password_confirmation" class="form-control" name="password_confirmation" type="password" minlength="8" placeholder="Confirmation du mot de passe" required>
				</div>


				<div class="form-group">
					<label for="academie">Académie de l'utilisateur</label>
					<select id="academie" class="form-control" name="academie" required>
						<option value="" hidden>Sélectionner une Académie</option>
						@foreach($academies as $academy)
							@if(old("academie") == $academy->id)
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
