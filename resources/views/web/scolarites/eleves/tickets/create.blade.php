@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.tickets.index", "id" => $eleve])
			Création d'un ticket
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.scolarites.eleves.tickets.store", [$eleve]) }}" method="POST">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="libelle">Libellé</label>
					<input id="libelle" class="form-control" name="libelle" type="text" placeholder="Ex : Appel téléphonique" value="{{ old("libelle") }}" required>
				</div>


				<div class="form-group">
					<label for="type_ticket_id">Type</label>
					<select id="type_ticket_id" class="form-control" name="type_ticket_id" required>
						<option>Sélectionnez un type de ticket</option>
						@foreach($typesTicket as $type)
							@if($type->id === old("type_ticket_id"))
								<option value="{{ $type->id }}" selected>{{ $type->libelle }}</option>
							@else
								<option value="{{ $type->id }}">{{ $type->libelle }}</option>
							@endif
						@endforeach
					</select>
				</div>

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer le ticket</button>
				</div>
			</form>
		</div>

	</div>

@endsection

@include("web._includes.sidebars.eleve")
