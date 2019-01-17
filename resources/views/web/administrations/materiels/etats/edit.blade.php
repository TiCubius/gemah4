@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.materiels.etats.index"])
			Édition de {{ $etat->libelle }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.materiels.etats.update", [$etat]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				<div class="form-group">
					<label for="libelle">Libellé</label>
					<input id="libelle" class="form-control" name="libelle" type="text" placeholder="Ex: Volé" value="{{ $etat->libelle }}" required>
				</div>
				<div class="form-group">
					<label for="couleur">Couleur</label>
					<input id="couleur" class="form-control" name="couleur" type="color" value="{{ $etat->couleur }}" required>
				</div>

				@component("web._includes.components.form_edit")
				@endcomponent
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.administrations.materiels.etats.destroy", "id" => $etat])
		@slot("name")
			{{ $etat->libelle }}
		@endslot
	@endcomponent

@endsection
