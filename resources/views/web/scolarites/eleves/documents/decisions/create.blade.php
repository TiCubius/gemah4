@extends('web._includes._master')

@include('web._includes.sidebars.eleve')
@section('content')

	@component("web._includes.components.title", ["back" => "web.scolarites.eleves.documents.index", "id" => [$eleve]])
		Nouvelle décision
	@endcomponent

	<!-- enctype="multipart/form-data" permet l'envoie de fichiers -->
	<form action="{{ route('web.scolarites.eleves.documents.decisions.store', [$eleve->id]) }}" method="POST" enctype="multipart/form-data">
		{{ csrf_field() }}

		<div class="row">
			<div class="col-6">
				<div class="form-group">
					<label class="optional" for="date_cda">Date de la CDA</label>
					<input type="date" id="date_cda" name="date_cda" placeholder="Date de la CDA" class="form-control" value="{{ Session::get('_old_input')['date_cda'] ?? '' }}">
				</div>

				<div class="form-group">
					<label class="optional" for="date_notif">Date de réception de la notification</label>
					<input type="date" id="date_notif" name="date_notif" placeholder="Date de réception de la notification" class="form-control" value="{{ Session::get('_old_input')['date_notif'] ?? '' }}">
				</div>

				<div class="form-group">
					<label class="optional" for="date_limite">Date limite</label>
					<input type="date" id="date_limite" name="date_limite" placeholder="Date limite de la décision" class="form-control" value="{{ Session::get('_old_input')['date_limite'] ?? '' }}">
				</div>

				<div class="form-group">
					<label class="optional" for="date_convention">Date de la convention</label>
					<input type="date" id="date_lidate_conventionmite" name="date_convention" placeholder="Date de la convention" class="form-control" value="{{ Session::get('_old_input')['date_lidate_conventionmite'] ?? '' }}">
				</div>
			</div>

			<div class="col-6">
				<div>
					<div class="form-group">
						<label for="numero_dossier">Numéro du dossier MDPH</label>
						<input type="text" id="numero_dossier" name="numero_dossier" placeholder="Numéro du dossier Mdph" class="form-control" value="{{ Session::get('_old_input')['numero_dossier'] ?? '' }}">
					</div>
				</div>

				<div class="form-group">
					<label for="enseignant_id">Nom/prénom de l'enseignant référent</label>
					<select name="enseignant_id" id="enseignant_id" class="form-control">
						<option value="">Choisissez l'enseignant référent</option>
						@foreach ($enseignants as $enseignant)
							<option value="{{ $enseignant->id }}">{{ $enseignant->nom }} {{ $enseignant->prenom }}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label for="nom_suivi">Affaire suivie par</label>
					<input type="text" id="nom_suivi" name="nom_suivi" placeholder="Affaire suivie par" class="form-control" value="{{ Session::get('_old_input')['nom_suivi'] ?? '' }}">
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
@endsection