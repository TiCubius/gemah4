@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.index"])
			Création d'un élève
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.scolarites.eleves.index") }}" method="POST">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="nom">Nom</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex : Doe" value="{{ old("nom") }}" required>
				</div>

				<div class="form-group">
					<label for="prenom">Prénom</label>
					<input id="prenom" class="form-control" name="prenom" type="text" placeholder="Ex : John" value="{{ old("prenom") }}" required>
				</div>


				<div class="form-group">
					<label for="date_naissance">Date de naissance</label>
					<input id="date_naissance" class="form-control" name="date_naissance" type="date" value="{{ old("date_naissance") }}" required>
				</div>

				<div class="form-group">
					<label for="classe">Classe</label>
					<input id="classe" class="form-control" name="classe" type="text" placeholder="Ex : 1e" value="{{ old("classe") }}" required>
				</div>


				<div class="form-group">
					<label for="academie_id">Académie</label>
					<select id="academie_id" class="form-control" name="academie_id" required>
						<option>Sélectionnez une académie</option>
						@foreach($academies as $academie)
							@if($academie->id === old("academie_id"))
								<option value="{{ $academie->id }}" selected>{{ $academie->nom }}</option>
							@else
								<option value="{{ $academie->id }}">{{ $academie->nom }}</option>
							@endif
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label for="etablissement_id">Établissement</label>
					<select id="etablissement_id" class="form-control" name="etablissement_id" required>
						<option>Sélectionnez un établissement</option>
						@foreach($etablissements as $etablissement)
							@if($etablissement->id === old("etablissement_id"))
								<option value="{{ $etablissement->id }}" selected>{{ $etablissement->nom }}</option>
							@else
								<option value="{{ $etablissement->id }}">{{ $etablissement->nom }}</option>
							@endif
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label class="optional" for="code_ine">Code INE</label>
					<input id="code_ine" class="form-control" name="code_ine" type="text" value="{{ old("code_ine") }}" placeholder="Ex : 0000000000X">
				</div>

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer l'élève</button>
				</div>
			</form>
		</div>

	</div>
@endsection