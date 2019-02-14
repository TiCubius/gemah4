@extends('web._includes._master')
@php($title = "Nouveau document")

@section('content')
	<div class="row">
		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.documents.index", "id" => [$eleve]])
			Nouveau document
		@endcomponent

	</div>

	<!-- enctype="multipart/form-data" permet l'envoie de fichiers -->
	<form action="{{ route('web.scolarites.eleves.documents.store', [$eleve]) }}" method="POST" enctype="multipart/form-data">
		{{ csrf_field() }}

		<div class="row">
			<div class="col-sm-12 col-md-6">
				@component("web._includes.components.input", ["name" => "nom", "placeholder" => "Ex : Plainte du 01/01/2019"])
					Nom
				@endcomponent
			</div>


			<div class="col-sm-12 col-md-6">
				<div class="form-group">
					<label for="type_document_id">Type</label>
					<select id="type_document_id" class="form-control" name="type_document_id" required>
						<option selected value="" hidden>Sélectionnez un type</option>
						@foreach($types as $type)
							@if($type->libelle !== "Décision")
								@if(old("type_document_id") == $type->id || request("type_document_id") == $type->id)
									<option selected value="{{ $type->id }}">{{ $type->libelle }}</option>
								@else
									<option value="{{ $type->id }}">{{ $type->libelle }}</option>
								@endif
							@endif
						@endforeach
					</select>
				</div>
			</div>

			<div class="col-sm-12 col-md-6">
				@component("web._includes.components.input", ["optional" => true, "name" => "description", "placeholder" => "Ex : Suite au vol de matériel"])
					Description
				@endcomponent
			</div>

			<div class="col-sm-12">
				<label for="file">Fichier</label>
				<div class="form-group">
					<div class="custom-file">
						<input id="file" name="file" type="file" class="custom-file-input" required>
						<label class="custom-file-label" for="file">Choisissez un fichier</label>
					</div>
				</div>
			</div>

			<div class="col-12 my-3">
				<div class="float-right">
					<button class="btn btn-outline-success btn-sm" type="submit">
						Ajouter
					</button>
				</div>
			</div>
		</div>
	</form>
@endsection

@include("web._includes.sidebars.eleve")
