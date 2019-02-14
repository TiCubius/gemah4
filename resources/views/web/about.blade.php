@extends("web._includes._master")@php($title = "A propos")

@section("content")

	<div class="row">

		<div class="col-12 text-center">
			<h2>Bienvenue sur <strong>GEMAH</strong> <a href="{{ route("about") }}"><span class="text-muted small">3.0</span></a></h2>
			<h5>L'application de <strong>ge</strong>stion de prêt de <strong>ma</strong>tériel aux enfants en situation de <strong>h</strong>andicap.</h5>
			<hr class="w-100">
		</div>

		<div class="col-12">
			<div class="list-group mb-3">
				<div class="list-group-item list-group-item-action list-group-item-success">
					<b>AJOUTS</b>:
					<hr>

					<ul>
						<li class="mb-3">
							Administration
							<ul>
								<li>Gestion des académies</li>
								<li>Gestion des départements</li>
								<li>Gestion des régions</li>
								<li>Gestion des utilisateurs</li>
								<li>Gestion des services et des permissions</li>
								<li>Gestion des états administratifs du matériel</li>
								<li>Gestion des états physiques du matériel</li>
								<li>Gestion des types d'établissements</li>
								<li>Gestion des types de décision (AVS / Matériel)</li>
								<li>Gestion des types de documents (Lettre, photos, ...)</li>
								<li>Gestion des types de tickets (Appel téléphonique, ...)</li>
								<li>Personalisation des conventions</li>
								<li>Historique des actions</li>
							</ul>
						</li>

						<li class="mb-3">
							Conventions
							<ul>
								<li>Gestion des conventions</li>
								<li>Système de sauvegarde et de restauration des états signatures</li>
							</ul>
						</li>

						<li class="mb-3">
							Documentation utilisateur
							<ul>
								<li>Documentation complète de GEMAH</li>
							</ul>
						</li>

						<li class="mb-3">
							Matériels
							<ul>
								<li>
									Stocks
									<ul>
										<li>Affichage des derniers ajoutés/modifiés</li>
									</ul>
								</li>
								<li>
									Domaines
									<ul>
										<li>Gestion des domaines matériels</li>
									</ul>
								</li>
								<li>
									Types
									<ul>
										<li>Gestion des types matériels</li>
									</ul>
								</li>
							</ul>
						</li>

						<li class="mb-3">
							Scolarité
							<ul>
								<li>
									Élèves
									<ul>
										<li>Affichage des derniers ajoutés/modifiés</li>
										<li>Gestion des documents des élèves</li>
										<li>Système d'exportation</li>
									</ul>
								</li>
								<li>
									Établissements
									<ul>
										<li>Affichage des derniers ajoutés/modifiés</li>
										<li>Gestion des établissements</li>
										<li>65 000 établissements</li>
									</ul>
								</li>
								<li>
									Enseignants référents
									<ul>
										<li>Affichage des derniers ajoutés/modifiés</li>
										<li>Gestion des enseignants référents</li>
									</ul>
								</li>
							</ul>
						</li>

						<li class="mb-3">
							Statistiques
							<ul>
								<li>Exportation de la base de donnée au format excel</li>
								<li>Statistiques élèves et recherche avancée</li>
								<li>Statistiques matériels et recherche avancée</li>
							</ul>
						</li>

						<li class="mb-3">
							Responsables
							<ul>
								<li>Affichage des derniers ajoutés/modifiés</li>
								<li>Gestion des responsables</li>
								<li>Profil des responsables (détails des élèves, matériels, ...)</li>
							</ul>
						</li>

						<li>
							Autres modifications
							<ul>
								<li>Ajout du système d'historique des actions</li>
								<li>Ajout du système de permissions</li>
								<li>Ajout du système de trie par départements</li>
							</ul>
						</li>
					</ul>
				</div>

				<div class="list-group-item list-group-item-action list-group-item-primary">
					<b>CORRECTIONS / MODIFICATIONS</b>:
					<hr>

					<ul>
						<li>L'édition d'un élève ne remet plus à la date du jour sa date de naissance</li>
						<li>L'édition d'une décision ne remet plus à la date du jour les différentes dates</li>
						<li>La suppression des responsables ne supprime plus aléatoirement dans la base de donnée</li>
						<li>Changement de l'interface de GEMAH (uniformisation)</li>
						<li>La génération des conventions est maintenant plus rapide (quelques secondes contre quelques heures auparavant)</li>
					</ul>
				</div>

				<div class="list-group-item list-group-item-action list-group-item-danger">
					<b>SUPPRESSIONS</b>:
					<hr>

					<ul>
						<li>L'onglet récapitulatif de la gestion des élèves a été fusionné avec le profil</li>
					</ul>
				</div>

				<div class="list-group-item list-group-item-action list-group-item-info">
					<b>DÉVELOPPEURS</b>:
					<hr>

					<ul>
						<li>ARNAUD Louis, <a href="mailto:louis.arnaud.pro@gmail.com">envoyer un E-Mail</a></li>
						<li>MOULIN Théo, <a href="mailto:theo.moulin.sw@gmail.com">envoyer un E-Mail</a></li>
						<li>TARTIERE Kévin, <a href="mailto:ktartiere@gmail.com">envoyer un E-Mail</a></li>
					</ul>
				</div>
			</div>

		</div>

	</div>

@endsection