@extends('web._includes._master')
@php($title = "Descriptif matériel de {$stock->modele}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.materiels.stocks.index"])
			Descriptif matériel de {{ $stock->modele }}
		@endcomponent

		<div class="col-12">
			<div class="row">
				<div class="col-sm-12 col-md-6 mb-3">
					<div class="card">
						<div class="card-header gemah-bg-primary">
							Informations sur le Matériel
						</div>
						<div class="card-body">
							<p class="mb-0">
								<strong>N° de série</strong>:
								{!! $stock->numero_serie ?? '<span class="text-muted">Non rensigné</span>' !!}
							</p>

							@if(!empty($stock->cle_produit))
								<p class="mb-0">
									<strong>Clé de produit</strong>:
									{!! $stock->cle_produit ?? '<span class="text-muted">Non rensigné</span>' !!}
								</p>
							@endif

							<p class="mb-0">
								<strong>Type</strong>:
								{!! $stock->type->libelle ?? '<span class="text-muted">Non rensigné</span>' !!}
							</p>

							<p class="mb-0">
								<strong>Marque</strong>:
								{!! $stock->marque ?? '<span class="text-muted">Non rensigné</span>' !!}
							</p>

							<p class="mb-0">
								<strong>Modèle</strong>:
								{!! $stock->modele ?? '<span class="text-muted">Non rensigné</span>' !!}
							</p>

							<p class="mb-0">
								<strong>Prix TTC</strong>:
								{{ $stock->prix_ttc . "€" }}
							</p>

							<p class="mb-0">
								<strong>Nom du fournisseur</strong>:
								{!! $stock->nom_fournisseur ?? '<span class="text-muted">Non rensigné</span>' !!}
							</p>

							<p class="mb-0">
								<strong>Etat administratif</strong>:
								{!!  $stock->etatAdministratif->libelle ?? '<span class="text-muted"> Non renseigné</span>' !!}
							</p>

							<p class="mb-0">
								<strong>Etat physique</strong>:
								{!!  $stock->etatPhysique->libelle ?? '<span class="text-muted"> Non renseigné</span>' !!}
							</p>

							<p class="mb-0">
								<strong>N° de devis</strong>:
								{!! $stock->numero_devis ?? '<span class="text-muted">Non rensigné</span>' !!}
							</p>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-6 mb-3">
					<div class="card">
						<div class="card-header gemah-bg-primary">
							Informations Administrative
						</div>
						<div class="card-body">
							<p class="mb-0">
								<strong>N° de facture CHORUS</strong>:
								{!! $stock->numero_facture_chorus ?? '<span class="text-muted"> Non renseigné</span>' !!}
							</p>

							<p class="mb-0">
								<strong>N° de formulaire CHORUS</strong>:
								{!! $stock->numero_formulaire_chorus ?? '<span class="text-muted"> Non renseigné</span>' !!}
							</p>

							<p class="mb-0">
								<strong>N° d'engagement juridique EJ</strong>:
								{!! $stock->numero_ej  ?? '<span class="text-muted"> Non renseigné</span>' !!}
							</p>

							<p class="mb-0">
								<strong>Date d'engagement juridique EJ</strong>:
								{!! $stock->date_ej ? $stock->date_ej->format("d/m/Y")  : '<span class="text-muted"> Non renseigné</span>' !!}
							</p>

							<p class="mb-0">
								<strong>Date de facture</strong>:
								{!! $stock->date_facture ? $stock->date_facture->format("d/m/Y") : '<span class="text-muted"> Non renseigné</span>' !!}
							</p>

							<p class="mb-0">
								<strong>Date de service fait</strong>:
								{!! $stock->date_service_fait ? $stock->date_service_fait->format("d/m/Y") : '<span class="text-muted"> Non renseigné</span>' !!}
							</p>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-6 mb-3">
					<div class="card">
						<div class="card-header gemah-bg-primary">
							Informations d'Achat
						</div>
						<div class="card-body">
							<p class="mb-0">
								<strong>Acheté pour</strong>:
								{!! $stock->achat_pour ?? '<span class="text-muted"> Non renseigné</span>' !!}
							</p>

							<p class="mb-0">
								<strong>Date de fin de garantie</strong>:
								{!! $stock->date_fin_garantie ? $stock->date_fin_garantie->format("d/m/Y") : '<span class="text-muted"> Non renseigné</span>' !!}
							</p>
						</div>
					</div>
				</div>
				@if(!empty($stock->eleve))
					<div class="col-sm-12 col-md-6 mb-3">
						<div class="card">
							<div class="card-header gemah-bg-primary">
								Informations Elève
								<a class="btn btn-outline-light btn-sm float-right" href="{{ route('web.scolarites.eleves.show', [$stock->eleve]) }}">
									<i class="fas fa-info-circle"></i>
									Détails
								</a>
							</div>

							<div class="card-body">
								<p class="mb-0">
									<strong>Assigné à</strong>:
									{{ $stock->eleve->nom }} {{ $stock->eleve->prenom }}
								</p>
								<p class="mb-0">
									<strong>Date de prêt</strong>:
									{!! $stock->date_pret ? $stock->date_pret->format('d/m/Y H:i:s') : '<span class="text-muted"> Non renseigné</span>'  !!}<br>
								</p>
							</div>
						</div>
					</div>
				@endif
			</div>

			<div class="actions d-flex justify-content-center">
				@hasPermission("materiels/stocks/edit")
				<a href="{{ route('web.materiels.stocks.edit', [$stock]) }}" class="btn btn-sm btn-outline-primary">
					<i class="far fa-edit"></i> Éditer
				</a>
				@endHas
			</div>

		</div>
	</div>
@endsection