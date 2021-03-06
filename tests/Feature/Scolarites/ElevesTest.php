<?php

namespace Tests\Feature\Scolarites;

use App\Models\Departement;
use App\Models\Eleve;
use App\Models\Materiel;
use App\Models\Responsable;
use App\Models\Service;
use App\Models\TypeDecision;
use App\Models\Utilisateur;
use Carbon\Carbon;
use Tests\TestCase;

class ElevesTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexEleves()
	{
		$eleves = factory(Eleve::class, 5)->create();

		$request = $this->get("/scolarites/eleves");

		$request->assertStatus(200);
		$request->assertSee("Gestion des élèves");

		foreach ($eleves as $eleve) {
			$request->assertSee($eleve->nom);
			$request->assertSee($eleve->prenom);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationEleve()
	{
		$request = $this->get("/scolarites/eleves/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'un élève");

		$request->assertSee("Nom");
		$request->assertSee("Prénom");
		$request->assertSee("Date de naissance");
		$request->assertSee("Classe");
		$request->assertSee("Département");
		$request->assertSee("Code INE");

		$request->assertSee("Créer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationEleveIncomplet()
	{
		$request = $this->post("/scolarites/eleves", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
	 * d'un Eleve déjà existante
	 */
	public function testTraitementFormulaireCreationEleveExistant()
	{
		$eleve = factory(Eleve::class)->create();

		$request = $this->post("/scolarites/eleves", [
			"_token"         => csrf_token(),
			"nom"            => $eleve->nom,
			"prenom"         => $eleve->prenom,
			"date_naissance" => $eleve->date_naissance,
			"classe"         => $eleve->classe,
			"departement_id" => $eleve->departement_id,
			"code_ine"       => $eleve->code_ine,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	public function testTraitementFormulaireCreationEleveCompletSansINE()
	{
		$departement = factory(Departement::class)->create();

		$request = $this->post("/scolarites/eleves", [
			"_token"         => csrf_token(),
			"nom"            => "unit.testing",
			"prenom"         => "unit.testing",
			"date_naissance" => Carbon::now(),
			"classe"         => "unit.testing",
			"departement_id" => $departement->id,
			"code_ine"       => "",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("eleves", [
			"nom"    => "unit.testing",
			"prenom" => "unit.testing",
		]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "eleve/created",
            "information" => "L'élève unit.testing unit.testing à été créé par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'un Eleve à bien été créée lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationEleveCompletAvecCodeINE()
	{
		$departement = factory(Departement::class)->create();

		$request = $this->post("/scolarites/eleves", [
			"_token"         => csrf_token(),
			"nom"            => "unit.testing",
			"prenom"         => "unit.testing",
			"date_naissance" => Carbon::now(),
			"classe"         => "unit.testing",
			"departement_id" => $departement->id,
			"code_ine"       => "unit.testin",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("eleves", ["code_ine" => "unit.testin"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "eleve/created",
            "information" => "L'élève unit.testing unit.testing à été créé par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie l'envoi d'E-Mail [MANUEL]
	 */
	public function testEmail()
	{
		$departement = factory(Departement::class)->create();
		$service = factory(Service::class)->create(["departement_id" => $departement->id]);
		factory(Utilisateur::class)->create(["service_id" => $service->id]);

		$request = $this->post("/scolarites/eleves", [
			"_token"         => csrf_token(),
			"nom"            => "unit.testing",
			"prenom"         => "unit.testing",
			"date_naissance" => Carbon::now(),
			"classe"         => "unit.testing",
			"departement_id" => $departement->id,
			"code_ine"       => "unit.testin",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "eleve/created",
            "information" => "L'élève unit.testing unit.testing à été créé par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	public function testAffichageProfilEleve()
	{
		$eleve = factory(Eleve::class)->create();

		$request = $this->get("/scolarites/eleves/{$eleve->id}");

		$request->assertStatus(200);
		$request->assertSee("Profil élève de {$eleve->nom} {$eleve->prenom}");
		$request->assertSee("Nom");
		$request->assertSee("Prénom");
		$request->assertSee("Date de naissance");
		$request->assertSee("Joker");
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionEleve()
	{
		$eleve = factory(Eleve::class)->create();

		$request = $this->get("/scolarites/eleves/{$eleve->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$eleve->nom} {$eleve->prenom}");

		$request->assertSee("Nom");
		$request->assertSee("Prénom");
		$request->assertSee("Date de naissance");
		$request->assertSee("Classe");
		$request->assertSee("Département");
		$request->assertSee("Code INE");

		$request->assertSee("Éditer");
		$request->assertSee("Supprimer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionEleveIncomplet()
	{
		$eleve = factory(Eleve::class)->create();

		$request = $this->put("/scolarites/eleves/{$eleve->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'un Eleve déjà existante
	 */
	public function testTraitementFormulaireEditionEleveExistant()
	{
		$eleves = factory(Eleve::class, 2)->create();

		$request = $this->put("/scolarites/eleves/{$eleves[0]->id}", [
			"_token"         => csrf_token(),
			"nom"            => $eleves[1]->nom,
			"prenom"         => $eleves[1]->prenom,
			"date_naissance" => $eleves[1]->date_naissance,
			"classe"         => $eleves[1]->classe,
			"departement_id" => $eleves[1]->departement_id,
			"code_ine"       => $eleves[1]->code_ine,
		]);


		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("eleves", [
			"nom"      => $eleves[0]->nom,
			"prenom"   => $eleves[0]->prenom,
			"code_ine" => $eleves[0]->code_ine,
		]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'éleve à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionEleveCompletSansModification()
	{
		$eleve = factory(Eleve::class)->create();

		$request = $this->put("/scolarites/eleves/{$eleve->id}", [
			"_token"         => csrf_token(),
			"nom"            => $eleve->nom,
			"prenom"         => $eleve->prenom,
			"date_naissance" => $eleve->date_naissance,
			"classe"         => $eleve->classe,
			"departement_id" => $eleve->departement_id,
			"code_ine"       => $eleve->code_ine,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("eleves", [
			"nom"      => $eleve->nom,
			"prenom"   => $eleve->prenom,
			"code_ine" => $eleve->code_ine,
		]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "eleve/modified",
            "information" => "L'élève {$eleve->nom} {$eleve->prenom} à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'éleve à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionEleveCompletAvecModification()
	{
		$eleve = factory(Eleve::class)->create();
		$departement = factory(Departement::class)->create();

		$request = $this->put("/scolarites/eleves/{$eleve->id}", [
			"_token"         => csrf_token(),
			"nom"            => "unit.testing",
			"prenom"         => "unit.testing",
			"date_naissance" => Carbon::now(),
			"classe"         => "unit.testing",
			"departement_id" => $departement->id,
			"code_ine"       => "unit.testin",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("eleves", ["code_ine" => "unit.testin"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "eleve/modified",
            "information" => "L'élève unit.testing unit.testing à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
	}


	/**
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionEleve()
	{
		$eleve = factory(Eleve::class)->create();

		$request = $this->get("/scolarites/eleves/{$eleve->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer");
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . "{$eleve->nom} {$eleve->prenom}" . "</b>.");
	}


	/**
	 * Vérifie qu'une erreur est présente lors de la suppression d'un élève associé à un
	 * responsable, et que l'éleve n'a pas été supprimé
	 */
	public function testTraitementSuppressionEleveAvecResponsables()
	{
		$eleve = factory(Eleve::class)->create();
		$responsable = factory(Responsable::class)->create();

		$responsable->eleves()->attach($eleve);

		$request = $this->delete("/scolarites/eleves/{$eleve->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("eleves", ["id" => $eleve->id]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "eleve/deleted",
            "information" => "L'élève {$eleve->nom} {$eleve->prenom} à été supprimé par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie qu'une erreur est présente lors de la suppression d'un élève associé à un
	 * matériel, et que l'éleve n'a pas été supprimé
	 */
	public function testTraitementSuppressionEleveAvecMateriels()
	{
		$eleve = factory(Eleve::class)->create();
		$materiel = factory(Materiel::class)->create([
			"eleve_id" => $eleve->id,
		]);

		$request = $this->delete("/scolarites/eleves/{$eleve->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("eleves", ["id" => $eleve->id]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "eleve/deleted",
            "information" => "L'élève {$eleve->nom} {$eleve->prenom} à été supprimé par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie que la possibilité de suppression du responsbale est bien présente lors de la
	 * suppression d'un élève associé à un responsable affecté a aucun autre eleve
	 */
	public function testAffichageSuppressionEleveAvecResponsablesSansAutresEleve()
	{
		$eleve = factory(Eleve::class)->create();
		$responsable = factory(Responsable::class)->create();
		$responsable->eleves()->attach($eleve);


		$request = $this->get("/scolarites/eleves/{$eleve->id}/edit");

		$request->assertStatus(200);

		$request->assertSee("{$responsable->nom} {$responsable->prenom} ne sera affecté a aucun élève après cette suppression");
		$request->assertSee("Supprimer {$responsable->nom} {$responsable->prenom }");
	}

	/**
	 * Vérifie qu'une erreur est présente lors de la suppression d'un élève associé à un
	 * responsable, et que l'éleve n'a pas été supprimé
	 */
	public function testTraitementSuppressionEleveAvecResponsablesSansAutresEleve()
	{
		$eleve = factory(Eleve::class)->create();
		$responsable = factory(Responsable::class)->create();
		$responsable->eleves()->attach($eleve);

		$request = $this->delete("/scolarites/eleves/{$eleve->id}",[
			"delete-responsables"=>[$responsable->id]
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("eleves", ["id" => $eleve->id]);
		$this->assertDatabaseHas("historiques", [
			"from_id" => $this->user->id,
			"type" => "eleve/deleted",
			"information" => "L'élève {$eleve->nom} {$eleve->prenom} à été supprimé par {$this->user->nom} {$this->user->prenom}"
		]);
		$this->assertDatabaseMissing("responsables", ["id" => $responsable->id]);
		$this->assertDatabaseHas("historiques", [
			"from_id" => $this->user->id,
			"type" => "responsable/deleted",
			"information" => "Le responsable {$responsable->nom} {$responsable->prenom} à été supprimé par {$this->user->nom} {$this->user->prenom}"
		]);


	}
	/**
	 * Vérifie qu'aucune erreur n'est présente et que l'éleve à bien été supprimé
	 */
	public function testTraitementSuppressionEleve()
	{
		$eleve = factory(Eleve::class)->create();

		$request = $this->delete("/scolarites/eleves/{$eleve->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("eleves", ["id" => $eleve->id]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "eleve/deleted",
            "information" => "L'élève {$eleve->nom} {$eleve->prenom} à été supprimé par {$this->user->nom} {$this->user->prenom}"
        ]);
	}
}
