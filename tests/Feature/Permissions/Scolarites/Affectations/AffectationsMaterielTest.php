<?php

namespace Tests\Feature\Permissions;

use App\Models\Eleve;
use App\Models\Materiel;
use App\Models\Permission;
use App\Models\Service;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AffectationsMaterielTest extends TestCase
{
    private $service;
    protected $user;

    /**
     * Création d'un utilisateur possèdant un service avec uniquement les permissions de la gestion des affectations matériel
     * et simulation de la connexion.
     */
    public function setUp()
    {
        parent::setUp();

        $permissions = Permission::where("id", "LIKE", "affectations/materiels/%")->get();

        $this->service = factory(Service::class)->create();
        $this->service->permissions()->sync($permissions->pluck('id'));

        $this->user = factory(Utilisateur::class)->create([
            "service_id" => $this->service->id,
            "password" => Hash::make("root"),
        ]);

        $this->session(["user" => $this->user]);
    }

    /**
     * Vérifie que toutes les autres routes soient refusées
     */
    public function testAccessAutorise()
    {
        $eleve = factory(Eleve::class)->create();
        $materiel = factory(Materiel::class)->create();

        $eleve->materiels()->save($materiel);


        $request = $this->get("/scolarites/eleves/{$eleve->id}/affectations/materiels");

        // Vérification de la redirection
        $request->assertStatus(200);

        // Vérification de la présence de l'erreur dans la session
        if (session("errors")) {
            $this->assertNotContains("Vous n'avez pas la permission requise pour accéder à cette ressource.", session("errors")->get(0));
        }


        $request = $this->post("/scolarites/eleves/{$eleve->id}/affectations/materiels/{$materiel->id}");

        // Vérification de la redirection
        $request->assertStatus(302);

        // Vérification de la présence de l'erreur dans la session
        if (session("errors")) {
            $this->assertNotContains("Vous n'avez pas la permission requise pour accéder à cette ressource.", session("errors")->get(0));
        }


        $request = $this->delete("/scolarites/eleves/{$eleve->id}/affectations/materiels/{$materiel->id}");

        // Vérification de la redirection
        $request->assertStatus(302);

        // Vérification de la présence de l'erreur dans la session
        if (session("errors")) {
            $this->assertNotContains("Vous n'avez pas la permission requise pour accéder à cette ressource.", session("errors")->get(0));
        }

    }
}
