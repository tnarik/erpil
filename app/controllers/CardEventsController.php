<?php

class CardEventsController extends \BaseController {

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$facility = Facility::whereCode(Input::get('facility'))->first();
		$card_event = new CardEvent(Input::all());
		$card_event->facility()->associate($facility);
		$card_event->save();
	}

}
