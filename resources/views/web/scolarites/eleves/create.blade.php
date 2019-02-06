@extends('web._includes._master')
@section('content')

	<div class="row">
		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.index"])
			Création d'un élève
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.scolarites.eleves.store") }}" method="POST">
				{{ csrf_field() }}

				@component("web._includes.components.input", ["name" => "nom", "placeholder" => "Ex: SMITH"])
					Nom
				@endcomponent

				@component("web._includes.components.input", ["name" => "prenom", "placeholder" => "Ex: Jane"])
					Prénom
				@endcomponent

				@component("web._includes.components.input", ["name" => "date_naissance", "placeholder" => "Ex: 07/01/2019", "type" => "date"])
					Date de naissance
				@endcomponent

				@component("web._includes.components.input", ["optional" => true, "name" => "classe", "placeholder" => "Ex: 1e"])
					Classe
				@endcomponent

				@component('web._includes.components.departement', ['academies' => $academies])
				@endcomponent

				@component("web._includes.components.input", ["optional" => true, "name" => "code_ine", "placeholder" => "Ex: 0000000000X"])
					Code INE
				@endcomponent

				@hasPermission("eleves/create")
				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer</button>
				</div>
				@endHas
			</form>
		</div>
	</div>

@endsection
