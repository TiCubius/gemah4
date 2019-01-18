<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class EtablissementSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$file = File::get("database/data/opendata-etablissements-1.json");
		$etablissements = json_decode($file);

		$output = new ConsoleOutput();
		$progress = new ProgressBar($output, count($etablissements));
		$progress->setFormat("<fg=white> %current%/%max% [%bar%] %percent:3s%%\n  TIME: %elapsed:6s%\n  EST: %estimated:-6s% / ETA: %remaining:-6s%");
		$progress->start();

		foreach ($etablissements as $key => $etablissement) {
			$type = \App\Models\TypeEtablissement::where("libelle", $etablissement->fields->nature_uai_libe)->first();
			if (!$type) {
				$type = \App\Models\TypeEtablissement::create([
					"libelle" => $etablissement->fields->nature_uai_libe,
				]);
			}


			\App\Models\Etablissement::create([
				"type_etablissement_id" => $type->id,
				"departement_id"        => $etablissement->fields->code_departement,

				"id"          => $etablissement->fields->numero_uai,
				"nom"         => $etablissement->fields->appellation_officielle ?? "NON DEFINI",
				"degre"       => ($etablissement->fields->nature_uai < 200) ? "Primaire" : "Secondaire",
				"regime"      => $etablissement->fields->secteur_public_prive_libe,
				"adresse"     => $etablissement->fields->adresse_uai ?? "NON DEFINI",
				"code_postal" => $etablissement->fields->code_postal_uai,
				"ville"       => $etablissement->fields->libelle_commune,
				"telephone"   => null,
			]);

			$progress->advance();
		}


		// Fichier 2.json si nécessaire
		//
		//		foreach ($etablissements as $key => $etablissement) {
		//			$progress->advance();
		//
		//			\App\Models\Etablissement::create([
		//				"id"          => $etablissement->fields->identifiant_de_l_etablissement,
		//				"type"        => $etablissement->fields->libelle_nature,
		//				"nom"         => $etablissement->fields->nom_etablissement,
		//				"degre"       => ($etablissement->fields->code_nature < 200) ? "Primaire" : "Secondaire",
		//				"regime"      => $etablissement->fields->statut_public_prive,
		//				"adresse"     => $etablissement->fields->adresse_1 ?? null,
		//				"code_postal" => $etablissement->fields->code_postal,
		//				"ville"       => $etablissement->fields->nom_commune,
		//				"email"       => $etablissements->fields->mail ?? null,
		//				"telephone"   => $etablissement->fields->telephone ?? null,
		//
		//				"departement_id" => $etablissement->fields->code_departement,
		//				"updated_at"     => $etablissement->fields->date_maj_ligne,
		//			]);
		//		}

		$progress->finish();
	}

}