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

        $this->call(TypesDocumentSeeder::class);

        $this->call(ServicesSeeder::class);

		$this->call(DomainesMaterielSeeder::class);
		$this->call(TypesMaterielSeeder::class);
		$this->call(EtatsMaterielSeeder::class);
	}
}
