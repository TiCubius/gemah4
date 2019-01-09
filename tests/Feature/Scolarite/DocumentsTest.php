<?php

namespace Tests\Feature;

use App\Models\Decision;
use App\Models\Document;
use App\Models\Eleve;
use App\Models\Etablissement;
use App\Models\TypeDocument;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;


class DocumentsTest extends TestCase
{

    /**
     * Vérifie que les données présentes sur l'index sont bien celles attendues.
     */
    public function testAffichageIndexDocuments()
    {
        $eleve = factory(Eleve::class)->create();
        $documents = factory(Document::class, 5)->create([
            "eleve_id" => $eleve->id
        ]);

        $request = $this->get("/scolarites/eleves/{$eleve->id}/documents");

        $request->assertStatus(200);
        $request->assertSee("Gestion des documents");

        foreach ($documents as $document) {
                $request->assertSee($document->nom);
        }
    }

    /**
     * Vérifie que le formulaire de création contient bien les champs nécessaires
     */
    public function testAffichageFormulaireCreationDecision()
    {
        $eleve = factory(Eleve::class)->create();
        $request = $this->get("/scolarites/eleves/{$eleve->id}/documents/decision/create");

        $request->assertStatus(200);
        $request->assertSee("Création d'une decision");

        $request->assertSee("Date de la CDA");
        $request->assertSee("Date de réception de la notification");
        $request->assertSee("Date limite de la décision");
        $request->assertSee("Date limite de la convention");
        $request->assertSee("Numéro du dossier MDPH");
        $request->assertSee("Enseignant référent");
        $request->assertSee("Affaire suivie par");
        $request->assertSee("Fichier");

        $request->assertSee("Ajouter une décision");
    }

    /**
     * Vérifie que le formulaire de création contient bien les champs nécessaires
     */

    public function testAffichageFormulaireCreationDocument()
    {
        $eleve = factory(Eleve::class)->create();
        $request = $this->get("/scolarites/eleves/{$eleve->id}/documents/create");

        $request->assertStatus(200);
        $request->assertSee("Nouveau document");

        $request->assertSee("Nom");
        $request->assertSee("Description");
        $request->assertSee("Fichier");


        $request->assertSee("Ajouter un document");
    }

    /**
     * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
     * de création incomplet
     */
    public function testTraitementFormulaireCreationDecisionsIncomplete()
    {
        $eleve = factory(Eleve::class)->create();
        $request = $this->post("/scolarites/eleves/{$eleve->id}/decisions", [
            "_token" => csrf_token(),
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
    }

    /**
     * Vérifie que des erreurs sont présentes lors de la tentative de soumission d'un formulaire
     * de création incomplet
     */
    public function testTraitementFormulaireCreationDocumentIncomplet()
    {
        $eleve = factory(Eleve::class)->create();
        $request = $this->post("/scolarites/eleves/{$eleve->id}/documents", [
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

        $request = $this->post("/scolarites/eleves/{$eleve->id}/decisions", [
            "_token" => csrf_token(),
            "enseignant_id" => $eleve->enseignant_id,
            "date_cda" => "01/01/01",
            "date_notif" => "01/01/01",
            "date_limite" => "01/01/01",
            "date_convention" => "01/01/01",
            "numero_dossier" => "unit.testing",
            "nom_suivi" => "unit.testing",
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
    }

    /**
     * Vérifie qu'aucune erreur n'est présente et qu'un Eleve à bien été créée lors de la soumissions d'un
     * formulaire de création complet
     */

    public function testTraitementFormulaireCreationDocumentComplet()
    {
        $eleve = factory(Eleve::class)->create();
        $type = factory(TypeDocument::class)->create();

        $request = $this->post("/scolarites/eleves/{$eleve->id}/documents", [
            "_token" => csrf_token(),
            "type_document_id" => $type->id,
            "nom" => "unit.testing",
            "description" => "unit.testing",
            "file" => UploadedFile::fake()->create("avatar.jpg"),
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
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
        $request->assertSee("Académie");
        $request->assertSee("Établissement");
        $request->assertSee("Code INE");

        $request->assertSee("Éditer l'élève");
        $request->assertSee("Supprimer l'élève");
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
            "_token" => csrf_token(),
            "nom" => $eleves[1]->nom,
            "prenom" => $eleves[1]->prenom,
            "date_naissance" => $eleves[1]->date_naissance,
            "classe" => $eleves[1]->classe,
            "academie_id" => $eleves[1]->academie_id,
            "etablissement_id" => $eleves[1]->etablissement,
            "code_ine" => $eleves[1]->code_ine,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
        $this->assertDatabaseHas("eleves", [
            "nom" => $eleves[0]->nom,
            "prenom" => $eleves[0]->prenom,
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
            "_token" => csrf_token(),
            "nom" => $eleve->nom,
            "prenom" => $eleve->prenom,
            "date_naissance" => $eleve->date_naissance,
            "classe" => $eleve->classe,
            "academie_id" => $eleve->academie_id,
            "etablissement_id" => $eleve->etablissement_id,
            "code_ine" => $eleve->code_ine,
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $this->assertDatabaseHas("eleves", [
            "nom" => $eleve->nom,
            "prenom" => $eleve->prenom,
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
        $etablissement = factory(Etablissement::class)->create();

        $request = $this->put("/scolarites/eleves/{$eleve->id}", [
            "_token" => csrf_token(),
            "nom" => "unit.testing",
            "prenom" => "unit.testing",
            "date_naissance" => "01/01/01",
            "classe" => "unit.testing",
            "academie_id" => $etablissement->academie_id,
            "etablissement_id" => $etablissement->id,
            "code_ine" => "unit.testin",
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
        $request->assertSee("Supprimer l'élève");
        $request->assertSee("Vous êtes sur le point de supprimer <b>" . strtoupper("{$eleve->nom} {$eleve->prenom}") . "</b>.");
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
        $this->assertDatabaseMissing("eleves", ["code_ine" => $eleve->code_ine]);
    }

}
