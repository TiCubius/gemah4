<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\TypeDocument;
use Tests\TestCase;

class TypesDocumentsTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexTypesEleves()
	{
		$types = factory(TypeDocument::class, 3)->create();

		$request = $this->get("/administrations/types/documents");

		$request->assertStatus(200);
		$request->assertSee("Gestion des types de document");

		foreach ($types as $type) {
			$request->assertSee($type->libelle);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationType()
	{
		$request = $this->get("/administrations/types/documents/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'un type de document");
		$request->assertSee("Libellé");
		$request->assertSee("Créer le type de document");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationTypeIncomplet()
	{
		$request = $this->post("/administrations/types/documents", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
	 * d'un type d'élève déjà existant
	 */
	public function testTraitementFormulaireCreationTypeExistant()
	{
		$type = factory(TypeDocument::class, 5)->create();

		$request = $this->post("/administrations/types/documents", [
			"_token"  => csrf_token(),
			"libelle" => $type->random()->libelle,
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
		$request = $this->post("/administrations/types/documents", [
			"_token"  => csrf_token(),
			"libelle" => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_documents", ["libelle" => "unit.testing"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "type/document/created",
            "contenue" => "Le type de document unit.testing à été créé par {$this->user->nom} {$this->user->prenom}"
        ]);
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionType()
	{
		$type = factory(TypeDocument::class)->create();

		$request = $this->get("/administrations/types/documents/{$type->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$type->libelle}");
		$request->assertSee("Libellé");
		$request->assertSee("Éditer");
		$request->assertSee("Supprimer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionTypeIncomplet()
	{
		$type = factory(TypeDocument::class)->create();

		$request = $this->put("/administrations/types/documents/{$type->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'un type d'élève déjà existant
	 */
	public function testTraitementFormulaireEditionTypeExistant()
	{
		$type = factory(TypeDocument::class, 2)->create();

		$request = $this->put("/administrations/types/documents/{$type[0]->id}", [
			"_token"  => csrf_token(),
			"libelle" => $type[1]->libelle,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("types_documents", ["libelle" => $type[0]->libelle]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "type/document/modified",
            "contenue" => "Le type de document {$type[1]->libelle} à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le type d'élève à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet sans modification
	 */
	public function testTraitementFormulaireEditionServiceTypeSansModification()
	{
		$type = factory(TypeDocument::class)->create();

		$request = $this->put("/administrations/types/documents/{$type->id}", [
			"_token"  => csrf_token(),
			"libelle" => $type->libelle,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_documents", ["libelle" => $type->libelle]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "type/document/modified",
            "contenue" => "Le type de document {$type->libelle} à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le type d'élève à bien été édité lors de la soumission
	 * d'un formulaire d'édition complet avec modification
	 */
	public function testTraitementFormulaireEditionTypeCompletAvecModification()
	{
		$type = factory(TypeDocument::class)->create();

		$request = $this->put("/administrations/types/documents/{$type->id}", [
			"_token"  => csrf_token(),
			"libelle" => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_documents", ["libelle" => "unit.testing"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "type/document/modified",
            "contenue" => "Le type de document unit.testing à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
	}


	/**
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionType()
	{
		$type = factory(TypeDocument::class)->create();

		$request = $this->get("/administrations/types/documents/{$type->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer " . $type->libelle);
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . $type->libelle . "</b>.");
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le type d'élève à bien été supprimé s'il n'est associé à aucun
	 * utilisateur
	 */
	public function testTraitementSuppressionTypeAssocie()
	{
		$type = factory(TypeDocument::class)->create();
		$document = factory(Document::class)->create();
		$document->typeDocument()->associate($type);
		$document->save();

		$request = $this->delete("/administrations/types/documents/{$type->id}");

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("types_documents", ["libelle" => $type->libelle]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le type d'élève à bien été supprimé s'il n'est associé à aucun
	 * utilisateur
	 */
	public function testTraitementSuppressionTypeNonAssocie()
	{
		$type = factory(TypeDocument::class)->create();

		$request = $this->delete("/administrations/types/documents/{$type->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("types_documents", ["libelle" => $type->libelle]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "type/document/deleted",
            "contenue" => "Le type de document {$type->libelle} à été supprimé par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

}
