@extends('web._includes._master')
@php($title = "Création d'un type de décision")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.types.decisions.index"])
			Création d'un type de décision
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.types.decisions.index") }}" method="POST">
				{{ csrf_field() }}

				@component("web._includes.components.input", ["name" => "libelle", "placeholder" => "Ex: Matériel"])
					Libellé
				@endcomponent

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer le type de décision</button>
				</div>
			</form>
		</div>

	</div>
@endsection
