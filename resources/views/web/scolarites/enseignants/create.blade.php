@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.enseignants.index"])
			Création d'un Enseignant
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.scolarites.enseignants.index") }}" method="POST">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="civilite">Civilité</label>
					<select id="civilite" class="form-control" name="civilite" required>
						<option hidden value="">Veuillez sélectionner la civilité</option>
						<option value="M">M</option>
						<option value="Mme">Mme</option>
					</select>
				</div>

				<div class="form-group">
					<label for="nom">Nom de l'enseignant</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: Smith" value="{{ old("nom") }}" required>
				</div>

				<div class="form-group">
					<label for="prenom">Prénom de l'enseignant</label>
					<input id="prenom" class="form-control" name="prenom" type="text" placeholder="Ex: John" value="{{ old("prenom") }}" required>
				</div>


				<div class="form-group">
					<label for="email">Adresse E-Mail de l'enseignant</label>
					<input id="email" class="form-control" name="email" type="email" placeholder="Ex: john.smith@exemple.fr" value="{{ old("email") }}" required>
				</div>

				<div class="form-group">
					<label class="optional" for="telephone">Téléphone de l'enseignant</label>
					<input id="telephone" class="form-control" name="telephone" type="text" placeholder="Ex: 04 77 81 41 00" value="{{ old("telephone") }}">
				</div>

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer l'enseignant</button>
				</div>
			</form>
		</div>

	</div>
@endsection
