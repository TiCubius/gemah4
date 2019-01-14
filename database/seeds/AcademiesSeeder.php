<?php

use Illuminate\Database\Seeder;

class AcademiesSeeder extends Seeder
{

	private $academiesParRegions = [
		"Auvergne-Rhône-Alpes"       => [
			"Académie de Clermont-Ferrand",
			"Académie de Grenoble",
			"Académie de Lyon",
		],
		"Bourgogne-Franche-Comté"    => [
			"Académie de Besançon",
			"Académie de Dijon",
		],
		"Bretagne"                   => [
			"Académie de Rennes",
		],
		"Centre-Val de Loire"        => [
			"Académie d'Orléans-Tours",
		],
		"Corse"                      => [
			"Académie de Corse",
		],
		"Grand Est"                  => [
			"Académie de Nancy-Metz",
			"Académie de Reims",
			"Académie de Strasbourg",
		],
		"Guadeloupe"                 => [
			"Académie de la Guadeloupe",
		],
		"Guyane"                     => [
			"Académie de la Guyane",
		],
		"Hauts-de-France"            => [
			"Académie d'Amiens",
			"Académie de Lille",
		],
		"Île-de-France"              => [
			"Académie de Créteil",
			"Académie de Paris",
			"Académie de Versailles",
		],
		"Martinique"                 => [
			"Académie de Martinique",
		],
		"Normandie"                  => [
			"Académie de Caen",
			"Académie de Rouen",
		],
		"Nouvelle-Aquitaine"         => [
			"Académie de Bordeaux",
			"Académie de Limoges",
			"Académie de Poitiers",
		],
		"Occitanie"                  => [
			"Académie de Montpellier",
			"Académie de Toulouse",
		],
		"Pays de la Loire"           => [
			"Académie de Nantes",
		],
		"Provence-Alpes-Côte d'Azur" => [
			"Académie d'Aix-Marseille",
			"Académie de Nice",
		],
		"La Réunion"                 => [
			"Académie de La Réunion",
		],
        "Mayotte"                    => [
            "Académie de Mayotte",
        ],
	];

	public function run()
	{
		foreach ($this->academiesParRegions as $region => $academies) {
			foreach ($academies as $academy) {
				\App\Models\Academie::create([
					"nom"       => $academy,
                    "region_id" => \App\Models\Region::where("nom", "=", $region)->first()->id,
				]);
			}
		}
	}

}
