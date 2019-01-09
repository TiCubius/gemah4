@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.tickets.index", "id" => $eleve])
			Édition d'un ticket
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.scolarites.eleves.tickets.update", [$eleve, $ticket]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("PATCH") }}

				<div class="form-group">
					<label for="libelle">Libellé</label>
					<input id="libelle" class="form-control" name="nom" type="text" placeholder="Ex : Appel téléphonique" value="{{ $ticket->libelle }}" required>
				</div>


				<div class="form-group">
					<label for="type_ticket_id">Type</label>
					<select id="type_ticket_id" class="form-control" name="type_ticket_id" required>
						<option>Sélectionnez un type de ticket</option>
						@foreach($typesTicket as $type)
							@if($type->id === $ticket->type_ticket_id))
							<option value="{{ $type->id }}" selected>{{ $type->libelle }}</option>
							@else
								<option value="{{ $type->id }}">{{ $type->libelle }}</option>
							@endif
						@endforeach
					</select>
				</div>

				<div class="d-flex justify-content-between">
					<button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">Supprimer le ticket</button>
					<button class="btn btn-sm btn-outline-success">Éditer le ticket</button>
				</div>
			</form>
		</div>

	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.scolarites.eleves.tickets.destroy", "id" => [$eleve, $ticket]])
		@slot("name")
			{{ str_limit($ticket->libelle, 15) }}
		@endslot
	@endcomponent
@endsection

@include("web._includes.sidebars.eleve")