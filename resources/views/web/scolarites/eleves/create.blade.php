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


				@component('web._includes.components.departement', ['academies' => $academies, 'id' => old("departement_id")])
				@endcomponent

				<div class="form-group">
					<label class="optional" for="code_ine">Code INE</label>
					<input id="code_ine" class="form-control" name="code_ine" type="text" value="{{ old("code_ine") }}" placeholder="Ex : 0000000000X">
				</div>

				<div class="row">

					<div class="form-group col-12 col-lg-3">
						Type d'élève
						<div class="border border rounded pt-0 pl-2 pt-1 mt-1">
							@foreach($types as $type)
								<div class="custom-control custom-checkbox mb-1  ">
									@if((old("types") !== null) && (in_array($type->id, old("types"))))
										<input checked id="type-{{ $type->id }}" class="custom-control-input " name="types[]" value="{{ $type->id }}" type="checkbox">
									@else
										<input id="type-{{ $type->id }}" class="custom-control-input" name="types[] " value="{{ $type->id }}" type="checkbox">
									@endif
									<label class="custom-control-label" for="type-{{ $type->id }}">{{ $type->libelle }}</label>
								</div>
							@endforeach
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer l'élève</button>
				</div>
			</form>
		</div>

	</div>
@endsection
