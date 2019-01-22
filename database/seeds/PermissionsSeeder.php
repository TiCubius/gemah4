<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
	protected $permissions = [
		"administrations/index" => "Peut afficher le menu administrateur",

		"administrations/academies/index"   => "Peut afficher la liste des académies",
		"administrations/academies/create"  => "Peut créer une academie",
		"administrations/academies/show"    => "Peut afficher les informations sur une academie",
		"administrations/academies/edit"    => "Peut modifier une academie",
		"administrations/academies/destroy" => "Peut supprimer une academie",

		"administrations/departements/index"   => "Peut afficher la liste des départements",
		"administrations/departements/create"  => "Peut créer un departement",
		"administrations/departements/show"    => "Peut afficher les informations sur un departement",
		"administrations/departements/edit"    => "Peut modifier un departement",
		"administrations/departements/destroy" => "Peut supprimer un departement",

		"administrations/regions/index"   => "Peut afficher la liste des régions",
		"administrations/regions/create"  => "Peut créer un departement",
		"administrations/regions/show"    => "Peut afficher les informations sur un departement",
		"administrations/regions/edit"    => "Peut modifier un departement",
		"administrations/regions/destroy" => "Peut supprimer un departement",


		"administrations/services/index"   => "Peut afficher la liste des services",
		"administrations/services/create"  => "Peut créer un service",
		"administrations/services/show"    => "Peut afficher les informations sur un service",
		"administrations/services/edit"    => "Peut modifier un service",
		"administrations/services/destroy" => "Peut supprimer un service",

		"administrations/utilisateurs/index"   => "Peut afficher la liste des utilisateurs",
		"administrations/utilisateurs/create"  => "Peut créer un utilisateur",
		"administrations/utilisateurs/show"    => "Peut afficher les informations sur un utilisateur",
		"administrations/utilisateurs/edit"    => "Peut modifier un utilisateur",
		"administrations/utilisateurs/destroy" => "Peut supprimer un utilisateur",


		"administrations/etats/materiels/index"   => "Peut afficher la liste des états matériel",
		"administrations/etats/materiels/create"  => "Peut créer un état matériel",
		"administrations/etats/materiels/show"    => "Peut afficher les informations sur un état matériel",
		"administrations/etats/materiels/edit"    => "Peut modifier un état matériel",
		"administrations/etats/materiels/destroy" => "Peut supprimer un état matériel",

		"administrations/historique/show" => "Peut afficher l'historique des actions",

		"administrations/types/eleves/index"   => "Peut afficher la liste des types d'élève",
		"administrations/types/eleves/create"  => "Peut créer un type d'élève",
		"administrations/types/eleves/show"    => "Peut afficher les informations sur un type d'élève",
		"administrations/types/eleves/edit"    => "Peut modifier un type d'élève",
		"administrations/types/eleves/destroy" => "Peut supprimer un type d'élève",

		"administrations/types/etablissements/index"   => "Peut afficher la liste des types d'établissement",
		"administrations/types/etablissements/create"  => "Peut créer un type d'établissement",
		"administrations/types/etablissements/show"    => "Peut afficher les informations sur un type d'établissement",
		"administrations/types/etablissements/edit"    => "Peut modifier un type d'établissement",
		"administrations/types/etablissements/destroy" => "Peut supprimer un type d'établissement",

		"administrations/types/tickets/index"   => "Peut afficher la liste des types de tickets",
		"administrations/types/tickets/create"  => "Peut créer un type de ticket",
		"administrations/types/tickets/show"    => "Peut afficher les informations sur un type de ticket",
		"administrations/types/tickets/edit"    => "Peut modifier un type de ticket",
		"administrations/types/tickets/destroy" => "Peut supprimer un type de ticket",


		"eleves/index"   => "Peut afficher la liste des élèves",
		"eleves/create"  => "Peut créer un élève",
		"eleves/show"    => "Peut afficher les informations sur un élève",
		"eleves/edit"    => "Peut modifier un élève",
		"eleves/destroy" => "Peut supprimer un élève",

		"affectations/etablissements/attach" => "Peut affecter un élève à un établissement",
		"affectations/etablissements/detach" => "Peut désaffecter un élève d'un établissement",
		"affectations/materiels/attach"      => "Peut affecter du matériel à un élève",
		"affectations/materiels/detach"      => "Peut désaffecter un matériel d'un élève",
		"affectations/responsables/attach"   => "Peut affecter un élève à un responsable",
		"affectations/responsables/detach"   => "Peut désaffecter un élève d'un responsable",


		"enseignants/index"   => "Peut afficher la liste des enseignants",
		"enseignants/create"  => "Peut créer un enseignant",
		"enseignants/show"    => "Peut afficher les informations sur un enseignant",
		"enseignants/edit"    => "Peut modifier un enseignant",
		"enseignants/destroy" => "Peut supprimer un enseignant",


		"etablissements/index"   => "Peut afficher la liste des établissements",
		"etablissements/create"  => "Peut créer un etablissement",
		"etablissements/show"    => "Peut afficher les informations sur un etablissement",
		"etablissements/edit"    => "Peut modifier un etablissement",
		"etablissements/destroy" => "Peut supprimer un etablissement",

		"materiels/index" => "Peut afficher le menu gestion du matériel",

		"materiels/stocks/index"   => "Peut afficher la liste des matériels",
		"materiels/stocks/create"  => "Peut créer un matériel",
		"materiels/stocks/show"    => "Peut afficher les informations sur un matériel",
		"materiels/stocks/edit"    => "Peut modifier un matériel",
		"materiels/stocks/destroy" => "Peut supprimer un matériel",

		"materiels/types/index"   => "Peut afficher la liste des types de matériel",
		"materiels/types/create"  => "Peut créer un type de matériel",
		"materiels/types/show"    => "Peut afficher les informations sur un type de matériel",
		"materiels/types/edit"    => "Peut modifier un type de matériel",
		"materiels/types/destroy" => "Peut supprimer un type de matériel",

		"materiels/domaines/index"   => "Peut afficher la liste des domaines de matériel",
		"materiels/domaines/create"  => "Peut créer un domaine de matériel",
		"materiels/domaines/show"    => "Peut afficher les informations sur un domaine de matériel",
		"materiels/domaines/edit"    => "Peut modifier un domaine de matériel",
		"materiels/domaines/destroy" => "Peut supprimer un domaine de matériel",


		"responsables/index"   => "Peut afficher la liste des responsables",
		"responsables/create"  => "Peut créer un responsable",
		"responsables/show"    => "Peut afficher les informations sur un responsable",
		"responsables/edit"    => "Peut modifier un responsable",
		"responsables/destroy" => "Peut supprimer un responsable",
	];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		foreach ($this->permissions as $code => $permission) {
			\App\Models\Permission::create([
				"id"      => $code,
				"libelle" => $permission,
			]);
		}
	}
}
