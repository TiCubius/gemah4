@extends('web._includes._master')

@section('content')

	<div class="row">
		@component("web._includes.components.title", ["back" => "web.scolarites.eleves.show", "id" => [$eleve]])
			<div class="d-flex justify-content-between">
				<h4>Gestion des documents</h4>
			</div>
			@slot("custom")
				<div class="btn-group">

					<div class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Ajouter un document
					</div>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
						<a class="dropdown-item" href="{{route('web.scolarites.eleves.documents.decisions.create', [$eleve]) }}">
							Décision
						</a>
						<a class="dropdown-item" href="{{ route('web.scolarites.eleves.documents.create', [$eleve]) }}">
							Autre document
						</a>
					</div>
				</div>
			@endslot
		@endcomponent

	</div>


	@if ($eleve->documents->isEmpty())
		<div class="col-12">
			<div class="alert alert-warning">
				Aucun document n'a été trouvé pour cet élève
			</div>
		</div>

	@else
		<div class="row">
			<div class="col-12">
				<div class="form-group">
					<label for="type">Type de Document</label>
					<select name="type" id="type" class="form-control" required>
						<option selected value="" hidden>Choisissez un Type de Document</option>
						@foreach($typesDocument as $typeDocument)
							<option value="{{ $typeDocument->id }}">{{ $typeDocument->libelle }}</option>
						@endforeach
					</select>
				</div>
			</div>

			@foreach($eleve->documents as $document)
				@if ($document->typeDocument->libelle == "Décision")
					<div class="col-6 js-document js-document-{{ $document->type_document_id }}" style="display: none;">
						<div class="card mb-3">
							<div class="card-body">
								<p class="mb-0">
									<b>Réunion CDA</b>:
									{!! $document->decision->date_cda ? $document->decision->date_cda->format("d/m/Y") : '<span class="text-muted">Non défini</span>' !!}
								</p>
								<p class="mb-0">
									<b>Réception de la Notification</b>:
									{!! $document->decision->date_notification ? $document->decision->date_notification->format("d/m/Y") : '<span class="text-muted">Non défini</span>' !!}
								</p>
								<p class="mb-0">
									<b>Date Limite de la Décision</b>:
									{!! $document->decision->date_limite ? $document->decision->date_limite->format("d/m/Y") : '<span class="text-muted">Non défini</span>' !!}
								</p>
								<p class="mb-0">
									<b>Date Convention</b>:
									{!! $document->decision->date_convention ? $document->decision->date_convention->format("d/m/Y") : '<span class="text-muted">Non défini</span>' !!}
								</p>

								<hr>
								<p class="mb-0">
									<b>Numéro MDPH</b>:
									{!! $document->decision->numero_dossier ?? '<span class="text-muted">Non défini</span>' !!}
								</p>
								<p class="mb-0">
									<b>Enseignant Référent</b>:
									@if ($document->decision->enseignant_id !== NULL)
										{{ $document->decision->enseignant->nom }} {{ $document->decision->enseignant->prenom }}
									@else
										<span class="text-muted">Non défini</span>
									@endif
								</p>
								<p class="mb-0">
									<b>Suivi par</b>:
									{!! $document->decision->nom_suivi ?? '<span class="text-muted">Non défini</span>' !!}
								</p>
							</div>
							<div class="card-footer d-flex justify-content-between">
								<a class="btn btn-sm btn-outline-secondary" href="{{ route('web.scolarites.eleves.documents.decisions.edit', [$eleve, $document->decision]) }}">
									<i class="far fa-edit"></i>
									Modifier
								</a>
								<div class="btn-group">
									<a class="btn btn-sm btn-outline-success" target="_blank" href="{{ route("web.scolarites.eleves.documents.decisions.download", [$eleve, $document->decision]) }}">
										<i class="fas fa-download"></i>
										Télécharger
									</a>
									<a class="btn btn-sm btn-outline-success" target="_blank" href="{{ asset('storage/decisions/' . $document->path) }}">
										<i class="far fa-eye"></i>
										Visualiser
									</a>
								</div>
							</div>
						</div>
					</div>
				@else
					<div class="col-6 js-document js-document-{{ $document->type_document_id }}" style="display: none;">
						<div class="card mb-3">
							<div class="card-body">
								<p class="mb-0">
									<b>Nom</b>:
									{!! $document->nom ?? '<span class="text-muted">Non défini</span>' !!}
								</p>
								<p>
									<b>Description</b>:
									{!! $document->description ?? '<span class="text-muted">Non défini</span>' !!}
								</p>
								<p class="mb-0">Document soumis le {{ $document->created_at }}</p>
							</div>
							<div class="card-footer gemah-bg-primary d-flex justify-content-between">
								<a class="btn btn-sm btn-outline-warning" href="{{ route('web.scolarites.eleves.documents.edit', [$eleve->id, $document->id]) }}">
									<i class="far fa-edit"></i>
									Modifier
								</a>
								@if($document->path)
									<div class="btn-group">
										<a class="btn btn-sm btn-primary" target="_blank" href="{{ route("web.scolarites.eleves.documents.download", [$eleve, $document]) }}">
											<i class="fas fa-download"></i>
											Télécharger
										</a>
										<a class="btn btn-sm btn-primary" href="{{ asset('storage/documents/' . $document->path) }}">
											<i class="far fa-eye"></i>
											Visualiser
										</a>
									</div>
								@else
									<div class="btn-group" data-toggle="tooltip" data-placement="top" title="Aucun fichier n'a été envoyé lors de la création du document">
										<a class="btn btn-sm btn-outline-danger" href="#">
											<i class="far fa-question-circle"></i>
										</a>
									</div>
								@endif
							</div>
						</div>
					</div>
				@endif
			@endforeach
		</div>
	@endif

@endsection

@include("web._includes.sidebars.eleve")

@section('scripts')
	<script>

		$('#type').on('change', () => {

			let type = $("#type")

			$(`.js-document`).hide()
			$(`.js-document-${type.val()}`).show()

		}).trigger("change")

	</script>
@endsection