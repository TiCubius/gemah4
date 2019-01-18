@extends("web._includes._master")
@section('content')

	@component('web._includes.components.title', ["back" => "web.index"])
		Liste des conventions

		@slot("custom")
			<div class="btn-group">
				<div class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Gestion des conventions
				</div>

				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item" href="{{ route("web.conventions.signatures_effectues") }}">Liste des responsables ayant signé</a>
					<a class="dropdown-item" href="{{ route("web.conventions.signatures_manquantes") }}">Liste des responsables n'aynt pas signé</a>

					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="{{ route("web.conventions.impressions_toutes_conventions") }}">Impression de toutes les signatures non signé</a>

					<div class="dropdown-divider"></div>
					<a id="export" class="dropdown-item" href="#" download="data.json">Sauvegarder la liste actuelle</a>
					<a class="dropdown-item" data-toggle="modal" data-target="#modal">Importer une sauvegarde</a>
					<a id="reset" class="dropdown-item" href="#">Remettre à zéro</a>
				</div>
			</div>
		@endslot
	@endcomponent

	<div class="row">
		<div class="col-12">
			<form method="POST" action="{{ route("web.conventions.update", ["" => $eleves]) }}">
				{{ csrf_field() }}
				{{ method_field("PATCH") }}

				<div class="row">
					@foreach($eleves as $eleve)
						<div class="col-12 col-md-6 col-lg-3 mt-3">
							<div class="card">
								<div class="card-header gemah-bg-primary">
									{{ $eleve->nom }} {{ $eleve->prenom }}
								</div>

								<div class="card-body">
									@foreach($eleve->responsables as $responsable)
										@if($responsable->pivot->etat_signature)
											<div class="custom-control custom-checkbox" data-toggle="tooltip" data-placement="bottom" title="Signée le {{ \Carbon\Carbon::parse($responsable->pivot->date_signature)->format("d/m/Y") }}">
												<input name="eleve-{{$eleve->id}}_responsable-{{ $responsable->id }}" id="eleve-{{$eleve->id}}_responsable-{{ $responsable->id }}" class="custom-control-input js-checkbox" type="checkbox" checked>

												<label class="custom-control-label" for="eleve-{{$eleve->id}}_responsable-{{ $responsable->id }}">
													{{ $responsable->nom }} {{ $responsable->prenom }}
												</label>
											</div>
										@else
											<div class="custom-control custom-checkbox">
												<input name="eleve-{{$eleve->id}}_responsable-{{ $responsable->id }}" id="eleve-{{$eleve->id}}_responsable-{{ $responsable->id }}" class="custom-control-input js-checkbox" type="checkbox">

												<label class="custom-control-label" for="eleve-{{$eleve->id}}_responsable-{{ $responsable->id }}">
													{{ $responsable->nom }} {{ $responsable->prenom }}
												</label>
											</div>
										@endif
									@endforeach
								</div>
							</div>
						</div>
					@endforeach
				</div>

				<button type="submit" class="btn btn-menu btn-outline-primary float-right my-3">Enregistrer</button>
			</form>
		</div>
	</div>

	<form id="modal" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					Importer des données
				</div>

				<div class="modal-body text-center">
					<p>
						L'importation d'une sauvegarde précédente écrasera toutes les données présentes.
						<br>
					</p>

					<div class="custom-file">
						<input id="file" type="file" class="custom-file-input" id="customFile">
						<label class="custom-file-label" for="customFile">Choose file</label>
					</div>
				</div>

				<div class="modal-footer d-flex justify-content-between">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Annuler</button>
					<button id="import" type="button" class="btn btn-primary" data-dismiss="modal">Importer</button>
				</div>
			</div>
		</div>
	</form>

@endsection

@section("scripts")
	<script>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>
	<script>
		document.querySelector(`#reset`).addEventListener(`click`, () => {
			let inputs = document.querySelectorAll('.js-checkbox')
			for (let i = 0; i < inputs.length; i++) {
				inputs[i].checked = false
			}
		})
	</script>
	<script>
		$(`#export`).click(function () {
			let JSONExport = []
			let inputs = document.querySelectorAll(".js-checkbox")

			inputs.forEach((input) => {
				JSONExport.push({id: input.id, checked: input.checked})
			})

			this.download = `Sauvegarde des conventions - ${(new Date()).toLocaleDateString('fr-FR')}.json`
			this.href = (`data:application/octet-stream;charset=utf-8,${encodeURIComponent(JSON.stringify(JSONExport))}`)
		})

		$(`#import`).click(() => {
			let file = document.getElementById("file").files[0]
			if (file) {
				let reader = new FileReader()
				reader.readAsText(file, "UTF-8")
				reader.onload = function (evt) {
					let data = JSON.parse(evt.target.result)

					let inputs = document.querySelectorAll(".js-checkbox")
					inputs.forEach((input) => {
						let checkbox = data.find((d) => {
							return d.id === input.id
						})

						if (checkbox.checked) {
							input.checked = true
						}
					})
				}
				reader.onerror = function (evt) {
					console.error(evt)
				}
			}
		})
	</script>

@endsection
