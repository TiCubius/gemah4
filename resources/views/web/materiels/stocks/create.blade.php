@extends('web._includes._master')
@php($title = "Création d'un matériel")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.materiels.stocks.index"])
			Création d'un matériel
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.materiels.stocks.store") }}" method="POST">
				{{ csrf_field() }}

				<div class="row">
					<div class="col-md-6">
						<div class="card card-body mb-3">
							<h5 class="card-title text-center">Informations Administrative</h5>

							<div class="form-group">
								<label class="optional" for="numero_devis">Numéro de devis</label>
								<input id="numero_devis" class="form-control" name="numero_devis" type="text" placeholder="Ex: ..." value="{{ old("numero_devis") }}">
							</div>

							<div class="form-group">
								<label class="optional" for="numero_formulaire_chorus">Numéro de formulaire CHORUS</label>
								<input id="numero_formulaire_chorus" class="form-control" name="numero_formulaire_chorus" type="text" placeholder="Ex: ..." value="{{ old("numero_formulaire_chorus") }}">
							</div>

							<div class="form-group">
								<label class="optional" for="numero_facture_chorus">Nom de facture CHORUS</label>
								<input id="numero_facture_chorus" class="form-control" name="numero_facture_chorus" type="text" placeholder="Ex: ..." value="{{ old("numero_facture_chorus") }}">
							</div>

							<div class="form-group">
								<label class="optional" for="numero_ej">Numéro d'engagement juridique</label>
								<input id="numero_ej" class="form-control" name="numero_ej" type="text" placeholder="Ex: ..." value="{{ old("numero_ej") }}">
							</div>

							<div class="form-group">
								<label class="optional" for="date_ej">Date d'engagement juridique</label>
								<input id="date_ej" class="form-control" name="date_ej" type="date" placeholder="Ex: 01/01/2019" value="{{ old("date_ej") }}">
							</div>

							<div class="form-group">
								<label class="optional" for="date_facture">Date de la facture</label>
								<input id="date_facture" class="form-control" name="date_facture" type="date" placeholder="Ex: 01/01/2019" value="{{ old("date_facture") }}">
							</div>

							<div class="form-group">
								<label class="optional" for="date_service_fait">Date de service fait</label>
								<input id="date_service_fait" class="form-control" name="date_service_fait" type="date" placeholder="Ex: 01/01/2019" value="{{ old("date_service_fait") }}">
							</div>

							<div class="form-group">
								<label class="optional" for="date_fin_garantie">Date de fin de garantie</label>
								<input id="date_fin_garantie" class="form-control" name="date_fin_garantie" type="date" placeholder="Ex: 01/01/2019" value="{{ old("date_fin_garantie") }}">
							</div>

							<div class="form-group">
								<label class="optional" for="acheter_pour">Acheté pour</label>
								<input id="acheter_pour" class="form-control" name="acheter_pour" type="text" placeholder="Ex: John SMITH" value="{{ old("acheter_pour") }}">
							</div>

							@component('web._includes.components.departement', ['academies' => $academies, 'id' => old("departement_id")])
							@endcomponent
						</div>
					</div>

					<div class="col-md-6">
						<div class="card card-body mb-3">
							<h5 class="card-title text-center">Informations du Matériel</h5>

							<div class="form-group">
								<label for="type_materiel_id">Type du matériel</label>
								<select id="type_materiel_id" class="form-control" name="type_materiel_id" required>
									<option value="">Sélectionnez un type</option>
									@foreach ($domaines as $domaine)
										<optgroup label="{{ $domaine->libelle }}">
											@foreach($domaine->types as $type)
												@if (old("type_materiel_id") == $type->id)
													<option selected value="{{ $type->id }}">{{ $type->libelle }}</option>
												@else
													<option value="{{ $type->id }}">{{ $type->libelle }}</option>
												@endif
											@endforeach
										</optgroup>
									@endforeach
								</select>
							</div>


							<div class="form-group">
								<label for="marque">Marque du matériel</label>
								<input id="marque" class="form-control" name="marque" type="text" placeholder="Ex: HP" value="{{ old("marque") }}" required>
							</div>

							<div class="form-group">
								<label for="modele">Modèle du matériel</label>
								<input id="modele" class="form-control" name="modele" type="text" placeholder="Ex: HP 14-bs006nf" value="{{ old("modele") }}" required>
							</div>


							<div class="form-group">
								<label class="optional" for="numero_serie">Numéro de série / Clé de produit</label>
								<input id="numero_serie" class="form-control" name="numero_serie" type="text" placeholder="Ex: AAAA-BBBB-CCCC-DDDD" value="{{ old("numero_serie") }}">
							</div>

							<div class="form-group">
								<label class="optional" for="nom_fournisseur">Nom du fournisseur</label>
								<input id="nom_fournisseur" class="form-control" name="nom_fournisseur" type="text" placeholder="Ex: LDLC" value="{{ old("nom_fournisseur") }}">
							</div>


							<div class="form-group">
								<label for="prix_ttc">Prix TTC (€)</label>
								<input id="prix_ttc" class="form-control" name="prix_ttc" type="number" step="0.01" placeholder="Ex: 9.99" value="{{ old("prix_ttc") }}" required>
							</div>

							<div class="form-group">
								<label for="etat_administratif_materiel_id">Etat administratif du matériel</label>
								<select id="etat_administratif_materiel_id" class="form-control" name="etat_administratif_materiel_id" required>
									<option value="">Veuillez sélectionner l'état du matériel</option>
									@foreach ($etatsAdministratifs as $etat)
										@if (old("etat_administratif_materiel_id") == $etat->id)
											<option selected value="{{ $etat->id }}">{{ $etat->libelle }}</option>
										@else
											<option value="{{ $etat->id }}">{{ $etat->libelle }}</option>
										@endif
									@endforeach
								</select>
							</div>

							<div class="form-group">
								<label for="etat_physique_materiel_id">Etat physique du matériel</label>
								<select id="etat_physique_materiel_id" class="form-control" name="etat_physique_materiel_id" required>
									<option value="">Veuillez sélectionner l'état du matériel</option>
									@foreach ($etatsPhysiques as $etat)
										@if (old("etat_physique_materiel_id") == $etat->id)
											<option selected value="{{ $etat->id }}">{{ $etat->libelle }}</option>
										@else
											<option value="{{ $etat->id }}">{{ $etat->libelle }}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer</button>
				</div>
			</form>
		</div>

	</div>
@endsection
