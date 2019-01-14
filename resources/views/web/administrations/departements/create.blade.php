@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.departements.index"])
			Création d'un département
		@endcomponent

		<div class="col-12">

			<form class="mb-3" action="{{ route("web.administrations.departements.index") }}" method="POST">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="id">Code</label>
					<input id="id" class="form-control" name="id" type="text" placeholder="Code" value="{{ old("id") }}" required>
				</div>

				<div class="form-group">
					<label for="nom">Nom</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Nom" value="{{ old("nom") }}" required>
				</div>

				<div class="form-group">
					<label for="academie">Académie</label>
					<select id="academie" class="form-control" name="academie" required>
						<option value="" hidden>Sélectionner une Région</option>
						@foreach($academies as $academie)
							@if (old("academie") == $academie->id)
								<option selected value="{{ $academie->id }}">{{ $academie->nom }}</option>
							@else
								<option value="{{ $academie->id }}">{{ $academie->nom }}</option>
							@endif
						@endforeach
					</select>
				</div>

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer</button>
				</div>
			</form>

		</div>
	</div>
@endsection
