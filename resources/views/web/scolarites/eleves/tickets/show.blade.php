@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.tickets.index", "id" => $eleve])
			Ticket {{ $eleve->nom }} {{ $eleve->prenom }} / {{ $ticket->type->libelle }}

			@slot("custom")
				<div class="btn-group">
					<div class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Gestion ticket
					</div>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
						@hasPermission("eleves/tickets/edit")
						<a class="dropdown-item" href="{{ route("web.scolarites.eleves.tickets.edit", [$eleve, $ticket]) }}">Éditer le ticket</a>
						@endHas
					</div>
				</div>
			@endslot
		@endcomponent

		<div class="col-12">

			<div class="card">
				<div class="card-body bg-light d-flex justify-content-between">
					<div class="header d-flex align-items-center">
						<strong>{{ $ticket->libelle }}</strong> <br>
					</div>

					<div class="footer text-center">
						<small>{{ $ticket->created_at->diffForHumans()}}</small>
						<br>
						<small>{{ $ticket->created_at->format("d/m/Y H:i:s") }}</small>
					</div>
				</div>
			</div>

			@foreach($ticket->messages as $message)
				<div class="card mt-3">
					<div class="card-body">
						{!! nl2br(e($message->contenu)) !!}
					</div>
					<div class="card-footer d-flex justify-content-between align-items-center">
						<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.eleves.tickets.messages.edit", [$eleve, $ticket, $message]) }}">Éditer</a>
						<small>{{ $message->created_at->format("d/m/Y H:i:s") }}</small>
					</div>
				</div>
			@endforeach

			@hasPermission("eleves/tickets/messages/create")
			<form class="mt-3" action="{{ route("web.scolarites.eleves.tickets.messages.store", [$eleve, $ticket]) }}" method="POST">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="contenu">Nouveau message</label>
					<textarea id="contenu" name="contenu" rows="5" class="form-control"></textarea>
				</div>

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-primary">Envoyer le nouveau message</button>
				</div>
			</form>
			@endHas
		</div>
	</div>
@endsection

@include("web._includes.sidebars.eleve")