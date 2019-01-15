@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.types.tickets.index"])
			Édition de {{ $ticket->libelle }}
		@endcomponent

		<div class="col-12">

			<form class="mb-3" action="{{ route("web.administrations.types.tickets.update", [$ticket]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				<div class="form-group">
					<label for="libelle">Libellé</label>
					<input id="libelle" class="form-control" name="libelle" type="text" value="{{ $ticket->libelle }}" required>
				</div>

				<div class="d-flex justify-content-between">
					<button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">Supprimer le type de ticket</button>
					<button class="btn btn-sm btn-outline-success">Éditer le type de ticket</button>
				</div>
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.administrations.types.tickets.destroy", "id" => $ticket])
		@slot("name")
			{{ $ticket->libelle }}
		@endslot
	@endcomponent

@endsection