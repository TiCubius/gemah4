@extends('web._includes._master')
@php($title = "Édition de {$region->nom}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.regions.index"])
			Édition de {{ $region->nom }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.regions.update", [$region]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				<div class="form-group">
					<label for="nom">Nom</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: Auvergne-Rhône-Alpes" value="{{ $region->nom }}" required>
				</div>

				@component("web._includes.components.form_edit")
				@endcomponent
			</form>
		</div>
	</div>
	@component("web._includes.components.modals.destroy", ["route" => "web.administrations.regions.destroy", "id" => $region])
		@slot("name")
			{{ "{$region->nom}" }}
		@endslot
	@endcomponent
@endsection
