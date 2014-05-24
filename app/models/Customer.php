<?php

class Customer extends Eloquent {

	protected $fillable = array('name', 'surname', 'email', 'verified', 'address',
		'phone', 'comment', 'payment_next_date', 'payment_method', 'customer_id', 'card_id');

	public function events()
	{
		return $this->hasMany('CardEvent', 'card_id', 'card_id');
	}
}