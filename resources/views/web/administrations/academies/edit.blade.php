@extends('web._includes._master')
@php($title = "Édition de l'{$academie->nom}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.academies.index"])
			Édition de l'{{ $academie->nom }}
		@endcomponent

		<div class="col-12">

			<form class="mb-3" action="{{ route("web.administrations.academies.update", [$academie]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				@component("web._includes.components.input", ["name" => "nom", "placeholder" => "Ex: Académie de Lyon", "value" => $academie->nom])
					Nom
				@endcomponent

				<div class="form-group">
					<label for="region">Région</label>
					<select id="region" class="form-control" name="region" required>
						<option value="" hidden>Sélectionner une Région</option>
						@foreach($regions as $region)
							@if ($academie->region_id == $region->id))
							<option selected value="{{ $region->id }}">{{ $region->nom }}</option>
							@else
								<option value="{{ $region->id }}">{{ $region->nom }}</option>
							@endif
						@endforeach
					</select>
				</div>

				@component("web._includes.components.form_edit")
				@endcomponent
			</form>

		</div>
	</div>


	@component("web._includes.components.modals.destroy", 	["route" => "web.administrations.academies.destroy", "id" => $academie])
		@slot("name")
			{{ "{$academie->nom}" }}
		@endslot
	@endcomponent

@endsection
