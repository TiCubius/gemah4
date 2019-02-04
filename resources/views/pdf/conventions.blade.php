<html lang="fr">
<head>
	<title>Consignes d'utilisation du materiel</title>
	<meta charset="UTF-8">
	@include("pdf._includes.style")
</head>

@foreach($eleves as $eleve)
	@php
		$decision = $eleve->decisions->sortBy("created_at")->last()
	@endphp

	@foreach($eleve->responsables as $responsable)
		<body style="font-size: 11px;">
		<header>
			<section id="marianne" class="text-center">
				<img src="{{ resource_path("images/marianne-logo.png") }}" style="height: 75px;">
			</section>

			<section id="dsden" style="position: absolute; top: 0;">
				<img src="{{ resource_path("images/dsden-logo.png") }}">
			</section>

			<section id="responsable" style="margin-top: 50px; margin-left: 58%;">
				<p>
					L’Inspecteur d’académie, directeur académique <br>
					des services de l’éducation nationale de la Loire
					<br> <br>
					à
					<br><br>
					{{ "{$responsable->nom} {$responsable->prenom}" }} <br>
					{{ "{$responsable->adresse}" }} <br>
					{{ "{$responsable->code_postal} {$responsable->ville}" }}
				</p>
			</section>

			<section id="informations" style="width: 125px; font-size: 10px; text-align: right; margin-top: -50px;">
				<p>
					CONVENTIONS <br>
					Affaire suivie par : <br>
					{{ $parametres["conventions/affaire/convention/nom"] }} <br>
					{{ $parametres["conventions/affaire/convention/telephone"] }} <br>
					{{ $parametres["conventions/affaire/convention/email"] }} <br>
				</p>

				<p>
					MATERIEL INFORMATIQUE <br>
					Affaire suivie par : <br>
					{{ $parametres["conventions/affaire/informatique/nom"] }} <br>
					{{ $parametres["conventions/affaire/informatique/telephone"] }} <br>
					{{ $parametres["conventions/affaire/informatique/email"] }} <br>
				</p>

				<p>
					MATERIEL AUDIO <br>
					Affaire suivie par : <br>
					{{ $parametres["conventions/affaire/audio/nom"] }} <br>
					{{ $parametres["conventions/affaire/audio/telephone"] }} <br>
					{{ $parametres["conventions/affaire/audio/email"] }} <br>
				</p>

				<p>
					ADRESSE <br>
					{{ $parametres["conventions/adresse"] }} <br>
					{{ $parametres["conventions/code_postal"] }} {{ $parametres["conventions/ville"] }}
				</p>
			</section>
		</header>

		<section id="content">
			<section id="lois" style="text-align: justify;">
				<p>
					<i>
						Vu la circulaire n° 2001-061 du 5 avril 2001 publiée au Bulletin Officiel n° 15 du 12 avril
						2001, sur le financement de matériels pédagogiques adaptés au bénéfice d’élèves présentant des
						déficiences sensorielles ou motrices. Vu la circulaire n° 2001-221 du 29 octobre 2001 apportant
						des précision ssur les conventions de mise à disposition de ces matériels.
					</i>
				</p>
			</section>

			<section id="parties">
				<p>
					Entre les soussignés : <br><br>
					D'une part le directeur académique des services de l’éducation nationale de la Loire <br><br>
					Et, d'autre part : {{"{$responsable->nom} {$responsable->prenom}"}}<br><br>
					Représentant légal de l'élève (articles L 131-4 du Code de l'Education)
				</p>


				<div style="display: inline-block; width: 50%; float: left; text-align: left;">
					<p>
						Élève <br>
						Nom / Prénom : <b>{{ "{$eleve->nom} {$eleve->prenom}" }}</b> <br>
						Né(e) le : <b>{{ "{$eleve->date_naissance->format('d/m/Y')}" }}</b>
					</p>
				</div>

				<div style="display: inline-block; width: 50%; float: left; text-align: left;">
					<p>
						Scolarisé(e) à <br>
						Etablissement : <b>{{ "{$eleve->etablissement->nom}" }}</b> <br>
						Classe : <b>{{ "{$eleve->classe}" }}</b> <br>
					</p>
				</div>

				<p>Il a été convenu ce qui suit :</p>
			</section>

			<section id="article-1" style="margin-top: 50px; text-align: justify;">
				<h2>Article 1 : objet de la convention</h2>

				<p>
					Dans le cadre du plan triennal d'accès à l'autonomie des personnes handicapées, la Commission des droits
					et de l’autonomie est garante de l'attribution d'équipement répondant aux besoins particuliers d'enfants
					déficients sensoriels et moteurs, après avis médical et pédagogique des services compétents.
				</p>
			</section>

			<div class="new-page"></div>
			<section id="article2" style="text-align: justify;">
				<h2>Article 2 : désignation du matériel</h2>

				<p>
					Pour <b>l'année scolaire {{ $parametres["conventions/annee"] }}</b> est mis à disposition le matériel suivant appartenant à l’Etat :
				</p>

				<table>
					<thead>
					<tr>
						<th>Type</th>
						<th>Marque</th>
						<th>Modèle</th>
						<th>N° de Série</th>
					</tr>
					</thead>
					<tbody>
					@foreach($eleve->materiels as $materiel)
						<tr>
							<td>{{ $materiel->type->libelle }}</td>
							<td>{{ $materiel->marque }}</td>
							<td>{{ $materiel->modele }}</td>
							@if($materiel->type->domaine->libelle == "Logiciel")
								<td>{{ $materiel->cle_produit }}</td>
							@else
								<td>{{ $materiel->numero_serie }}</td>
							@endif
						</tr>
					@endforeach
					</tbody>
				</table>
			</section>


			<section id="article3" style="text-align: justify;">
				<h2>Article 3 : dispositions financières</h2>

				<p>Il ne sera demandé aucune contribution financière au bénéficiaire à l'exclusion des consommables
					indispensables au fonctionnement du matériel.
				</p>
			</section>

			<section id="article4" style="text-align: justify;">
				<h2>Article 4 : conditions de mise à disposition</h2>

				<p>Le bénéficiaire s'engage à utiliser le bien qui lui est confié uniquement dans le cadre du travail
					scolaire dans l'établissement ou à son domicile (article 1880 du Code civil). Il s’engage à porter à
					la connaissance du service gestionnaire (direction des services départementaux de l’éducation
					nationale de le Loire, service informatique) tout sinistre affectant le matériel prêté. Le service
					étudiera alors les modalités de prise en charge des réparations nécessaires. Toutefois s’il s’avère
					que le matériel a subit des dommages importants et ne peut être réparé, il ne sera pas remplacé plus
					d’une fois. Toute modification dans la composition de la liste du matériel fera l'objet d'un avenant
					à la présente convention (retrait ou adjonction).
				</p>
			</section>

			<section id="article5" style="text-align: justify;">
				<h2>Article 5 : Durée et renouvellement de la convention</h2>

				<p>
					<b>La présente convention devra être obligatoirement signée et retournée à la direction des services
						départementaux de l’éducation nationale de le Loire, division de l’élève en début de chaque
						année scolaire afin de faciliter le suivi de l’élève et du matériel.</b> A défaut de signature
					de la convention, ce matériel ne pourra être laissé à disposition de l’élève. <br><br>
					L'élève peut conserver le bénéfice de cette opération <b>le temps de sa scolarité dans un
						établissement Education Nationale de l'Académie de LYON</b> (premier et second degrés) ; s'il
					quitte cette dernière, le matériel sera restitué à la direction des services départementaux de
					l’éducation nationale de la Loire, qui assurera le lien avec l'Académie d'accueil.

					@if($decision->date_limite)
						Le prêt de matériel prendra fin le {{ $decision->date_limite->format("d/m/Y") }} en vertu de la
						décision du {{ $decision->date_notification ? $decision->date_notification->format("d/m/Y") : \Carbon\Carbon::now()->format("d/m/Y") }}.
					@endif
				</p>
			</section>

			<section id="signature1" style="margin-top: 20px; height: 150px;">
				<div style="width: 50%; height: 150px; text-align: center; float: left;">
					<p>
						A Saint-Etienne, <br>
						le : {{ \Carbon\Carbon::now()->format('d/m/Y') }} <br><br>

						Le représentant légal
					</p>
				</div>

				<div style="width: 50%; height: 150px; text-align: center; float: left;">
					<p>
						A Saint-Etienne, le {{ \Carbon\Carbon::now()->format('d/m/Y') }} <br><br>

						Pour l’inspecteur d’académie, directeur académique des services de l’éducation nationale de la
						Loire <br>
						Par délégation <br><br>
						Le secrétaire général <br>
						{{ $parametres["conventions/secretaire"] }}
					</p>
				</div>
			</section>

			<section>
				<p>Dans le cas d'un matériel restant en permanence sur le lieu de scolarisation : signature du Chef
					d'établissement ou du représentant de la commune (articles 1921, 1927 et suivants du Code
					civil).
				</p>
			</section>

			<section id="signature2" style="height: 50px;">
				<div style="float: left; width: 50%; text-align: center; height: 50px;">
					A Saint-Etienne, le : {{ \Carbon\Carbon::now()->format('d/m/Y') }}
				</div>

				<div style="float: left; width: 50%; text-align: center; height: 50px;">
					Qualité du signataire
				</div>
			</section>

			<section class="text-center">
				<p><b>Cette convention, après signature de la famille et du secrétaire général, doit être conservée par
						la famille</b></p>
			</section>
		</section>
		</body>
	@endforeach
@endforeach
</html>