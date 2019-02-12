@extends('web._includes._master')
@php($title = "Édition de {$decision->libelle}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.types.decisions.index"])
			Édition de {{ $decision->libelle }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.types.decisions.update", [$decision]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				<div class="form-group">
					<label for="libelle">Libellé</label>
					<input id="libelle" class="form-control" name="libelle" type="text" placeholder="Ex: Matériel" value="{{ $decision->libelle }}" required>
				</div>

				@component("web._includes.components.form_edit")
				@endcomponent
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.administrations.types.decisions.destroy", "id" => $decision])
		@slot("name")
			{{ $decision->libelle }}
		@endslot
	@endcomponent

@endsection
