@extends('web._includes._master')
@section('content')
	<div class="row">

		<div class="col-12">
			<div class="d-flex flex-column">
				<div class="d-flex justify-content-between align-items-center">
					<h4>Édition de {{ $TypeMateriel->nom }}</h4>
					<a href="{{ route("web.materiels.types.index") }}">
						<button class="btn btn-outline-primary">Retour</button>
					</a>
				</div>
				<hr class="w-100">
			</div>
		</div>

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.materiels.types.update", [$TypeMateriel->id]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("PUT") }}

				<div class="form-group">
					<label for="nom">Nom du type</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: Smith" value="{{ $TypeMateriel->nom }}" required>
				</div>

				<div class="form-group">
					<label for="domaine">Domaine Matériel</label>
					<select id="domaine" class="form-control" name="domaine" required>
						<option value="" hidden>Sélectionner un Domaine</option>
						@foreach($DomainesMateriel as $DomaineMateriel)
							@if($TypeMateriel->domaine_id === $DomaineMateriel->id)
								<option selected value="{{ $DomaineMateriel->id }}">{{ $DomaineMateriel->nom }}</option>
							@else
								<option value="{{ $DomaineMateriel->id }}">{{ $DomaineMateriel->nom }}</option>
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

	<form id="modal" class="modal fade" action="{{ route("web.materiels.types.destroy", [$TypeMateriel->id]) }}" method="POST" tabindex="-1">
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
						Vous êtes sur le point de supprimer le type <b>{{ strtoupper($TypeMateriel->nom) }}</b>.
						<br>
						Cette action est irreversible </p>
				</div>
				<div class="modal-footer d-flex justify-content-between">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Annuler</button>
					<button type="submit" class="btn btn-danger">Supprimer le type</button>
				</div>
			</div>
		</div>
	</form>
@endsection
