@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.materiels.etats.index"])
			Édition de {{ $etat->nom }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.materiels.etats.update", [$etat]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				<div class="form-group">
					<label for="nom">Nom de l'état matériel</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="E.g : Volé, Cassé" value="{{ $etat->nom }}" required>
				</div>
				<div class="form-group">
					<label for="nom">Couleur de l'état matériel</label>
					<input id="nom" class="form-control" name="couleur" type="color" placeholder="couleur" value="{{ $etat->couleur }}" required>
				</div>

				<div class="d-flex justify-content-between">
					<button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">Supprimer l'état matériel</button>
					<button class="btn btn-sm btn-outline-success">Éditer l'état matériel</button>
				</div>
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.administrations.materiels.etats.destroy", "id" => $etat])
		@slot("name")
			{{ $etat->nom }}
		@endslot
	@endcomponent

@endsection
