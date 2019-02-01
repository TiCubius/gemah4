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
						@hasPermission("eleves/decisions/create")
						<a class="dropdown-item" href="{{route('web.scolarites.eleves.documents.decisions.create', [$eleve]) }}">
							Décision
						</a>
						@endHas

						@hasPermission("eleves/documents/create")
						@foreach($types->where("libelle", "<>", "Décision") as $type)
							<a class="dropdown-item" href="{{ route('web.scolarites.eleves.documents.create', [$eleve, "type_document_id" => $type->id]) }}">
								{{ $type->libelle }}
							</a>
						@endforeach
						@endHas
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
					<label for="type">Trier par type de document :</label>
					<select selected name="type" id="type" class="form-control" required>
						<option selected value="">Tout les types de documents</option>
						@foreach($types as $typeDocument)
							<option value="{{ $typeDocument->id }}">{{ $typeDocument->libelle }}</option>
						@endforeach
					</select>
				</div>
			</div>

			@foreach($eleve->documents->sortByDesc("created_at") as $document)
				@if ($document->typeDocument->libelle == "Décision")
					<div class="col-6 js-document js-document-{{ $document->type_document_id }}" style="display: none;">
						<div class="card mb-3">
							<div class="card-body">
								<p class="mb-0">
									<strong>Nom</strong>:
									{!! $document->nom ?? '<span class="text-muted">Non défini</span>' !!}
								</p>
								<hr>
								<p class="mb-0">
									<strong>Réunion CDA</strong>:
									{!! $document->decision->date_cda ? $document->decision->date_cda->format("d/m/Y") : '<span class="text-muted">Non défini</span>' !!}
								</p>
								<p class="mb-0">
									<strong>Réception de la Notification</strong>:
									{!! $document->decision->date_notification ? $document->decision->date_notification->format("d/m/Y") : '<span class="text-muted">Non défini</span>' !!}
								</p>
								<p class="mb-0">
									<strong>Date Limite de la Décision</strong>:
									{!! $document->decision->date_limite ? $document->decision->date_limite->format("d/m/Y") : '<span class="text-muted">Non défini</span>' !!}
								</p>
								<p class="mb-0">
									<strong>Date Convention</strong>:
									{!! $document->decision->date_convention ? $document->decision->date_convention->format("d/m/Y") : '<span class="text-muted">Non défini</span>' !!}
								</p>

								<hr>
								<p class="mb-0">
									<strong>Numéro MDPH</strong>:
									{!! $document->decision->numero_dossier ?? '<span class="text-muted">Non défini</span>' !!}
								</p>
								<p class="mb-0">
									<strong>Enseignant Référent</strong>:
									@if ($document->decision->enseignant)
										{{ "{$document->decision->enseignant->nom} {$document->decision->enseignant->prenom}" }}
									@else
										<span class="text-muted">Non défini</span>
									@endif
								</p>
								<p class="mb-0">
									<strong>Suivi par</strong>:
									{!! $document->decision->nom_suivi ?? '<span class="text-muted">Non défini</span>' !!}
								</p>
							</div>
							<div class="card-footer gemah-bg-primary d-flex justify-content-between">
								@hasPermission("eleves/decisions/edit")
								<a class="btn btn-sm btn-outline-warning" href="{{ route('web.scolarites.eleves.documents.decisions.edit', [$eleve->id, $document->decision]) }}">
									<i class="far fa-edit"></i>
									Éditer
								</a>
								@endHas

								@hasPermission("eleves/decisions/download")
								<div class="btn-group">
									<a class="btn btn-sm btn-primary" href="{{ route("web.scolarites.eleves.documents.decisions.download", [$eleve, $document->decision]) }}">
										<i class="fas fa-download"></i>
										Télécharger
									</a>

									<a class="btn btn-sm btn-primary" href="{{ asset("storage/decisions/{$document->path}") }}" target="_blank">
										<i class="far fa-eye"></i>
										Visualiser
									</a>
								</div>
								@endHas
							</div>
						</div>
					</div>
				@else
					<div class="col-6 js-document js-document-{{ $document->type_document_id }}" style="display: none;">
						<div class="card mb-3">
							<div class="card-body">
								<p class="mb-0">
									<strong>Nom</strong>:
									{!! $document->nom ?? '<span class="text-muted">Non défini</span>' !!}
								</p>
								<p>
									<strong>Description</strong>:
									{!! $document->description ?? '<span class="text-muted">Non défini</span>' !!}
								</p>
								<p class="mb-0">Document soumis le {{ $document->created_at->format("d/m/Y à H:i:s") }}</p>
							</div>
							<div class="card-footer gemah-bg-primary d-flex justify-content-between">
								@hasPermission("eleves/documents/edit")
								<a class="btn btn-sm btn-outline-warning" href="{{ route('web.scolarites.eleves.documents.edit', [$eleve->id, $document->id]) }}">
									<i class="far fa-edit"></i>
									Éditer
								</a>
								@endHas

								@hasPermission("eleves/documents/download")
								<div class="btn-group">
									<a class="btn btn-sm btn-primary" href="{{ route("web.scolarites.eleves.documents.download", [$eleve, $document]) }}">
										<i class="fas fa-download"></i>
										Télécharger
									</a>
									<a class="btn btn-sm btn-primary" href="{{ asset("storage/documents/{$document->path}") }}" target="_blank">
										<i class="far fa-eye"></i>
										Visualiser
									</a>
								</div>
								@endHas
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

			if (type.val() === "") {
				$(`.js-document`).show()
			} else {
				$(`.js-document`).hide()
				$(`.js-document-${type.val()}`).show()
			}

		}).trigger("change")

	</script>
@endsection