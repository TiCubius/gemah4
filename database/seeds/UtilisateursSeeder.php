<?php

use Illuminate\Database\Seeder;

class UtilisateursSeeder extends Seeder
{
	protected $users = [
		[
			"nom"             => "Admin",
			"prenom"          => "Admin",
			"identifiant"     => "admin",
			"email"           => "admin@admin.admin",
			"reception_email" => 0,
			"password"        => "goddess*",
			"service"         => "Administrateur",
		],
		[
			"nom"         => "GOUNON",
			"prenom"      => "Jean-jacques",
			"identifiant" => "jgounon",
			"email"       => "jean-jacques.gounon@ac-lyon.fr",
			"password"    => "jgounon*",
			"service"     => "DSI",
		],
		[
			"nom"         => "DECHAVANNE",
			"prenom"      => "Béatrice",
			"identifiant" => "bdechavanne",
			"email"       => "beatrice.dechavanne@ac-lyon.fr",
			"password"    => "bdechavanne*",
			"service"     => "DIVEL",
		],
		[
			"nom"         => "CHADUC",
			"prenom"      => "Pierre-henri",
			"identifiant" => "pchaduc",
			"email"       => "pierre-henri.chaduc@ac-lyon.fr",
			"password"    => "pchaduc*",
			"service"     => "ASH",
		],
		[
			"nom"         => "GAVILLET",
			"prenom"      => "Annick",
			"identifiant" => "agavillet",
			"email"       => "annick.gavillet@ac-lyon.fr",
			"password"    => "agavillet*",
			"service"     => "DAF",
		],
	];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		foreach ($this->users as $user) {
			$service = \App\Models\Service::where("departement_id", "42")->where("nom", $user["service"])->first();

			$fetchedUser = \App\Models\Utilisateur::where("email", $user["email"])->first();
			if ($fetchedUser) {
				$fetchedUser ->update([
					"nom"             => $user["nom"],
					"prenom"          => $user["prenom"],
					"identifiant"     => $user["identifiant"],
					"reception_email" => isset($user["reception_email"]) ? 1 : 0,
					"email"           => $user["email"],
					"password"        => \Illuminate\Support\Facades\Hash::make($user["password"]),
					"service_id"      => $service["id"],
				]);
			} else {
				\App\Models\Utilisateur::create([
					"nom"             => $user["nom"],
					"prenom"          => $user["prenom"],
					"identifiant"     => $user["identifiant"],
					"reception_email" => isset($user["reception_email"]) ? 1 : 0,
					"email"           => $user["email"],
					"password"        => \Illuminate\Support\Facades\Hash::make($user["password"]),
					"service_id"      => $service["id"],
				]);
			}
		}
	}
}
