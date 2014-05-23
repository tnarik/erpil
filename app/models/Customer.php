<?php

class Customer extends Eloquent {

	protected $fillable = array('name', 'surname', 'email', 'address',
		'phone', 'comment', 'payment', 'customer_id', 'card_id');

}