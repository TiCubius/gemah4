@extends('web._includes._master')
@php($title = "Édition de {$document->nom}")

@section('content')

	<div class="row">
		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.documents.index", "id" => [$eleve]])
			Édition de {{ $document->nom }}
		@endcomponent

	</div>

	<!-- enctype="multipart/form-data" permet l'envoie de fichiers -->
	<form action="{{ route('web.scolarites.eleves.documents.update', [$eleve  ->id, $document->id]) }}" method="POST" enctype="multipart/form-data">
		{{ csrf_field() }}
		{{ method_field('PATCH') }}

		<div class="row">
			<div class="col-12">
				<div class="form-group">
					<label for="type">Type</label>
					<select name="type" id="type" class="form-control" required>
						<option disabled value="MDPH">Décision MDPH</option>
						<option selected value="autre">Autre</option>
					</select>
				</div>
			</div>

			<div class="col-sm-12 col-md-6">
				@component("web._includes.components.input", ["name" => "nom", "placeholder" => "Ex : Plainte du 01/01/2019", "value" => $document->nom])
					Nom
				@endcomponent
			</div>

			<div class="col-sm-12 col-md-6">
				@component("web._includes.components.input", ["optional" => true, "name" => "description", "placeholder" => "Ex : Suite au vol de matériel", "value" => $document->description])
					Description
				@endcomponent
			</div>

			<div class="col-sm-12 js-mdph js-other">
				<label for="file">Fichier</label>
				<div class="form-group">
					<div class="custom-file">
						<input id="file" name="file" type="file" class="custom-file-input">
						<label class="custom-file-label" for="file">Choisissez un fichier</label>
					</div>
				</div>
			</div>
		</div>

		@component("web._includes.components.form_edit")
		@endcomponent
	</form>

	@component("web._includes.components.modals.destroy", ["route" => "web.scolarites.eleves.documents.destroy", "id" => [$eleve, $document]])
		@slot("name")
			{{ "{$document->nom}" }}
		@endslot
	@endcomponent
@endsection

@include("web._includes.sidebars.eleve")
