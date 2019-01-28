<html lang="fr">
	<head>
		<title>Autorisation CNIL - {{ "{$eleve->nom} {$eleve->prenom}" }}</title>
		<meta charset="UTF-8">
		@include("pdf._includes.style")
	</head>

	@foreach($eleve->responsables as $responsable)
		<body>
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
			</header>

			<section id="content" style="margin-top: 50px; font-size: 16px;">
				<section id="date">
					A Saint-Etienne, le : {{ \Carbon\Carbon::now()->format("d/m/Y") }}
				</section>

				<section id="legal" style="margin-top: 100px; text-align: center; font-size: 18px;">
					Je donne mon accord pour que l'ensemble des informations nécessaires au prêt de matériel adapté pour mon enfant fasse l'objet d'un traitement automatisé.

					Je suis informé que le droit d'accès et de rectification s'exerce auprès de l'IA-DASEN du département concerné conformément à la loi du 10/01/78.
				</section>

				<section id="signature" style="margin-top: 100px; text-align: center;">
					Signature
				</section>
			</section>
		</body>
	@endforeach
</html>