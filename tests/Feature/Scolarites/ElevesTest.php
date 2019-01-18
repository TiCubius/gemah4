<?php

namespace Tests\Feature;

use App\Models\Departement;
use App\Models\Eleve;
use App\Models\Materiel;
use App\Models\Responsable;
use App\Models\TypeEleve;
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
		$request->assertSee("Type");

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
		$type = factory(TypeEleve::class)->create();

		$request = $this->post("/scolarites/eleves", [
			"_token"         => csrf_token(),
			"nom"            => $eleve->nom,
			"prenom"         => $eleve->prenom,
			"date_naissance" => $eleve->date_naissance,
			"classe"         => $eleve->classe,
			"departement_id" => $eleve->departement_id,
			"code_ine"       => $eleve->code_ine,
			"types"          => [$type->id],
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	public function testTraitementFormulaireCreationEleveCompletSansINE()
	{
		$departement = factory(Departement::class)->create();
		$type = factory(TypeEleve::class)->create();

		$request = $this->post("/scolarites/eleves", [
			"_token"         => csrf_token(),
			"nom"            => "unit.testing",
			"prenom"         => "unit.testing",
			"date_naissance" => Carbon::now(),
			"classe"         => "unit.testing",
			"departement_id" => $departement->id,
			"code_ine"       => "",
			"types"          => [$type->id],
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("eleves", [
			"nom"    => "unit.testing",
			"prenom" => "unit.testing",
		]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'un Eleve à bien été créée lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationEleveCompletAvecCodeINE()
	{
		$departement = factory(Departement::class)->create();
		$type = factory(TypeEleve::class)->create();

		$request = $this->post("/scolarites/eleves", [
			"_token"         => csrf_token(),
			"nom"            => "unit.testing",
			"prenom"         => "unit.testing",
			"date_naissance" => Carbon::now(),
			"classe"         => "unit.testing",
			"departement_id" => $departement->id,
			"code_ine"       => "unit.testin",
			"types"          => [$type->id],
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("eleves", ["code_ine" => "unit.testin"]);
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
		$type = factory(TypeEleve::class)->create();

		$request = $this->put("/scolarites/eleves/{$eleves[0]->id}", [
			"_token"         => csrf_token(),
			"nom"            => $eleves[1]->nom,
			"prenom"         => $eleves[1]->prenom,
			"date_naissance" => $eleves[1]->date_naissance,
			"classe"         => $eleves[1]->classe,
			"departement_id" => $eleves[1]->departement_id,
			"code_ine"       => $eleves[1]->code_ine,
			"types"          => [$type->id],
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
		$type = factory(TypeEleve::class)->create();

		$request = $this->put("/scolarites/eleves/{$eleve->id}", [
			"_token"         => csrf_token(),
			"nom"            => $eleve->nom,
			"prenom"         => $eleve->prenom,
			"date_naissance" => $eleve->date_naissance,
			"classe"         => $eleve->classe,
			"departement_id" => $eleve->departement_id,
			"code_ine"       => $eleve->code_ine,
			"types"          => [$type->id],
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("eleves", [
			"nom"      => $eleve->nom,
			"prenom"   => $eleve->prenom,
			"code_ine" => $eleve->code_ine,
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
		$type = factory(TypeEleve::class)->create();

		$request = $this->put("/scolarites/eleves/{$eleve->id}", [
			"_token"         => csrf_token(),
			"nom"            => "unit.testing",
			"prenom"         => "unit.testing",
			"date_naissance" => Carbon::now(),
			"classe"         => "unit.testing",
			"departement_id" => $departement->id,
			"code_ine"       => "unit.testin",
			"types"          => [$type->id],
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("eleves", ["code_ine" => "unit.testin"]);
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
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("eleves", ["id" => $eleve->id]);
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
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("eleves", ["id" => $eleve->id]);
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
	}
}
