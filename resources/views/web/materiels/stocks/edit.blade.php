@extends('web._includes._master')
@section('content')
	<div class="row">

		<div class="col-12">
			<div class="d-flex flex-column">
				<div class="d-flex justify-content-between align-items-center">
					<h4>Édition de {{ $stock->modele }}</h4>
					<a href="{{ route("web.materiels.stocks.index") }}">
						<button class="btn btn-outline-primary">Retour</button>
					</a>
				</div>
				<hr class="w-100">
			</div>
		</div>

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.materiels.stocks.index") }}" method="POST">
				{{ csrf_field() }}

				<div class="card card-body mb-3">
					<h5 class="card-title text-center">Informations du Matériel</h5>

					<div class="form-group">
						<label for="domaine_id">Domaine du matériel</label>
						<select id="domaine_id" class="form-control" name="domaine_id" required>
							<option value="">Veuillez sélectionner un domaine</option>
							@foreach($domaines as $domaine)
								@if ($stock->type->domaine_id === $domaine->id)
									<option value="{{ $domaine->id }}" selected>{{ $domaine->nom }}</option>
								@else
									<option value="{{ $domaine->id }}">{{ $domaine->nom }}</option>
								@endif
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="type_id">Type du matériel</label>
						<select id="type_id" class="form-control" name="type_id" required>
							<option value="">Veuillez sélectionner un type</option>
							@foreach($types as $type)
								@if($stock->type_id === $type->id)
									<option value="{{ $type->id }}" selected>{{ $type->nom }}</option>
								@else
									<option value="{{ $type->id }}">{{ $type->nom }}</option>
								@endif
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
						<label class="optional" for="num_serie">Numéro de série / Clé de produit</label>
						<input id="num_serie" class="form-control" name="num_serie" type="text" placeholder="Ex: AAAA-BBBB-CCCC-DDDD" value="{{ $stock->num_serie }}">
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
						<label for="etat_id">Etat du matériel</label>
						<select id="etat_id" class="form-control" name="etat_id" required>
							<option value="">Veuillez sélectionner l'état du matériel</option>
							@foreach ($etats as $etat)
								@if($stock->etat_id === $etat->id)
									<option value="{{ $etat->id }}" selected>{{ $etat->nom }}</option>
								@else
									<option value="{{ $etat->id }}">{{ $etat->nom }}</option>
								@endif
							@endforeach
						</select>
					</div>
				</div>

				<div class="card card-body mb-3">
					<h5 class="card-title text-center">Informations Administrative</h5>

					<div class="form-group">
						<label class="optional" for="num_devis">Numéro de devis</label>
						<input id="num_devis" class="form-control" name="num_devis" type="text" placeholder="Ex: ..." value="{{ $stock->num_devis }}">
					</div>

					<div class="form-group">
						<label class="optional" for="num_formulaire_chorus">Numéro de formulaire CHORUS</label>
						<input id="num_formulaire_chorus" class="form-control" name="num_formulaire_chorus" type="text" placeholder="Ex: ..." value="{{ $stock->num_formulaire_chorus }}">
					</div>

					<div class="form-group">
						<label class="optional" for="num_facture_chorus">Nom de facture CHROUS</label>
						<input id="num_facture_chorus" class="form-control" name="num_facture_chorus" type="text" placeholder="Ex: ..." value="{{ $stock->num_facture_chorus }}">
					</div>

					<div class="form-group">
						<label class="optional" for="num_ej">Numéro d'engagement juridique</label>
						<input id="num_ej" class="form-control" name="num_ej" type="text" placeholder="Ex: ..." value="{{ $stock->num_ej }}">
					</div>

					<div class="form-group">
						<label class="optional" for="date_ej">Date d'engagement juridique</label>
						<input id="date_ej" class="form-control" name="date_ej" type="date" value="{{ $stock->date_ej }}">
					</div>

					<div class="form-group">
						<label class="optional" for="date_facture">Date de la facture</label>
						<input id="date_facture" class="form-control" name="date_facture" type="date" value="{{ $stock->date_facture }}">
					</div>

					<div class="form-group">
						<label class="optional" for="date_service_fait">Date de service fait</label>
						<input id="date_service_fait" class="form-control" name="date_service_fait" type="date" value="{{ $stock->date_service_fait }}">
					</div>

					<div class="form-group">
						<label class="optional" for="date_fin_garantie">Date de fin de garantie</label>
						<input id="date_fin_garantie" class="form-control" name="date_fin_garantie" type="date" value="{{ $stock->date_fin_garantie }}">
					</div>

					<div class="form-group">
						<label class="optional" for="acheter_pour">Acheté pour</label>
						<input id="acheter_pour" class="form-control" name="acheter_pour" type="text" placeholder="Ex: John Smith" value="{{ $stock->acheter_pour }}">
					</div>
				</div>


				<div class="d-flex justify-content-between">
					<button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">Supprimer le matériel</button>
					<button class="btn btn-sm btn-outline-success">Éditer le matériel</button>
				</div>
			</form>
		</div>

	</div>


	<form id="modal" class="modal fade" action="{{ route("web.materiels.stocks.destroy", [$stock->id]) }}" method="POST" tabindex="-1">
		{{ csrf_field() }}
		{{ method_field("DELETE") }}

		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Attention</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body text-center">
					<p>
						Vous êtes sur le point de supprimer le matériel <b>{{ strtoupper("{$stock->marque} {$stock->modele}") }}</b>. <br>
						Cette action est irreversible </p>
				</div>
				<div class="modal-footer d-flex justify-content-between">
					<button type="button" class="btn btn-dark" data-dismiss="modal">Annuler</button>
					<button type="submit" class="btn btn-danger">Supprimer le matériel</button>
				</div>
			</div>
		</div>
	</form>
@endsection