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

		<div class="content" style="margin-top: 150px; font-size: 18px;">
			<h2 style="text-align: center;">Récépissé de récupération du matériel prêté</h2>

			<section id="date" style="margin-top: 50px;">
				A Saint-Etienne, le {{ \Carbon\Carbon::now()->format("d/m/Y") }}
			</section>

			<section style="margin-top: 50px;">
				Le responsable légal de DUPUY Anthony nous a rendu le matériel suivant : <br><br>

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

			<section style="margin-top: 50px;">
				Nous accusons réception de ce matériel qui est rendu définitivement.
			</section>

			<section style="margin-top: 50px; text-align: center;">
				Signature
			</section>

		</div>


	</body>
</html>