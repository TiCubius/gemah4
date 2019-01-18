@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.materiels.types.index"])
			Édition de {{ $type->libelle }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.materiels.types.update", [$type]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("PUT") }}

				<div class="form-group">
					<label for="libelle">Libellé</label>
					<input id="libelle" class="form-control" name="libelle" type="text" placeholder="Ex: Clavier" value="{{ $type->libelle }}" required>
				</div>

				<div class="form-group">
					<label for="domaine">Domaine</label>
					<select id="domaine" class="form-control" name="domaine" required>
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

				<div class="d-flex justify-content-between">
					<button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">Supprimer le type</button>
					<button class="btn btn-sm btn-outline-success">Éditer le type</button>
				</div>
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.materiels.types.destroy", "id" => $type])
		@slot("name")
			{{ $type->libelle }}
		@endslot
	@endcomponent

@endsection
