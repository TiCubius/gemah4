@extends('web._includes._master')
@php($title = "Édition de {$domaine->libelle}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.materiels.domaines.index"])
			Édition de {{ $domaine->libelle }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.materiels.domaines.update", [$domaine]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("PUT") }}

				@component("web._includes.components.input", ["name" => "libelle", "placeholder" => "Ex: Informatique", "value" => $domaine->libelle])
					Libellé
				@endcomponent

				@hasPermission("materiels/domaines/edit")
				@component("web._includes.components.form_edit")
				@endcomponent
				@endHas
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.materiels.domaines.destroy", "id" => $domaine])
		@slot("name")
			{{ $domaine->libelle }}
		@endslot
	@endcomponent
@endsection
