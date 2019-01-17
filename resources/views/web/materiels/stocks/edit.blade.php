@extends('web._includes._master')
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

							<div class="form-group">
								<label class="optional" for="numero_devis">Numéro de devis</label>
								<input id="numero_devis" class="form-control" name="numero_devis" type="text" placeholder="Ex: ..." value="{{ $stock->numero_devis }}">
							</div>

							<div class="form-group">
								<label class="optional" for="numero_formulaire_chorus">Numéro de formulaire CHORUS</label>
								<input id="numero_formulaire_chorus" class="form-control" name="numero_formulaire_chorus" type="text" placeholder="Ex: ..." value="{{ $stock->numero_formulaire_chorus }}">
							</div>

							<div class="form-group">
								<label class="optional" for="numero_facture_chorus">Nom de facture CHROUS</label>
								<input id="numero_facture_chorus" class="form-control" name="numero_facture_chorus" type="text" placeholder="Ex: ..." value="{{ $stock->numero_facture_chorus }}">
							</div>

							<div class="form-group">
								<label class="optional" for="numero_ej">Numéro d'engagement juridique</label>
								<input id="numero_ej" class="form-control" name="numero_ej" type="text" placeholder="Ex: ..." value="{{ $stock->numero_ej }}">
							</div>

							<div class="form-group">
								<label class="optional" for="date_ej">Date d'engagement juridique</label>
								<input id="date_ej" class="form-control" name="date_ej" type="date" placeholder="Ex: 01/01/2019" value="{{ $stock->date_ej }}">
							</div>

							<div class="form-group">
								<label class="optional" for="date_facture">Date de la facture</label>
								<input id="date_facture" class="form-control" name="date_facture" type="date" placeholder="Ex: 01/01/2019" value="{{ $stock->date_facture }}">
							</div>

							<div class="form-group">
								<label class="optional" for="date_service_fait">Date de service fait</label>
								<input id="date_service_fait" class="form-control" name="date_service_fait" type="date" placeholder="Ex: 01/01/2019" value="{{ $stock->date_service_fait }}">
							</div>

							<div class="form-group">
								<label class="optional" for="date_fin_garantie">Date de fin de garantie</label>
								<input id="date_fin_garantie" class="form-control" name="date_fin_garantie" type="date" placeholder="Ex: 01/01/2019" value="{{ $stock->date_fin_garantie }}">
							</div>

							<div class="form-group">
								<label class="optional" for="acheter_pour">Acheté pour</label>
								<input id="acheter_pour" class="form-control" name="acheter_pour" type="text" placeholder="Ex: John SMITH" value="{{ $stock->acheter_pour }}">
							</div>

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


							<div class="form-group">
								<label for="marque">Marque du matériel</label>
								<input id="marque" class="form-control" name="marque" type="text" placeholder="Ex: HP" value="{{ $stock->marque }}" required>
							</div>

							<div class="form-group">
								<label for="modele">Modèle du matériel</label>
								<input id="modele" class="form-control" name="modele" type="text" placeholder="Ex: HP 14-bs006nf" value="{{ $stock->modele }}" required>
							</div>


							<div class="form-group">
								<label class="optional" for="numero_serie">Numéro de série / Clé de produit</label>
								<input id="numero_serie" class="form-control" name="numero_serie" type="text" placeholder="Ex: AAAA-BBBB-CCCC-DDDD" value="{{ $stock->numero_serie }}">
							</div>

							<div class="form-group">
								<label class="optional" for="nom_fournisseur">Nom du fournisseur</label>
								<input id="nom_fournisseur" class="form-control" name="nom_fournisseur" type="text" placeholder="Ex: LDLC" value="{{ $stock->nom_fournisseur }}">
							</div>


							<div class="form-group">
								<label for="prix_ttc">Prix TTC (€)</label>
								<input id="prix_ttc" class="form-control" name="prix_ttc" type="number" step="0.01" placeholder="Ex: 9.99" value="{{ $stock->prix_ttc }}" required>
							</div>

							<div class="form-group">
								<label for="etat_materiel_id">Etat du matériel</label>
								<select id="etat_materiel_id" class="form-control" name="etat_materiel_id" required>
									<option value="">Veuillez sélectionner l'état du matériel</option>
									@foreach ($etats as $etat)
										@if($stock->etat_materiel_id === $etat->id)
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


				@component("web._includes.components.form_edit")
				@endcomponent
			</form>
		</div>

	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.materiels.stocks.destroy", "id" => $stock])
		@slot("name")
			{{ "{$stock->marque} {$stock->modele}" }}
		@endslot
	@endcomponent

@endsection
