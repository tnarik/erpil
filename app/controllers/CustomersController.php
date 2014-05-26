<?php

class CustomersController extends \BaseController {

	/**
     * Instantiate a new CustomersController instance.
     */
    public function __construct()
    {
        $this->beforeFilter('auth');
    }


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$customers = Customer::searchAndPaginate(Input::get('search'), Input::get('filter'), 3);
		//$customers = Customer::searchAndPaginate(Input::get('search'), 3);
        return View::make('customers/index')->withCustomers($customers)
        	->withUser('a')->withSearch(Input::get('search'))->withFilter(Input::get('filter'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$customer = new Customer;
    	return View::make('customers/create')->withCustomer($customer)->withUser('a');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$customer = Customer::create( array( 'name' => Input::get('name'), 'surname' => Input::get('surname') ));
		$customer->save();
		return Redirect::route('customers.index');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		dd('getting a $id');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$customer = Customer::find($id);
    	return View::make('customers/edit')->withCustomer($customer)->withUser('a');
 	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$customer = Customer::find($id);
		$customer->fill(Input::all());
		$customer->save();
		return Redirect::route('customers.index');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{   
		$customer = Customer::find($id);
		$customer->delete();

		// delete associated entries
		// only with authorization
	}



}
