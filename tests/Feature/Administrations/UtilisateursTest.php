<?php

namespace Tests\Feature\Administrations;

use App\Models\Historique;
use App\Models\Service;
use App\Models\Utilisateur;
use Tests\TestCase;

class UtilisateursTest extends TestCase
{

    /**
     * Vérifie que les données présentes sur l'index sont bien celles attendues.
     */
    public function testAffichageIndexUtilisateurs()
    {
        $service = factory(Service::class)->create();
        $utilisateurs = factory(Utilisateur::class, 5)->create();

        $request = $this->get("/administrations/utilisateurs");

        $request->assertStatus(200);
        $request->assertSee("Gestion des utilisateurs");

        foreach ($utilisateurs as $utilisateur) {
            $request->assertSee($utilisateur->nom);
            $request->assertSee($utilisateur->prenom);
            $request->assertSee($utilisateur->service->nom);
        }
    }


    /**
     * Vérifie que le formulaire de création contient bien les champs nécessaires
     */
    public function testAffichageFormulaireCreationUtilisateur()
    {
        $request = $this->get("/administrations/utilisateurs/create");

        $request->assertStatus(200);
        $request->assertSee("Création d'un utilisateur");
        $request->assertSee("Nom");
        $request->assertSee("Prénom");
        $request->assertSee("Identifiant");
        $request->assertSee("Adresse");
        $request->assertSee("Mot de passe");
        $request->assertSee("Confirmation du mot de passe");
        $request->assertSee("Département");
        $request->assertSee("Service");
        $request->assertSee("Créer");
    }

