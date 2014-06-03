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
		$customers = Customer::searchAndPaginate(Input::get('search'), Input::get('filter'), 15);
	   	return View::make('customers/index')->withCustomers($customers)->withDebug(Input::get('filter'))
     		->withFilter(Input::get('filter'))->withSearch(Input::get('search'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$customer = new Customer;
    	return View::make('customers/create')->withCustomer($customer);
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

		Session::flash('flash_message', array( 'success' => 'Nuevo usuario creado'));
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
    	return View::make('customers/edit')->withCustomer($customer);
 	}

	/**
	 * Show the statistics for the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function stats($id)
	{
		$customer = Customer::find($id);

		// are stats global or for an ID?
		$card_events = $customer->events; //DB::table('card_events')->where( 'card_id' => $customer->card_id);
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
    	return View::make('customers/stats')->withCustomer($customer)->withStats($stats);
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

		Session::flash('flash_message', array( 'success' => 'Datos de usuario actualizados'));
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
