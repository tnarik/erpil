<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCustomers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('name');
			$table->text('email')->nullable();
			$table->boolean('verified')->default(false);
			$table->text('surname')->nullable();
			$table->text('address')->nullable();
			$table->text('phone')->nullable();
			$table->text('comment')->nullable();
			$table->text('customer_id')->nullable();
			$table->text('card_id')->nullable();

            $table->date('payment_next_date')->nullable();
			$table->text('payment_method')->nullable();

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customers');
	}

}

#CREATE TABLE `members` (
#  `has_parking` int(11) DEFAULT NULL,
#  `flagDisabled` text,
#  PRIMARY KEY (`id`)