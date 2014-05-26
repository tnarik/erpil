<?php

class CustomersTableSeeder extends Seeder {

	public function run()
	{
		DB::table('customers')->delete();

		Customer::create(array('name' => 'Manolo', 'card_id' => '123'));
		Customer::create(array('name' => 'Pepa', 'card_id' => '234'));
		Customer::create(array('name' => 'Luisa'));
	}

}
