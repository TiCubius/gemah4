@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.services.index"])
			Édition de {{ $service->nom }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.services.update", [$service->id]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				<div class="form-group">
					<label for="nom">Nom du service</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Nom" value="{{ $service->nom }}" required>
				</div>

				<div class="form-group">
					<label for="description">Description du service</label>
					<input id="description" class="form-control" name="description" type="text" placeholder="Description" value="{{ $service->description }}" required>
				</div>

				<div class="d-flex justify-content-between">
					<button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">Supprimer le servicee</button>
					<button class="btn btn-sm btn-outline-success">Éditer le service</button>
				</div>
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.administrations.services.destroy", "id" => $service->id])
		@slot("name")
			{{ $service->nom }}
		@endslot
	@endcomponent

@endsection
