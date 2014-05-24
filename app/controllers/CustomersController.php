<?php

class CustomersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Input::has('search')) {
			if (Input::get('search') == "unverified") {
				$customers = Customer::where('verified', '=', false)->paginate(3);
			} elseif (Input::get('search') == "pending_payment") {
				$customers = Customer::where('verified', '=', true)->whereNull('payment_next_date')->orWhere('payment_next_date', '<', date('Y-m-d'))->paginate(3);
			} else {
				$customers = Customer::where('name', 'like', '%'.Input::get('search').'%')->paginate(3);
			}
		} else {
			$customers = Customer::paginate(3);
		}
		//  $page = Input::get('page', 1);
    //  $data = $this->user->getByPage($page, 50);
    //  $users = Paginator::make($data->items, $data->totalItems, 50);

		//$users = Paginator::make($items, $totalItems, $perPage);
    return View::make('customers/index')->withCustomers($customers)->withUser('a');
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