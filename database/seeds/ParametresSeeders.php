<?php

use Illuminate\Database\Seeder;

class ParametresSeeders extends Seeder
{
	private $departements = [
		"42" => [
			[
				"libelle" => "Affaire suivie par",
				"key"     => "conventions/affaire/convention/nom",
				"value"   => "DECHAVANNE Béatrice",
			],
			[
				"libelle" => "Téléphone",
				"key"     => "conventions/affaire/convention/telephone",
				"value"   => "04 77 81 41 13",
			],
			[
				"libelle" => "E-Mail",
				"key"     => "conventions/affaire/convention/email",
				"value"   => "",
			],
			[
				"libelle" => "Affaire suivie par",
				"key"     => "conventions/affaire/informatique/nom",
				"value"   => "GOUNON Jean-Jacques",
			],
			[
				"libelle" => "Téléphone",
				"key"     => "conventions/affaire/informatique/telephone",
				"value"   => "04 77 81 79 47",
			],
			[
				"libelle" => "E-Mail",
				"key"     => "conventions/affaire/informatique/email",
				"value"   => "",
			],
			[
				"libelle" => "Affaire suivie par",
				"key"     => "conventions/affaire/audio/nom",
				"value"   => "GAVILLET Annick",
			],
			[
				"libelle" => "Téléphone",
				"key"     => "conventions/affaire/audio/telephone",
				"value"   => "04 77 81 41 38",
			],
			[
				"libelle" => "E-Mail",
				"key"     => "conventions/affaire/audio/email",
				"value"   => "",
			],
			[
				"libelle" => "Secrétaire général",
				"key"     => "conventions/secretaire",
				"value"   => "Jean-Luc POUMAREDES",
			],
			[
				"libelle" => "Adresse",
				"key"     => "conventions/adresse",
				"value"   => "11, rue des Docteurs Charcot",
			],
			[
				"libelle" => "Code Postal",
				"key"     => "conventions/code_postal",
				"value"   => "42023",
			],
			[
				"libelle" => "Ville",
				"key"     => "conventions/ville",
				"value"   => "Saint-Etienne",
			],
			[
				"libelle" => "Année scolaire",
				"key"     => "conventions/annee",
				"value"   => "2018 / 2019",
			],
            [
                "libelle" => "Entête législatif",
                "key"     => "conventions/lois/entete",
                "value"   => "Vu la circulaire n° 2001-061 du 5 avril 2001 publiée au Bulletin Officiel n° 15 du 12 avril 2001, sur le financement de matériels pédagogiques adaptés au bénéfice d’élèves présentant des déficiences sensorielles ou motrices. Vu la circulaire n° 2001-221 du 29 octobre 2001 apportant des précisions sur les conventions de mise à disposition de ces matériels.",
            ],
            [
                "libelle" => "Localisation de la direction académie",
                "key"     => "conventions/direction/localisation",
                "value"   => "des services de l’éducation nationale de la Loire",
            ],
            [
                "libelle" => "Titre de l'article 1",
                "key"     => "conventions/article1/titre",
                "value"   => "Article 1 : objet de la convention",
            ],
            [
                "libelle" => "Contenu de l'article 1",
                "key"     => "conventions/article1/contenu",
                "value"   => "Dans le cadre du plan triennal d'accès à l'autonomie des personnes handicapées, la Commission des droits et de l’autonomie est garante de l'attribution d'équipement répondant aux besoins particuliers d'enfants déficients sensoriels et moteurs, après avis médical et pédagogique des services compétents.",
            ],
            [
                "libelle" => "Titre de l'article 2",
                "key"     => "conventions/article2/titre",
                "value"   => "Article 2 : désignation du matériel",
            ],
            [
                "libelle" => "Titre de l'article 3",
                "key"     => "conventions/article3/titre",
                "value"   => "Article 3 : dispositions financières",
            ],
            [
                "libelle" => "Contenu de l'article 3",
                "key"     => "conventions/article3/contenu",
                "value"   => "Il ne sera demandé aucune contribution financière au bénéficiaire à l'exclusion des consommables indispensables au fonctionnement du matériel.",
            ],
            [
                "libelle" => "Titre de l'article 4",
                "key"     => "conventions/article4/titre",
                "value"   => "Article 4 : conditions de mise à disposition",
            ],
            [
                "libelle" => "Contenu de l'article 4",
                "key"     => "conventions/article4/contenu",
                "value"   => "Le bénéficiaire s'engage à utiliser le bien qui lui est confié uniquement dans le cadre du travail scolaire dans l'établissement ou à son domicile (article 1880 du Code civil). Il s’engage à porter à la connaissance du service gestionnaire (direction des services départementaux de l’éducation nationale de le Loire, service informatique) tout sinistre affectant le matériel prêté. Le service étudiera alors les modalités de prise en charge des réparations nécessaires. Toutefois s’il s’avère que le matériel a subit des dommages importants et ne peut être réparé, il ne sera pas remplacé plus d’une fois. Toute modification dans la composition de la liste du matériel fera l'objet d'un avenant à la présente convention (retrait ou adjonction).",
            ],
            [
                "libelle" => "Titre de l'article 5",
                "key"     => "conventions/article5/titre",
                "value"   => "Article 5 : Durée et renouvellement de la convention",
            ],
            [
                "libelle" => "Titre de l'article 5",
                "key"     => "conventions/article5/contenu",
                "value"   => "<b>La présente convention devra être obligatoirement signée et retournée à la direction des services départementaux de l’éducation nationale de le Loire, division de l’élève en début de chaque année scolaire afin de faciliter le suivi de l’élève et du matériel.</b> A défaut de signature de la convention, ce matériel ne pourra être laissé à disposition de l’élève. <br><br> L'élève peut conserver le bénéfice de cette opération <b>le temps de sa scolarité dans un établissement Education Nationale de l'Académie de LYON</b> (premier et second degrés) ; s'il quitte cette dernière, le matériel sera restitué à la direction des services départementaux de l’éducation nationale de la Loire, qui assurera le lien avec l'Académie d'accueil.",
            ],
		],
	];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		foreach ($this->departements as $departement => $keys) {
			foreach ($keys as $data) {
				\App\Models\Parametre::create([
					"departement_id" => $departement,
					"libelle"        => $data["libelle"],
					"key"            => $data["key"],
					"value"          => $data["value"],
				]);
			}
		}
	}
}
