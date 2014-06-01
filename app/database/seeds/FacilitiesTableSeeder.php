<?php

class FacilitiesTableSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();

		DB::table('facilities')->delete();

		Facility::create(array('code' => 'PARKING', 'name' => 'parking', 'description' => 'Garage de bicis'));
		Facility::create(array('code' => 'WSHOP', 'name' => 'taller', 'description' => 'Taller de bicis'));
		Facility::create(array('code' => 'LIBRARY', 'name' => 'biblioteca', 'description' => 'Prestamo de libros'));
	}

}
