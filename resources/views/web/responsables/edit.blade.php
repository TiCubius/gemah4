@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.responsables.index"])
			Édition de {{ "{$responsable->nom} {$responsable->prenom}" }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.responsables.update", [$responsable]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("PUT") }}

				@component("web._includes.components.departement", ["academies" => $academies])
				@endcomponent

				<div class="form-group">
					<label for="civilite">Civilité</label>
					<select id="civilite" class="form-control" name="civilite" required>
						<option hidden value="">Veuillez sélectionner la civilité</option>
						<option value="M.">M</option>
						<option value="Mme">Mme</option>
						<option value="M / Mme">M / Mme</option>
					</select>
				</div>

				<div class="form-group">
					<label for="nom">Nom</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: SMITH" value="{{ $responsable->nom }}" required>
				</div>

				<div class="form-group">
					<label for="prenom">Prénom</label>
					<input id="prenom" class="form-control" name="prenom" type="text" placeholder="Ex: John" value="{{ $responsable->prenom }}" required>
				</div>


				<div class="form-group">
					<label class="optional" for="email">Adresse E-Mail</label>
					<input id="email" class="form-control" name="email" type="email" placeholder="Ex: john.smith@exemple.fr" value="{{ $responsable->email }}">
				</div>

				<div class="form-group">
					<label class="optional" for="telephone">Téléphone</label>
					<input id="telephone" class="form-control" name="telephone" type="text" placeholder="Ex: 04 77 81 41 00" value="{{ $responsable->telephone }}">
				</div>


				<div class="form-group">
					<label class="optional" for="code_postal">Code postal</label>
					<input id="code_postal" class="form-control" name="code_postal" type="text" placeholder="Ex: 42100" value="{{ $responsable->code_postal }}">
				</div>

				<div class="form-group">
					<label class="optional" for="ville">Ville</label>
					<input id="ville" class="form-control" name="ville" type="text" placeholder="Ex: Saint-Etienne" value="{{ $responsable->ville }}">
				</div>

				<div class="form-group">
					<label class="optional" for="adresse">Adresse</label>
					<input id="adresse" class="form-control" name="adresse" type="text" placeholder="Ex: 11 Rue des Docteurs Charcot" value="{{ $responsable->adresse }}">
				</div>

				@component("web._includes.components.form_edit")
				@endcomponent
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.responsables.destroy", "id" => $responsable])
		@slot("name")
			{{ "{$responsable->nom} {$responsable->prenom}" }}
		@endslot
	@endcomponent

@endsection
