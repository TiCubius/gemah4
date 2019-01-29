<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
	protected $permissions = [
		"administrations/index" => "Peut afficher le menu administrateur",

		"administrations/academies/index"   => "Peut afficher la liste des académies",
		"administrations/academies/create"  => "Peut créer une academie",
		//		"administrations/academies/show"    => "Peut afficher les informations sur une academie",
		"administrations/academies/edit"    => "Peut modifier une academie",
		"administrations/academies/destroy" => "Peut supprimer une academie",

		"administrations/departements/index"   => "Peut afficher la liste des départements",
		"administrations/departements/create"  => "Peut créer un departement",
		//		"administrations/departements/show"    => "Peut afficher les informations sur un departement",
		"administrations/departements/edit"    => "Peut modifier un departement",
		"administrations/departements/destroy" => "Peut supprimer un departement",

		"administrations/regions/index"   => "Peut afficher la liste des régions",
		"administrations/regions/create"  => "Peut créer un departement",
		//		"administrations/regions/show"    => "Peut afficher les informations sur un departement",
		"administrations/regions/edit"    => "Peut modifier un departement",
		"administrations/regions/destroy" => "Peut supprimer un departement",


		"administrations/services/index"   => "Peut afficher la liste des services",
		"administrations/services/create"  => "Peut créer un service",
		//		"administrations/services/show"    => "Peut afficher les informations sur un service",
		"administrations/services/edit"    => "Peut modifier un service",
		"administrations/services/destroy" => "Peut supprimer un service",

		"administrations/utilisateurs/index"   => "Peut afficher la liste des utilisateurs",
		"administrations/utilisateurs/create"  => "Peut créer un utilisateur",
		//		"administrations/utilisateurs/show"    => "Peut afficher les informations sur un utilisateur",
		"administrations/utilisateurs/edit"    => "Peut modifier un utilisateur",
		"administrations/utilisateurs/destroy" => "Peut supprimer un utilisateur",


		"administrations/etats/materiels/administratifs/index"   => "Peut afficher la liste des états administratifs du matériel",
		"administrations/etats/materiels/administratifs/create"  => "Peut créer un état administratif du matériel",
		//		"administrations/etats/materiels/administratifs/show"    => "Peut afficher les informations sur un état administratif d'un matériel",
		"administrations/etats/materiels/administratifs/edit"    => "Peut modifier un état administratif du matériel",
		"administrations/etats/materiels/administratifs/destroy" => "Peut supprimer un état administratif du matériel",

		"administrations/etats/materiels/physiques/index"   => "Peut afficher la liste des états physiques du matériel",
		"administrations/etats/materiels/physiques/create"  => "Peut créer un état physique d'un matériel",
		//		"administrations/etats/materiels/physiques/show"    => "Peut afficher les informations sur un état physique d'un matériel",
		"administrations/etats/materiels/physiques/edit"    => "Peut modifier un état physique d'un matériel",
		"administrations/etats/materiels/physiques/destroy" => "Peut supprimer un état physique d'un matériel",

        "administrations/historiques/index" => "Peut afficher l'historique",
        "administrations/historiques/show"  => "Peut afficher les informations sur une ligne de l'historique",

		"administrations/parametres/edit" => "Peut modifier les paramètres généraux (ex: informations sur les conventions)",

		"administrations/types/documents/index"   => "Peut afficher la liste des types de documen",
		"administrations/types/documents/create"  => "Peut créer un type de document",
		//		"administrations/types/documents/show"    => "Peut afficher les informations sur un type de document",
		"administrations/types/documents/edit"    => "Peut modifier un type de document",
		"administrations/types/documents/destroy" => "Peut supprimer un type de document",

		"administrations/types/decisions/index"   => "Peut afficher la liste des types de décision",
		"administrations/types/decisions/create"  => "Peut créer un type de décision",
		//		"administrations/types/decisions/show"    => "Peut afficher les informations sur un type d'élève",
		"administrations/types/decisions/edit"    => "Peut modifier un type de décision",
		"administrations/types/decisions/destroy" => "Peut supprimer un type de décision",

		"administrations/types/etablissements/index"   => "Peut afficher la liste des types d'établissement",
		"administrations/types/etablissements/create"  => "Peut créer un type d'établissement",
		//		"administrations/types/etablissements/show"    => "Peut afficher les informations sur un type d'établissement",
		"administrations/types/etablissements/edit"    => "Peut modifier un type d'établissement",
		"administrations/types/etablissements/destroy" => "Peut supprimer un type d'établissement",

		"administrations/types/tickets/index"   => "Peut afficher la liste des types de tickets",
		"administrations/types/tickets/create"  => "Peut créer un type de ticket",
		//		"administrations/types/tickets/show"    => "Peut afficher les informations sur un type de ticket",
		"administrations/types/tickets/edit"    => "Peut modifier un type de ticket",
		"administrations/types/tickets/destroy" => "Peut supprimer un type de ticket",


		"affectations/etablissements/index"  => "Peut rechercher un établissement à affecter",
		"affectations/etablissements/attach" => "Peut affecter un élève à un établissement",
		"affectations/etablissements/detach" => "Peut désaffecter un élève d'un établissement",
		"affectations/materiels/index"       => "Peut rechercher un materiel à affecter",
		"affectations/materiels/attach"      => "Peut affecter du matériel à un élève",
		"affectations/materiels/detach"      => "Peut désaffecter un matériel d'un élève",
		"affectations/responsables/index"    => "Peut rechercher un responsable à affecter",
		"affectations/responsables/create"   => "Peut créer un responsable à affecter et l'affecter immédiatement",
		"affectations/responsables/attach"   => "Peut affecter un élève à un responsable",
		"affectations/responsables/detach"   => "Peut désaffecter un élève d'un responsable",


		"conventions/index"                        => "Peut afficher la liste des états signature des conventions",
		"conventions/edit"                         => "Peut modifier l'état signature des conventions",
		"conventions/signaturesEffectuees"         => "Peut générer la liste des signatures effecutées",
		"conventions/signaturesManquantes"         => "Peut générer la liste des signatures manquantes",
		"conventions/impressionsToutesConventions" => "Peut générer les conventions",


		"eleves/index"   => "Peut afficher la liste des élèves",
		"eleves/create"  => "Peut créer un élève",
		"eleves/show"    => "Peut afficher les informations sur un élève",
		"eleves/edit"    => "Peut modifier un élève",
		"eleves/destroy" => "Peut supprimer un élève",

		"eleves/documents/index"    => "Peut afficher la liste des documents",
		"eleves/documents/create"   => "Peut créer un document",
		"eleves/documents/edit"     => "Peut modifier un document",
		"eleves/documents/destroy"  => "Peut supprimer un document",
		"eleves/documents/download" => "Peut télécharger un document",

		"eleves/decisions/index"    => "Peut afficher la liste des décisions",
		"eleves/decisions/create"   => "Peut créer une décision",
		"eleves/decisions/edit"     => "Peut modifier une décision",
		"eleves/decisions/destroy"  => "Peut supprimer une décision",
		"eleves/decisions/download" => "Peut télécharger une décision",

		"eleves/impressions/autorisations"  => "Peut générer un PDF d'autorisations CNIL",
		"eleves/impressions/consignes"      => "Peut générer un PDF de consignes de prêt",
		"eleves/impressions/conventions"    => "Peut générer un PDF de convention élève",
		"eleves/impressions/recapitulatifs" => "Peut générer un PDF de récapitulatif élève",
		"eleves/impressions/recuperations"  => "Peut générer un PDF de récépissé de récupération de matériel",

		"eleves/tickets/index"   => "Peut afficher la liste des tickets",
		"eleves/tickets/create"  => "Peut créer un ticket",
		"eleves/tickets/show"    => "Peut afficher les informations d'un ticket",
		"eleves/tickets/edit"    => "Peut modifier un ticket",
		"eleves/tickets/destroy" => "Peut supprimer un ticket",

		"eleves/tickets/messages/create"  => "Peut ajouter un message a un ticket",
		"eleves/tickets/messages/edit"    => "Peut modifier un message d'un ticket",
		"eleves/tickets/messages/destroy" => "Peut supprimer un message d'un ticket",

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

		"scolarites/index" => "Peut afficher le menu gestion de la scolarité",

		"statistiques/index"    => "Peut afficher le menu des statistiques",
		"statistiques/generale" => "Peut afficher les statistiques générales",
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
