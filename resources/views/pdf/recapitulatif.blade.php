<html>
	<head>
		<meta charset="UTF-8">
		@include("pdf._includes.style")
	</head>
	<body>

		<section class="images">
			<div class="center" style="width: 100px;">
				<img src="{{ resource_path("images/liberte-egalite-fraternite.png") }}" style="height: 75px;">
			</div>

			<img src="{{ resource_path("images/dsden-logo.png") }}">
		</section>


		<div class="content">

			<h2 class="text-center">Récapitulatif</h2>

			<div>
				<section class="eleve" style="display: inline-block; width: 50%; float: left;">
					<h4>Élève</h4>

					<p>
						Nom : {{ $eleve->nom }} <br>
						Prénom : {{ $eleve->prenom }} <br>
						Date de naissance : {{ \Carbon\Carbon::parse($eleve->date_naissance)->format("d/m/Y") }} <br>
						Nombre de Joker : {{ $eleve->joker }} <br>
					</p>
				</section>

				<section class="mdph" style="display: inline-block; width: 50%;">
					<h4>Dossier MDPH</h4>

					<p>
						Date limite de la décision : 11/01/2019 <br>
						Date de signature de la convention : 11/01/2019 <br>
						Enseignant Référent : <br>
					</p>
				</section>
			</div>

			<section class="etablissement">
				<h4>Établissement</h4>

				<p>
					EtablissementNom : <br>
					Régime : <br>
					Classe de l'élève : 4e <br>
				</p>
			</section>

			<div>
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

				<section class="responsable" style="display: inline-block; width: 50%;">
					<h4>Responsable</h4>

					<p>
						Nom : {{ $responsable->nom }} <br>
						Prénom : {{ $responsable->prenom }} <br>
						Adresse : {{ $responsable->adresse }}<br>
						Téléphone : {{ $responsable->telephone }}<br>
						Email : {{ $responsable->email }} <br>
					</p>
				</section>
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

		</div>
	</body>
</html>