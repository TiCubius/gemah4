@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.show", "id" => [$eleve]])
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
					<input id="date_naissance" class="form-control" name="date_naissance" type="date" value="{{ $eleve->date_naissance->format("Y-m-d") }}" required>
				</div>

				<div class="form-group">
					<label for="classe">Classe</label>
					<input id="classe" class="form-control" name="classe" type="text" placeholder="Ex : 1e" value="{{ $eleve->classe }}" required>
				</div>

				@component('web._includes.components.departement', ['academies' => $academies, 'id' => $eleve->departement_id])
				@endcomponent

				<div class="form-group">
					<label class="optional" for="code_ine">Code INE</label>
					<input id="code_ine" class="form-control" name="code_ine" type="text" value="{{ $eleve->code_INE }}" placeholder="Ex : 0000000000X">
				</div>

				<div class="row">

					<div class="form-group col-12 col-lg-3">
						Type d'élève
						<div class="border border rounded pt-0 pl-2 pt-1 mt-1">
							@foreach($types as $type)
								<div class="custom-control custom-checkbox">
									@if($eleve->types->contains($type))
										<input checked id="type-{{ $type->id }}" class="custom-control-input" name="types[]" value="{{ $type->id }}" type="checkbox">
									@else
										<input id="type-{{ $type->id }}" class="custom-control-input" name="types[]" value="{{ $type->id }}" type="checkbox">
									@endif
									<label class="custom-control-label" for="type-{{ $type->id }}">{{ $type->libelle }}</label>
								</div>
							@endforeach
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-between">
					<button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">Supprimer l'élève
					</button>
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