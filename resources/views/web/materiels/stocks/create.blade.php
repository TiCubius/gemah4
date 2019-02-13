@extends('web._includes._master')@php($title = "Création d'un matériel")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.materiels.stocks.index"])
			Création d'un matériel
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.materiels.stocks.store") }}" method="POST">
				{{ csrf_field() }}

				<div class="row">
					<div class="col-12 col-md-6">
						<div class="card card-body mb-3">
							<h5 class="card-title text-center">Informations Administrative</h5>

							@component("web._includes.components.input", ["optional" => true, "name" => "numero_devis", "placeholder" => "Ex: DV1600561"])
								Numéro de devis
							@endcomponent

							@component("web._includes.components.input", ["optional" => true, "name" => "numero_formulaire_chorus", "placeholder" => "Ex: 15385789"])
								Numéro de formulaire CHORUS
							@endcomponent


							@component("web._includes.components.input", ["optional" => true, "name" => "numero_facture_chorus", "placeholder" => "Ex: FC1507101"])
								Numéro de facture CHORUS
							@endcomponent

							@component("web._includes.components.input", ["optional" => true, "name" => "numero_ej", "placeholder" => "Ex: 1508270350"])
								Numéro d'engagement juridique
							@endcomponent


							@component("web._includes.components.input", ["optional" => true, "name" => "date_ej", "type" => "date", "placeholder" => "Ex: 07/01/2019"])
								Date d'engagement juridique
							@endcomponent

							@component("web._includes.components.input", ["optional" => true, "name" => "date_facture", "type" => "date", "placeholder" => "Ex: 07/01/2019"])
								Date de la facture
							@endcomponent

							@component("web._includes.components.input", ["optional" => true, "name" => "date_service_fait", "type" => "date", "placeholder" => "Ex: 07/01/2019"])
								Date de service fait
							@endcomponent

							@component("web._includes.components.input", ["optional" => true, "name" => "date_fin_garantie", "type" => "date", "placeholder" => "Ex: 07/01/2019"])
								Date de fin de garantie
							@endcomponent


							@component("web._includes.components.input", ["optional" => true, "name" => "achat_pour", "placeholder" => "Ex: John SMITH"])
								Acheté pour
							@endcomponent

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


							@component("web._includes.components.input", ["name" => "marque", "placeholder" => "Ex: HP"])
								Marque
							@endcomponent

							@component("web._includes.components.input", ["name" => "modele", "placeholder" => "Ex: ELITE BOOK 820 G3"])
								Modèle
							@endcomponent


							@component("web._includes.components.input", ["optional" => true, "name" => "numero_serie", "placeholder" => "Ex: 5CG80515KR"])
								Numéro de série / Clé de produit
							@endcomponent

							@component("web._includes.components.input", ["optional" => true, "name" => "nom_fournisseur", "placeholder" => "Ex: LDLC"])
								Nom du fournisseur
							@endcomponent


							@component("web._includes.components.input", ["name" => "prix_ttc", "type" => "number", "placeholder" => "Ex: 499.99"])
								Prix TTC (€)
							@endcomponent


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
