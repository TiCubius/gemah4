@extends('web._includes._master')
@php($title = "Création d'un domaine matériel")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.materiels.domaines.index"])
			Création d'un domaine matériel
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.materiels.domaines.store") }}" method="POST">
				{{ csrf_field() }}

				@component("web._includes.components.input", ["name" => "libelle", "placeholder" => "Ex: Informatique"])
					Libellé
				@endcomponent

				@hasPermission("materiels/domaines/create")
				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer</button>
				</div>
				@endHas
			</form>
		</div>

	</div>
@endsection
