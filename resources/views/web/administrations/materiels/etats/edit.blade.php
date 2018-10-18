@extends('web._includes._master')
@section('content')
	<div class="row">

		<div class="col-12">
			<div class="d-flex flex-column">
				<div class="d-flex justify-content-between align-items-center">
					<h4>Édition de {{ $Etat->nom }}</h4>
					<a href="{{ route("web.administrations.materiels.etats.index") }}">
						<button class="btn btn-outline-primary">Retour</button>
					</a>
				</div>
				<hr class="w-100">
			</div>
		</div>

		<div class="col-12">

			<form class="mb-3" action="{{ route("web.administrations.materiels.etats.update", [$Etat->id]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				<div class="form-group">
					<label for="nom">Nom de l'état matériel</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="E.g : Volé, Cassé" value="{{ $Etat->nom }}" required>
				</div>
				<div class="form-group">
					<label for="nom">Couleur de l'état matériel</label>
					<input id="nom" class="form-control" name="couleur" type="color" placeholder="couleur" value="{{ $Etat->couleur }}" required>
				</div>

				<div class="d-flex justify-content-between">
					<button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">Supprimer l'état matériel</button>
					<button class="btn btn-sm btn-outline-success">Éditer l'état matériel</button>
				</div>
			</form>
		</div>
	</div>

	<form id="modal" class="modal fade" action="{{ route("web.administrations.materiels.etats.destroy", [$Etat->id]) }}" method="POST" tabindex="-1">
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
						Vous êtes sur le point de supprimer <b>{{ strtoupper("{$Etat->nom}") }}</b>.
						<br>
						Cette action est irreversible </p>
				</div>
				<div class="modal-footer d-flex justify-content-between">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Annuler</button>
					<button type="submit" class="btn btn-danger">Supprimer l'état matériel</button>
				</div>
			</div>
		</div>
	</form>
@endsection
