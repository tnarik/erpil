<?php

class CardEvent extends Eloquent {

	protected $fillable = array('card_id', 'comment');
	protected $softDelete = true;

    public function customer()
    {
        return $this->belongsTo('Customer', 'card_id', 'card_id');
    }
}