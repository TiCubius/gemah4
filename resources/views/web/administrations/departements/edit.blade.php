@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.departements.index"])
			Édition de {{ $departement->nom }}
		@endcomponent

		<div class="col-12">

			<form class="mb-3" action="{{ route("web.administrations.departements.update", [$departement]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				<div class="form-group">
					<label for="id">Code</label>
					<input id="id" class="form-control" name="id" type="text" placeholder="Code" value="{{ $departement->id }}" required>
				</div>

				<div class="form-group">
					<label for="nom">Nom</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Nom" value="{{ $departement->nom }}" required>
				</div>


				<div class="form-group">
					<label for="academie">Académie</label>
					<select id="academie" class="form-control" name="academie" required>
						<option value="" hidden>Sélectionner une Académie</option>
						@foreach($academies as $academie)
							@if ($departement->academie_id == $academie->id))
							<option selected value="{{ $academie->id }}">{{ $academie->nom }}</option>
							@else
								<option value="{{ $academie->id }}">{{ $academie->nom }}</option>
							@endif
						@endforeach
					</select>
				</div>

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Éditer</button>
				</div>
			</form>

		</div>
	</div>
@endsection
