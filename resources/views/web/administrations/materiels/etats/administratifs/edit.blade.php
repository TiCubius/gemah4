@extends('web._includes._master')
@php($title = "Édition de {$administratif->libelle}")

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

				@component("web._includes.components.form_edit")
				@endcomponent
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.administrations.materiels.etats.administratifs.destroy", "id" => $administratif])
		@slot("name")
			{{ $administratif->libelle }}
		@endslot
	@endcomponent

@endsection
