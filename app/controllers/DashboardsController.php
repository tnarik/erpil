<?php

class DashboardsController extends \BaseController {

	/**
	 * Main dashboard.
	 *
	 * @return Response
	 */
	public function main()
	{
		if (Auth::check()) {
        	return View::make('dashboards/main'); //for the first site!
        } else {
        	return Redirect::route('login');
        }
    }

	/**
	 * Stats dashboard.
	 *
	 * @return Response
	 */
	public function stats()
	{
		// are stats global or for an ID?

		// get the logs

		// generate the view, in the old version 'home.stats'
		
		$card_events = DB::table('card_events')->get();
		$stats = [];
		$hours = array_fill_keys(array("00",  "01",  "02",  "03",  "04",  "05",
			"06",  "07",  "08",  "09",  "10",  "11",
			"12",  "13",  "14",  "15",  "16",  "17",
			"18",  "19",  "20",  "21",  "22",  "23",
			"24"), 0);
		$days = array_fill(0, 7, 0);
		foreach ($card_events as $card_event) {
			$key = explode(':', explode(' ', $card_event->created_at)[1])[0];
			$date = date('w', strtotime($card_event->created_at));
			$code = Facility::find($card_event->facility_id)->code;

			$stats[$code] = array_key_exists($code, $stats) ? $stats[$code] : [];
			$stats[$code]['hours'] = array_key_exists('hours', $stats[$code]) ? $stats[$code]['hours'] : $hours;
			$stats[$code]['days'] = array_key_exists('days', $stats[$code]) ? $stats[$code]['days'] : $days;
			$stats[$code]['hours'][$key] +=1;
			$stats[$code]['days'][$date] +=1;
		}
		foreach ( array( 'WSHOP', 'LIBRARY', 'PARKING') as $code ) {
			$stats[$code] = array_key_exists($code, $stats) ? $stats[$code] : [];
			$stats[$code]['hours'] = array_key_exists('hours', $stats[$code]) ? $stats[$code]['hours'] : $hours;
			$stats[$code]['days'] = array_key_exists('days', $stats[$code]) ? $stats[$code]['days'] : $days;
			$stats[$code] = array_key_exists($code, $stats) ? $stats[$code] : [];
			$stats[$code]['hours'] = array_key_exists('hours', $stats[$code]) ? $stats[$code]['hours'] : $hours;
			$stats[$code]['days'] = array_key_exists('days', $stats[$code]) ? $stats[$code]['days'] : $days;
			$stats[$code] = array_key_exists($code, $stats) ? $stats[$code] : [];
			$stats[$code]['hours'] = array_key_exists('hours', $stats[$code]) ? $stats[$code]['hours'] : $hours;
			$stats[$code]['days'] = array_key_exists('days', $stats[$code]) ? $stats[$code]['days'] : $days;
		}
		return View::make('dashboards/stats')->withStats($stats);
	}

	/**
	 * Trigger opening of door.
	 *
	 * @return Response
	 */
	public function openDoor()
	{
		if (Auth::check()) {
			system('sudo door_opener');
		}
		return Redirect::route('home');
	}

	public function displayLog()
	{
		if (is_readable('/tmp/simpledod.log')) {
			return "<pre>".file_get_contents('/tmp/simpledod.log')."</pre>";
		} else {
			return "no luck, cowboy";
		}
	}

}
