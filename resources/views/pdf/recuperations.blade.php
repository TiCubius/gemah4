<html>
	<head>
		<meta charset="UTF-8">
		@include("pdf._includes.style")
	</head>
	<body>
		<header>
			<section id="marianne" class="text-center">
				<img src="{{ resource_path("images/marianne-logo.png") }}" style="height: 75px;">
			</section>

			<section id="dsden" style="position: absolute; top: 0;">
				<img src="{{ resource_path("images/".session('user')->departement_id."/dsden-logo.png") }}">
			</section>
		</header>

		<section class="content" style="margin-top: 125px;">
			<h2>Récépissé de récupération du matériel prêté</h2>

			<section id="date" style="margin-top: 50px;">
				A Saint-Etienne, le {{ \Carbon\Carbon::now()->format("d/m/Y") }}
			</section>

			<section style="margin-top: 50px;">
				Le responsable légal de {{ "{$eleve->nom} {$eleve->prenom}" }} nous a rendu le matériel suivant : <br><br>

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
								<td>{{ $materiel->type->libelle }}</td>
								<td>{{ $materiel->marque }}</td>
								<td>{{ $materiel->numero_serie }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</section>

			<section style="margin-top: 50px;">
				Nous accusons réception de ce matériel qui est rendu définitivement.
			</section>

			<section style="margin-top: 50px; text-align: center;">
				Signature
			</section>
		</section>
	</body>
</html>