@extends('web._includes._master')
@php($title = "Création d'un type matériel")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.materiels.types.index"])
			Création d'un type matériel
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.materiels.types.index") }}" method="POST">
				{{ csrf_field() }}

				@component("web._includes.components.input", ["name" => "libelle", "placeholder" => "Ex: Clavier"])
					Libellé
				@endcomponent

				<div class="form-group">
					<label for="domaine_id">Domaine</label>
					<select id="domaine_id" class="form-control" name="domaine_id" required>
						<option value="" hidden>Sélectionner un Domaine</option>
						@foreach($domaines as $domaine)
							<option value="{{ $domaine->id }}">{{ $domaine->libelle }}</option>
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
