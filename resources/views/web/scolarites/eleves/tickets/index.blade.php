@extends("web._includes._master")

@section("content")

	@component("web._includes.components.title", ["add" => "web.scolarites.eleves.tickets.create", "back" => "web.scolarites.eleves.show", "id" => $eleve])
		Gestion des tickets
	@endcomponent

	<div class="row">
		<div class="col-12">

			@foreach($tickets as $ticket)
				<div class="col-6 float-left mb-3">

					<div class="card">
						<div class="card-body">
							<p class="mb-0">
								<strong>Libellé</strong>:
								{{ $ticket->libelle }}
							</p>
							<hr>
							<p class="mb-0">
								<strong>Type</strong>:
								{{ $ticket->type->libelle }}
							</p>
							<p class="mb-0">
								<strong>Soumis le</strong>:
								{{ \Carbon\Carbon::parse($ticket->created_at)->format("d/m/Y H:m:s") }}
							</p>
						</div>

						<div class="card-footer gemah-bg-primary d-flex justify-content-between">
							<a role="button" href="{{ route('web.scolarites.eleves.tickets.edit', [$eleve, $ticket]) }}" class="btn btn-sm btn-outline-warning">
								<i class="fas fa-edit"></i>
								Modifier
							</a>
							<a role="button" href="{{ route('web.scolarites.eleves.tickets.show', [$eleve, $ticket]) }}" class="btn btn-sm btn-outline-light">
								<i class="far fa-eye"></i>
								Visualiser
							</a>
						</div>
					</div>
				</div>


			@endforeach

		</div>
	</div>

@endsection

@include("web._includes.sidebars.eleve")