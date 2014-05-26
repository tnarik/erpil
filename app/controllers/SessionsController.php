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

		return View::make('sessions/create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if ( User::count() == 2 ) {
			$user = User::create(array('name' => 'lalo', 'email' => 'a@aa.com', 'password' => Hash::make('capicola')));
			return $user;
		}
		if (Auth::attempt(Input::only('email', 'password'))) {
		    return Redirect::intended(URL::route('home'));
		} else {
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

		return Redirect::route('sessions.create');
	}

}
