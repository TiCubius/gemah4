@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.tickets.index", "id" => $eleve])
			Édition d'un message
		@endcomponent

		<div class="col-12">

			<form action="{{ route("web.scolarites.eleves.tickets.messages.update", [$eleve, $ticket, $message]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("PATCH") }}

				<div class="form-group">
					<label for="contenu">Contenu</label>
					<textarea id="contenu" name="contenu" rows="5" class="form-control">{{ $message->contenu }}</textarea>
				</div>

				<div class="d-flex justify-content-between">
					<button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">Supprimer le message</button>
					<button class="btn btn-sm btn-outline-primary">Modifier le message</button>
				</div>
			</form>

		</div>

	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.scolarites.eleves.tickets.messages.destroy", "id" => [$eleve, $ticket, $message]])
		@slot("name")
			{{ str_limit($message->contenu, 15) }}
		@endslot
	@endcomponent
@endsection

@include("web._includes.sidebars.eleve")