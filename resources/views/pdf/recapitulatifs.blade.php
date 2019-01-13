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
				<img src="{{ resource_path("images/dsden-logo.png") }}">
			</section>
		</header>

		<section class="content" style="margin-top: 75px;">
			<h2>Récapitulatif</h2>

			<section>
				<div class="eleve" style="display: inline-block; width: 50%; float: left; height: 150px;">
					<h4>Élève</h4>

					<p>
						Nom : {{ $eleve->nom }} <br>
						Prénom : {{ $eleve->prenom }} <br>
						Date de naissance : {{ \Carbon\Carbon::parse($eleve->date_naissance)->format("d/m/Y") }} <br>
						Nombre de Joker : {{ $eleve->joker }} <br>
					</p>
				</div>

				<div class="mdph" style="display: inline-block; width: 50%; float: left; height: 150px;">
					<h4>Dossier MDPH</h4>

					<p>
						Date limite de la décision : 11/01/2019 <br>
						Date de signature de la convention : 11/01/2019 <br>
						Enseignant Référent : <br>
					</p>
				</div>
			</section>

			<section class="etablissement">
				<h4>Établissement</h4>

				<p>
					Nom : {{ $eleve->etablissement->nom }}<br>
					Régime : {{ $eleve->etablissement->regime }}<br>
					Classe de l'élève : {{ $eleve->classe }} <br>
				</p>
			</section>

			<div>
				@foreach($eleve->responsables as $responsable)
					<section class="responsable" style="display: inline-block; width: 50%; float: left;">
						<h4>Responsable</h4>

						<p>
							Nom : {{ $responsable->nom }} <br>
							Prénom : {{ $responsable->prenom }} <br>
							Adresse : {{ $responsable->adresse }}<br>
							Téléphone : {{ $responsable->telephone }}<br>
							Email : {{ $responsable->email }} <br>
						</p>
					</section>
				@endforeach
			</div>

			<section class="materiel" style="margin-top: 50px;">
				<h4 class="text-center">Matériel prêté</h4>

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
		</section>
	</body>
</html>