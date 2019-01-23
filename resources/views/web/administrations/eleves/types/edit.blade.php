@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.eleves.types.index"])
			Édition de {{ $type->libelle }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.eleves.types.update", [$type]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				<div class="form-group">
					<label for="libelle">Libellé</label>
					<input id="libelle" class="form-control" name="libelle" type="text" placeholder="Ex: Matériel" value="{{ $type->libelle }}" required>
				</div>

				@component("web._includes.components.form_edit")
				@endcomponent
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.administrations.eleves.types.destroy", "id" => $type])
		@slot("name")
			{{ $type->libelle }}
		@endslot
	@endcomponent

@endsection
