<?php

namespace Tests\Feature\Permissions;

use App\Models\Permission;
use App\Models\Service;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdministrationsTest extends TestCase
{
    private $service;
    protected $user;

    /**
     * Création d'un utilisateur possèdant un service avec uniquement la permission de visualitation de l'index d'administration
     * et simulation de la connexion.
     */
    public function setUp()
    {
        parent::setUp();

        $permission = Permission::where("id", "administrations/index")->get();

        $this->service = factory(Service::class)->create();
        $this->service->permissions()->attach($permission);

        $this->user = factory(Utilisateur::class)->create([
            "service_id" => $this->service->id,
            "password" => Hash::make("root"),
        ]);

        $this->session(["user" => $this->user]);
    }


    /**
     * Vérifie que l'index d'administration est fonctionel
     */
    public function testAccessAutorise()
    {
        $request = $this->get("/administrations");

        // Vérification de la redirection
        $request->assertStatus(200);

        // Vérification de la présence de l'erreur dans la session
        if (session("errors")) {
            $this->assertNotContains("Vous n'avez pas la permission requise pour accéder à cette ressource.", session("errors")->get(0));
        }
    }

}
