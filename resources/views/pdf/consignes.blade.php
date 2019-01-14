<html lang="fr">
	<head>
		<title>Consignes d'utilisation du materiel</title>
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

		<section id="content" style="margin-top: 150px; font-size: 16px;">
			<h2 class="text-center">Consignes d’utilisation du matériel informatique prêté</h2>

			<section id="legal" style="margin-top: 100px;">
				<b>L’ordinateur est prêté à l’enfant pour l’aider dans sa scolarité.</b>

				<p>Vous devrez nous le rendre dans les cas suivants :</p>

				<ul style="list-style: square">
					<li>la décision MDPH a pris fin</li>
					<li>l’enfant a eu son BAC</li>
					<li>l’enfant n’est plus scolarisé dans l’académie de Lyon</li>
					<li>l’enfant a changé d’orientation scolaire</li>
					(appelez-nous pour qu’on voit ensemble ce que cela implique)
				</ul>

				<p>Le matériel est prêté à l’enfant, et uniquement à lui.</p>

				<p>Il doit être utilisé à bon escient, donc pour travailler. Les jeux sont de ce fait proscrits (exception faite des logiciels éducatifs ou d’apprentissage sous forme ludique, ces derniers sont évidemment acceptés).</p>
			</section>

			<section id="antivirus">
				<b>Un anti-virus est déjà installé sur cette machine</b>

				<p>
					Il se nomme TrendMicro Officescan.

					Vous ne devez donc surtout pas en installer un autre (sinon votre machine risque de tomber en panne).

					Il faut le mettre à jour régulièrement (au moins une fois par semaine). Pour cela il suffit de connecter l’ordinateur à internet et l’anti-virus se mettra à jour tout seul.
				</p>

				<p>
					En cas de problèmes ou de questions, n’hésitez pas à nous appeler, vous avez nos coordonnées sur la convention.

					Prendre rendez-vous est obligatoire avant de passer nous voir.
				</p>
			</section>
		</section>
	</body>
</html>