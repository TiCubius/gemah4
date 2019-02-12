@extends('web._includes._master')
@php($title = "Création d'un état administratif matériel")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.materiels.etats.administratifs.index"])
			Création d'un état administratif matériel
		@endcomponent

		<div class="col-12">

			<form class="mb-3" action="{{ route("web.administrations.materiels.etats.administratifs.index") }}" method="POST">
				{{ csrf_field() }}

				@component("web._includes.components.input", ["name" => "libelle", "placeholder" => "Ex: Volé"])
					Libellé
				@endcomponent

				@component("web._includes.components.input", ["name" => "color", "placeholder" => "Ex: #B63636"])
					Couleur
				@endcomponent

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer</button>
				</div>
			</form>

		</div>
	</div>
@endsection
