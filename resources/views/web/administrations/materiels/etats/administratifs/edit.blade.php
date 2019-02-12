@extends('web._includes._master')
@php($title = "Édition de {$administratif->libelle}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.materiels.etats.administratifs.index"])
			Édition de {{ $administratif->libelle }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.materiels.etats.administratifs.update", [$administratif]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				@component("web._includes.components.input", ["name" => "libelle", "placeholder" => "Ex: Volé", "value" => $administratif->libelle])
					Libellé
				@endcomponent

				@component("web._includes.components.input", ["name" => "color", "placeholder" => "Ex: #B63636", "value" => $administratif->couleur])
					Couleur
				@endcomponent

				@component("web._includes.components.form_edit")
				@endcomponent
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.administrations.materiels.etats.administratifs.destroy", "id" => $administratif])
		@slot("name")
			{{ $administratif->libelle }}
		@endslot
	@endcomponent

@endsection
