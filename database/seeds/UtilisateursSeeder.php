<?php

use Illuminate\Database\Seeder;

class UtilisateursSeeder extends Seeder
{
    protected $users = [
        [
            "nom" => "Admin",
            "prenom" => "Admin",
            "pseudo" => "admin",
            "email" => "root@root.root",
            "password" => "goddess",
            "service" => "Administrateur",
        ], [
            "nom" => "GOUNON",
            "prenom" => "Jean-jacques",
            "pseudo" => "jgounon",
            "email" => "jean-jacques.gounon@ac-lyon.fr",
            "password" => "password",
            "service" => "Service informatique",
        ], [
            "nom" => "CHADUC",
            "prenom" => "Pierre-henri",
            "pseudo" => "pchaduc",
            "email" => "pierre-henri.chaduc@ac-lyon.fr",
            "password" => "password",
            "service" => "ASH",
        ], [
            "nom" => "GAVILLET",
            "prenom" => "Annick",
            "pseudo" => "agavillet",
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
                "pseudo" => $user["pseudo"],
                "email" => $user["email"],
                "password" => \Illuminate\Support\Facades\Hash::make($user["password"]),
                "service_id" => $service["id"],
            ]);
        }
    }
}
