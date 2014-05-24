<?php

class CardEventsController extends \BaseController {

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$card_event = CardEvent::create(Input::all());
		$card_event->save();
	}

}
