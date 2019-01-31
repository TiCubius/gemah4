<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class ServicesSeeder extends Seeder
{

    protected $services = [
        "Administrateur" => "Gestion de GEMAH",
        "ASH" => "Gestion des élèves en situation de handicap",
        "DAF" => "Division des affaires financiaires",
        "DIVEL" => "Division des élèves",
        "DSI" => "Direction du système informatique",
    ];

    public function run()
    {
        $services = $this->services;
        $departements = \App\Models\Departement::all();
        $permissions = \App\Models\Permission::all();
        $permissionsCrudMateriel = \App\Models\Permission::where("id", "LIKE", "%materiels/stocks/%")->get();
        $permissionsAffectationMateriel = \App\Models\Permission::where("id", "LIKE", "%affectations/materiels/%")->get();
        $permissionsAdmin = \App\Models\Permission::where("id", "LIKE", "materiels/types/%")->orWhere("id", "LIKE", "materiels/domaines/%")->orWhere("id", "LIKE", "administrations/%")->get();
        $permissionsGlobal = $permissions->diff($permissionsAdmin)->diff($permissionsCrudMateriel)->diff($permissionsAffectationMateriel);

        $output = new ConsoleOutput();
        $progress = new ProgressBar($output, count($services)); //* count($departements));
        $progress->setFormat("<fg=white> %current%/%max% [%bar%] %percent:3s%%\n  TIME: %elapsed:6s%\n  EST: %estimated:-6s% / ETA: %remaining:-6s%");
        $progress->start();

        foreach ($departements as $departement) {
            foreach ($services as $service => $description) {
                $service = \App\Models\Service::create([
                    "nom" => $service,
                    "description" => $description,
                    "departement_id" => $departement->id,
                ]);

                $progress->advance();

                if ($service->nom == "Administrateur") {
                    $service->permissions()->sync($permissions->pluck('id'));
                }
                if ($service->nom == "DAF") {
                    $permissionsList = $permissionsGlobal->merge($permissionsCrudMateriel);

                    $service->permissions()->sync($permissionsList->pluck('id'));
                }
                if ($service->nom == "ASH") {
                    $permissionsList = $permissionsGlobal->merge($permissionsAffectationMateriel);

                    $service->permissions()->sync($permissionsList->pluck('id'));
                }
                if ($service->nom == "DSI") {
                    $permissionsList = $permissionsGlobal->merge($permissionsAffectationMateriel)->merge($permissionsCrudMateriel);

                    $service->permissions()->sync($permissionsList->pluck('id'));
                }
                if ($service->nom == "DIVEL") {
                    $service->permissions()->sync($permissionsGlobal->pluck('id'));
                }
            }
        }

        $progress->finish();
    }
}
