<html>
	<head>
		@include("pdf._includes.style")
	</head>
	<body>


		<div class="center" style="width: 100px;">
			<img src="{{ resource_path("images/liberte-egalite-fraternite.png") }}" style="height: 75px;">
		</div>

		<img class="float-left" src="{{ resource_path("images/dsden-logo.png") }}">

		<div class="float-right" style="width: 310px; margin-top: 50px;">
			<p style="font-size: 14px;">
				L’Inspecteur d’académie, directeur académique des services de l’éducation nationale de la Loire <br><br>
				à <br><br>
				{{ "{$responsable->nom} {$responsable->prenom}" }} <br>
				{{ "{$responsable->adresse}" }} <br>
				{{ "{$responsable->code_postal} {$responsable->ville}" }}
			</p>
		</div>

		<div class="space" style="margin-top: 300px;">
			<h4>A Saint-Etienne, le : {{ Carbon\Carbon::now()->format('d/m/Y') }}</h4>
		</div>

		<p class="text-center" style="margin-top: 100px;">
			Je donne mon accord pour que l'ensemble des informations nécessaires auprêt de matériel adapté pour mon enfant fasse l'objet d'un traitementautomatisé.Je suis informé que le droit d'accès et de rectification s'exerce auprès del'IA-DASEN du département concerné conformément à la loi du 10/01/78.
		</p>

		<div class="signature text-center" style="margin-top: 100px;">
			<h4>Signature</h4>
		</div>

	</body>
</html>