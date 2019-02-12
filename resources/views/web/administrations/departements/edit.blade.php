@extends('web._includes._master')
@php($title = "Édition de {$departement->nom}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.departements.index"])
			Édition de {{ $departement->nom }}
		@endcomponent

		<div class="col-12">

			<form class="mb-3" action="{{ route("web.administrations.departements.update", [$departement]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				@component("web._includes.components.input", ["name" => "id", "placeholder" => "Ex: 42", "value" => $departement->id])
					Code
				@endcomponent

				@component("web._includes.components.input", ["name" => "nom", "placeholder" => "Ex: Loire", "value" => $departement->nom])
					Nom
				@endcomponent


				<div class="form-group">
					<label for="academie_id">Académie</label>
					<select id="academie_id" class="form-control" name="academie_id" required>
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

				@component("web._includes.components.form_edit")
				@endcomponent
			</form>

		</div>
	</div>
	@component("web._includes.components.modals.destroy", ["route" => "web.administrations.departements.destroy", "id" => $departement])
		@slot("name")
			{{ "{$departement->nom}" }}
		@endslot
	@endcomponent
@endsection
