@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.enseignants.index"])
			Édition de {{ "{$enseignant->nom} {$enseignant->prenom}" }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.scolarites.enseignants.update", [$enseignant]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("PUT") }}

				<div class="form-group">
					<label for="civilite">Civilité</label>
					<select id="civilite" class="form-control" name="civilite" required>
						<option hidden value="">Veuillez sélectionner la civilité</option>
						<option value="M">M</option>
						<option value="Mme">Mme</option>
					</select>
				</div>

				<div class="form-group">
					<label for="nom">Nom</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: Smith" value="{{ $enseignant->nom }}" required>
				</div>

				<div class="form-group">
					<label for="prenom">Prénom</label>
					<input id="prenom" class="form-control" name="prenom" type="text" placeholder="Ex: John" value="{{ $enseignant->prenom }}" required>
				</div>


				<div class="form-group">
					<label for="email">Adresse E-Mail</label>
					<input id="email" class="form-control" name="email" type="email" placeholder="Ex: john.smith@exemple.fr" value="{{ $enseignant->email }}" required>
				</div>

				<div class="form-group">
					<label class="optional" for="telephone">Téléphone</label>
					<input id="telephone" class="form-control" name="telephone" type="text" placeholder="Ex: 04 77 81 41 00" value="{{ $enseignant->telephone }}">
				</div>

				<div class="d-flex justify-content-between">
					<button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">Supprimer l'enseignant</button>
					<button class="btn btn-sm btn-outline-success">Éditer l'enseignant</button>
				</div>
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.scolarites.enseignants.destroy", "id" => $enseignant])
		@slot("name")
			{{ "{$enseignant->nom} {$enseignant->prenom}" }}
		@endslot
	@endcomponent

@endsection
