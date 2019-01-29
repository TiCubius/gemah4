<?php

namespace Tests\Feature\Permissions;

use App\Models\Eleve;
use App\Models\Permission;
use App\Models\Responsable;
use App\Models\Service;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AffectationsResponsableTest extends TestCase
{
    private $service;
    protected $user;

    /**
     * Création d'un utilisateur possèdant un service avec uniquement les permissions de la gestion des affectations responsable
     * et simulation de la connexion.
     */
    public function setUp()
    {
        parent::setUp();

        $permissions = Permission::where("id", "LIKE", "affectations/responsables/%")->get();

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
        $responsable = factory(Responsable::class)->create();

        $eleve->responsables()->save($responsable);


	    $getRoutes = [
		    "/scolarites/eleves/{$eleve->id}/affectations/responsables",
		    "/scolarites/eleves/{$eleve->id}/affectations/responsables/create",
	    ];

	    $postRoutes = [
		    "/scolarites/eleves/{$eleve->id}/affectations/responsables",
	    ];

	    $patchRoutes = [
	    	"/scolarites/eleves/{$eleve->id}/affectations/responsables/{$responsable->id}",
	    ];

	    $deleteRoutes = [
	    	"/scolarites/eleves/{$eleve->id}/affectations/responsables/{$responsable->id}"
	    ];


	    foreach ($getRoutes as $route) {
		    $request = $this->get($route);

		    // Vérification de la redirection
		    $request->assertStatus(200);

		    // Vérification de la présence de l'erreur dans la session
		    if (session("errors")) {
			    $this->assertNotContains("Vous n'avez pas la permission requise pour accéder à cette ressource.", session("errors")->get(0));
		    }
	    }

	    foreach ($postRoutes as $route) {
		    $request = $this->post($route);

		    // Vérification de la redirection
		    $request->assertStatus(302);

		    // Vérification de la présence de l'erreur dans la session
		    if (session("errors")) {
			    $this->assertNotContains("Vous n'avez pas la permission requise pour accéder à cette ressource.", session("errors")->get(0));
		    }
	    }

	    foreach ($patchRoutes as $route) {
		    $request = $this->patch($route);

		    // Vérification de la redirection
		    $request->assertStatus(302);

		    // Vérification de la présence de l'erreur dans la session
		    if (session("errors")) {
			    $this->assertNotContains("Vous n'avez pas la permission requise pour accéder à cette ressource.", session("errors")->get(0));
		    }
	    }

	    foreach ($deleteRoutes as $route) {
		    $request = $this->delete($route);

		    // Vérification de la redirection
		    $request->assertStatus(302);

		    // Vérification de la présence de l'erreur dans la session
		    if (session("errors")) {
			    $this->assertNotContains("Vous n'avez pas la permission requise pour accéder à cette ressource.", session("errors")->get(0));
		    }
	    }
    }
}
