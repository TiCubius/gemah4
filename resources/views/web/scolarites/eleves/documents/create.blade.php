@extends('web._includes._master')

@section('content')
	<div class="row">
		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.documents.index", "id" => [$eleve]])
			Nouveau document
		@endcomponent

	</div>

	<!-- enctype="multipart/form-data" permet l'envoie de fichiers -->
	<form action="{{ route('web.scolarites.eleves.documents.store', $eleve->id) }}" method="POST" enctype="multipart/form-data">
		{{ csrf_field() }}

		<div class="row">
			<div class="col-sm-12 col-md-6">
				<div class="form-group">
					<label for="nom">Nom du document</label>
					<input type="text" id="nom" name="nom" placeholder="Nom du Document" class="form-control" value="{{ Session::get('_old_input')['nom'] ?? '' }}">
				</div>
			</div>

			<div class="col-sm-12 col-md-6">
				<div class="form-group">
					<label for="type_document_id">Type</label>
					<select id="type_document_id" class="form-control" name="type_document_id" required>
						<option selected value="" hidden>Sélectionnez un type</option>
						@foreach($types as $type)
							@if($type->libelle !== "Décision"))
							<option value="{{ $type->id }}">{{ $type->libelle }}</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>

			<div class="col-sm-12 col-md-6">
				<div class="form-group">
					<label for="description">Description du document</label>
					<input type="text" id="description" name="description" placeholder="Description du Document" class="form-control" value="{{ Session::get('_old_input')['description'] ?? '' }}">
				</div>
			</div>

			<div class="col-sm-12">
				<label for="file">Fichier</label>
				<div class="form-group">
					<div class="custom-file">
						<input id="file" name="file" type="file" class="custom-file-input">
						<label class="custom-file-label" for="file">Choisissez un fichier</label>
					</div>
				</div>
			</div>

			<div class="col-12 mt-3">
				<div class="float-right">
					<button class="btn btn-outline-success btn-sm" type="submit">
						Ajouter un document
					</button>
				</div>
			</div>
		</div>
	</form>
@endsection

@include("web._includes.sidebars.eleve")
