<?php

namespace Tests\Feature\Administrations;

use App\Models\Academie;
use App\Models\Region;
use Tests\TestCase;

class RegionsTest extends TestCase
{

	/**
	 * Vérifie que les données présentes sur l'index sont bien celles attendues.
	 */
	public function testAffichageIndexRegions()
	{
		$regions = factory(Region::class, 5)->create();

		$request = $this->get("/administrations/regions");

		$request->assertStatus(200);
		$request->assertSee("Gestion des régions");

		foreach ($regions as $region) {
			$request->assertSee($region->nom);
		}
	}


	/**
	 * Vérifie que le formulaire de création contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireCreationRegion()
	{
		$request = $this->get("/administrations/regions/create");

		$request->assertStatus(200);
		$request->assertSee("Création d'une région");
		$request->assertSee("Nom");
		$request->assertSee("Créer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
	 * de création incomplet
	 */
	public function testTraitementFormulaireCreationRegionIncomplet()
	{
		$request = $this->post("/administrations/regions", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
	 * d'une région déjà existante
	 */
	public function testTraitementFormulaireCreationRegionExistante()
	{
		$regions = factory(Region::class, 5)->create();

		$request = $this->post("/administrations/regions", [
			"_token" => csrf_token(),
			"nom"    => $regions->random()->nom,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et qu'une région à bien été créée lors de la soumissions d'un
	 * formulaire de création complet
	 */
	public function testTraitementFormulaireCreationRegionComplet()
	{
		$request = $this->post("/administrations/regions", [
			"_token" => csrf_token(),
			"nom"    => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("regions", ["nom" => "unit.testing"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "region/created",
            "contenue" => "La région unit.testing à été créée par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

    /**
     * Vérifie que les données présentes sur le profil sont bien celles attendues
     */
    public function testAffichageProfilRegion()
    {
        $region = factory(Region::class)->create();
        $academies = factory(Academie::class, 2)->create([
            "region_id" => $region->id
        ]);

        $request = $this->get("/administrations/regions/{$region->id}");

        $request->assertStatus(200);
        $request->assertSee("Profil de la région \"{$region->nom}\"");

        $request->assertSee("Académies");
        $request->assertSee("Action");
        foreach ($academies as $academy)
        {
            $request->assertSee($academy->nom);
            $request->assertSee("Détails");
        }
    }


	/**
	 * Vérifie que le formulaire d'édition contient bien les champs nécessaires
	 */
	public function testAffichageFormulaireEditionRegion()
	{
		$region = factory(Region::class)->create();

		$request = $this->get("/administrations/regions/{$region->id}/edit");

		$request->assertStatus(200);
		$request->assertSee("Édition de {$region->nom}");
		$request->assertSee("Nom");
		$request->assertSee("Éditer");
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
	 */
	public function testTraitementFormulaireEditionRegionIncomplet()
	{
		$region = factory(Region::class)->create();

		$request = $this->put("/administrations/regions/{$region->id}", [
			"_token" => csrf_token(),
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
	}

	/**
	 * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
	 * d'une région déjà existante
	 */
	public function testTraitementFormulaireEditionRegionExistante()
	{
		$regions = factory(Region::class, 2)->create();

		$request = $this->put("/administrations/regions/{$regions[0]->id}", [
			"_token" => csrf_token(),
			"nom"    => $regions[1]->nom,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasErrors();
		$this->assertDatabaseHas("regions", ["nom" => $regions[0]->nom]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "region/modified",
            "contenue" => "La région {$regions[1]->nom} à été modifiée par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que la région à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet sans modification
	 */
	public function testTraitementFormulaireEditionRegionCompletSansModification()
	{
		$region = factory(Region::class)->create();

		$request = $this->put("/administrations/regions/{$region->id}", [
			"_token" => csrf_token(),
			"nom"    => $region->nom,
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("regions", ["nom" => $region->nom]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "region/modified",
            "contenue" => "La région {$region->nom} à été modifiée par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

	/**
	 * Vérifie qu'aucune erreur n'est présente et que la région à bien été éditée lors de la soumission
	 * d'un formulaire d'édition complet avec modification
	 */
	public function testTraitementFormulaireEditionRegionCompletAvecModification()
	{
		$region = factory(Region::class)->create();

		$request = $this->put("/administrations/regions/{$region->id}", [
			"_token" => csrf_token(),
			"nom"    => "unit.testing",
		]);

		$request->assertStatus(302);
		$request->assertSessionHasNoErrors();
		$this->assertDatabaseHas("regions", ["nom" => "unit.testing"]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "region/modified",
            "contenue" => "La région unit.testing à été modifiée par {$this->user->nom} {$this->user->prenom}"
        ]);
	}

    /**
     * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
     */
    public function testAffichageAlerteSuppressionRegion()
    {
        $region = factory(Region::class)->create();

        $request = $this->get("/administrations/regions/{$region->id}/edit");

        $request->assertStatus(200);
        $request->assertSee("Supprimer");
        $request->assertSee("Vous êtes sur le point de supprimer <b>" . $region->nom . "</b>.");
    }

    /**
     * Vérifie que des erreurs sont présentes et que le service n'est pas supprimé s'il est associé à des académies
     */
    public function testTraitementSuppressionRegionAssocie()
    {
        $region = factory(Region::class)->create();
        $academie = factory(Academie::class)->create([
            "region_id" => $region->id,
        ]);

        $request = $this->delete("/administrations/regions/{$region->id}");

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
        $this->assertDatabaseHas("regions", ["nom" => $region->nom]);
        $this->assertDatabaseMissing("historiques", [
            "from_id" => $this->user->id,
            "type" => "region/deleted",
            "contenue" => "La région {$region->nom} à été supprimée par {$this->user->nom} {$this->user->prenom}"
        ]);
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et que le service à bien été supprimé s'il n'est associé à aucune
     * académie
     */
    public function testTraitementSuppressionRegionNonAssocie()
    {
        $region = factory(Region::class)->create();

        $request = $this->delete("/administrations/regions/{$region->id}");

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseMissing("regions", ["nom" => $region->nom]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "region/deleted",
            "contenue" => "La région {$region->nom} à été supprimée par {$this->user->nom} {$this->user->prenom}"
        ]);
    }
}
