<?php

class DashboardsController extends \BaseController {

	/**
	 * Main dashboard.
	 *
	 * @return Response
	 */
	public function main()
	{
        //if (Auth::check()) {
        	return View::make('dashboards/main');
    	//}
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

}
