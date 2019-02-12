@extends('web._includes._master')
@php($title = "Édition de {$physique->libelle}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.materiels.etats.physiques.index"])
			Édition de {{ $physique->libelle }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.materiels.etats.physiques.update", [$physique]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				@component("web._includes.components.input", ["name" => "libelle", "placeholder" => "Ex: Volé", "value" => $physique->libelle])
					Libellé
				@endcomponent

				@component("web._includes.components.form_edit")
				@endcomponent
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.administrations.materiels.etats.physiques.destroy", "id" => $physique])
		@slot("name")
			{{ $physique->libelle }}
		@endslot
	@endcomponent

@endsection
