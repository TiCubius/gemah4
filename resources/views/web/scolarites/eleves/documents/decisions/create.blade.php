@extends('web._includes._master')
@php($title = "Nouvelle décision")

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
						<div class="form-group">
							<label class="optional" for="date_cda">Date de la CDA</label>
							<input type="date" id="date_cda" name="date_cda" placeholder="Ex: 01/01/2019" class="form-control" value="{{ Session::get('_old_input')['date_cda'] ?? '' }}">
						</div>

						<div class="form-group">
							<label class="optional" for="date_notif">Date de réception de la notification</label>
							<input type="date" id="date_notif" name="date_notif" placeholder="Ex: 01/01/2019" class="form-control" value="{{ Session::get('_old_input')['date_notif'] ?? '' }}">
						</div>

						<div class="form-group">
							<label class="optional" for="date_limite">Date limite</label>
							<input type="date" id="date_limite" name="date_limite" placeholder="Ex: 01/01/2019" class="form-control" value="{{ Session::get('_old_input')['date_limite'] ?? '' }}">
						</div>

						<div class="form-group">
							<label class="optional" for="date_convention">Date de la convention</label>
							<input type="date" id="date_convention" name="date_convention" placeholder="Ex: 01/01/2019" class="form-control" value="{{ Session::get('_old_input')['date_convention'] ?? '' }}">
						</div>
					</div>

					<div class="col-6">
						<div>
							<div class="form-group">
								<label class="optional" for="numero_dossier">Numéro du dossier MDPH</label>
								<input type="text" id="numero_dossier" name="numero_dossier" placeholder="Ex: ..." class="form-control" value="{{ Session::get('_old_input')['numero_dossier'] ?? '' }}">
							</div>
						</div>

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