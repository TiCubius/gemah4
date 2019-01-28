<?php

namespace Tests\Feature\Materiels;

use App\Models\DomaineMateriel;
use App\Models\TypeMateriel;
use Tests\TestCase;

class TypesMaterielTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexTypes()
	{
		$domaines = factory(DomaineMateriel::class, 5)->create();
		$types = factory(TypeMateriel::class, 5)->create([
			"domaine_id" => $domaines->random()->id,
		]);

		$request = $this->get("/materiels/types");

		$request->assertStatus(200);
		$request->assertSee("Gestion des types matériel");

		foreach ($types as $type) {
			$request->assertSee($type->libelle);
			$request->assertSee($type->domaine->libelle);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationType()
	{
		$domaine = factory(DomaineMateriel::class)->create();
		$request = $this->get("/materiels/types/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'un type matériel");
		$request->assertSee("Libellé");
		$request->assertSee("Domaine");
		$request->assertSee("Créer le type");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationTypeIncomplet()
	{
		$request = $this->post("/materiels/types", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
	 * d'un Type déjà existant
	 */
	public function testTraitementFormulaireCreationTypeExistant()
	{
		$domaine = factory(DomaineMateriel::class, 5)->create();
		$types = factory(TypeMateriel::class, 5)->create([
			"domaine_id" => $domaine->random()->id,
		]);

		$request = $this->post("/materiels/types", [
			"_token"  => csrf_token(),
			"libelle" => $types->random()->libelle,
			"domaine" => $domaine->random()->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'un Type à bien été créée lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationTypeComplet()
	{
		$domaine = factory(DomaineMateriel::class)->create();
		$request = $this->post("/materiels/types", [
			"_token"  => csrf_token(),
			"libelle" => "unit.testing",
			"domaine" => $domaine->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_materiels", ["libelle" => "unit.testing"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "type/materiel/created",
            "contenue" => "Le type de matériel unit.testing à été créé par {$this->user->nom} {$this->user->prenom}"
        ]);
	}


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionType()
	{
		$domaine = factory(DomaineMateriel::class)->create();
		$type = factory(TypeMateriel::class)->create();

		$request = $this->get("/materiels/types/{$type->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$type->libelle}");
		$request->assertSee("Libellé");
		$request->assertSee("Domaine");
		$request->assertSee("Éditer");
		$request->assertSee("Supprimer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionTypeIncomplet()
	{
		$domaine = factory(DomaineMateriel::class)->create();
		$type = factory(TypeMateriel::class)->create();

		$request = $this->put("/materiels/types/{$type->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'un Type déjà existante
	 */
	public function testTraitementFormulaireEditionTypeExistant()
	{
		$domaine = factory(DomaineMateriel::class)->create();
		$types = factory(TypeMateriel::class, 2)->create();

		$request = $this->put("/materiels/types/{$types[0]->id}", [
			"_token"  => csrf_token(),
			"libelle" => $types[1]->libelle,
			"domaine" => $domaine->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("types_materiels", ["libelle" => $types[0]->libelle]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "type/materiel/modified",
            "contenue" => "Le type de matériel {$types[1]->libelle} à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le Type à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionTypeCompletSansModification()
	{
		$domaine = factory(DomaineMateriel::class)->create();
		$type = factory(TypeMateriel::class)->create();

		$request = $this->put("/materiels/types/{$type->id}", [
			"_token"  => csrf_token(),
			"libelle" => $type->libelle,
			"domaine" => $type->domaine_id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_materiels", ["libelle" => $type->libelle]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "type/materiel/modified",
            "contenue" => "Le type de matériel {$type->libelle} à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le Type à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet
	 */
	public function testTraitementFormulaireEditionTypeCompletAvecModification()
	{
		$type = factory(TypeMateriel::class)->create();
		$domaine = factory(DomaineMateriel::class)->create();

		$request = $this->put("/materiels/types/{$type->id}", [
			"_token"  => csrf_token(),
			"libelle" => "unit.testing",
			"domaine" => $domaine->id,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("types_materiels", ["libelle" => "unit.testing"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "type/materiel/modified",
            "contenue" => "Le type de matériel unit.testing à été modifié par {$this->user->nom} {$this->user->prenom}"
        ]);
	}


	/**
	 * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
	 */
	public function testAffichageAlerteSuppressionType()
	{
		$domaine = factory(DomaineMateriel::class)->create();
		$type = factory(TypeMateriel::class)->create();

		$request = $this->get("/materiels/types/{$type->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Supprimer");
		$request->assertSee("Vous êtes sur le point de supprimer <b>" . $type->libelle . "</b>.");
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que le Type à bien été supprimé s'il n'est associé à aucun
	 * utilisateur
	 */
	public function testTraitementSuppressionType()
	{
		$domaine = factory(DomaineMateriel::class)->create();
		$type = factory(TypeMateriel::class)->create();

		$request = $this->delete("/materiels/types/{$type->id}");

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseMissing("types_materiels", ["libelle" => $type->libelle]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "type/materiel/deleted",
            "contenue" => "Le type de matériel {$type->libelle} à été supprimé par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

}
