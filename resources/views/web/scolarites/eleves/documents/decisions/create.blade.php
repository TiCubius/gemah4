@extends('web._includes._master')@php($title = "Nouvelle décision")

@include('web._includes.sidebars.eleve')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.documents.index", "id" => [$eleve]])
			Nouvelle décision
		@endcomponent

		<div class="col-12">

			<!-- enctype="multipart/form-data" permet l'envoie de fichiers -->
			<form action="{{ route('web.scolarites.eleves.documents.decisions.store', [$eleve->id]) }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}

				<div class="row">
					<div class="col-6">
						@component("web._includes.components.input", ["optional" => true, "name" => "date_cda", "type" => "date", "placeholder" => "Ex: 07/01/2019"])
							Date de la CDA
						@endcomponent

						@component("web._includes.components.input", ["optional" => true, "name" => "date_notif", "type" => "date", "placeholder" => "Ex: 07/01/2019"])
							Date de réception de la notification
						@endcomponent

						@component("web._includes.components.input", ["optional" => true, "name" => "date_limite", "type" => "date", "placeholder" => "Ex: 07/01/2019"])
							Date limite
						@endcomponent


						@component("web._includes.components.input", ["optional" => true, "name" => "date_convention", "type" => "date", "placeholder" => "Ex: 07/01/2019"])
							Date de la convention
						@endcomponent
					</div>

					<div class="col-6">
						@component("web._includes.components.input", ["optional" => true, "name" => "numero_dossier", "placeholder" => "Ex: 295631"])
							Numéro de dossier MDPH
						@endcomponent

						<div class="form-group">
							<label class="optional" for="enseignant_id">Nom/prénom de l'enseignant référent</label>
							<select name="enseignant_id" id="enseignant_id" class="form-control">
								<option value="">Choisissez l'enseignant référent</option>
								@foreach ($enseignants as $enseignant)
									<option value="{{ $enseignant->id }}">{{ $enseignant->nom }} {{ $enseignant->prenom }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							Type d'élève

							<div class="border border rounded pt-0 pl-2 pt-1 mt-1">
								@foreach($types as $type)
									<div class="custom-control custom-checkbox mb-1">
										<input id="type-{{ $type->id }}" class="custom-control-input" name="types[]" value="{{ $type->id }}" type="checkbox">
										<label class="custom-control-label" for="type-{{ $type->id }}">{{ $type->libelle }}</label>
									</div>
								@endforeach
							</div>
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

					<div class="col-12 mt-3 ">
						<div class="float-right">
							<button class="btn btn-outline-success btn-sm" type="submit">
								Ajouter la décision
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection