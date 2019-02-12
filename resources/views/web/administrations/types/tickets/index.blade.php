@extends("web._includes._master")
@php($title = "Gestion des types de tickets")

@section("content")
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.administrations.types.tickets.create", "permission" => "administrations/types/tickets/create", "back" => "web.administrations.index"])
			Gestion des types de tickets
		@endcomponent

		<div class="col-12">
			@if($tickets->isEmpty())
				<div class="alert alert-warning">
					Aucun type de ticket n'est enregistré sur l'application
				</div>
			@else
				<table class="table table-sm table-hover text-center">
					<thead class="gemah-bg-primary">
						<tr>
							<th>Libellé</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($tickets as $ticket)
							<tr>
								<td>{{ $ticket->libelle }}</td>
								<td>
									@hasPermission("administrations/types/tickets/edit")
									<a href="{{ route("web.administrations.types.tickets.edit", [$ticket]) }}">
										<button class="btn btn-sm btn-outline-primary">Éditer</button>
									</a>
									@endHas
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
		</div>
	</div>
@endsection