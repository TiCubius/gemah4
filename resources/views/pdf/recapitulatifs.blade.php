<html lang="fr">
	<head>
		<title>Récapitulatif - {{ "{$eleve->nom} {$eleve->prenom}" }}</title>
		<meta charset="UTF-8">
		@include("pdf._includes.style")
	</head>

	@php
		$decision = $eleve->decisions->sortBy("created_at")->last()
	@endphp

	<body>
		<header>
			<section id="marianne" class="text-center">
				<img src="{{ resource_path("images/marianne-logo.png") }}" style="height: 75px;">
			</section>

			<section id="dsden" style="position: absolute; top: 0;">
				<img src="{{ resource_path("images/".session('user')->departement_id."/dsden-logo.png") }}">
			</section>

			<section class="content" style="margin-top: 50px; font-size: 14px;">
				<h2>Récapitulatif</h2>

				<section style="height: 137px;">
					<section class="eleve" style="width: 50%; float: left;">
						<h4>Élève</h4>

						<p>
							Nom : {{ $eleve->nom }} <br>
							Prénom : {{ $eleve->prenom }} <br>
							Date de naissance : {{ $eleve->date_naissance->format("d/m/Y") }} <br>
							Nombre de Joker : {{ $eleve->joker}} <br>
						</p>
					</section>

					@if($eleve->decisions->isNotEmpty())
						<section class="mdph" style="width: 50%; float: left; height: 137px;">
							@php($decision = $eleve->decisions->sortByDesc('created_at')[0])

							<h4>Dossier MDPH</h4>

							<p>
								Date limite de la décision : {{ $decision->date_limite ? $decision->date_limite->format("d/m/Y") : "Non défini" }} <br>
								Date de signature de la décision : {{ $decision->date_convention ? $decision->date_convention->format("d/m/Y") : "Non défini" }} <br>
								Enseignant référent : {{ $decision->enseignant ? "{$decision->enseignant->nom} {$decision->enseignant->prenom}" : "Non défini" }} <br>
							</p>
						</section>
					@endif
				</section>

				@isset($eleve->etablissement)
					<section class="etablissement">
						<h4>Établissement</h4>

						<p>
							Nom : {{ $eleve->etablissement->nom }} <br>
							Régime : {{ $eleve->etablissement->regime }} <br>
							Classe de l'élève : {{ $eleve->classe }} <br>
						</p>

					</section>
				@endisset

				@if($eleve->responsables->isNotEmpty())
					@foreach($eleve->responsables as $responsable)
						<section class="responsable">
							<h4>Responsable</h4>

							<p>
								Nom : {{ $responsable->nom }} <br>
								Prénom : {{ $responsable->prenom }} <br>
								Adresse : {{ $responsable->adresse }} <br>
								Téléphone : {{ $responsable->telephone }} <br>
								E-Mail: {{ $responsable->email }} <br>
							</p>
						</section>
					@endforeach
				@endif

				@if($eleve->materiels->isNotEmpty())
					<section class="materiel">
						<h4 class="text-center">Matériel prêté</h4>

						<table>
							<thead>
								<tr>
									<th>Type</th>
									<th>Marque</th>
									<th>N° de Série / Produit</th>
								</tr>
							</thead>
							<tbody>
								@foreach($eleve->materiels as $materiel)
									<tr>
										<td>{{ $materiel->type->libelle }}</td>
										<td>{{ $materiel->marque }}</td>
										<td>
											@if(!empty($materiel->cle_produit))
												{{ $materiel->cle_produit }}
											@else
												{{ $materiel->numero_serie }}
											@endif
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</section>
				@endif
			</section>
		</header>
	</body>
</html>