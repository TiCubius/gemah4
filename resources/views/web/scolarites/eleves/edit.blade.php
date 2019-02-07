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

				@component("web._includes.components.input", ["name" => "nom", "placeholder" => "Ex: SMITH", "value" => $eleve->nom])
					Nom
				@endcomponent

				@component("web._includes.components.input", ["name" => "prenom", "placeholder" => "Ex: Jane", "value" => $eleve->prenom])
					Prénom
				@endcomponent

				@component("web._includes.components.input", ["name" => "date_naissance", "placeholder" => "Ex: 07/01/2019", "type" => "date", "value" => $eleve->date_naissance->format("Y-m-d")])
					Date de naissance
				@endcomponent

				@component("web._includes.components.input", ["optional" => true, "name" => "classe", "placeholder" => "Ex: 1e", "value" => $eleve->classe])
					Classe
				@endcomponent

				@component('web._includes.components.departement', ['academies' => $academies, 'id' => $eleve->departement_id])
				@endcomponent

				@component("web._includes.components.input", ["optional" => true, "name" => "code_ine", "placeholder" => "Ex: 0000000000X", "value" => $eleve->code_INE])
					Code INE
				@endcomponent

				@hasPermission("eleves/edit")
				@component("web._includes.components.form_edit")
				@endcomponent
				@endHas
			</form>
		</div>
	</div>

@endsection

@component("web._includes.components.modals.destroy", ["route" => "web.scolarites.eleves.destroy", "id" => $eleve])
	@slot("name")
		{{ "{$eleve->nom} {$eleve->prenom}" }}
	@endslot
	@foreach($eleve->responsables as $responsable)
		@if($responsable->eleves->count() <= 1 )
			{{ "{$responsable->nom} {$responsable->prenom} ne sera affecté a aucun élève après cette suppression"}}

			<div class="custom-control custom-checkbox">
				<input id="delete-responsables[]" class="custom-control-input" name="delete-responsables[]" value="{{$responsable->id}}" type="checkbox">
				<label class="custom-control-label" for="delete-responsables[]">Supprimer {{ "{$responsable->nom} {$responsable->prenom}"}}</label>
			</div>
		@endif
	@endforeach
@endcomponent

@include("web._includes.sidebars.eleve")