<?php

class CardEvent extends Eloquent {


	protected $fillable = array('card_id', 'comment');

    public function customer()
    {
        return $this->belongsTo('Customer', 'card_id', 'card_id');
    }
}