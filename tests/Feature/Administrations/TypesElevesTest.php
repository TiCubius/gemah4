<?php

namespace Tests\Feature;

use App\Models\Departement;
use App\Models\Eleve;
use App\Models\Service;
use App\Models\TypeEleve;
use App\Models\Utilisateur;
use phpDocumentor\Reflection\Type;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeEleveTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexTypesEleves()
	{
		$types = factory(TypeEleve::class, 3)->create();

		$request = $this->get("/administrations/eleves/types");

		$request->assertStatus(200);
		$request->assertSee("Gestion des types d'élèves");

		foreach ($types as $type) {
			$request->assertSee($type->nom);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationType()
	{
		$request = $this->get("/administrations/eleves/types/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'un type d'élève");
		$request->assertSee("Nom");
		$request->assertSee("Créer le type d'élève");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationTypeIncomplet()
	{
		$request = $this->post("/administrations/eleves/types", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
	 * d'un Service déjà existant
	 */
	public function testTraitementFormulaireCreationTypeExistant()
	{
		$type = factory(TypeEleve::class, 5)->create();

		$request = $this->post("/administrations/eleves/types", [
			"_token" => csrf_token(),
			"nom"    => $type->random()->nom,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'un Service à bien été créée lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationTypeComplet()
	{
		$request = $this->post("/administrations/eleves/types", [
			"_token"      => csrf_token(),
			"nom"         => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_eleves", ["nom" => "unit.testing"]);
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionType()
	{
		$type = factory(TypeEleve::class)->create();

		$request = $this->get("/administrations/eleves/types/{$type->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$type->nom}");
		$request->assertSee("Nom");
		$request->assertSee("Éditer");
		$request->assertSee("Supprimer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionTypeIncomplet()
	{
		$type = factory(TypeEleve::class)->create();

		$request = $this->put("/administrations/eleves/types/{$type->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'un Service déjà existant
	 */
	public function testTraitementFormulaireEditionTypeExistant()
	{
		$type = factory(TypeEleve::class, 2)->create();

		$request = $this->put("/administrations/eleves/types/{$type[0]->id}", [
			"_token"      => csrf_token(),
			"nom"         => $type[1]->nom,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("types_eleves", ["nom" => $type[0]->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le Service à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionServiceTypeSansModification()
	{
		$type = factory(TypeEleve::class)->create();

		$request = $this->put("/administrations/eleves/types/{$type->id}", [
			"_token"      => csrf_token(),
			"nom"         => $type->nom,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_eleves", ["nom" => $type->nom]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le Service à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionTypeCompletAvecModification()
	{
	    $type = factory(TypeEleve::class)->create();

		$request = $this->put("/administrations/eleves/types/{$type->id}", [
			"_token"      => csrf_token(),
			"nom"         => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_eleves", ["nom" => "unit.testing"]);
	}


	/**
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionType()
	{
		$type = factory(TypeEleve::class)->create();

		$request = $this->get("/administrations/eleves/types/{$type->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer ".$type->nom);
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . $type->nom . "</b>.");
	}

    /**
     * Vérifie qu'aucune erreur n'est présente et que le Service à bien été supprimé s'il n'est associé à aucun
     * utilisateur
     */
    public function testTraitementSuppressionTypeAssocie()
    {
        $type = factory(TypeEleve::class)->create();
        $eleve = factory(Eleve::class)->create();
        $eleve->types()->attach($type);

        $request = $this->delete("/administrations/eleves/types/{$type->id}");

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
        $this->assertDatabaseHas("types_eleves", ["nom" => $type->nom]);
    }
    /**
     * Vérifie qu'aucune erreur n'est présente et que le Service à bien été supprimé s'il n'est associé à aucun
     * utilisateur
     */
    public function testTraitementSuppressionTypeNonAssocie()
    {
        $type = factory(TypeEleve::class)->create();

        $request = $this->delete("/administrations/eleves/types/{$type->id}");

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseMissing("types_eleves", ["nom" => $type->nom]);
    }

}
