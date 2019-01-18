@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.academies.index"])
			Création d'une académie
		@endcomponent

		<div class="col-12">

			<form class="mb-3" action="{{ route("web.administrations.academies.index") }}" method="POST">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="nom">Nom</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: Académie de Lyon" value="{{ old("nom") }}" required>
				</div>

				<div class="form-group">
					<label for="region">Région</label>
					<select id="region" class="form-control" name="region" required>
						<option value="" hidden>Sélectionner une Région</option>
						@foreach($regions as $region)
							@if (old("region") == $region->id)
								<option selected value="{{ $region->id }}">{{ $region->nom }}</option>
							@else
								<option value="{{ $region->id }}">{{ $region->nom }}</option>
							@endif
						@endforeach
					</select>
				</div>

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer l'académie</button>
				</div>
			</form>

		</div>
	</div>
@endsection
