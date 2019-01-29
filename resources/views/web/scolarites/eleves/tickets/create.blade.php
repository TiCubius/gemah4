@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.tickets.index", "id" => $eleve])
			Création d'un ticket
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.scolarites.eleves.tickets.store", [$eleve]) }}" method="POST">
				{{ csrf_field() }}

				@component("web._includes.components.input", ["name" => "libelle", "placeholder" => "Ex : Matériel défaillant"])
					Libellé
				@endcomponent

				<div class="form-group">
					<label for="type_ticket_id">Type</label>
					<select id="type_ticket_id" class="form-control" name="type_ticket_id" required>
						<option hidden value="">Sélectionnez un type de ticket</option>
						@foreach($typesTicket as $type)
							@if($type->id === old("type_ticket_id"))
								<option value="{{ $type->id }}" selected>{{ $type->libelle }}</option>
							@else
								<option value="{{ $type->id }}">{{ $type->libelle }}</option>
							@endif
						@endforeach
					</select>
				</div>


				<div class="form-group">
					<label class="optional" for="message">Message</label>
					<textarea id="message" name="message" rows="5" class="form-control"></textarea>
				</div>

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer</button>
				</div>
			</form>
		</div>

	</div>

@endsection

@include("web._includes.sidebars.eleve")
