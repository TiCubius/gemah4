@extends("web._includes._master")
@section('content')

	@component('web._includes.components.title', ["back" => "web.index"])
		Liste des conventions

		@slot("custom")
			<div class="input-group">
				<input id="search" class="form-control" type="text" placeholder="Recherche">

				<div class="btn-group input-group-append input-group-prepend">
					<div class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Gestion des conventions
					</div>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
						<a class="dropdown-item" href="{{ route("web.conventions.signatures_effectues") }}">Générer la liste des responsables ayant signé</a>
						<a class="dropdown-item" href="{{ route("web.conventions.signatures_manquantes") }}">Générer la liste des responsables n'ayant pas signé</a>

						<div class="dropdown-divider"></div>
						<a class="dropdown-item" data-toggle="modal" data-target="#conventionsUpdate">Gérer les données des conventions</a>
						<a class="dropdown-item" href="{{ route("web.conventions.impressions_toutes_conventions") }}">Générer toutes les conventions non signé</a>

						<div class="dropdown-divider"></div>
						<a id="export" class="dropdown-item" href="#" download="data.json">Sauvegarder la liste actuelle</a>
						<a class="dropdown-item" data-toggle="modal" data-target="#dataImport">Importer une sauvegarde</a>
						<a id="reset" class="dropdown-item" href="#">Remettre à zéro</a>
					</div>
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
						<div class="js-card col-12 col-md-6 col-lg-3 mt-3">
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

	<form id="dataImport" class="modal fade" tabindex="-1">
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
					<button class="btn btn-dark" type="button" data-dismiss="modal">Annuler</button>
					<button id="import" class="btn btn-primary" type="button" data-dismiss="modal">Importer</button>
				</div>
			</div>
		</div>
	</form>

	<form id="conventionsUpdate" class="modal fade" tabindex="-1" action="{{ route("web.administrations.parametres.update") }}" method="POST">
		{{ csrf_field() }}
		{{ method_field("PATCH") }}

		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					Mettre à jours les données de la convention
				</div>

				<div class="modal-body">
					<div class="form-group">
						<label for="conventions/affaire/nom">{{ $parametres["conventions/audio/nom"]["libelle"] }}</label>
						<input id="conventions/affaire/nom" class="form-control" name="conventions/affaire/nom" type="text" value="{{ $parametres["conventions/affaire/nom"]["value"] }}">
					</div>

					<div class="form-group">
						<label for="conventions/affaire/telephone">{{ $parametres["conventions/audio/telephone"]["libelle"] }}</label>
						<input id="conventions/affaire/telephone" class="form-control" name="conventions/affaire/telephone" type="text" value="{{ $parametres["conventions/affaire/telephone"]["value"] }}">
					</div>

					<div class="form-group">
						<label for="conventions/affaire/email">{{ $parametres["conventions/audio/email"]["libelle"] }}</label>
						<input id="conventions/affaire/email" class="form-control" name="conventions/affaire/email" type="text" value="{{ $parametres["conventions/affaire/email"]["value"] }}">
					</div>


					<div class="form-group">
						<label for="conventions/informatique/nom">{{ $parametres["conventions/audio/nom"]["libelle"] }}</label>
						<input id="conventions/informatique/nom" class="form-control" name="conventions/informatique/nom" type="text" value="{{ $parametres["conventions/informatique/nom"]["value"] }}">
					</div>

					<div class="form-group">
						<label for="conventions/informatique/telephone">{{ $parametres["conventions/audio/telephone"]["libelle"] }}</label>
						<input id="conventions/informatique/telephone" class="form-control" name="conventions/informatique/telephone" type="text" value="{{ $parametres["conventions/informatique/telephone"]["value"] }}">
					</div>

					<div class="form-group">
						<label for="conventions/informatique/email">{{ $parametres["conventions/audio/email"]["libelle"] }}</label>
						<input id="conventions/informatique/email" class="form-control" name="conventions/informatique/email" type="text" value="{{ $parametres["conventions/informatique/email"]["value"] }}">
					</div>


					<div class="form-group">
						<label for="conventions/audio/nom">{{ $parametres["conventions/audio/nom"]["libelle"] }}</label>
						<input id="conventions/audio/nom" class="form-control" name="conventions/audio/nom" type="text" value="{{ $parametres["conventions/audio/nom"]["value"] }}">
					</div>

					<div class="form-group">
						<label for="conventions/audio/telephone">{{ $parametres["conventions/audio/telephone"]["libelle"] }}</label>
						<input id="conventions/audio/telephone" class="form-control" name="conventions/audio/telephone" type="text" value="{{ $parametres["conventions/audio/telephone"]["value"] }}">
					</div>

					<div class="form-group">
						<label for="conventions/audio/email">{{ $parametres["conventions/audio/email"]["libelle"] }}</label>
						<input id="conventions/audio/email" class="form-control" name="conventions/audio/email" type="text" value="{{ $parametres["conventions/audio/email"]["value"] }}">
					</div>


					<div class="form-group">
						<label for="conventions/adresse">{{ $parametres["conventions/adresse"]["libelle"] }}</label>
						<input id="conventions/adresse" class="form-control" name="conventions/adresse" type="text" value="{{ $parametres["conventions/adresse"]["value"] }}">
					</div>

					<div class="form-group">
						<label for="conventions/code_postal">{{ $parametres["conventions/code_postal"]["libelle"] }}</label>
						<input id="conventions/code_postal" class="form-control" name="conventions/code_postal" type="text" value="{{ $parametres["conventions/code_postal"]["value"] }}">
					</div>

					<div class="form-group">
						<label for="conventions/ville">{{ $parametres["conventions/ville"]["libelle"] }}</label>
						<input id="conventions/ville" class="form-control" name="conventions/ville" type="text" value="{{ $parametres["conventions/ville"]["value"] }}">
					</div>


					<div class="form-group">
						<label for="conventions/secretaire">{{ $parametres["conventions/secretaire"]["libelle"] }}</label>
						<input id="conventions/secretaire" class="form-control" name="conventions/secretaire" type="text" value="{{ $parametres["conventions/secretaire"]["value"] }}">
					</div>
				</div>

				<div class="modal-footer d-flex justify-content-between">
					<button class="btn btn-dark" type="button" data-dismiss="modal">Annuler</button>
					<button class="btn btn-primary">Mettre à jour</button>
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

	<script>

		document.querySelector('#search').addEventListener('keyup', (e) => {
			let search = document.querySelector('#search').value.toLowerCase()
			let cards = document.querySelectorAll('.js-card')

			cards.forEach((card) => {
				if ((search === "") || (card.innerHTML.toLowerCase().includes(search))) {
					card.classList.remove('d-none')
				} else {
					card.classList.add('d-none')
				}
			})
		})

	</script>

@endsection
