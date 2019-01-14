<?php

namespace Tests\Feature;

use App\Models\Decision;
use App\Models\Document;
use App\Models\Eleve;
use App\Models\Etablissement;
use App\Models\TypeDocument;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;


class DecisionsTest extends TestCase
{

    /**
     * Vérifie que les données présentes sur l'index sont bien celles attendues.
     */
    public function testAffichageIndexDecision()
    {
        $eleve = factory(Eleve::class)->create();
        $decisions = factory(Decision::class, 5)->create([
            "eleve_id" => $eleve->id
        ]);

        $request = $this->get("/scolarites/eleves/{$eleve->id}/documents");

        $request->assertStatus(200);
        $request->assertSee("Gestion des documents");

        foreach ($decisions as $decision) {
            $request->assertSee($decision->date_convention->format('d/m/Y'));
        }
    }

    /**
     * Vérifie que le formulaire de création contient bien les champs nécessaires
     */
    public function testAffichageFormulaireCreationDecision()
    {
        $eleve = factory(Eleve::class)->create();
        $request = $this->get("/scolarites/eleves/{$eleve->id}/documents/decisions/create");

        $request->assertStatus(200);
        $request->assertSee("Nouvelle décision");

        $request->assertSee("Date de la CDA");
        $request->assertSee("Date de réception de la notification");
        $request->assertSee("Date limite de la décision");
        $request->assertSee("Date de la convention");
        $request->assertSee("Numéro du dossier MDPH");
        $request->assertSee("Nom/prénom de l'enseignant référent");
        $request->assertSee("Affaire suivie par");
        $request->assertSee("Fichier");

        $request->assertSee("Ajouter la décision");
    }

    /**
     * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
     * de création incomplet
     */
    public function testTraitementFormulaireCreationDecisionsIncomplete()
    {
        $eleve = factory(Eleve::class)->create();
        $request = $this->post("/scolarites/eleves/{$eleve->id}/documents/decisions", [
            "_token" => csrf_token(),
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et qu'un Eleve à bien été créée lors de la soumissions d'un
     * formulaire de création complet
     */

    public function testTraitementFormulaireCreationDecisionComplete()
    {
        $eleve = factory(Eleve::class)->create();
        factory(TypeDocument::class)->create([
            "nom" => 'Décision'
        ]);

        $request = $this->post("/scolarites/eleves/{$eleve->id}/documents/decisions", [
            "_token" => csrf_token(),
            "enseignant_id" => $eleve->enseignant_id,
            "date_cda" => \Carbon\Carbon::now(),
            "date_notif" => \Carbon\Carbon::now(),
            "date_limite" => \Carbon\Carbon::now(),
            "date_convention" => \Carbon\Carbon::now(),
            "numero_dossier" => "unit.testing",
            "nom_suivi" => "unit.testing",
            "file" => UploadedFile::fake()->create("avatar.jpg"),
        ]);
        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
    }

    /**
     * Vérifie que le formulaire d'édition contient bien les champs nécessaires
     */

    public function testAffichageFormulaireEditionDecision()
    {
        $eleve = factory(Eleve::class)->create();
        $decision = factory(Decision::class)->create();

        $request = $this->get("/scolarites/eleves/{$eleve->id}/documents/decisions/{$decision->id}/edit");

        $request->assertStatus(200);
        $request->assertSee("Édition de {$decision->document->nom}");

        $request->assertSee("Date de la CDA");
        $request->assertSee("Date de réception de la notification");
        $request->assertSee("Date limite de la décision");
        $request->assertSee("Date de la convention");
        $request->assertSee("Numéro du dossier MDPH");
        $request->assertSee("Nom/prénom de l'enseignant référent");
        $request->assertSee("Affaire suivie par");
        $request->assertSee("Fichier");

        $request->assertSee("Modifier la décision");
        $request->assertSee("Supprimer la décision");
    }

    /**
     * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
     */
    public function testTraitementFormulaireEditionDecisionIncomplet()
    {
        $eleve = factory(Eleve::class)->create();
        $decision = factory(Decision::class)->create();


        $request = $this->patch("/scolarites/eleves/{$eleve->id}/documents/decisions/{$decision->id}", [
            "_token" => csrf_token(),
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et que la décision à bien été édité lors de la soumission
     * d'un formulaire d'édition complet
     */
    public function testTraitementFormulaireEditionDecisionCompleteSansModification()
    {
        $eleve = factory(Eleve::class)->create();
        $decision = factory(Decision::class)->create([
            'eleve_id' => $eleve->id
        ]);


        $request = $this->put("/scolarites/eleves/{$eleve->id}/documents/decisions/{$decision->id}", [
            "_token" => csrf_token(),
            "enseignant_id" => $decision->eleve->enseignant_id,
            "date_cda" => $decision->date_cda,
            "date_notif" => $decision->date_notif,
            "date_limite" => $decision->date_limite,
            "date_convention" => $decision->date_convention,
            "numero_dossier" => $decision->numero_dossier,
            "nom_suivi" => $decision->nom_suivi,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("decisions", [
            "enseignant_id" => $decision->eleve->enseignant_id,
            "date_cda" => $decision->date_cda,
            "date_notif" => $decision->date_notif,
            "date_limite" => $decision->date_limite,
            "date_convention" => $decision->date_convention,
            "numero_dossier" => $decision->numero_dossier,
            "nom_suivi" => $decision->nom_suivi,
        ]);
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et que la décision à bien été éditée lors de la soumission
     * d'un formulaire d'édition complet
     */
    public function testTraitementFormulaireEditionDecisionCompletAvecModification()
    {
        $eleve = factory(Eleve::class)->create();
        $decision = factory(Decision::class)->create([
            'eleve_id' => $eleve->id
        ]);

        $path = $decision->document->path;
        $date = \Carbon\Carbon::now();

        $request = $this->patch("/scolarites/eleves/{$eleve->id}/documents/decisions/{$decision->id}", [
            "_token" => csrf_token(),
            "enseignant_id" => $eleve->enseignant_id,
            "date_cda" => $date,
            "date_notif" => $date,
            "date_limite" => $date,
            "date_convention" => $date,
            "numero_dossier" => "unit.testing",
            "nom_suivi" => "unit.testing",
            "file" => UploadedFile::fake()->create("avatar.jpg"),
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("decisions", [
            "enseignant_id" => $eleve->enseignant_id,
            "date_cda" => $date,
            "date_notif" => $date,
            "date_limite" => $date,
            "date_convention" => $date,
            "numero_dossier" => "unit.testing",
            "nom_suivi" => "unit.testing",
        ]);
        $this->assertDatabaseMissing("documents", ["path" => $path]);
    }


    /**
     * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
     */
    public function testAffichageAlerteSuppressionDecision()
    {
        $eleve = factory(Eleve::class)->create();
        $decision = factory(Decision::class)->create();


        $request = $this->get("/scolarites/eleves/{$eleve->id}/documents/decisions/{$decision->document->id}/edit");

        $request->assertStatus(200);
        $request->assertSee("Supprimer {$decision->document->nom}");
        $request->assertSee("Vous êtes sur le point de supprimer <b>" . "{$decision->document->nom}" . "</b>.");
    }


    /**
     * Vérifie qu'aucune erreur n'est présente et que la decision à bien été supprimé
     */
    public function testTraitementSuppressionEleve()
    {
        $eleve = factory(Eleve::class)->create();
        $decision = factory(Decision::class)->create();


        $request = $this->delete("/scolarites/eleves/{$eleve->id}/documents/decisions/{$decision->document->id}");

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseMissing("documents", ["id" => $decision->id]);
    }

}
