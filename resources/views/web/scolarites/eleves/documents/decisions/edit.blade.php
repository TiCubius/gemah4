@extends('web._includes._master')

@include('web._includes.sidebars.eleve')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.documents.index", "id" => [$eleve]])
			Édition de {{ $decision->document->nom }}
		@endcomponent


		<div class="col-12">
			<!-- enctype="multipart/form-data" permet l'envoie de fichiers -->
			<form action="{{ route('web.scolarites.eleves.documents.decisions.update', [$eleve, $decision]) }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				{{ method_field('PATCH') }}

				<div class="row">
					<div class="col-6">
						<div>
							<div class="form-group">
								<label class="optional" for="date_cda">Date de la CDA</label>
								<input type="date" id="date_cda" name="date_cda" placeholder="Ex: 01/01/2019" class="form-control" value="{{ $decision->date_cda ? $decision->date_cda->format('Y-m-d') : '' }}">
							</div>
						</div>

						<div>
							<div class="form-group">
								<label class="optional" for="date_notification">Date de réception de la notification</label>
								<input type="date" id="date_notification" name="date_notification" placeholder="Ex: 01/01/2019" class="form-control" value="{{ $decision->date_notification ? $decision->date_notification->format('Y-m-d') : '' }}">
							</div>
						</div>

						<div>
							<div class="form-group">
								<label class="optional" for="date_limite">Date limite</label>
								<input type="date" id="date_limite" name="date_limite" placeholder="Ex: 01/01/2019" class="form-control" value="{{ $decision->date_limite ? $decision->date_limite->format('Y-m-d') : '' }}">
							</div>
						</div>

						<div>
							<div class="form-group">
								<label class="optional" for="date_convention">Date de la convention</label>
								<input type="date" id="date_lidate_conventionmite" name="date_convention" placeholder="Ex: 01/01/2019" class="form-control" value="{{ $decision->date_convention ? $decision->date_convention->format('Y-m-d') : '' }}">
							</div>
						</div>
					</div>

					<div class="col-6">
						<div>
							<div class="form-group">
								<label class="optional" for="numero_dossier">Numéro du dossier MDPH</label>
								<input type="text" id="numero_dossier" name="numero_dossier" placeholder="Ex: ..." class="form-control" value="{{ $decision->numero_dossier ?? '' }}">
							</div>
						</div>

						<div>
							<div class="form-group">
								<label class="optional" for="enseignant_id">Nom/prénom de l'enseignant référent</label>
								<select name="enseignant_id" id="enseignant_id" class="form-control">
									<option value="">Choisissez l'enseignant référent</option>
									@foreach ($enseignants as $enseignant)
										@if ($enseignant->id === $decision->enseignant_id)
											<option selected value="{{ $enseignant->id }}">{{ $enseignant->nom }} {{ $enseignant->prenom }}</option>
										@else
											<option value="{{ $enseignant->id }}">{{ $enseignant->nom }} {{ $enseignant->prenom }}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group">
							Type d'élève
							<div class="border border rounded pt-0 pl-2 pt-1 mt-1">
								@foreach($types as $type)
									<div class="custom-control custom-checkbox mb-1">
										@if($decision->types->contains($type))
											<input id="type-{{ $type->id }}" class="custom-control-input" name="types[]" value="{{ $type->id }}" type="checkbox" checked>
										@else
											<input id="type-{{ $type->id }}" class="custom-control-input" name="types[]" value="{{ $type->id }}" type="checkbox">
										@endif
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
				</div>

				@component("web._includes.components.form_edit")
				@endcomponent
			</form>
		</div>

	</div>
	@component("web._includes.components.modals.destroy", ["route" => "web.scolarites.eleves.documents.decisions.destroy", "id" => [$eleve, $decision]])
		@slot("name")
			{{ $decision->document->nom }}
		@endslot
	@endcomponent
@endsection