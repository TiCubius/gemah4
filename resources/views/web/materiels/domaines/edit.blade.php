@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.materiels.domaines.index"])
			Édition de {{ $domaine->libelle }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.materiels.domaines.update", [$domaine]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("PUT") }}

				<div class="form-group">
					<label for="libelle">Libellé</label>
					<input id="libelle" class="form-control" name="libelle" type="text" placeholder="Ex: Informatique" value="{{ $domaine->libelle }}" required>
				</div>

				<div class="d-flex justify-content-between">
					<button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">Supprimer le domaine</button>
					<button class="btn btn-sm btn-outline-success">Éditer le domaine</button>
				</div>
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.materiels.domaines.destroy", "id" => $domaine])
		@slot("name")
			{{ $domaine->libelle }}
		@endslot
	@endcomponent
@endsection
