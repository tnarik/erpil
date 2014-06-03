<?php

class SessionsController extends \BaseController {

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if (Auth::check()) return Redirect::route('home');

		return View::make('sessions/create')->withFirst( SessionsController::needInitialization()? true : null);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if ( SessionsController::needInitialization() ) {
			// System should be initialized
			$user = User::create(array('name' => 'default_name', 'email' => Input::get('email'), 'password' => Hash::make(Input::get('password'))));
		}
		if (Auth::attempt(Input::only('email', 'password'))) {
			Session::flash('flash_message', array( 'success' => 'Bienvenido!!'));
		    return Redirect::intended(URL::route('home'));  //with('flash_message', 'something')
		} else {
			Session::flash('flash_message', array( 'danger' => 'uh oh! Intentalo otra vez, por favor.'));
			return Redirect::back()->withInput();
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{   
		Auth::logout();

		return Redirect::route('login');
	}

	public function needInitialization()
	{
		return (User::count() == 0);
	}

}
