<?php

use Illuminate\Database\Seeder;

class UtilisateursSeeder extends Seeder
{
    protected $users = [
        [
            "nom" => "Admin",
            "prenom" => "Admin",
            "login" => "Admin",
            "email" => "root@root.root",
            "password" => "goddess",
            "service" => "Administrateur",
        ], [
            "nom" => "GOUNON",
            "prenom" => "Jean-jacques",
            "login" => "jgounon",
            "email" => "jean-jacques.gounon@ac-lyon.fr",
            "password" => "password",
            "service" => "Service informatique",
        ], [
            "nom" => "CHADUC",
            "prenom" => "Pierre-henri",
            "login" => "pchaduc",
            "email" => "pierre-henri.chaduc@ac-lyon.fr\" \"ASH",
            "password" => "password",
            "service" => "ASH",
        ], [
            "nom" => "GAVILLET",
            "prenom" => "Annick",
            "login" => "agavillet",
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
            $service = \App\Models\Service::where("departement_id", "42")->where("nom", $user->service)->first();

            \App\Models\Utilisateur::create([
                "nom" => $user->nom,
                "prenom" => $user->prenom,
                "login" => $user->login,
                "email" => $user->email,
                "password" => $user->password,
                "service_id" => $service->id,
            ]);
        }
    }
}
