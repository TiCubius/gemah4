<?php

use Illuminate\Database\Seeder;

class UtilisateursSeeder extends Seeder
{
    protected $users = [
        [
            "nom" => "Admin",
            "prenom" => "Admin",
            "identifiant" => "admin",
            "email" => "root@root.root",
            "password" => "goddess",
            "service" => "Administrateur",
        ], [
            "nom" => "GOUNON",
            "prenom" => "Jean-jacques",
            "identifiant" => "jgounon",
            "email" => "jean-jacques.gounon@ac-lyon.fr",
            "password" => "password",
            "service" => "DSI",
        ], [
            "nom" => "CHADUC",
            "prenom" => "Pierre-henri",
            "identifiant" => "pchaduc",
            "email" => "pierre-henri.chaduc@ac-lyon.fr",
            "password" => "password",
            "service" => "ASH",
        ], [
            "nom" => "GAVILLET",
            "prenom" => "Annick",
            "identifiant" => "agavillet",
            "email" => "Annick.Gavillet@ac-lyon.fr",
            "password" => "password",
            "service" => "DAF",
        ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->users as $user)
        {
            $service = \App\Models\Service::where("departement_id", "42")->where("nom", $user["service"])->first();

            \App\Models\Utilisateur::create([
                "nom" => $user["nom"],
                "prenom" => $user["prenom"],
                "identifiant" => $user["identifiant"],
                "email" => $user["email"],
                "password" => \Illuminate\Support\Facades\Hash::make($user["password"]),
                "service_id" => $service["id"],
            ]);
        }
    }
}
