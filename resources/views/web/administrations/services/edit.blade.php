@extends('web._includes._master')
@section('content')
	<div class="row">

		<div class="col-12">
			<div class="d-flex flex-column">
				<div class="d-flex justify-content-between align-items-center">
					<h4>Édition de {{ $service->nom }}</h4>
					<a href="{{ route("web.administrations.services.index") }}">
						<button class="btn btn-outline-primary">Retour</button>
					</a>
				</div>
				<hr class="w-100">
			</div>
		</div>

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.services.update", [$service->id]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				<div class="form-group">
					<label for="nom">Nom du service</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Nom" value="{{ $service->nom }}" required>
				</div>

				<div class="form-group">
					<label for="description">Description du service</label>
					<input id="description" class="form-control" name="description" type="text" placeholder="Description" value="{{ $service->description }}" required>
				</div>

				<div class="d-flex justify-content-between">
					<button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">Supprimer le servicee</button>
					<button class="btn btn-sm btn-outline-success">Éditer le service</button>
				</div>
			</form>
		</div>
	</div>

	<form id="modal" class="modal fade" action="{{ route("web.administrations.services.destroy", [$service->id]) }}" method="POST" tabindex="-1">
		{{ csrf_field() }}
		{{ method_field("DELETE") }}

		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Attention</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body text-center">
					<p>
						Vous êtes sur le point de supprimer le service <b>{{ strtoupper($service->nom) }}</b>.
						<br>
						Cette action est irreversible </p>
				</div>
				<div class="modal-footer d-flex justify-content-between">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Annuler</button>
					<button type="submit" class="btn btn-danger">Supprimer le service</button>
				</div>
			</div>
		</div>
	</form>
@endsection
