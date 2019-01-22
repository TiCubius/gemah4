@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.materiels.etats.administratifs.index"])
			Édition de {{ $administratif->libelle }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.materiels.etats.administratifs.update", [$administratif]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				<div class="form-group">
					<label for="libelle">Libellé</label>
					<input id="libelle" class="form-control" name="libelle" type="text" placeholder="Ex: Volé" value="{{ $administratif->libelle }}" required>
				</div>
				<div class="form-group">
					<label for="couleur">Couleur</label>
					<input id="couleur" class="form-control" name="couleur" type="color" value="{{ $administratif->couleur }}" required>
				</div>

				<div class="d-flex justify-content-between">
					<button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">Supprimer l'état administratif matériel</button>
					<button class="btn btn-sm btn-outline-success">Éditer l'état administratif matériel</button>
				</div>
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.administrations.materiels.etats.administratifs.destroy", "id" => $administratif])
		@slot("name")
			{{ $administratif->libelle }}
		@endslot
	@endcomponent

@endsection
