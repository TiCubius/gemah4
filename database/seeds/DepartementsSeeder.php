<?php

use Illuminate\Database\Seeder;

class DepartementsSeeder extends Seeder
{
    private $departementsParAcademie = [
        "Académie de Clermont-Ferrand" => [
            "Allier" => "03",
            "Cantal" => "15",
            "Haute-Loire" => "43",
            "Puy-de-Dôme" => "63",
        ],
        "Académie de Grenoble" => [
            "Ardèche" => "07",
            "Drôme" => "26",
            "Isère" => "38",
            "Savoie" => "73",
            "Haute-Savoie" => "74",
        ],
        "Académie de Lyon" => [
            "Ain" => "01",
            "Loire" => "42",
            "Rhône" => "69",
        ],
        "Académie de Besançon" => [
            "Doubs" => "25",
            "Jura" => "39",
            "Haute-Saône" => "70",
            "Territoire de Belfort" => "90",
        ],
        "Académie de Dijon" => [
            "Côte-d'or" => "21",
            "Nièvre" => "58",
            "Saône-et-Loire" => "71",
            "Yonne" => "89",
        ],
        "Académie de Rennes" => [
            "Côtes-d'armor" => "22",
            "Finistère" => "29",
            "ille-et-Vilaine" => "35",
            "Morbihan" => "56",
        ],
        "Académie d'Orléans-Tours" => [
            "Cher" => "18",
            "Eure-et-Loir" => "28",
            "Indre" => "36",
            "Indre-et-Loire" => "37",
            "Loir-et-Cher" => "41",
            "Loiret" => "45",
        ],
        "Académie de Corse" => [
            "Corse-du-sud" => "2a",
            "Haute-corse" => "2b",
        ],
        "Académie de Nancy-Metz" => [
            "Meurthe-et-Moselle" => "54",
            "Meuse" => "55",
            "Moselle" => "57",
            "Vosges" => "88",
        ],
        "Académie de Reims" => [
            "Ardennes" => "08",
            "Aube" => "10",
            "Marne" => "51",
            "Haute-Marne" => "52",
        ],
        "Académie de Strasbourg" => [
            "Bas-Rhin" => "67",
            "Haut-Rhin" => "68",
        ],
        "Académie de la Guadeloupe" => [
            "Guadeloupe" => "971",
        ],
        "Académie de la Guyane" => [
            "Guyane" => "973",
        ],
        "Académie d'Amiens" => [
            "Aisne" => "02",
            "Oise" => "60",
            "Somme" => "80",
        ],
        "Académie de Lille" => [
            "Nord" => "59",
            "Pas-de-Calais" => "62",
        ],
        "Académie de Créteil" => [
            "Seine-et-Marne" => "77",
            "Seine-Saint-Denis" => "93",
            "Val-de-Marne" => "94",
        ],
        "Académie de Paris" => [
            "Paris" => "75",
        ],
        "Académie de Versailles" => [
            "Yvelines" => "78",
            "Essonne" => "91",
            "Hauts-de-Seine" => "92",
            "Val-d'oise" => "95",
        ],
        "Académie de Martinique" => [
            "Martinique" => "972",
        ],
        "Académie de Caen" => [
            "Calvados" => "14",
            "Manche" => "50",
            "Orne" => "61",
        ],
        "Académie de Rouen" => [
            "Eure" => "27",
            "Seine-Maritime" => "76",
        ],
        "Académie de Bordeaux" => [
            "Dordogne" => "24",
            "Gironde" => "33",
            "Landes" => "40",
            "Lot-et-Garonne" => "47",
            "Pyrénées-Atlantiques" => "64",
        ],
        "Académie de Limoges" => [
            "Corrèze" => "19",
            "Creuse" => "23",
            "Haute-Vienne" => "87",
        ],
        "Académie de Poitiers" => [
            "Charente" => "16",
            "Charente-Maritime" => "17",
            "Deux-Sèvres" => "79",
            "Vienne" => "86",
        ],
        "Académie de Montpellier" => [
            "Aude" => "11",
            "Gard" => "30",
            "Hérault" => "34",
            "Lozère" => "48",
            "Pyrénées-Orientales" => "66",
        ],
        "Académie de Toulouse" => [
            "Ariège" => "09",
            "Aveyron" => "12",
            "Haute-Garonne" => "31",
            "Gers" => "32",
            "Lot" => "46",
            "Hautes-Pyrénées" => "65",
            "Tarn" => "81",
            "Tarn-et-Garonne" => "82",
        ],
        "Académie de Nantes" => [
            "Loire-Atlantique" => "44",
            "Maine-et-Loire" => "49",
            "Mayenne" => "53",
            "Sarthe" => "72",
            "Vendée" => "85",
        ],
        "Académie d'Aix-Marseille" => [
            "Alpes-de-Haute-Provence" => "04",
            "Hautes-Alpes" => "05",
            "Bouches-du-Rhône" => "13",
            "Vaucluse" => "84"
        ],
        "Académie de Nice" => [
            "Alpes-Maritimes" => "06",
            "Var" => "83",
        ],
        "Académie de La Réunion" => [
            "Réunion" => "974",
        ],
        "Académie de Mayotte" => [
            "Mayotte" => "976"
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // On parcoure la liste des académies, ayant pour valeur un tableau de départements
        foreach ($this->departementsParAcademie as $academie => $departements) {
            //Pour chaque liste de département on sépare le nom du département => "clé) et l'identifiant de ce dernier => "valeur)
            foreach ($departements as $departement => $id) {
                \App\Models\Departement::create([
                    "id"        => $id,
                    "nom"       => $departement,
                    "academie_id" => \App\Models\Academie::where("nom", "=", $academie)->first()->id,
                ]);
            }
        }
    }
}
