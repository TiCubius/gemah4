<?php

namespace Tests\Feature;

use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConnexionTest extends TestCase
{

    /**
     * Test d'affichage de l'écran de connexion.
     *
     * @return void
     */
    public function testAffichageEcranConnexion()
    {
        $request = $this->get("/connexion");

        $request->assertSee("Pseudo");
        $request->assertSee("Mot de passe");

        $request->assertSee("Connexion");

    }

    /**
     * Envoie d'un formulaire de connexion incorrect.
     *
     * @return void
     */
    public function testConnexionAvecDonneesIncorrect()
    {
        $this->session(["user" => null]);

        factory(Utilisateur::class)->create();
        $request = $this->post("/connexion",[
            "pseudo" => "testing@unit.fr",
            "password" => "testing.unit"
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasErrors();
        $request->assertSessionMissing("user");
    }

    /**
     * Envoie d'un formulaire de connexion correct.
     *
     * @return void
     */
    public function testConnexionAvecDonneesCorrect()
    {
        $this->session(["user" => null]);

        $utilisateur = factory(Utilisateur::class)->create([
            "password" => Hash::make("admin")
        ]);
        $request = $this->post("/connexion",[
            "pseudo" => $utilisateur->pseudo,
            "password" =>  "admin"
        ]);

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $request->assertSessionHas("user");
    }

    /**
     * Deconnexion.
     *
     * @return void
     */
    public function testDeconnexion()
    {
        $request = $this->get("/deconnexion");

        $request->assertStatus(302);
        $request->assertSessionHasNoErrors();
        $request->assertSessionMissing("user");
    }
}
