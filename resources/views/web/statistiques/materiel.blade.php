@extends('web._includes._master')
@php($title = "Liste des matériels")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.statistiques.index"])
			Liste des matériels
		@endcomponent
		<div class="col-12">
			<form class="mb-3">
				<div class="card mb-3">
					<div class="card-header gemah-bg-primary d-flex justify-content-between">
						Recherche :

						<a data-toggle="collapse" href="#option_recherche" aria-expanded="true" aria-controls="option_recherche" id="recherche" style="text-decoration:none; color:#FFFFFF">
							<i class="fa fa-chevron-down pull-right"></i> </a>
					</div>

					<div id="option_recherche" class="collapse show" aria-labelledby="recherche">
						<div class="card-body row">
							<div class="col-md-6 col-12">
								@component("web._includes.components.departement", ["optional" => true, "academies" => $academies, "id" => app("request")->input("departement_id")])
								@endcomponent
							</div>

							<div class="col-md-6 col-12">
								<div class="form-group">
									<label class="optional" for="etat_administratif_materiel_id">État administratif</label>
									<select id="etat_administratif_materiel_id" class="form-control" name="etat_administratif_materiel_id">
										<option value="">Sélectionner un état administratif</option>
										@foreach($etat_administratifs as $etat_administratif)
											<option value="{{ $etat_administratif->id }}">{{ $etat_administratif->libelle }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-md-6 col-12">
								<div class="form-group">
									<label class="optional" for="etat_physique_materiel_id">État physique</label>
									<select id="etat_physique_materiel_id" class="form-control" name="etat_physique_materiel_id">
										<option value="">Sélectionner un état physique</option>
										@foreach($etat_physiques as $etat_physique)
											<option value="{{ $etat_physique->id }}">{{ $etat_physique->libelle }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-md-6 col-12">
								<div class="form-group">
									<label class="optional" for="type_materiel_id">Type de matériel</label>
									<select id="type_materiel_id" class="form-control" name="type_materiel_id">
										<option value>Sélectionnez un type</option>
										@foreach ($domaines as $domaine)
											<optgroup label="{{ $domaine->libelle }}">
												@foreach($domaine->types as $type)
													@if(request("type_materiel_id") == $type->id)
														<option selected value="{{ $type->id }}">{{ $type->libelle }}</option>
													@else
														<option value="{{ $type->id }}">{{ $type->libelle }}</option>
													@endif
												@endforeach
											</optgroup>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-md-6 col-12">
								@component("web._includes.components.input", ["optional" => true, "name" => "numero_serie", "placeholder" => "Ex: XXXX-XXXX-XXXX-XXXX"])
									Numéro de série
								@endcomponent
							</div>

							<div class="col-md-6 col-12">
								@component("web._includes.components.input", ["optional" => true, "name" => "cle_produit", "placeholder" => "Ex: XXXX-XXXX-XXXX-XXXX"])
									Clé produit
								@endcomponent
							</div>

							<div class="col-md-6 col-12">
								@component("web._includes.components.input", ["optional" => true, "name" => "marque", "placeholder" => "Ex: HP"])
									Marque
								@endcomponent
							</div>

							<div class="col-md-6 col-12">
								@component("web._includes.components.input", ["optional" => true, "name" => "modele", "placeholder" => "Ex: ProBook 650 G3"])
									Modèle
								@endcomponent
							</div>

							<div class="col-md-6 col-12">
								@component("web._includes.components.input", ["optional" => true, "name" => "nom_fournisseur", "placeholder" => "Ex: LDLC   "])
									Nom du fournisseur
								@endcomponent
							</div>

							<div class="col-md-6 col-12">
								@component("web._includes.components.input", ["optional" => true, "name" => "numero_devis", "placeholder" => "Ex: XX00000000   "])
									Numéro devis
								@endcomponent
							</div>

							<div class="col-md-6 col-12">
								@component("web._includes.components.input", ["optional" => true, "name" => "numero_formulaire_chorus", "placeholder" => "Ex: 00000000"])
									Numéro de formulaire chorus
								@endcomponent
							</div>

							<div class="col-md-6 col-12">
								@component("web._includes.components.input", ["optional" => true, "name" => "numero_facture_chorus", "placeholder" => "Ex: FC1507101"])
									Numéro de facture chorus
								@endcomponent
							</div>

							<div class="col-md-6 col-12">
								@component("web._includes.components.input", ["optional" => true, "name" => "numero_ej", "placeholder" => "Ex: 0000000000"])
									Numéro d'engagement juridique
								@endcomponent
							</div>

							<div class="col-md-6 col-12">
								@component("web._includes.components.input", ["optional" => true, "name" => "date_ej", "type" => "date"])
									Date d'engagement juridique
								@endcomponent
							</div>

							<div class="col-md-6 col-12">
								@component("web._includes.components.input", ["optional" => true, "name" => "date_facture", "type" => "date"])
									Date de facture
								@endcomponent
							</div>

							<div class="col-md-6 col-12">
								@component("web._includes.components.input", ["optional" => true, "name" => "date_service_fait", "type" => "date"])
									Date de service fait
								@endcomponent
							</div>

							<div class="col-md-6 col-12">
								@component("web._includes.components.input", ["optional" => true, "name" => "date_fin_garantie", "type" => "date"])
									Date de fin de garantie
								@endcomponent
							</div>

							<div class="col-md-6 col-12">
								@component("web._includes.components.input", ["optional" => true, "name" => "date_pret", "type" => "date"])
									Date de prêt
								@endcomponent
							</div>

							<div class="col-md-6 col-12">
								@component("web._includes.components.input", ["optional" => true, "name" => "achat_pour", "placeholder" => "Ex: SMITH John"])
									Acheté pour
								@endcomponent
							</div>
						</div>
					</div>
				</div>

				<div class="card mb-3">
					<div class="card-header gemah-bg-primary d-flex justify-content-between">
						Filtres :

						<a data-toggle="collapse" href="#option_filtre" aria-expanded="true" aria-controls="option_filtre" id="filtre" style="text-decoration:none; color:#FFFFFF">
							<i class="fa fa-chevron-down pull-right"></i> </a>
					</div>

					<div id="option_filtre" class="collapse show" aria-labelledby="filtre">
						<div class="card-body row">
							<div class="col-12 col-lg-6">
								@component("web._includes.components.filtre", ["optional" => true, "name" => "eleve"])
									<option value="with">Avec</option>
									<option value="without">Sans</option>
								@endcomponent
							</div>
							<div class="col-12">
								@component("web._includes.components.filtre", ["optional" => true, "name" => "ordre"])
									<option value="ASC/created_at">Ordre croissant de création</option>
									<option value="DESC/created_at">Ordre décroissant de création</option>
									<option value="ASC/updated_at">Ordre croissant de modification</option>
									<option value="DESC/updated_at">Odre décroissant de modification</option>
									<option value="ASC/alphabetique">Ordre alphabétique [A-Z]</option>
									<option value="DESC/alphabetique">Ordre alphabétique inversé [Z-A]</option>
								@endcomponent
							</div>
						</div>
					</div>
				</div>

				<div class="actions d-flex justify-content-between">
					<a class="btn btn-outline-dark" href="{{ route("web.statistiques.materiels") }}">
						Annuler la recherche
					</a>
					@isset($materiels)
						@hasPermission("statistiques/materielsExport")
						<a class="btn btn-outline-dark" href="{{ route("web.statistiques.materiels.exports", \Illuminate\Support\Facades\Request::all()) }}">
							Exporter les résultats
						</a>
						@endHas
					@endisset
					<button class="btn btn-outline-dark">Rechercher</button>
				</div>
			</form>

			@isset($materiels)
				<div class="mt-3">
					@component("web._includes.components.alert", ["type" => "success"])
						<b>Information(s) sur la recherche</b> <br>
						<ul class="mb-0">
							<li>
								Nombre de materiel: {{ count($materiels) }}
							</li>
						</ul>
					@endcomponent
				</div>

				<div class="table-responsive mb-3">
					<table id="table" class="table table-hover table-sm table-striped text-center">
						<thead class="gemah-bg-primary">
							<tr class="align-middle">
								<th class="align-middle">Etat</th>
								<th class="align-middle">Type</th>
								<th class="align-middle">Marque</th>
								<th class="align-middle">Modèle</th>
								<th class="align-middle">Numéro de Série</th>
								<th class="align-middle">Assigné à</th>
								<th class="align-middle">Date de prêt</th>
								<th class="align-middle">Etat physique</th>
								<th class="align-middle">Date d'ajout</th>
								<th class="align-middle" width="116px">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($materiels as $materiel)
								<tr>
									<td class="couleur" data-toggle="tooltip" data-placement="bottom" title="{{ $materiel->etatAdministratif->libelle }}" style="width: 57px; background:{{ $materiel->etatAdministratif->couleur }}"></td>
									<td class="align-middle">{{ $materiel->type->libelle }}</td>
									<td class="align-middle">{{ $materiel->marque }}</td>
									<td class="align-middle">{{ $materiel->modele }}</td>
									<td class="align-middle">{{ $materiel->numero_serie }}</td>
									@isset($materiel->eleve)
										<td class="align-middle">
											@hasPermission("eleves/show")
											<a href="{{ route("web.scolarites.eleves.show", [$materiel->eleve]) }}">{{ "{$materiel->eleve->nom} {$materiel->eleve->prenom}" }}</a>
											@endHas
										</td>
									@else
										<td></td>
									@endisset
									<td class="align-middle">{{ $materiel->date_pret ? $materiel->date_pret->format("d/m/Y") : null }}</td>
									<td class="align-middle">{{ $materiel->etatPhysique->libelle }}</td>
									<td class="align-middle">{{ $materiel->created_at->format("d/m/Y") }}</td>
									<td class="align-middle">
										@hasPermission("materiels/stocks/show")
										<a class="btn btn-sm btn-outline-primary" href="{{ route("web.materiels.stocks.show", [$materiel]) }}">Détail</a>
										@endHas
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endisset
		</div>
	</div>
@endsection

@section("scripts")
	<script>
		$(document).ready(function () {
			$('#table').DataTable({
				"language": {
					"url": "{{ asset("assets/js/dataTables.french.json") }}",
				},
				"info": false,
				"columnDefs": [
					{"orderable": false, "targets": 3},
				],
				"pageLength": 50,
			})
		})
	</script>
@endsection