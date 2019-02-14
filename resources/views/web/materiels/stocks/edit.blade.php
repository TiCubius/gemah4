@extends('web._includes._master')
@php($title = "Édition de {$stock->modele}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.materiels.stocks.index"])
			Édition de {{ $stock->modele }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.materiels.stocks.update", [$stock]) }}" method="POST">
				{{ method_field("PATCH") }}
				{{ csrf_field() }}

				<div class="row">

					<div class="col-md-6">
						<div class="card card-body mb-3">
							<h5 class="card-title text-center">Informations Administrative</h5>

							@component("web._includes.components.input", ["optional" => true, "name" => "numero_devis", "placeholder" => "Ex: DV1600561", "value" => $stock->numero_devis])
								Numéro de devis
							@endcomponent

							@component("web._includes.components.input", ["optional" => true, "name" => "numero_formulaire_chorus", "placeholder" => "Ex: 15385789", "value" => $stock->numero_formulaire_chorus])
								Numéro de formulaire CHORUS
							@endcomponent


							@component("web._includes.components.input", ["optional" => true, "name" => "numero_facture_chorus", "placeholder" => "Ex: FC1507101", "value" => $stock->numero_facture_chorus])
								Numéro de facture CHORUS
							@endcomponent

							@component("web._includes.components.input", ["optional" => true, "name" => "numero_ej", "placeholder" => "Ex: 1508270350", "value" => $stock->numero_ej])
								Numéro d'engagement juridique
							@endcomponent


							@component("web._includes.components.input", ["optional" => true, "name" => "date_ej", "type" => "date", "placeholder" => "Ex: 07/01/2019", "value" => $stock->date_ej ? $stock->date_ej->format("Y-m-d") : ""])
								Date d'engagement juridique
							@endcomponent

							@component("web._includes.components.input", ["optional" => true, "name" => "date_facture", "type" => "date", "placeholder" => "Ex: 07/01/2019", "value" => $stock->date_facture ? $stock->date_facture->format("Y-m-d") : ""])
								Date de la facture
							@endcomponent

							@component("web._includes.components.input", ["optional" => true, "name" => "date_service_fait", "type" => "date", "placeholder" => "Ex: 07/01/2019", "value" => $stock->date_service_fait ? $stock->date_service_fait->format("Y-m-d") : ""])
								Date de service fait
							@endcomponent

							@component("web._includes.components.input", ["optional" => true, "name" => "date_fin_garantie", "type" => "date", "placeholder" => "Ex: 07/01/2019", "value" => $stock->date_fin_garantie ? $stock->date_fin_garantie->format("Y-m-d") : ""])
								Date de fin de garantie
							@endcomponent


							@component("web._includes.components.input", ["optional" => true, "name" => "achat_pour", "placeholder" => "Ex: John SMITH", "value" => $stock->achat_pour])
								Acheté pour
							@endcomponent

							@component('web._includes.components.departement', ['academies' => $academies, 'id' => $stock->departement_id])
							@endcomponent
						</div>
					</div>
					<div class="col-md-6">
						<div class="card card-body mb-3">
							<h5 class="card-title text-center">Informations du Matériel</h5>

							<div class="form-group">
								<label for="type_materiel_id">Type du matériel</label>
								<select id="type_materiel_id" class="form-control" name="type_materiel_id">
									<option value="">Sélectionnez un type</option>
									@foreach ($domaines as $domaine)
										<optgroup label="{{ $domaine->libelle }}">
											@foreach($domaine->types as $type)
												@if($stock->type_materiel_id === $type->id)
													<option selected value="{{ $type->id }}">{{ $type->libelle }}</option>
												@else
													<option value="{{ $type->id }}">{{ $type->libelle }}</option>
												@endif
											@endforeach
										</optgroup>
									@endforeach
								</select>
							</div>


							@component("web._includes.components.input", ["name" => "marque", "placeholder" => "Ex: HP", "value" => $stock->marque])
								Marque
							@endcomponent

							@component("web._includes.components.input", ["name" => "modele", "placeholder" => "Ex: ELITE BOOK 820 G3", "value" => $stock->modele])
								Modèle
							@endcomponent


							@component("web._includes.components.input", ["optional" => true, "name" => "numero_serie", "placeholder" => "Ex: 5CG80515KR", "value" => !empty($stock->numero_serie) ? $stock->numero_serie : $stock->cle_produit ])
								Numéro de série / Clé de produit
							@endcomponent

							@component("web._includes.components.input", ["optional" => true, "name" => "nom_fournisseur", "placeholder" => "Ex: LDLC", "value" => $stock->nom_fournisseur])
								Nom du fournisseur
							@endcomponent


							@component("web._includes.components.input", ["name" => "prix_ttc", "type" => "number", "placeholder" => "Ex: 499.99", "value" => $stock->prix_ttc, "other" => "step=0.01"])
								Prix TTC (€)
							@endcomponent

							<div class="form-group">
								<label for="etat_administratif_materiel_id">Etat administratif du matériel</label>
								<select id="etat_administratif_materiel_id" class="form-control" name="etat_administratif_materiel_id" required>
									<option value="">Veuillez sélectionner l'état du matériel</option>
									@foreach ($etatsAdministratifs as $etat)
										@if($stock->etat_administratif_materiel_id === $etat->id)
											<option value="{{ $etat->id }}" selected>{{ $etat->libelle }}</option>
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
										@if($stock->etat_physique_materiel_id === $etat->id)
											<option value="{{ $etat->id }}" selected>{{ $etat->libelle }}</option>
										@else
											<option value="{{ $etat->id }}">{{ $etat->libelle }}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
					</div>
				</div>


				@hasPermission("materiels/stocks/edit")
				@component("web._includes.components.form_edit")
				@endcomponent
				@endHas
			</form>
		</div>

	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.materiels.stocks.destroy", "id" => $stock])
		@slot("name")
			{{ "{$stock->marque} {$stock->modele}" }}
		@endslot
	@endcomponent

@endsection
