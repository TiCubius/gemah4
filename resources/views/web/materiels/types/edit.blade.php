@extends('web._includes._master')
@php($title = "Édition de {$type->libelle}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.materiels.types.index"])
			Édition de {{ $type->libelle }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.materiels.types.update", [$type]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("PUT") }}

				@component("web._includes.components.input", ["name" => "libelle", "placeholder" => "Ex: Clavier", "value" => $type->libelle])
					Libellé
				@endcomponent

				<div class="form-group">
					<label for="domaine_id">Domaine</label>
					<select id="domaine_id" class="form-control" name="domaine_id" required>
						<option value="" hidden>Sélectionner un Domaine</option>
						@foreach($domaines as $domaine)
							@if($type->domaine_id === $domaine->id)
								<option selected value="{{ $domaine->id }}">{{ $domaine->libelle }}</option>
							@else
								<option value="{{ $domaine->id }}">{{ $domaine->libelle }}</option>
							@endif
						@endforeach
					</select>
				</div>

				@component("web._includes.components.form_edit")
				@endcomponent
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.materiels.types.destroy", "id" => $type])
		@slot("name")
			{{ $type->libelle }}
		@endslot
	@endcomponent

@endsection