    /**
     * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
     * de création incomplet
     */
    public function testTraitementFormulaireCreationUtilisateurIncomplet()
    {
        $request = $this->post("/administrations/utilisateurs", [
            "_token" => csrf_token(),
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
    }

    /**
     * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire de création
     * d'un utilisateur déjà existant
     */
    public function testTraitementFormulaireCreationUtilisateurExistant()
    {
        $service = factory(Service::class)->create();
        $utilisateurs = factory(Utilisateur::class, 5)->create();

        $request = $this->post("/administrations/utilisateurs", [
            "_token" => csrf_token(),
            "nom" => $utilisateurs->random()->nom,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et qu'un utilisateur à bien été créé lors de la soumissions d'un
     * formulaire de création complet
     */
    public function testTraitementFormulaireCreationUtilisateurComplet()
    {
        $service = factory(Service::class)->create();

        $request = $this->post("/administrations/utilisateurs", [
            "_token" => csrf_token(),
            "nom" => "unit.testing",
            "prenom" => "unit.testing",
            "identifiant" => "unit.testing",
            "email" => "unit@testing.fr",
            "password" => "unit.testing",
            "password_confirmation" => "unit.testing",
            "service_id" => $service->id,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("utilisateurs", ["nom" => "unit.testing"]);
    }

    /**
     * Vérifie que les données présentes sur le profil sont bien celles attendues
     */
    public function testAffichageProfilUtilisateur()
    {
        $utilisateur = factory(Utilisateur::class)->create();
        $historique = Historique::create([
            "from_id" => $utilisateur->id,
            "type" => "unit.testing",
            "contenue" => "unit.testing"
        ]);

        $request = $this->get("/administrations/utilisateurs/{$utilisateur->id}");

        $request->assertStatus(200);
        $request->assertSee("Profil de l'utilisateur \"{$utilisateur->nom} {$utilisateur->prenom}\"");

        $request->assertSee("Historique");
        $request->assertSee("Action");
        $request->assertSee($historique->type);
        $request->assertSee($historique->contenue);
        $request->assertSee("Détails");

    }


    /**
     * Vérifie que le formulaire d'édition contient bien les champs nécessaires
     */
    public function testAffichageFormulaireEditionUtilisateur()
    {
        $service = factory(Service::class)->create();
        $utilisateur = factory(Utilisateur::class)->create();

        $request = $this->get("/administrations/utilisateurs/{$utilisateur->id}/edit");

        $request->assertStatus(200);
        $request->assertSee("Édition de {$utilisateur->nom}");
        $request->assertSee("Nom");
        $request->assertSee("Prénom");
        $request->assertSee("Identifiant");
        $request->assertSee("Adresse E-Mail");
        $request->assertSee("Département");
        $request->assertSee("Service");
        $request->assertSee("Éditer");
        $request->assertSee("Supprimer");
    }

    /**
     * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
     */
    public function testTraitementFormulaireEditionUtilisateurIncomplet()
    {
        $service = factory(Service::class)->create();
        $utilisateur = factory(Utilisateur::class)->create();

        $request = $this->put("/administrations/utilisateurs/{$utilisateur->id}", [
            "_token" => csrf_token(),
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
    }

    /**
     * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition
     * d'un utilisateur déjà existant
     */
    public function testTraitementFormulaireEditionUtilisateurExistant()
    {
        $service = factory(Service::class)->create();
        $utilisateurs = factory(Utilisateur::class, 2)->create();

        $request = $this->put("/administrations/utilisateurs/{$utilisateurs[0]->id}", [
            "_token" => csrf_token(),
            "nom" => "unit.testing",
            "prenom" => "unit.testing",
            "identifiant" => "unit.testing",
            "email" => $utilisateurs[1]->email,
            "service_id" => $service->id,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
        $this->assertDatabaseHas("utilisateurs", ["nom" => $utilisateurs[0]->nom]);
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et que l'utilisateur à bien été édité lors de la soumission
     * d'un formulaire d'édition complet sans modification
     */
    public function testTraitementFormulaireEditionUtilisateurCompletSansModification()
    {
        $utilisateur = factory(Utilisateur::class)->create();

        $request = $this->put("/administrations/utilisateurs/{$utilisateur->id}", [
            "_token" => csrf_token(),
            "nom" => $utilisateur->nom,
            "prenom" => $utilisateur->prenom,
            "identifiant" => $utilisateur->identifiant,
            "email" => $utilisateur->email,
            "service_id" => $utilisateur->service_id,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("utilisateurs", ["email" => $utilisateur->email]);
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et que l'utilisateur à bien été édité lors de la soumission
     * d'un formulaire d'édition complet avec modification
     */
    public function testTraitementFormulaireEditionUtilisateurCompletAvecModification()
    {
        $service = factory(Service::class)->create();
        $utilisateur = factory(Utilisateur::class)->create();

        $request = $this->put("/administrations/utilisateurs/{$utilisateur->id}", [
            "_token" => csrf_token(),
            "nom" => "unit.testing",
            "prenom" => "unit.testing",
            "identifiant" => "unit.testing",
            "email" => "unit@testing.fr",
            "service_id" => $service->id,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("utilisateurs", ["email" => "unit@testing.fr"]);
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et que l'utilisateur à bien été édité lors de la soumission
     * d'un formulaire d'édition complet avec modification
     */
    public function testTraitementFormulaireModificationMotDePasse()
    {
        $utilisateur = factory(Utilisateur::class)->create();

        $request = $this->put("/administrations/utilisateurs/{$utilisateur->id}", [
            "_token" => csrf_token(),
            "nom" => $utilisateur->nom,
            "prenom" => $utilisateur->prenom,
            "identifiant" => $utilisateur->identifiant,
            "email" => $utilisateur->email,
            "service_id" => $utilisateur->service_id,
            'password' => 'unit.testing',
            'password_confirmation' => 'unit.testing',
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("utilisateurs", ["email" => $utilisateur->email]);
        $this->assertDatabaseMissing("utilisateurs", ["password" => $utilisateur->password]);
    }

    /**
     * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
     */
    public function testAffichageAlerteSuppressionUtilisateur()
    {
        $utilisateur = factory(Utilisateur::class)->create();

        $request = $this->get("/administrations/utilisateurs/{$utilisateur->id}/edit");

        $request->assertStatus(200);
        $request->assertSee("Supprimer");
        $request->assertSee("Vous êtes sur le point de supprimer <b>" . "{$utilisateur->nom} {$utilisateur->prenom}" . "</b>.");
    }


    /**
     * Vérifie qu'aucune erreur n'est présente et que le utilisateur à bien été supprimé
     */
    public function testTraitementSuppressionUtilisateur()
    {
        $utilisateur = factory(Utilisateur::class)->create();

        $request = $this->delete("/administrations/utilisateurs/{$utilisateur->id}");

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseMissing("utilisateurs", [
            "nom" => $utilisateur->nom,
            "prenom" => $utilisateur->prenom,
        ]);
        $this->assertDatabaseHas("historiques", [
            "from_id" => $this->user->id,
            "type" => "utilisateur/deleted",
            "information" => "L'utilisateur {$utilisateur->nom} {$utilisateur->prenom} à été supprimé par {$this->user->nom} {$this->user->prenom}"
        ]);
    }


}
