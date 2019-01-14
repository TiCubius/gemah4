@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.index"])
			Édition de {{ "{$eleve->nom} {$eleve->prenom}" }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.scolarites.eleves.update",[$eleve]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("PATCH") }}

				<div class="form-group">
					<label for="nom">Nom</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex : Doe" value="{{ $eleve->nom }}" required>
				</div>

				<div class="form-group">
					<label for="prenom">Prénom</label>
					<input id="prenom" class="form-control" name="prenom" type="text" placeholder="Ex : John" value="{{ $eleve->prenom }}" required>
				</div>


				<div class="form-group">
					<label for="date_naissance">Date de naissance</label>
					<input id="date_naissance" class="form-control" name="date_naissance" type="date" value="{{ $eleve->date_naissance }}" required>
				</div>

				<div class="form-group">
					<label for="classe">Classe</label>
					<input id="classe" class="form-control" name="classe" type="text" placeholder="Ex : 1e" value="{{ $eleve->classe }}" required>
				</div>

				@component('web._includes.components.departement', ['academies' => $academies, 'id' => $eleve->departement_id])
				@endcomponent

				<div class="form-group">
					<label for="etablissement_id">Établissement</label>
					<select id="etablissement_id" class="form-control" name="etablissement_id" required>
						<option>Sélectionnez un établissement</option>
						@foreach($etablissements as $etablissement)
							@if($etablissement->id === $eleve->etablissement_id)
								<option value="{{ $etablissement->id }}" selected>{{ $etablissement->nom }}</option>
							@else
								<option value="{{ $etablissement->id }}">{{ $etablissement->nom }}</option>
							@endif
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label class="optional" for="code_ine">Code INE</label>
					<input id="code_ine" class="form-control" name="code_ine" type="text" value="{{ $eleve->code_INE }}" placeholder="Ex : 0000000000X">
				</div>

				<div class="d-flex justify-content-between">
					<button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">Supprimer l'élève</button>
					<button class="btn btn-sm btn-outline-success">Éditer l'élève</button>
				</div>
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.scolarites.eleves.destroy", "id" => $eleve])
		@slot("name")
			{{ "{$eleve->nom} {$eleve->prenom}" }}
		@endslot
	@endcomponent

@endsection

@include("web._includes.sidebars.eleve")