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
			$table->text('email')->nullable();
			$table->boolean('verified')->default(false);
			$table->text('customer_id')->nullable();
			$table->text('card_id')->nullable();

			$table->text('name');
			$table->text('surname')->nullable();
			$table->text('address')->nullable();
			$table->text('phone')->nullable();
			$table->text('comment')->nullable();
			$table->text('national_id')->nullable();

			$table->date('payment_last_date')->nullable();
      $table->date('payment_next_date')->nullable();
			$table->text('payment_method')->nullable();

			$table->boolean('has_parking')->default(false);

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