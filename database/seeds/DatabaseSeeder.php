<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call(RegionsSeeder::class);
		$this->call(AcademiesSeeder::class);
		$this->call(DepartementsSeeder::class);
//
//		$this->call(EtablissementSeeder::class);
//
		$this->call(PermissionsSeeder::class);
		$this->call(ServicesSeeder::class);
		$this->call(UtilisateursSeeder::class);
//
//		$this->call(DomainesMaterielSeeder::class);
//		$this->call(TypesMaterielSeeder::class);
//		$this->call(TypesDocumentSeeder::class);
//		$this->call(TypesEleveSeeder::class);
//		$this->call(EtatsAdministratifsMaterielSeeder::class);
//		$this->call(EtatsPhysiquesMaterielSeeder::class);
		$this->call(ParametresSeeders::class);
	}
}
