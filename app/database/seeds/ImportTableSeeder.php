<?php

class ImportTableSeeder extends Seeder { 

    public function run() {
        Eloquent::unguard();

        DB::table('card_events')->delete();
        CardEvent::create(array('card_id' => '', 'facility_id' => 2, 'created_at' => '2013-04-29 16:00:00', 'updated_at' => '2013-04-29 16:00:00', 'comment' => ''));
        DB::table('customers')->delete();
        Customer::create(array('name' => 'Name', 'email' => 'mail@mail.com', 'verified' => '1', 'card_id' => '0123123123', 'created_at' => '2014-05-09 19:03:57', 'updated_at' => '2014-05-09 17:03:57', 'phone' => '646810742', 'address' => NULL, 'national_id' => '123123123A', 'surname' => 'Suername', 'payment_last_date' => NULL, 'payment_next_date' => '2015-04-24', 'comment' => NULL, 'payment_method' => 'cash', 'customer_id' => '223', 'has_parking' => '1'));
        DB::table('sites')->delete();
        Site::create(array('name' => 'La cicleria social club', 'user_id' => '1'));
        DB::table('users')->delete();
        User::create(array('id' => '1', 'name' => 'admin', 'email' => 'lacicleria@lacicleria.com', 'password' => '$2a$08$rEDPdq5eh48o2OQ5GWJDPul7nUqgvNxDMNnZGWwRcGQcA775jGcWu'));
    }
}