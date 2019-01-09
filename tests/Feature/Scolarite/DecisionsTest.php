<?php

namespace Tests\Feature;

use App\Models\Decision;
use App\Models\Document;
use App\Models\Eleve;
use App\Models\Etablissement;
use App\Models\TypeDocument;
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

    public function testAffichageFormulaireEditionDocument()
    {
        $eleve = factory(Eleve::class)->create();
        $document = factory(Document::class)->create();

        $request = $this->get("/scolarites/eleves/{$eleve->id}/documents/{$document->id}/edit");

        $request->assertStatus(200);
        $request->assertSee("Édition de {$document->nom}");

        $request->assertSee("Nom");
        $request->assertSee("Description");
        $request->assertSee("Fichier");

        $request->assertSee("Modifier le document");
        $request->assertSee("Supprimer {$document->nom}");
    }

    /**
     * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire d'édition incomplet
     */
    public function testTraitementFormulaireEditionDocumentIncomplet()
    {
        $eleve = factory(Eleve::class)->create();
        $document = factory(Document::class)->create();


        $request = $this->patch("/scolarites/eleves/{$eleve->id}/documents/{$document->id}", [
            "_token" => csrf_token(),
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et que l'éleve à bien été édité lors de la soumission
     * d'un formulaire d'édition complet
     */
    public function testTraitementFormulaireEditionDocumentCompletSansModification()
    {
        $eleve = factory(Eleve::class)->create();
        $document = factory(Document::class)->create();


        $request = $this->put("/scolarites/eleves/{$eleve->id}/documents/{$document->id}/", [
            "_token" => csrf_token(),
            "nom" => $document->nom,
            "description" => $document->description,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("documents", [
            "nom" => $document->nom,
            "description" => $document->description,
            "path" => $document->path,
        ]);
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et que l'éleve à bien été édité lors de la soumission
     * d'un formulaire d'édition complet
     */
    public function testTraitementFormulaireEditionDocumentCompletAvecModification()
    {
        $eleve = factory(Eleve::class)->create();
        $document = factory(Document::class)->create();


        $request = $this->put("/scolarites/eleves/{$eleve->id}/documents/{$document->id}", [
            "_token" => csrf_token(),
            "nom" => "unit.testing",
            "description" => "unit.testing",
            "file" => UploadedFile::fake()->create("avatar.jpg"),
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("documents", [
            "nom" => "unit.testing",
            "description" => "unit.testing",
        ]);
        $this->assertDatabaseMissing("documents", ["path" => $document->path]);
    }


    /**
     * Vérifie que les données présentes sur l'alerte de suppression sont bien celles attendues
     */
    public function testAffichageAlerteSuppressionDocument()
    {
        $eleve = factory(Eleve::class)->create();
        $document = factory(Document::class)->create();


        $request = $this->get("/scolarites/eleves/{$eleve->id}/documents/{$document->id}/edit");

        $request->assertStatus(200);
        $request->assertSee("Supprimer {$document->nom}");
        $request->assertSee("Vous êtes sur le point de supprimer <b>" . strtoupper("{$document->nom}") . "</b>.");
    }


    /**
     * Vérifie qu'aucune erreur n'est présente et que l'éleve à bien été supprimé
     */
    public function testTraitementSuppressionEleve()
    {
        $eleve = factory(Eleve::class)->create();
        $document = factory(Document::class)->create();


        $request = $this->delete("/scolarites/eleves/{$eleve->id}/documents/{$document->id}");

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseMissing("documents", ["id" => $document->id]);
    }

}
