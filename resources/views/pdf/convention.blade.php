<html>
	<head>
		<meta charset="UTF-8">
		@include("pdf._includes.style")
	</head>
	<body>

		<section id="images">
			<div class="center" style="width: 100px;">
				<img src="{{ resource_path("images/liberte-egalite-fraternite.png") }}" style="height: 75px;">
			</div>

			<img style="position: absolute; top: 0;" src="{{ resource_path("images/dsden-logo.png") }}">
		</section>

		<section id="responsable">
			<div class="float-right" style="width: 350px; margin-top: 50px;">
				<p style="font-size: 14px;">
					L’Inspecteur d’académie, directeur académique des services de l’éducation nationale de la Loire <br><br>
					à <br><br>
					{{ "{$responsable->nom} {$responsable->prenom}" }} <br>
					{{ "{$responsable->adresse}" }} <br>
					{{ "{$responsable->code_postal} {$responsable->ville}" }}
				</p>
			</div>
		</section>

		<section id="informations" style="margin-top: 180px; margin-bottom: 20px; width: 120px; text-align: right; font-size: 10px;">
			<div id="conventions">
				CONVENTIONS <br>
				Affaire suivie par : <br>
				BELMIRO Virginie <br>
				04 77 81 41 13 <br>
			</div>

			<div id="informatique" style="margin-top: 20px;">
				MATERIEL INFORMATIQUE <br>
				Affaire suivie par : <br>
				GOUNON Jean-Jacques <br>
				04 77 81 79 47 <br>
			</div>

			<div id="audio" style="margin-top: 20px;">
				MATERIEL AUDIO <br>
				Affaire suivie par : <br>
				GAVILLET Annick <br>
				04 77 81 41 38 <br>
			</div>

			<div id="adresse" style="margin-top: 20px;">
				ADRESSE : <br>
				11, rue des Docteurs Charcot <br>
				42023, Saint-Etienne <br>
			</div>
		</section>

		<div id="content" style="max-width: 800px; margin: 0 auto;">

			<section id="legal" style="font-style: italic;">
				Vu la circulaire n° 2001-061 du 5 avril 2001 publiée au Bulletin Officiel n° 15 du 12 avril 2001, sur lefinancement de matériels pédagogiques adaptés au bénéfice d’élèves présentant des déficiencessensorielles ou motrices. Vu la circulaire n° 2001-221 du 29 octobre 2001 apportant des précisionssur les conventions de mise à disposition de ces matériels
			</section>

			<section id="eleve" style="margin-top: 20px; margin-bottom: 20px;">
				Entre les soussignés : <br><br>

				D'une part le directeur académique des services de l’éducation nationale de la Loire <br><br>
				Et, d'autre part : vous-mêmes (responsable légal) <br><br>

				Représentant légal de l'élève (articles L 131-4 du Code de l'Education) <br>
				Prénom - Nom, élève : <b>{{ "{$eleve->nom} {$eleve->prenom}" }}</b> <br>
				Né(e) le : <b>{{ Carbon\Carbon::parse($eleve->date_naissance)->format("d/m/Y") }}</b> <br><br>

				Scolarisé(e) à : <br>
				Etablissement : <b>{{ $eleve->etablissement->nom }}</b><br>
				Classe : <b>{{ $eleve->classe }}</b><br><br>

				Il a été convenu ce qui suit :
			</section>

			<section id="article1">
				<h2 class="text-center">Article 1 : objet de la convention</h2>

				Dans le cadre du plan triennal d'accès à l'autonomie des personnes handicapées, la Commission des droitset de l’autonomie est garante de l'attribution d'équipement répondant aux besoins particuliers d'enfantsdéficients sensoriels et moteurs, après avis médical et pédagogique des services compétents
			</section>

			<section id="article2" class="new-page">
				<h2 class="text-center">Article 2 : désignation du matériel</h2>
				Pour l'année scolaire 2018/2019 est mis à disposition le matériel suivant appartenant à l’Etat : <br><br>

				<table>
					<thead>
						<tr>
							<th>Type</th>
							<th>Marque</th>
							<th>N° de Série</th>
						</tr>
					</thead>
					<tbody>
						@foreach($eleve->materiels as $materiel)
							<tr>
								<td>{{ $materiel->type->nom }}</td>
								<td>{{ $materiel->marque }}</td>
								<td>{{ $materiel->num_serie }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>

			</section>

			<section id="article3">
				<h2 class="text-center">Article 3 : dispositions financières</h2>

				Il ne sera demandé aucune contribution financière au bénéficiaire à l'exclusion des consommables indispensablesau fonctionnement du matériel.
			</section>

			<section id="article4">
				<h2 class="text-center">Article 4 : conditions de mise à disposition</h2>

				Le bénéficiaire s'engage à utiliser le bien qui lui est confié uniquement dans le cadre du travail scolaire dans l'établissement ou à son domicile (article 1880 du Code civil). Il s’engage à porter à la connaissance du service gestionnaire (direction des services départementaux de l’éducation nationale de le Loire, service informatique) tout sinistre affectant le matériel prêté. Le service étudiera alors les modalités de prise en charge des réparations nécessaires. Toutefois s’il s’avère que le matériel a subit des dommages importants et ne peut être réparé, il ne sera pas remplacé plus d’une fois. Toute modification dans la composition de la liste du matériel fera l'objet d'un avenant à la présente convention (retrait ou adjonction).
			</section>

			<section id="article5">
				<h2 class="text-center">Article 5 : Durée et renouvellement de la convention</h2>

				<b>La présente convention devra être obligatoirement signée et retournée à la direction des services départementaux de l’éducation nationale de le Loire, division de l’élève en début de chaque année scolaire afin de faciliter le suivi de l’élève et du matériel.</b> A défaut de signature de la convention, ce matériel ne pourra être laissé à disposition de l’élève. <br><br>
				L'élève peut conserver le bénéfice de cette opération <b>le temps de sa scolarité dans un établissement Education Nationale de l'Académie de LYON</b> (premier et second degrés) ; s'il quitte cette dernière, le matériel sera restitué à la direction des services départementaux de l’éducation nationale de la Loire, qui assurera le lien avec l'Académie d'accueil. Le prêt de matériel prendra fin le 10/07/2021 en vertu de la décision du 15/05/2018.
			</section>

			<section id="signature1" style="margin: 20px 0; margin-bottom: 200px;">
				<div class="col1" style="float: left; padding-left: 12.5%; width: 25%;">
					A Saint-Etienne, <br>
					le : {{ \Carbon\Carbon::now()->format('d/m/Y') }} <br> <br>

					Le représentant légal
				</div>

				<div class="col2" style="float: left; padding-left: 12.5%; width: 50%;">
					A Saint-Etienne, le {{ \Carbon\Carbon::now()->format('d/m/Y') }} <br> <br>

					Pour l’inspecteur d’académie, directeur académiquedes services de l’éducation nationale de la Loire <br>
					Par délégation <br>
					Le secrétaire général <br>
					Jean-Luc POUMAREDES
				</div>

			</section>

			<section>
				Dans le cas d'un matériel restant en permanence sur le lieu de scolarisation : signature du Chef d'établissement ou du représentant de la commune (articles 1921, 1927 et suivants du Code civil).
			</section>

			<section id="signature2" style="margin-top: 20px;">

				<div class="col1" style="float: left; padding-left: 12.5%; width: 25%;">
					A Saint-Etienne, le : {{ \Carbon\Carbon::now()->format('d/m/Y') }}
				</div>

				<div class="col2" style="float: left; padding-left: 12.5%; width: 50%;">
					Qualité du signataire
				</div>
			</section>

			<section class="text-center" style="margin-top: 75px;">
				<b>
					Cette convention, après signature de la famille et du secrétaire général, doit être conservée par la famille
				</b>
			</section>
		</div>

	</body>
</html>