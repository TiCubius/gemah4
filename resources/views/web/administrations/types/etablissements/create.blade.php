@extends('web._includes._master')
@php($title = "Création d'un type d'établissement")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.types.etablissements.index"])
			Création d'un type d'établissement
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.types.etablissements.index") }}" method="POST">
				{{ csrf_field() }}

				@component("web._includes.components.input", ["name" => "libelle", "placeholder" => "Ex: LYCEE POLYVALENT"])
					Libellé
				@endcomponent

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer</button>
				</div>
			</form>
		</div>

	</div>
@endsection
