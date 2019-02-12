@extends('web._includes._master')
@php($title = "Création d'un département")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.departements.index"])
			Création d'un département
		@endcomponent

		<div class="col-12">

			<form class="mb-3" action="{{ route("web.administrations.departements.index") }}" method="POST">
				{{ csrf_field() }}

				@component("web._includes.components.input", ["name" => "id", "placeholder" => "Ex: 42"])
					Code
				@endcomponent

				@component("web._includes.components.input", ["name" => "nom", "placeholder" => "Ex: Loire"])
					Nom
				@endcomponent

				<div class="form-group">
					<label for="academie_id">Académie</label>
					<select id="academie_id" class="form-control" name="academie_id" required>
						<option value="" hidden>Sélectionner une Académie</option>
						@foreach($academies as $academie)
							@if (old("academie_id") == $academie->id)
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
