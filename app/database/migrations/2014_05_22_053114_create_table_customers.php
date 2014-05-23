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
			$table->integer('status')->nullable()->default(NULL);

			$table->text('surname')->nullable();
			$table->text('address')->nullable();
			$table->text('phone')->nullable();
			$table->text('comment')->nullable();
			$table->text('payment')->nullable();
			$table->text('customer_id')->nullable();
			$table->text('card_id')->nullable();

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
#  `fechaPagado` date DEFAULT NULL,
#  `fechaPago` date DEFAULT NULL,
#
#  `has_parking` int(11) DEFAULT NULL,
#  `flagDisabled` text,
#  PRIMARY KEY (`id`)